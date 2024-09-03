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

function getRandomPlantData($plantID) {
    //die Funktion gibt eine Pflanze (map) mit zufälligen Werten
    //kurzzeitige Lösung um am Front-End weiter arbeiten zu können
    $randomPlant = ["id" => rand(1,100),
    "date" => date("d.m.Y H:i:s"),
    "timestamp" =>  time(),
    "temp" => rand(-10,40), 
    "conduct" => rand(0, 1000),
    "water" => rand(0, 100)];

    return $randomPlant;
}

$plant1Measurements = [
    [
        "date" => "01.04.2023 10:00:00",
        "timestamp" => 1683024000,
        "temp" => 20, 
        "conduct" => 500,
        "water" => 60
    ],
    [
        "date" => "02.04.2023 10:00:00",
        "timestamp" => 1683110400,
        "temp" => 21, 
        "conduct" => 510,
        "water" => 62
    ],
    [
        "date" => "03.04.2023 10:00:00",
        "timestamp" => 1683196800,
        "temp" => 19, 
        "conduct" => 480,
        "water" => 58
    ]
];

$plant2Measurements = [
    [
        "date" => "01.04.2023 10:00:00",
        "timestamp" => 1683024000,
        "temp" => 22, 
        "conduct" => 300,
        "water" => 70
    ],
    [
        "date" => "02.04.2023 10:00:00",
        "timestamp" => 1683110400,
        "temp" => 23, 
        "conduct" => 310,
        "water" => 72
    ],
    [
        "date" => "03.04.2023 10:00:00",
        "timestamp" => 1683196800,
        "temp" => 21, 
        "conduct" => 290,
        "water" => 68
    ]
];

function getPlantByID($id){
    global $plant1Measurements, $plant2Measurements;
    $plant = null;
    if($id == 1){
        $plant = $plant1Measurements;
    } else if($id == 2){
        $plant = $plant2Measurements;
    }
    return $plant;
}

function countIDs(){
    return 2;
}

?>