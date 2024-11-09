<?php

namespace PlantMonitor;

use DateTime;

class Plant
{
    private function __construct(
        readonly string $plant_id,
        readonly DateTime $date,
        readonly float $longitude,
        readonly float $latitude,
        readonly float $min_temp,
        readonly float $max_temp,
        readonly float $temp,
        readonly float $min_conduct,
        readonly float $max_conduct,
        readonly float $conduct,
        readonly float $min_water,
        readonly float $max_water,
        readonly float $water
    ) {
    }

    public function getPlantId()
    {
        return $this->plant_id;
    }

    public function getTimestamp()
    {
        return $this->plant_id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getLongitude()
    {
        return $this->plant_id;
    }

    public function getLatitude()
    {
        return $this->plant_id;
    }

    public function getMinTemp()
    {
        return $this->min_temp;
    }

    public function getMaxTemp()
    {
        return $this->max_temp;
    }

    public function getTemp()
    {
        return $this->temp;
    }

    public function getMinWater()
    {
        return $this->min_water;
    }

    public function getMaxWater()
    {
        return $this->max_water;
    }


    public function getWater()
    {
        return $this->water;
    }

    public function getMinConduct()
    {
        return $this->min_conduct;
    }

    public function getMaxConduct()
    {
        return $this->max_conduct;
    }


    public function getConduct()
    {
        return $this->conduct;
    }

    //Bewertungsfunktion ob Temperatur okay ist (mithilfe von Enum)
    public function getTempStatus(): PlantStatus
    {
        return $this->evaluateValue($this->temp, $this->min_temp, $this->max_temp);
    }
    public function getConductStatus(): PlantStatus
    {
        return $this->evaluateValue($this->conduct, $this->min_conduct, $this->max_conduct);
    }

    public function getWaterStatus(): PlantStatus
    {
        return $this->evaluateValue($this->water, $this->min_water, $this->max_water);
    }

    private function evaluateValue($value, $min, $max): PlantStatus
    {

        if ($value > $max) {
            return PlantStatus::HIGH;
        }
        if ($value < $min) {
            return PlantStatus::LOW;
        }

        return PlantStatus::GOOD;

    }

    public static function init($plant_id)
    {

        $database = new Database();
        $cfg_manager = new ConfigManager();

        $current_plant_data = $database->getPlantData($plant_id);
        $config_plant_data = $cfg_manager->getPlantConfig($plant_id);

        $current_plant = end($current_plant_data);

        return new Plant(
            $plant_id,
            new DateTime($current_plant["date"]),
            $current_plant["longitude"],
            $current_plant["latitude"],
            $config_plant_data["temp"]["min"],
            $config_plant_data["temp"]["max"],
            $current_plant["temp_SOIL"],
            $config_plant_data["conduct"]["min"],
            $config_plant_data["conduct"]["max"],
            $current_plant["conduct_SOIL"],
            $config_plant_data["water"]["min"],
            $config_plant_data["water"]["max"],
            $current_plant["water_SOIL"],
        );
    }


    public static function initPlants($plant_id): array
    {

        $plants = [];

        $database = new Database();
        $current_plant = $database->getPlantData($plant_id);

        $cfg_manager = new ConfigManager();
        $values_plant = $cfg_manager->getPlantConfig($plant_id);

        foreach (array_keys($current_plant) as $timestamp) {
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
