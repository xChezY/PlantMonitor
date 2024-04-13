<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PlanMonitor</title>
    </head>
    <body>
        <?php

        require_once realpath(__DIR__ . '/vendor/autoload.php');
        use Dotenv\Dotenv;
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $client = new GuzzleHttp\Client();
        $url = $_ENV['INFLUX_DB_URL'];
        $key = $_ENV['INFLUX_DB_API_KEY'];
        $res = $client->request('GET', $url,
            [
                "headers" => [
                    "Authorization" => "Token ". $key
                ]
            ]);
        echo $res->getStatusCode();
        echo $res->getBody();
        
        ?>
    </body>
</html>
