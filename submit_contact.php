<!-- inclusion des variables et fonctions -->
<?php include('config.php'); ?>
<?php include('includes/registration_login.php'); ?>
<?php include('includes/head_section.php'); ?>
</head>
<?php
//session_start();

$postData = $_POST;

if (!isset($postData['email']) || !isset($postData['message'])) {
    echo ('Il faut un email et un message pour soumettre le formulaire.');
    return;
}

$email = $postData['email'];
$message = $postData['message'];

?>

<!DOCTYPE html>
<html>


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nous Contacter</title>

</head>

<body>
    <div class="container">

        <h1>Message bien reçu !</h1>

        <div class="card">

            <div class="card-body">
                <h5 class="card-title">Rappel de vos informations</h5>
                <p class="card-text"><b>Email</b> : <?php echo ($email); ?></p>
                <p class="card-text"><b>Message</b> : <?php echo strip_tags($message); ?></p>
            </div>
        </div>
    </div>

</body>


</html>