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
                "body" => 'from(bucket: "' . $bucket . '") |> range(start: -10h)  |> filter(fn: (r) => r._measurement == "' . $bucket . '")'
            ]
        );

        $remove_attribute = [0,1,8,9,10,11];
        $result_as_string = $res->getBody();
        $rows = explode("\n", $result_as_string);
        $counter = 0;
        $current = "";
        $header_array = explode(",",$rows[0]);
        foreach($remove_attribute as $index){
            unset($header_array[$index]);
        }
        $header_table = "<tr><th>".implode("</th><th>",$header_array)."</th></tr>";
        for($i = 0; $i < count($rows); $i++){
            $cells = explode(",", $rows[$i]);
            if ($cells[2] == "table"){
                unset($rows[$i]);
                continue;
            }
            if($current == $cells[2] || $current == ""){
                $current = $cells[2];
                $counter++;
                continue;
            }
            
        }
        $rows = array_values($rows);
        for($i = 0; $i < $counter; $i++){
            echo "<h3>Pflanze Nr.".$i."</h3><table>".$header_table;
            for($j = 0; $j < count($rows); $j+=$counter){
                $order = $rows[$i+$j];
                $cells = explode(",", $order);
                foreach($remove_attribute as $index){
                    unset($cells[$index]);
                }
                echo "<tr>";
                foreach ($cells as $cell) {
                    echo "<td>" . $cell . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }

        ?>
</body>

</html>