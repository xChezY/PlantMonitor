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
?>