<?php include('config.php'); ?>

<?php include('includes/head_section.php'); ?>
<!DOCTYPE html>


<title>Contacter nous </title>
</head>

<body>
    <div class="container">
        <!-- Navbar -->
        <?php include(ROOT_PATH . '/includes/navbar.php'); ?>


        <body class="d-flex flex-column min-vh-100">
            <div class="container">

                <h1>Contactez nous</h1>
                <form action="submit_contact.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="email-help">
                        <div id="email-help" class="form-text">Nous ne revendrons pas votre email!</div>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Votre message</label>
                        <textarea class="form-control" placeholder="Exprimez vous" id="message" name="message"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
                <br />
            </div>

            <?php include('includes/footer.php') ?>
        </body>

        </html>