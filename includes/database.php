<?php

require_once realpath(dirname(__DIR__, 1) . '/vendor/autoload.php');
use Dotenv\Dotenv;

function getPlantData($plantID){

    $dotenv = Dotenv::createImmutable(dirname(__DIR__, 1));
    $dotenv->load();

    $client = new GuzzleHttp\Client();
    $url = $_ENV['INFLUX_DB_URL'];
    $key = $_ENV['INFLUX_DB_API_KEY'];
    $bucket = $_ENV["BUCKET"];
    $res = $client->request(
        'POST',
        $url . "api/v2/query",
        [
            "headers" => [
                "Authorization" => "Token " . $key,
                "Content-Type" => "application/vnd.flux",
            ],
            "body" => '
                from(bucket: "' . $bucket . '")
                |> range(start: -10m)
                |> drop(columns: ["_start","_stop","_time","_measurement","topic","host","deviceName","device_id"])
                ',
            "query" => ["orgID" => "cdfecc3b33e9176d"]
        ]
    );
    return str_replace(",_result,", "<br>", (string) $res->getBody());
}

?>