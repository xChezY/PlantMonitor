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
    require_once  '../vendor/autoload.php';

    use PlantMonitor\Database;
    use PlantMonitor\View;
    use PlantMonitor\ConfigManager;

    View::get("navbar");

    $plantid = $_GET["plant"]??"lse01-vhs-projekt";
    $aktuellePflanze;
    $configmanager = new ConfigManager();
    $testplant = $configmanager->getPlantConfig($plantid);

    $db = new Database();
    $plant = $db->getPlantData($plantid);
    
    ?>

    <pre>
        <?php print_r($plant); ?> 
    </pre>

    <div class="pt-4 pl-6 field">
        <label class="label">Wähle eine Pflanze</label>
        <form method="GET">
        <div class="control">
            <div class="select">
                <select name="plant" id="pflanzeDropdown" onchange="this.form.submit()">
                    <option value="">Auswählen...</option>
                    <?php
                    foreach ($configmanager->getAllPlantsIds() as $plantId) {?>
                        <option
                         value="<?php echo $plantId ?>"
                         <?php if($_GET["plant"]==$plantId) {?>
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

    <div class="block pl-6 pr-6">
        <nav class="panel is-info">
            <p class="panel-heading">
                Zeitpunkt der Messung
            </p>
            <p class="panel-tabs">
                <?php
                $first = true;

    foreach (array_keys($plant) as $key) {
        if ($first) {
            echo '<a class="is-active clickable has-text-grey-light" id="' . $key . '"></a>';
            $first = false;
        } else {
            echo '<a class="clickable has-text-grey-light" id="' . $key . '"></a>';
        }
    }
    ?>
            </p>
        </nav>
    </div>

    <div class="block pl-6 pr-6">

        <div class="block">
            <h5 class="title is-5">Bodenleitfähigkeit in µS(Mikrosiemens) </h5>
            <div class="box" type="text">
                <p id="conduct_SOIL"></p>
            </div>
        </div>

        <div class="block">
            <h5 class="title is-5">Bodentemperatur in °C</h5>
            <div class="box" type="text">
                <p id="temp_SOIL"></p>
            </div>
        </div>

        <div class="block">
            <h5 class="title is-5">Bodenfeuchtigkeit in %</h5>
            <div class="box" type="text">
                <p id="water_SOIL"></p>
            </div>
        </div>

        <div class="block">
            <h5 class="title is-5">Breitengrad</h5>
            <div class="box" type="text">
                <p id="latitude"></p>
            </div>
        </div>

        <div class="block">
            <h5 class="title is-5">Längengrad</h5>
            <div class="box" type="text">
                <p id="longitude"></p>
            </div>
        </div>

    </div>

    <style>
        .custom-margin {
            margin-top: 10rem;
        }
    </style>

    <?php View::get("footer"); ?>
</body>

</html>
