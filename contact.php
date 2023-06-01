<?php include('config.php'); ?>
<?php 
error_reporting(-1);
ini_set("display_errors","On");

?>

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
                        <label for="name" class="form-label">Nom / Prénom :</label>
                        <input type="name" class="form-control" id="name" name="name" >
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="email-help">
                        <div id="email-help" class="form-text">Vos données restent confidentiels!</div>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message:</label>
                        <input type="textarea" class="form-control" placeholder="Exprimez vous" id="message" name="message" aria-describedby="">
                        
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
                <br />
            </div>
            <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    
    // Adresse e-mail de destination
    $to = "ibh28031982@yahoo.fr";
    
    // Sujet de l'e-mail
    $subject = "Nouveau message de contact";
    
    // Contenu de l'e-mail
    $email_content = "Nom: $name\n";
    $email_content .= "E-mail: $email\n";
    $email_content .= "Message: $message\n";
    
    // En-têtes de l'e-mail
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    
    // Envoi de l'e-mail
    $mail_return=mail($to, $subject, $email_content, $headers);
    var_dump($mail_return);exit;
    if ($mail_return) {
        echo "Votre message a été envoyé avec succès.";
    } else {
        echo "Une erreur est survenue lors de l'envoi du message.";
    }
}
?>

            <?php include('includes/footer.php') ?>
        </body>

        </html>