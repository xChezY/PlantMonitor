<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <?php

        require_once __DIR__ . '/vendor/autoload.php';

        $client = new GuzzleHttp\Client();
        $url = getenv("INFLUX_DB_URL");
        $key = getenv("INFLUX_DB_API_KEY");
        echo $url . "\n" . $key;
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
