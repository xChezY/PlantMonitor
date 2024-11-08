<?php

namespace PlantMonitor;
use DateTime;

class Plant
{


    private function __construct(
        readonly string $plant_id,
        readonly int $timestamp,
        readonly DateTime $date,
        readonly float $longitude,
        readonly float $latitude,
        readonly float $optimal_min_temp,
        readonly float $optimal_max_temp,
        readonly float $absolute_min_temp,
        readonly float $absolute_max_temp,
        readonly float $current_temp,
        readonly float $optimal_min_conduct,
        readonly float $optimal_max_conduct,
        readonly float $absolute_min_conduct,
        readonly float $absolute_max_conduct,
        readonly float $current_conduct,
        readonly float $optimal_min_water,
        readonly float $optimal_max_water,
        readonly float $absolute_min_water,
        readonly float $absolute_max_water,
        readonly float $current_water
    ) {}

    public function getPlantId(){
        return $this->plant_id;
    }

    public function getTimestamp(){
        return $this->plant_id;
    }

    public function getDate(){
        return $this->date;
    }

    public function getLongitude(){
        return $this->plant_id;
    }

    public function getLatitude(){
        return $this->plant_id;
    }

    public function getOptimalMinTemp(){
        return $this->optimal_min_temp;
    }

    public function getOptimalMaxTemp(){
        return $this->optimal_max_temp;
    }

    public function getAbsoluteMinTemp(){
        return $this->absolute_min_temp;
    }

    public function getAbsoluteMaxTemp(){
        return $this->absolute_max_temp;
    }

    public function getCurrentTemp(){
        return $this->current_temp;
    }

    public function getOptimalMinWater(){
        return $this->optimal_min_water;
    }

    public function getOptimalMaxWater(){
        return $this->optimal_max_water;
    }

    public function getAbsoluteMinWater(){
        return $this->absolute_min_water;
    }

    public function getAbsoluteMaxWater(){
        return $this->absolute_max_water;
    }

    public function getCurrentWater(){
        return $this->current_water;
    }

    public function getOptimalMinConduct(){
        return $this->optimal_min_conduct;
    }

    public function getOptimalMaxConduct(){
        return $this->optimal_max_conduct;
    }

    public function getAbsoluteMinConduct(){
        return $this->absolute_min_conduct;
    }

    public function getAbsoluteMaxConduct(){
        return $this->absolute_max_conduct;
    }

    public function getCurrentConduct(){
        return $this->current_conduct;
    }

    private static function init($plant_id, $timestamp, $current_plant, $values_plant){
        return new Plant(
            $plant_id,
            $timestamp,
            new DateTime($current_plant[$timestamp]["date"]),
            $current_plant[$timestamp]["longitude"],
            $current_plant[$timestamp]["latitude"],
            $values_plant["temp"]["min"],
            $values_plant["temp"]["max"],
            $values_plant["temp"]["min"],
            $values_plant["temp"]["max"],
            $current_plant[$timestamp]["temp_SOIL"],
            $values_plant["conduct"]["min"],
            $values_plant["conduct"]["max"],
            $values_plant["conduct"]["min"],
            $values_plant["conduct"]["max"],
            $current_plant[$timestamp]["conduct_SOIL"],
            $values_plant["water"]["min"],
            $values_plant["water"]["max"],
            $values_plant["water"]["min"],
            $values_plant["water"]["max"],
            $current_plant[$timestamp]["water_SOIL"],
        );
    }

    public static function initPlants($plant_id){

        $plants = [];

        $database = new Database();
        $current_plant = $database->getPlantData($plant_id);

        $cfg_manager = new ConfigManager();
        $values_plant = $cfg_manager->getPlantConfig($plant_id);

        foreach(array_keys($current_plant) as $timestamp){
            array_push($plants, Plant::init($plant_id, $timestamp, $current_plant, $values_plant));
        }

        return $plants;
    }

    public static function initPlantbyTimeStamp($plant_id, $timestamp)
    {
        $database = new Database();
        $current_plant = $database->getPlantData($plant_id);

        $cfg_manager = new ConfigManager();
        $values_plant = $cfg_manager->getPlantConfig($plant_id);

        return Plant::init($plant_id, $timestamp, $current_plant, $values_plant);
    }
}