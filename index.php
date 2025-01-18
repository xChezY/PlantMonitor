<?php
require_once './vendor/autoload.php' ;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.0/css/bulma.min.css">
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<?php
echo file_exists("config.yaml")
?>
<body>
<?php include 'parts/navbar.php'; ?>
<section class="section">

    <h1 class="title">
        PlantMonitor
    </h1>
    <p class="subtitle mb-6">
        Monitor your plans
    </p>

    <p class="subtitle has-text-centered mt-6">
        Image gallery
    </p>
</section>
<section class="section is-large" id="about">
    <div class="container">
        <div class="fixed-grid has-3-cols">
            <div class="grid">
                <div class="cell">
                    <div class="card">
                        <div class="card-image">
                            <figure class="image is-1by1">
                                <img src="https://bulma.io/assets/images/placeholders/1280x960.png"
                                     alt="Placeholder image"/>
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="cell is-col-span-2 ml-6">
                    <div class="content">
                        <p class="title">About us</p>
                        <p>
                            Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
                            invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.
                            At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no
                            sea takimata sanctus est Lorem ipsum dolor sit amet.
                            Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
                            invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.
                            At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no
                            sea takimata sanctus est Lorem ipsum dolor sit amet.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section is-large">
    <p class="title has-text-centered mb-6">Sponsoren</p>
    <div class="container">
        <div class="fixed-grid has-5-cols">
            <div class="grid">
                <div class="cell is-col-start-2">
                    <div class="card">
                        <div class="card-image">
                            <figure class="image is-1by1">
                                <img src="https://bulma.io/assets/images/placeholders/1280x960.png"
                                     alt="Placeholder image"/>
                            </figure>
                        </div>
                        <div class="card-content">
                            <div class="content has-text-centered">
                                <h5>Sponsor 1</h5>
                                Lorem ipsum leo risus, porta ac consectetur ac
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cell is-col-start-4">
                    <div class="card">
                        <div class="card-image">
                            <figure class="image is-1by1">
                                <img src="https://bulma.io/assets/images/placeholders/1280x960.png"
                                     alt="Placeholder image"/>
                            </figure>
                        </div>
                        <div class="card-content">
                            <div class="content has-text-centered">
                                <h5>Sponsor 2</h5>
                                Lorem ipsum leo risus, porta ac consectetur ac
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<?php include 'parts/footer.php'; ?>
</body>

</html>
