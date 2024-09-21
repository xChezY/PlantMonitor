<?php

namespace PlantMonitor;

use Symfony\Component\Yaml\Yaml;

class ConfigManager {

    private $plant_list;
    
    public function __construct() {

        $this->plant_list = Yaml::parseFile(realpath(dirname(__DIR__, 1) . '/config.yaml'))['Plants'];
        
    }
    
    function getPlantsConfig() {
        return $this->plant_list;    
    }

    function getPlantConfig($plant_id) {
        return $this->plant_list[$plant_id];
    }

    function getCount() {
        return count($this->plant_list);
    }

    function getMinConduct($plant_id) {
        return $this->plant_list[$plant_id]['minConduct'];
    }
    function getMaxConduct($plant_id) {
        return $this->plant_list[$plant_id]['maxConduct'];
    }
    function getMinWater($plant_id) {
        return $this->plant_list[$plant_id]['minWater'];
    }
    function getMaxWater($plant_id) {
        return $this->plant_list[$plant_id]['maxWater'];
    }
    function getMinTemp($plant_id) {
        return $this->plant_list[$plant_id]['minTemp'];
    }
    function getMaxTemp($plant_id) {
        return $this->plant_list[$plant_id]['maxTemp'];
    }
}



?>