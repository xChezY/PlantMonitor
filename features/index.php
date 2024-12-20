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
$plantid = $safeget ?: "lse01-vhs-projekt";
$plant   = Plant::init( $plantid );


?>

<div class="pt-4 pl-6 field">
    <label class="label" for="pflanzeDropdown">Wähle eine Pflanze</label>
    <form method="GET">
        <div class="control">
            <div class="select">
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

<?php

// TODO Hinweis ergänzen das der Sensor sich alle 20min updatet daher man nicht extrem viel wasser drauf tun soll.

?>

<div class="block pl-6 pr-6">

    <div class="block">
        <h5 class="title is-5">Bodenleitfähigkeit in µS(Mikrosiemens) </h5>
        <div class="box" type="text">
            <p id="conduct_SOIL">
				<?php echo $plant->getConduct() ?>
            </p>
			<?php Icons::createIcon( "conduct", $plant->getConductStatus() ); ?>
        </div>
    </div>

    <div class="block">
        <h5 class="title is-5">Bodentemperatur in °C</h5>
        <div class="box" type="text">
            <p id="temp_SOIL">
				<?php echo $plant->getTemp() ?>
            </p>
	        <?php Icons::createIcon( "thermometer", $plant->getTempStatus() ); ?>
        </div>
    </div>

    <div class="block">
        <h5 class="title is-5">Bodenfeuchtigkeit in %</h5>
        <div class="box" type="text">
            <p id="water_SOIL">
				<?php echo $plant->getWater() ?>
            </p>
	        <?php Icons::createIcon( "water-drop", $plant->getWaterStatus() ); ?>
        </div>
    </div>

</div>

<?php View::get( "footer" ); ?>
</body>

</html>
