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
                                <img src="/assets/732FF582-2EB6-446A-A41E-C874B10BF9A3.jpeg"
                                     alt="Merlin Hofmann"/>
                                     <figcaption>Merlin Hofmann</figcaption>
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="cell is-col-span-2 ml-6">
                    <div class="content">
                        <p class="title">About us</p>
                        <p>
                            Wir sind eine Gruppe von Jugendlichen, die im Rahmen eines Projektes des Schülerforschungszentrums Hameln-Pyrmont zusammen mit merona eine Plattform zur Überwachung von Pflanzen entwickeln.
                        </p>
                        <p>    
                            Mit dieser Plattform wollen wir Leuten aus unserem Landkreis die Möglichkeit geben, die individuellen, akuten Bedürfnisse ihrer Pflanzen einfach und von Überall einzusehen.
                        </p>
                        <p>    
                            Anfangs, im Januar 2024, hatten wir noch keine Vorstellung davon, was für ein Projekt wir umsetzen wollen, uns war nur klar, dass unser Projekt unserer Region langfristig helfen soll.
                        </p>
                        <p>    
                            Nach Abwägung von einigen Vorschlägen, hat sich herauskristallisiert, dass wir mit dem Projekt PlantMonitor effektiv eine reale Problematik von Vereinen, sowie Privatpersonen des Landkreises lösen können.
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
