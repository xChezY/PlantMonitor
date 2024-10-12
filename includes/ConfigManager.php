<?php

namespace PlantMonitor;

use Symfony\Component\Yaml\Yaml;

class ConfigManager {
	private $plant_list;

	/**
	 * @throws \Exception
	 */
	public function __construct() {
		$file = dirname( __DIR__, 1 ) . '/config.yaml';
		if ( file_exists( $file ) ) {
			$yaml_array = Yaml::parseFile( realpath( dirname( __DIR__, 1 ) . '/config.yaml' ) );

			$this->plant_list = $yaml_array['Plants'] ?? [];
		} else {
			throw new \Exception( "Config file not found" );
		}
	}

	public function getPlantsConfig() {
		return $this->plant_list;
	}

	public function getPlantConfig( $plant_id ) {
		return $this->plant_list[ $plant_id ];
	}

	public function getCount() {
		return count( $this->plant_list );
	}

	public function getMinConduct( $plant_id ) {
		return $this->plant_list[ $plant_id ]['minConduct'];
	}

	public function getMaxConduct( $plant_id ) {
		return $this->plant_list[ $plant_id ]['maxConduct'];
	}

	public function getMinWater( $plant_id ) {
		return $this->plant_list[ $plant_id ]['minWater'];
	}

	public function getMaxWater( $plant_id ) {
		return $this->plant_list[ $plant_id ]['maxWater'];
	}

	public function getMinTemp( $plant_id ) {
		return $this->plant_list[ $plant_id ]['minTemp'];
	}

	public function getMaxTemp( $plant_id ) {
		return $this->plant_list[ $plant_id ]['maxTemp'];
	}
}
