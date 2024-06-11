<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlanMonitor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.0/css/bulma.min.css">
</head>

<body>
    <?php include '../assets/navbar.php'; ?>
    <?php

    require_once realpath(dirname(__DIR__, 1) . '/vendor/autoload.php');
    use Dotenv\Dotenv;

    $dotenv = Dotenv::createImmutable(dirname(__DIR__, 1));
    $dotenv->load();

    $client = new GuzzleHttp\Client();
    $url = $_ENV['INFLUX_DB_URL'];
    $key = $_ENV['INFLUX_DB_API_KEY'];
    $bucket = $_ENV["BUCKET"];
    $res = $client->request(
        'POST',
        $url . "/api/v2/query",
        [
            "headers" => [
                "Authorization" => "Token " . $key,
                "Content-Type" => "application/vnd.flux"
            ],
            "body" => '
                import "strings"
                from(bucket: "' . $bucket . '")
                |> range(start: -10h)
                |> filter(fn: (r) => contains(value: r._field, set: ["temp_SOIL","water_SOIL","conduct_SOIL"]))
                '
        ]
    );

    $remove_attribute = [0, 1, 8, 9, 10, 11];
    $result_as_string = $res->getBody();
    $rows = explode("\n", $result_as_string);
    $counter = 0;
    $current = "";
    $header_array = explode(",", $rows[0]);
    foreach ($remove_attribute as $index) {
        unset($header_array[$index]);
    }
    $header_table = "<tr><th>" . implode("</th><th>", $header_array) . "</th></tr>";
    for ($i = 0; $i < count($rows); $i++) {
        $cells = explode(",", $rows[$i]);
        if (count($cells) == 1 || $cells[2] == "table") { // Remove unnecessary lines when count($cells) == 1 then the line is empty and has no content. 
            unset($rows[$i]); // If $cells[2] == "table" then this is the header line, which sometimes repeats in the table.
            continue;
        }
        if ($current == $cells[2] || $current == "") { //Goal: Find the number of rows per plant. As long as the first value exists. 
            $current = $cells[2];// If the table has a specific number, the number of times this number appears in the following rows is counted.
            $counter++;
            continue;// In the end, we can now say that the variable 'current' holds the number of rows for the respective plant.
        }

    }
    $pflanzen = array();
    $rows = array_values($rows);
    for ($i = 0; $i < $counter; $i++) {
        $pflanze = array();
        for ($j = 0; $i + $j < count($rows); $j += $counter) { // Goal: Sort the table by plants instead of by attributes.
            $order = $rows[$i + $j]; // Always iterate over the n-th element of the attributes and place them into a table.
            $cells = explode(",", $order);
            foreach ($remove_attribute as $index) {
                unset($cells[$index]);
            }
            $pflanze[] = $cells[6];
        }
        $pflanzen[] = $pflanze; // Save the data from the fifth column of the plant into the array.
    }
    print_r($pflanzen[1][0]); // Print the data from the fifth column of the second plant. DEBUGGING!
    
    ?>
    <style>
        .custom-margin {
            margin-top: 10rem;
        }
    </style>


    <h1 class="title has-text-centered">Sehen Sie ihre Pflanze ein!</h1>
    <div class="columns custom-margin">
        <div class="column is-half is-offset-one-quarter">
            <form method="post">
                <input name="myInput" class="input has-text-centered" type="text"
                    placeholder="Welche Nummer hat ihre Pflanze?" />
                <div style="text-align: center;">
                    <button type="submit" class="button is-info mt-2">Info</button>
                </div>
            </form>
        </div>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $inputValue = $_POST['myInput'];
        echo "<h1 class='title has-text-centered'>Die Pflanze mit der Nummer $inputValue hat folgende Werte:</h1>";
        echo "<h2 class='subtitle has-text-centered mt-6'>Bodenleitfähigkeit: " . $pflanzen[$inputValue][0] . " µS</h2>";
        echo "<h2 class='subtitle has-text-centered'>Bodentemperatur: " . $pflanzen[$inputValue][1] . " °C</h2>";
        echo "<h2 class='subtitle has-text-centered'>Bodenfeuchtigkeit: " . $pflanzen[$inputValue][2] . " cb (Zentibar)</h2>";
    }
    ?>

    <?php include '../assets/footer.php'; ?>
</body>

</html>