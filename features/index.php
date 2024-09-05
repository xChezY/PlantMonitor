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
    include '../parts/navbar.php';
    include '../includes/database.php';

    $aktuellePflanze;
    $tempertureMin = 20;
    $tempertureMax = 30;
    $conductivityMin = 300;
    $conductivityMax = 800;
    $moistureMin = 50;
    $moistureMax = 80;

    $plant = getPlantData(1);
    ?>


    <div class="field columns is-centered">
        <div class="column is-half">
            <label class="label">Wähle eine Pflanze</label>
            <div class="control">
                <div class="select">
                    <select name="pflanze" id="pflanzeDropdown">
                        <option value="">Auswählen...</option>
                        <?php
                        for ($i = 1; $i <= getIDCount(); $i++) {
                            echo '<option value="' . $i . '">Pflanze ' . $i . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="block pl-6 pr-6">
        <nav class="panel">
            <p class="panel-heading">
                Zeitpunkt der Messung
            </p>
            <p class="panel-tabs">
                <?php
                for ($i = 1; $i <= count($plant); $i++) {
                    if ($i == 1) {
                        echo '<a class="is-active" id="timestamp_' . $i . '"></a>';
                        continue;
                    }
                    echo '<a id="timestamp_' . $i . '"></a>';
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

        function setFormData(plantData) {

            const sortedKeys = Object.keys(plantData).sort();
            var i = 1;
            sortedKeys.forEach(key => {
                const data = plantData[key];
                document.getElementById('timestamp_' + i).innerHTML = data.date;
                i++;
                document.getElementById('conduct_SOIL').innerHTML = data.conduct_SOIL;
                document.getElementById('temp_SOIL').innerHTML = data.temp_SOIL;
                document.getElementById('latitude').innerHTML = data.latitude;
                document.getElementById('longitude').innerHTML = data.longitude;
                document.getElementById('water_SOIL').innerHTML = data.water_SOIL;
            });
        }

        // Select the dropdown element
        const dropdown = document.querySelector('#pflanzeDropdown');

        // Add an event listener for the 'change' event
        dropdown.addEventListener('change', function (event) {
            // Get the selected value
            const selectedValue = event.target.value;
            // Log the selected value to the console
            if (selectedValue == 1) {
                console.log('Selected value:', selectedValue);
                setFormData(plant);
            }
        });


    </script>

    <style>
        .custom-margin {
            margin-top: 10rem;
        }
    </style>

    <?php include '../parts/footer.php'; ?>
</body>

</html>