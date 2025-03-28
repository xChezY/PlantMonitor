<?php

namespace PlantMonitor;

use DateTime;
use Dotenv\Dotenv;
use GuzzleHttp\Client;

class Database
{
    private Client $client;
    private string $baseURL;

    private string $apiKey;

    private string $bucket;
    private $range = "4h";

    private string $orgID;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . "/../");
        $dotenv->load();
        $this->client  = new Client(["verify" => false]);
        $this->baseURL = $_ENV['INFLUX_DB_URL'] ?? "";
        $this->apiKey  = $_ENV['INFLUX_DB_API_KEY'] ?? "";
        $this->bucket  = $_ENV["BUCKET"] ?? "";
        $this->orgID   = $_ENV["ORG_ID"] ?? "";
    }


    private function makeRequest($query)
    {

        $res = $this->client->request(
            'POST',
            $this->baseURL . "api/v2/query",
            [
                "headers" => [
                    "Authorization" => "Token " . $this->apiKey,
                    "Content-Type"  => "application/vnd.flux",
                ],
                "body"    => $query,
                "query"   => [ "orgID" => $this->orgID ] // todo: move to .env
            ]
        );

        return (string) $res->getBody();
    }

    public function getIDCount()
    {

        $query = '
	        from(bucket: "' . $this->bucket . '")
	        |> range(start: -' . $this->range . ')
	        |> filter(fn: (r) => exists r.device_id)
	        |> keep(columns: ["device_id"])
	        |> distinct(column: "device_id")
	        |> group(columns: [])
	        |> count(column: "device_id")
	    ';
        $array = explode(",", $this->makeRequest($query));

        return $array[ count($array) - 1 ];
    }


    public function convertToTimestamp($datetime)
    {
        $date = new DateTime($datetime);

        return $date->getTimestamp();
    }

    public function formatTimestamp($timestamp)
    {
        $date = new DateTime("@$timestamp");

        return $date->format('d.m.Y H:i:s');
    }

    public function getPlantData($plantID)
    {

        $query = '
	        from(bucket: "' . $this->bucket . '")
	        |> range(start: -' . $this->range . ')
	        |> filter(fn: (r) => r.device_id == "' . $plantID . '")
	        |> filter(fn: (r) => r._measurement == "ttn_vhs")
	        |> filter(fn: (r) => r._field == "water_SOIL" or r._field == "temp_SOIL" or r._field == "conduct_SOIL" or r._field == "latitude" or r._field == "longitude")
	        |> keep(columns: ["_time", "_value", "_field", "device_id"])
	    ';

        $formatteddata = explode(",_result,", str_replace(",result,", "", $this->makeRequest($query)));

        $header = str_getcsv(array_shift($formatteddata));

        $map = [];


        foreach ($formatteddata as $line) {
            $values = str_getcsv($line);

            if (count($values) < count($header)) {
                continue;
            }

            list($table, $time, $value, $field, $device_id) = $values;

            $timestamp = $this->convertToTimestamp($time);

            $formattedDate = $this->formatTimestamp($timestamp);

            if (! isset($map[ $timestamp ])) {
                $map[ $timestamp ] = [
                    'date' => $formattedDate
                ];
            }

            $map[ $timestamp ][ $field ] = $value;
        }

        return $map;
    }

    public function getAllData()
{
    $query = '
        from(bucket: "' . $this->bucket . '")
        |> range(start: -4h)
    ';

    $response = $this->makeRequest($query);
    return json_decode($response, true);
}

public function getAllFormattedData()
{
    $data = $this->getAllData();
    $formattedData = [];

    foreach ($data as $record) {
        $timestamp = $this->convertToTimestamp($record['_time']);
        $formattedDate = $this->formatTimestamp($timestamp);

        if (!isset($formattedData[$timestamp])) {
            $formattedData[$timestamp] = [
                'date' => $formattedDate
            ];
        }

        $formattedData[$timestamp][$record['_field']] = $record['_value'];
    }

    return $formattedData;
}

}
