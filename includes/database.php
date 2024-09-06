<?php

require_once realpath(dirname(__DIR__, 1) . '/vendor/autoload.php');
use Dotenv\Dotenv;
use GuzzleHttp\Client;

$range = "4h";

function initializeClient() {
    $dotenv = Dotenv::createImmutable(dirname(__DIR__, 1));
    $dotenv->load();

    $client = new Client();
    $url = $_ENV['INFLUX_DB_URL'];
    $key = $_ENV['INFLUX_DB_API_KEY'];
    $bucket = $_ENV["BUCKET"];

    return [
        'client' => $client,
        'url' => $url,
        'key' => $key,
        'bucket' => $bucket
    ];
}

function makeRequest($query) {
    $config = initializeClient();
    $client = $config['client'];
    $url = $config['url'];
    $key = $config['key'];

    $res = $client->request(
        'POST',
        $url . "api/v2/query",
        [
            "headers" => [
                "Authorization" => "Token " . $key,
                "Content-Type" => "application/vnd.flux",
            ],
            "body" => $query,
            "query" => ["orgID" => "cdfecc3b33e9176d"]
        ]
    );

    return (string) $res->getBody();
}

function getIDCount() {
    global $range;
    $config = initializeClient();
    $bucket = $config['bucket'];

    $query = '
        from(bucket: "' . $bucket . '")
        |> range(start: -' . $range . ')
        |> filter(fn: (r) => exists r.device_id)
        |> keep(columns: ["device_id"])
        |> distinct(column: "device_id")
        |> group(columns: [])
        |> count(column: "device_id")
    ';
    $array = explode(",", makeRequest($query));

    return $array[count($array) - 1];
}

function getPlantData($plantID) {
    global $range;
    $config = initializeClient();
    $bucket = $config['bucket'];

    $query = '
        from(bucket: "' . $bucket . '")
        |> range(start: -' . $range . ')
        |> filter(fn: (r) => r.device_id == "lse0' . $plantID . '-vhs-projekt")
        |> filter(fn: (r) => r._measurement == "ttn_vhs")
        |> filter(fn: (r) => r._field == "water_SOIL" or r._field == "temp_SOIL" or r._field == "conduct_SOIL" or r._field == "latitude" or r._field == "longitude")
        |> keep(columns: ["_time", "_value", "_field", "device_id"])
    ';

    $formatteddata = explode(",_result,", str_replace(",result,", "", makeRequest($query)));

    $header = str_getcsv(array_shift($formatteddata));

    $map = [];

    function convertToTimestamp($datetime)
    {
        $date = new DateTime($datetime);
        return $date->getTimestamp();
    }

    function formatTimestamp($timestamp)
    {
        $date = new DateTime("@$timestamp");
        return $date->format('d.m.Y H:i:s');
    }

    foreach ($formatteddata as $line) {
        $values = str_getcsv($line);

        if (count($values) < count($header))
            continue;

        list($table, $time, $value, $field, $device_id) = $values;

        $timestamp = convertToTimestamp($time);

        $formattedDate = formatTimestamp($timestamp);

        if (!isset($map[$timestamp])) {
            $map[$timestamp] = [
                'date' => $formattedDate
            ];
        }

        $map[$timestamp][$field] = $value;
    }

    return $map;
}