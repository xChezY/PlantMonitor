<?php

namespace PlantMonitor;

use Symfony\Component\Yaml\Yaml;

class ConfigManager
{
    private $plant_list;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $file = dirname(__DIR__, 1) . '/config.yaml';
        if (file_exists($file)) {
            $yaml_array = Yaml::parseFile(realpath(dirname(__DIR__, 1) . '/config.yaml'));

            $this->plant_list = $yaml_array['plants'] ?? [];
        } else {
            throw new \Exception("Config file not found");
        }
    }

    public function getPlantsConfig()
    {
        return $this->plant_list;
    }

    public function getPlantConfig($plant_id)
    {
        return $this->plant_list[ $plant_id ];
    }

    public function getCount()
    {
        return count($this->plant_list);
    }

    public function getAllPlantsIds()
    {
        $names = array_keys($this->plant_list);

        return $names;

    }

    public function getMinConduct($plant_id)
    {
        return $this->plant_list[ $plant_id ]['conduct']['min'] ?? null;
    }

    public function getMaxConduct($plant_id)
    {
        return $this->plant_list[ $plant_id ]['conduct']['max'] ?? null;
    }

    public function getMinWater($plant_id)
    {
        return $this->plant_list[ $plant_id ]['water']["min"] ?? null;
    }

    public function getMaxWater($plant_id)
    {
        return $this->plant_list[ $plant_id ]['water']["max"] ?? null;
    }

    public function getMinTemp($plant_id)
    {
        return $this->plant_list[ $plant_id ]['temp']["min"] ?? null;
    }

    public function getMaxTemp($plant_id)
    {
        return $this->plant_list[ $plant_id ]['temp']['max'] ?? null;
    }
}
