<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PlanMonitor</title>
    </head>
    <body>
        <pre>
            <?php

            require_once realpath(__DIR__ . '/vendor/autoload.php');
            use Dotenv\Dotenv;
            $dotenv = Dotenv::createImmutable(__DIR__);
            $dotenv->load();

            $client = new GuzzleHttp\Client();
            $url = $_ENV['INFLUX_DB_URL'];
            $key = $_ENV['INFLUX_DB_API_KEY'];
            $res = $client->request('POST', $url . "/api/v2/query",
                [
                    "headers" => [
                        "Authorization" => "Token ". $key,
                        "Content-Type" => "application/vnd.flux"
                    ],
                    "body" => 'from(bucket: "ttn_vhs")
                    |> range(start: -24h)
                    |> filter(fn: (r) => r._measurement == "ttn_vhs")'
                ]);
            echo $res->getBody();
            
            ?>
        </pre>
    </body>
</html>
