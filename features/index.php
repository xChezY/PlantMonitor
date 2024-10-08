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

    $plantid = "lse01-vhs-projekt";
    $aktuellePflanze;
    $configmanager = new ConfigManager();
    $testplant = $configmanager->getPlantConfig($plantid);

    $db = new Database();
    $plant = $db->getPlantData($plantid);
    ?>


    <div class="pt-4 pl-6 field">
        <label class="label">Wähle eine Pflanze</label>
        <div class="control">
            <div class="select">
                <select name="pflanze" id="pflanzeDropdown">
                    <option value="">Auswählen...</option>
                    <?php
                    for ($i = 1; $i <= $configmanager->getCount(); $i++) {
                        echo '<option value="' . $i . '">Pflanze ' . $i . '</option>';
                    }
    ?>
                </select>
            </div>
        </div>
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


    <script>
        var plant = <?php echo json_encode($plant); ?>;
        var minTemp = <?php echo $configmanager->getMinTemp($plantid); ?>;
        var maxTemp = <?php echo $configmanager->getMaxTemp($plantid); ?>;;
        var minConduct = <?php echo $configmanager->getMinConduct($plantid); ?>;;
        var maxConduct = <?php echo $configmanager->getMaxConduct($plantid); ?>;;
        var minWater = <?php echo $configmanager->getMinWater($plantid); ?>;;
        var maxWater = <?php echo $configmanager->getMaxWater($plantid); ?>;;

        function setAttributes(plantData) {
            document.getElementById('conduct_SOIL').innerHTML = plantData.conduct_SOIL;
            document.getElementById('temp_SOIL').innerHTML = plantData.temp_SOIL;
            document.getElementById('water_SOIL').innerHTML = plantData.water_SOIL;
            if (plantData.conduct_SOIL < minConduct) {
                document.getElementById('conduct_SOIL').innerHTML = plantData.conduct_SOIL + " (zu niedrig)";
            }else if (plantData.conduct_SOIL > maxConduct){
                document.getElementById('conduct_SOIL').innerHTML = plantData.conduct_SOIL + " (zu hoch)";
            }
            if (plantData.temp_SOIL < minTemp) {
                document.getElementById('temp_SOIL').innerHTML = plantData.temp_SOIL + " (zu kalt)";
            }else if (plantData.temp_SOIL > maxTemp){
                document.getElementById('temp_SOIL').innerHTML = plantData.temp_SOIL + " (zu warm)";
            }
            if (plantData.water_SOIL < minWater) {
                document.getElementById('water_SOIL').innerHTML = plantData.water_SOIL + " (zu niedrig)";
            }else if (plantData.water_SOIL > maxWater){
                document.getElementById('water_SOIL').innerHTML = plantData.water_SOIL + " (zu hoch)";
            }
        }

        function setFormData(plantData) {

            const sortedKeys = Object.keys(plantData).sort();
            const firstdata = plantData[sortedKeys[0]];
            sortedKeys.forEach(key => {
                const data = plantData[key];
                document.getElementById(key).innerHTML = data.date;
            });
            document.getElementById('latitude').innerHTML = firstdata.latitude;
            document.getElementById('longitude').innerHTML = firstdata.longitude;
            setAttributes(firstdata);
        }

        function changeAttributesByTimestamp(timestamp) {
            const plantData = plant[timestamp];
            document.getElementById('conduct_SOIL').innerHTML = plantData.conduct_SOIL;
            document.getElementById('temp_SOIL').innerHTML = plantData.temp_SOIL;
            document.getElementById('water_SOIL').innerHTML = plantData.water_SOIL;
            setAttributes(plantData);
        }

        const dropdown = document.querySelector('#pflanzeDropdown');
        dropdown.addEventListener('change', function (event) {
            const selectedValue = event.target.value;
            if (selectedValue == 1) {
                console.log('Selected value:', selectedValue);
                setFormData(plant);
            }
        });

        const links = document.querySelectorAll('a.clickable');

        links.forEach(link => {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                const activeLink = document.querySelector('a.is-active');
                if (activeLink) {
                    activeLink.classList.remove('is-active');
                }
                event.target.classList.add('is-active');
                changeAttributesByTimestamp(event.target.id);
            });
        });


    </script>

    <style>
        .custom-margin {
            margin-top: 10rem;
        }
    </style>

    <?php View::get("footer"); ?>
</body>

</html>
