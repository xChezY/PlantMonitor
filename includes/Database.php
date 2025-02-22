<?php

namespace PlantMonitor;

require_once 'constants.php'; // Include the constants.php file

use DateTime;
use Dotenv\Dotenv;
use GuzzleHttp\Client;
use Exception;

class Database
{
    private Client $client;
    private string $baseURL;

    private string $apiKey;

    private string $bucket;
    private $range = "4h";

    private string $orgID;

    private $plantsLabelingInDB;

    public function __construct()
    {

        $this->plantsLabelingInDB = getDBLabeling();

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
	        |> filter(fn: (r) => exists r.deviceName)
	        |> keep(columns: ["deviceName"])
	        |> distinct(column: "deviceName")
	        |> group(columns: [])
	        |> count(column: "deviceName")
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

    console_log($this->plantsLabelingInDB);
    console_log($plantID);
    // Überprüfen, ob das plantID im plantsLabelingInDB-Array existiert
    if (!isset($this->plantsLabelingInDB[$plantID])) {
        echo("Plant ID not found in plantsLabelingInDB");
    }

    // Holen Sie sich die Daten für das spezifische plantID
    $plantData = $this->plantsLabelingInDB[$plantID];

    // Erstellen Sie den Filter-String dynamisch basierend auf den Feldern im plantData-Array
    $fields = array_keys($plantData);
    $fieldFilters = implode(' or ', array_map(function($field) use ($plantData) {
        return 'r._field == "' . $plantData[$field] . '"';
    }, $fields));

    $query = '
        from(bucket: "' . $this->bucket . '")
        |> range(start: -' . $this->range . ')
        |> filter(fn: (r) => r.' . $plantData['DEVICEIDORNAME'] . ' == "' . $plantID . '")
        |> filter(fn: (r) => r._measurement == "' . $plantData['MEASUREMENT'] . '")
        |> filter(fn: (r) => ' . $fieldFilters . ')
        |> keep(columns: ["_time", "_value", "_field", "' . $plantData['DEVICEIDORNAME'] . '"])
    ';

    console_log($query);

    $formatteddata = explode(",_result,", str_replace(",result,", "", $this->makeRequest($query)));

    console_log($formatteddata);

    $header = str_getcsv(array_shift($formatteddata));

    $map = [];

    foreach ($formatteddata as $line) {
        $values = str_getcsv($line);

        if (count($values) < count($header)) {
            continue;
        }

        list($table, $time, $value, $field, $deviceName) = $values;

        $timestamp = $this->convertToTimestamp($time);

        $formattedDate = $this->formatTimestamp($timestamp);

        if (!isset($map[$timestamp])) {
            $map[$timestamp] = [
                'date' => $formattedDate
            ];
        }

        $map[$timestamp][$field] = $value;
    }

    console_log($map);
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
