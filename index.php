<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlanMonitor</title>
</head>

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
                "body" => 'from(bucket: "' . $bucket . '") |> range(start: -20m) |> filter(fn: (r) => r._measurement == "ttn_vhs")'
            ]
        );

        $result_as_string = $res->getBody();
        $rows = explode("\n", $result_as_string);
        //$array = explode("\n,result,table,_start,_stop,_time,_value,_field,_measurement,device_id,host,topic", $res->getBody());
        //var_dump($rows);
        


        foreach ($rows as $row) {
            $cells = explode(",", $row);
            $is_header = str_starts_with($cells[1], "result");

            ?>
            <tr>
                <?php
                foreach ($cells as $cell) {
                    if ($is_header) {
                        ?>
                        <th>
                            <?php
                            $cell ?>
                        </th>
                        <?php
                    } else {
                        ?>
                        <td>
                            <?php
                            $cell ?>
                        </td>
                        <?php
                    }

                }
                ?>
            </tr>
            <?php
        }



        ?>
    </table>
    <table>
        <tr>
            <th>Company</th>
            <th>Contact</th>
            <th>Country</th>
        </tr>
    </table>
</body>

</html>