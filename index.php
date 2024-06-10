<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.0/css/bulma.min.css">
</head>

<body>
    <?php include 'assets/navbar.php'; ?>
    <section class="section">
        <div class="container">
            <h1 class="title">
                PlanMonitor
            </h1>
            <p class="subtitle">
                Monitor your plans
            </p>
            <progress class="progress is-danger" value="50" max="100">
                15%
            </progress>
            <a href="/features" class="button is-link">Virus installieren</a>
        </div>
    </section>
    <?php include 'assets/footer.php'; ?>
</body>

</html>