<?php
require_once 'Plant.php'; // Include the Plant.php file

use PlantMonitor\Plant; // Use the PlantMonitor namespace

function console_log($data) {
    echo '<script>';
    echo 'console.log(' . json_encode($data) . ');';
    echo '</script>';
}

function giveRandomDouble($min, $max) {
    return rand($min, $max) + (rand(0, 100) / 100);
}

function dummyData() {
    return new Plant(
        "1",
        new DateTime(),
        0,
        0,
        20,
        30,
        giveRandomDouble(-10, 40),
        300,
        800,
        giveRandomDouble(0, 1000),
        50,
        80,
        giveRandomDouble(0, 100),
    );
}

function getBigValue() {
    return 1000000;
}

function showExplanationForNoValue() {
    return "<p>Keine Daten verfügbar :(</p>";
}

function getDBLabeling() {
    $plantsLabelingInDB = [
        "Mitwirkgarten-Barani-MeteoHelix-3" => [
            "MEASUREMENT" => "coop_garden",
            "WIND" => "wind_3sgust",
            "DEVICEIDORNAME" => "deviceName"
        ],
        "lse01-vhs-projekt" => [
            "MEASUREMENT" => "sfz",
            "WATER" => "water_SOIL",
            "CONDUCT" => "conduct_SOIL",
            "TEMPERATURE" => "temp_SOIL",
            "LATITUDE" => "location_latitude",
            "LONGITUDE" => "location_longitude",
            "ALTITUDE" => "location_altitude",
            "DEVICEIDORNAME" => "device_id"
        ],
        "Mitwirkgarten-Barani-MeteoHelix-1" => [
            "MEASUREMENT" => "coop_garden",
            "TEMPERATURE" => "Temperature",
            "LATITUDE" => "location_latitude",
            "LONGITUDE" => "location_longitude",
            "ALTITUDE" => "location_altitude",
            "DEVICEIDORNAME" => "deviceName"
        ],
        "Mitwirkgarten-Barani-MeteoHelix-2" => [
            "MEASUREMENT" => "coop_garden",
            "WATER" => "Humidity",
            "PRESSURE" => "Pressure",
            "RAIN" => "Rain",
            "TEMPERATURE" => "Temperature",
            "LATITUDE" => "location_latitude",
            "LONGITUDE" => "location_longitude",
            "ALTITUDE" => "location_altitude",
            "DEVICEIDORNAME" => "deviceName"
        ],
        "Mitwirkgarten-Dragino-LSPH01-1" => [
            "MEASUREMENT" => "coop_garden",
            "PH" => "fPH1_SOIL",
            "TEMPERATURE" => "fTEMP_SOIL",
            "LATITUDE" => "location_latitude",
            "LONGITUDE" => "location_longitude",
            "ALTITUDE" => "location_altitude",
            "DEVICEIDORNAME" => "deviceName"
        ],
        "Mitwirkgarten-DraginoD22-LB-2" => [
            "MEASUREMENT" => "coop_garden",
            "TEMPERATURERED" => "TempRed",
            "TEMPERATUREWHITE" => "TempWhite",
            "LATITUDE" => "location_latitude",
            "LONGITUDE" => "location_longitude",
            "ALTITUDE" => "location_altitude",
            "DEVICEIDORNAME" => "deviceName"
        ],
        "Mitwirkgarten-DraginoLSPH01-2" => [
            "MEASUREMENT" => "coop_garden",
            "PH" => "fPH1_SOIL",
            "TEMPERATURE" => "fTEMP_SOIL",
            "LATITUDE" => "location_latitude",
            "LONGITUDE" => "location_longitude",
            "ALTITUDE" => "location_altitude",
            "DEVICEIDORNAME" => "deviceName"
        ],
        "Mitwirkgarten-MilesightWTS305-1" => [
            "MEASUREMENT" => "coop_garden",
            "WATER" => "humidity",
            "TEMPERATURE" => "temperature",
            "PRESSURE" => "pressure",
            "LATITUDE" => "location_latitude",
            "LONGITUDE" => "location_longitude",
            "ALTITUDE" => "location_altitude",
            "DEVICEIDORNAME" => "deviceName"
        ],
        "Mitwirkgarten-SenseCAP-S2105-1" => [
            "MEASUREMENT" => "coop_garden",
            "WATER" => "data_messages_soil_moisture",
            "TEMPERATURE" => "data_messages_soil_temp",
            "LATITUDE" => "location_latitude",
            "LONGITUDE" => "location_longitude",
            "ALTITUDE" => "location_altitude",
            "DEVICEIDORNAME" => "deviceName"
        ],
        "Mitwirkgarten-SenseCAP-S2105-2" => [
            "MEASUREMENT" => "coop_garden",
            "LATITUDE" => "location_latitude",
            "LONGITUDE" => "location_longitude",
            "ALTITUDE" => "location_altitude",
            "DEVICEIDORNAME" => "deviceName"
        ],
        "Ueberflutung_VEGA_Air41-2" => [
            "MEASUREMENT" => "coop_garden",
            "TEMPERATURE" => "Temperature",
            "LATITUDE" => "location_latitude",
            "LONGITUDE" => "location_longitude",
            "ALTITUDE" => "location_altitude",
            "DEVICEIDORNAME" => "deviceName"
        ],
    ];

    return $plantsLabelingInDB;
}
?>