<?php

use PlantMonitor\View;

require_once '../vendor/autoload.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.0/css/bulma.min.css">
</head>

<body>
<?php View::get("navbar") ?>
<section class="section">
    <div class="container">
        <div class="columns is-multiline">
            <div class="column is-6">
                <h1 class="title mb-6">Kontakt</h1>
                <h2 class="subtitle">textemail@mail.com</h2>
                <h2 class="subtitle">Telefonnummer</h2>
                <form class="box">
                    <div class="field">
                        <h5 class="title is-5">Nachrichten direkt senden</h5>
                        <div class="control">
                            <input class="input" type="email" placeholder="E-Mail"/>
                        </div>
                        <div class="mt-2 control">
                            <input class="input" type="name" placeholder="Vor-und Nachname"/>
                        </div>
                    </div>

                    <textarea class="textarea" placeholder="Ihre Anfrage" rows="5"></textarea>

                    <button class="mt-2 button is-primary">Abschicken</button>
                </form>
            </div>

            <div class="column is-4">
                <figure class="image">
                    <img src="https://bulma.io/assets/images/placeholders/1280x960.png"/>
                </figure>
            </div>
        </div>
</section>
<?php View::get("footer") ?>
</body>

</html>
