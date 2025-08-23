<?php


namespace PlantMonitor;
use DateTime;

class Plant
{

    public function __construct(
        readonly string $plant_id,
        readonly DateTime $date,
	    readonly array $plant_data,
        readonly string $name
    ) {
    }

    public function getPlantId()
    {
        return $this->plant_id;
    }


    public function getDate()
    {
        return $this->date;
    }

	/**
	 * return array<string, array{min: float|int|null, value: float|int|null, max: float|int|null}>
	 */
	public function getPlantData(): array{
		return $this->plant_data;
	}

    public static function evaluateValue($value, $min, $max): PlantStatus
    {

        if ($value > $max) {
            return PlantStatus::HIGH;
        }
        if ($value < $min) {
            return PlantStatus::LOW;
        }

        return PlantStatus::GOOD;

    }

    public static function init(string $plant_id)
    {
	    $plant_id = trim($plant_id);
	    $database = new Database();
        $cfg_manager = new ConfigManager();

        $plant_config = $cfg_manager->getPlantConfig($plant_id);
        $name = $plant_config['name'] ?? "";


        // Get alle Field Names from the config
        $fieldNames = array_filter(array_map(function($valueConfig) {return $valueConfig['fieldName']??null;}, $plant_config));


	    $fluxSetString = '"' . implode('", "', array_values($fieldNames)) . '"';

	    $range = "24h";
        $plant_id = trim($plant_id);

		$result =$database->query ('
	        range(start: -' . $range . ')
	        |> filter( 
	            fn: (r) => r.deviceName == "'.$plant_id.'" or r.device_id == "'.$plant_id.'",
	        )
	        |> filter( 
	            fn: (r) => contains(value: r._field, set: ['.$fluxSetString.']),
	        )
	        |> group(columns: ["_field"])
            |> last()
	        |> keep(columns: ["_time", "_value", "_field"])
	        |> yield()
	    ');




        $result =  Utils::csvStringToArray($result);
        if(!$result){
            return false;
        }

	    $sensorReadingDate = new DateTime($result[0]["_time"]);
	    $sensorReading = [];

       foreach ($result as $data) {
           $dataFieldName = $data["_field"];

		   $field ="";
		   foreach ($fieldNames as $fieldName => $sensorFieldName) {
                if($sensorFieldName == $dataFieldName){
	                $field = $fieldName;
					break;
                }
		   }

	       $sensorReading[ $field ] = [
			   "min" => $plant_config[$field]["min"],
			   "value" => $data["_value"],
		       "max" =>$plant_config[$field]["max"],
	       ];
       }



       return new Plant(
            $plant_id,
	       $sensorReadingDate,
	       $sensorReading,
           $name
        );
    }



	public static function getInfoText($status): string{
		return match ( $status ) {
			PlantStatus::GOOD => "Alles in Ordnung",
			PlantStatus::LOW => "Zu wenig",
			PlantStatus::HIGH => "Zu viel",
			default => "",
		};
	}
}
