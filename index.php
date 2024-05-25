<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlanMonitor</title>
</head>
<style>
    table, th, td {
  border: 1px solid;
}

th, td {
  padding: 10px;
  text-align: left;
}
</style>

<body>
    <table>
        <?php

        require_once realpath(__DIR__ . '/vendor/autoload.php');
        use Dotenv\Dotenv;

        $dotenv = Dotenv::createImmutable(__DIR__);
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
                "body" => 'from(bucket: "' . $bucket . '") |> range(start: -10h) |> filter(fn: (r) => r._measurement == "' . $bucket . '")'
            ]
        );

        $result_as_string = $res->getBody();
        $rows = explode("\n", $result_as_string);
        foreach ($rows as $row) {
            $cells = explode(",", $row);
            unset($cells[0]);
            unset($cells[1]);
            unset($cells[8]);
            unset($cells[9]);
            unset($cells[10]);
            unset($cells[11]);
            echo "<tr>";
            foreach ($cells as $cell) {
                if ($cells[2] == "table") {
                    echo "<th>" . $cell . "</th>";
                    continue;
                }
                echo "<td>" . $cell . "</td>";
            }
            echo "</tr>";
        }

        ?>
    </table>
</body>

</html>