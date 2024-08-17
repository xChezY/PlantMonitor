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

    $tempertureMin = 20;
    $tempertureMax = 30;
    $conductivityMin = 300;
    $conductivityMax = 800;
    $moistureMin = 50;
    $moistureMax = 80;

    // Überprüfen, ob eine ID in der URL vorhanden ist
    if (isset($_GET["id"])) {
        $plantID = $_GET["id"];
        $plant = getRandomPlantData($plantID);

        if ($plant != null) {
            showValues($plant);
        } else {
            echo "<h1 class='title has-text-centered'>Pflanze mit der ID $plantID existiert nicht :(</h1>";
        }
    } else {
        // Wenn keine ID vorhanden ist, Formular anzeigen
        echo '<h1 class="title has-text-centered mt-3">Sehen Sie ihre Pflanze ein!</h1>';
        echo '<div class="columns custom-margin">
                <div class="column is-half is-offset-one-quarter">
                    <form method="get">
                        <input name="id" class="input has-text-centered" type="number" min="1"
                            placeholder="Welche Nummer hat ihre Pflanze?" />
                        <div style="text-align: center;">
                            <button type="submit" class="button is-info mt-2">Info</button>
                        </div>
                    </form>
                </div>
              </div>';
    }

    function showValues($plant) {
        $temp = $plant["temp"];
        $conduct = $plant["conduct"];
        $water = $plant["water"];

        // Pflanzendaten anzeigen
        echo "<div class='columns custom-margin'>
                <div class='column is-half is-offset-one-quarter'>
                    <div class='box'>
                        <h2 class='title has-text-centered'>Pflanzendaten</h2>
                        <p><strong>Temperatur:</strong> $temp °C</p>
                        <p><strong>Leitfähigkeit:</strong> $conduct µS/cm</p>
                        <p><strong>Feuchtigkeit:</strong> $water %</p>
                    </div>
                </div>
              </div>";
    }
    ?>
    
    <style>
        .custom-margin {
            margin-top: 10rem;
        }
    </style>

    <?php include '../parts/footer.php'; ?>
</body>

</html>