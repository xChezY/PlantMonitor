<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.0/css/bulma.min.css">
</head>

<body>
    <?php include '../assets/navbar.php'; ?>
    <section class="section">
        <style>
            .container {
                margin-left: 50px;
            }

            .subtitle {
                margin-left: 30px;
                margin-top: 90px;
            }

            .box {
                margin-left: 50px;
                width: 500px;
            }

            .box1 {
                margin-left: 0px;
                height: 100px;

            }

            .box2 {
                margin-left: 50px;
                margin-top: 90px;
            }
        </style>
        <div class="container">
            <div class="box box1">
                <h1 class="title">Kontaktieren Sie uns!</h1>
            </div>

            <h2 class="subtitle">textemail@mail.com</h2>
            <h2 class="subtitle">Telefonnummer</h2>

        </div>

        <form class="box box2">
            <div class="field">
                <h5 class="title is-5">Nachrichten direkt senden</h5>
                <label class="label">Ihre Email</label>
                <div class="control">
                    <input class="input" type="email" placeholder="e.g. alex@example.com" />
                </div>
                <label class="mt-2 label">Ihren vollständigen Namen</label>
                <div class="mt-2 control">
                    <input class="input" type="name" placeholder="Max Mustermann" />
                </div>
            </div>

            <textarea class="textarea" placeholder="" rows="5"></textarea>

            <button class="mt-2 button is-primary">Abschicken</button>
        </form>
        <?php include '../assets/footer.php'; ?>
</body>

</html>