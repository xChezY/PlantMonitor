<!DOCTYPE html>
<html lang="en" class="is-light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlanMonitor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.0/css/bulma.min.css">

    <style>
        html {
            scroll-behavior: smooth;
        }

        /* Light mode specific styles */
        body {
            background-color: white;
            color: black;
        }

        .card {
            background-color: white;
        }

        .navbar, .footer {
            background-color: white;
        }

        .card-image.logo {
            background-color: white;
            height: 90px;
            display: flex;
            allign-items: center;
        }

        .title {
            color: black;
        }

        .subtitle {
            color: black;
        }

        .content {
            color: black;
        }

        .card-content h5 {
            color: black;
        }

        .box {
            background-color: white;
            box-shadow: 4px 4px 20px 0px #00000040;
        }
    </style>
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

$plantParameter = htmlspecialchars( $_GET["plant"] ?? "", ENT_QUOTES, "UTF-8" );

if($plantParameter):
	$plant   = Plant::init( $plantParameter );
    ?>

	<?php
	$baseUrl = $_ENV['BASE_URL'];
	$data   = $baseUrl."features/qrcode?plant=".$plant->getPlantId();

	?>
    <div class="has-text-centered"><a href="<?php echo $data; ?>" download>QR-Code herunterladen</a></div>


    <div class="block pl-6 pr-6">

		<?php

		// TODO Hinweis ergänzen das der Sensor sich alle 20min updatet daher man nicht extrem viel wasser drauf tun soll.

		$plantData = $plant->getPlantData();

		foreach ( $plantData as $measurementName => $values ) :
			["min" => $min, "value" => $value,  "max" => $max ] = $values;
			?>

            <div class="block">
                <div class="box has-text-centered" type="text">
					<?php
					$status= Plant::evaluateValue( $value, $min, $max );

					$iconName = "";

					$iconName = match ($measurementName) {
						"conduct" => "conduct",
						"water" => "water-drop",
						"temp" => "thermometer",
						"ph" => "conduct",
					};

					$unit = match($measurementName) {
                        "conduct" => "µS",
                        "water" => "%",
                        "temp" => "°C",
                        "ph" => "(pH)",
                    };

					Icons::createIcon( $iconName, $status ); ?>
                    <h5 class="title is-5 pt-3"><?= $measurementName; ?></h5>
                    <p>
						<?php


						echo sprintf( "%s (%s %s)", Plant::getInfoText( $status ), number_format( $value, 2, ",", "." ) ,$unit);
						?>
                    </p>
                </div>
            </div>

		<?php endforeach; ?>



    </div>


<?php else: ?>

<h2>Bitte wähle einen Sensor</h2>

<?php endif; ?>




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
							<?php if ( isset( $plantParameter ) && $plantParameter == $plantId ) { ?>
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
