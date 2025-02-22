<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlanMonitor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.0/css/bulma.min.css">

</head>

<body>

<?php
require_once '../vendor/autoload.php';

use PlantMonitor\Database;
use PlantMonitor\Icons;
use PlantMonitor\Plant;
use PlantMonitor\View;
use PlantMonitor\ConfigManager;

View::get( "navbar" );

$safeget = htmlspecialchars( $_GET["plant"] ?? "", ENT_QUOTES, "UTF-8" );
$plantid = $safeget ?: "Mitwirkgarten-Barani-MeteoHelix-1";
$plant   = Plant::init( $plantid );


?>

<?php

// TODO Hinweis ergänzen das der Sensor sich alle 20min updatet daher man nicht extrem viel wasser drauf tun soll.

?>
<!-- TODO: Alle Elemente innerhalb der Blocks zentrieren -->
<div class="block pl-6 pr-6">
    <div class="block">
        <div class="box has-text-centered" type="text">
	        <?php
            $waterStatus = $plant->getWaterStatus();
            Icons::createIcon( "water-drop", $waterStatus); ?>
            <h5 class="title is-5 pt-3">Bodenfeuchtigkeit</h5>
            <p id="water_SOIL">
				<?php
                echo sprintf("%s (%s %%)",Plant::getInfoText($waterStatus), number_format($plant->getWater(), 2, ",", "."));
                ?>
            </p>
        </div>
    </div>

    <div class="block">
        <div class="box has-text-centered" type="text">
	        <?php
            $conductStatus = $plant->getConductStatus();
            Icons::createIcon( "conduct", $conductStatus ); ?>
            <h5 class="title is-5 pt-3">Bodenleitfähigkeit</h5>
            <p id="conduct_SOIL">
	            <?php
	            echo sprintf("%s (%s µS)",Plant::getInfoText($conductStatus), number_format($plant->getConduct(), 1, ",", "."));
	            ?>
            </p>
        </div>
    </div>

    <div class="block">
        <div class="box has-text-centered" type="text">
	        <?php
            $tempStatus = $plant->getTempStatus();
            Icons::createIcon( "thermometer", $tempStatus ); ?>
            <h5 class="title is-5 pt-3">Bodentemperatur</h5>
            <p id="temp_SOIL">
	            <?php
	            echo sprintf("%s (%s °C)",Plant::getInfoText($tempStatus), number_format($plant->getTemp(), 1, ",", "."));
	            ?>
            </p>
        </div>
    </div>



</div>

<div class="pt-4 px-6 field">
    <label class="label has-text-centered" for="pflanzeDropdown">Wähle eine Pflanze</label>
    <form method="GET">
        <div class="control">
            <div class="select is-fullwidth">
                <select name="plant" id="pflanzeDropdown" onchange="this.form.submit()">
                    <option value="">Auswählen...</option>
					<?php
					$configmanager = new ConfigManager();
					foreach ( $configmanager->getAllPlantsIds() as $plantId ) { ?>
                        <option
                                value="<?php echo $plantId ?>"
							<?php if ( isset( $safeget ) && $safeget == $plantId ) { ?>
                                selected
							<?php } ?>
                        >
							<?php echo "Pflanze " . $plantId ?>
                        </option>
					<?php }
					?>
                </select>
            </div>
        </div>
    </form>
</div>

<?php View::get( "footer" ); ?>
</body>

</html>
