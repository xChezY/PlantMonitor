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

</section>
<section class="section is-large" id="about">
    <div class="container">
        <div class="fixed-grid has-3-cols">
            <div class="grid">
                <div class="cell">
                    <div class="card">
                        <div class="card-image">
                            <figure class="image is-1by1">
                                <img src="\assets\PlantWithSensor.png"
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
    <p class="title has-text-centered mb-6">Unterstüzung</p>
    <div class="container">
        <div class="fixed-grid has-5-cols">
            <div class="grid">
                <div class="cell is-col-start-2">
                    <div class="card">
                        <div class="card-image">
                            <figure class="image">
                                <img src="\assets\SmartCityLogo.png"
                                     alt="Placeholder image"/>
                            </figure>
                        </div>
                        <div class="card-content">
                            <div class="content has-text-centered">
                                <h5>Ha-Py Smart City</h5>
                                Ideen und Projekte für eine liebenswerte und lebenswerte Zukunft im Landkreis Hameln-Pyrmont
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cell is-col-start-4">
                    <div class="card">
                        <div class="card-image">
                            <figure class="image" style="padding: 20px";>
                                <img src="\assets\merona-schriftzug-neu.svg"/>
                            </figure>
                        </div>
                        <div class="card-content">
                            <div class="content has-text-centered">
                                <h5>merona</h5>
                                Projektbegleitung während der Treffen und Unterstützung bei der Umsetzung unserer Ideen und Konzepte.
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
