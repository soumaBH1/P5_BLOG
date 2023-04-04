
<!-- index.php -->
<?php
try
{
    $db = new PDO('mysql:host=localhost;dbname=myblog;charset=utf8', 'root', 'root');
}
catch (Exception $e)
{ // En cas d'erreur, on affiche un message et on arrête tout -->rediriger vers une autre page avec un message derreur
        die('Erreur : ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Ibtissel BEN HAMMOUDA - Page d'accueil</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">

    <?php include_once('header.php'); ?>
        <h1>BLOG IBH</h1>

        <!-- inclusion des variables et fonctions -->
        <?php
            include_once('variables.php');
            include_once('functions.php');
        ?>

        <!-- inclusion de l'entête du site -->
        <?php include_once('header.php'); ?>
        
       
    </div>

    <!-- inclusion du bas de page du site -->
    <?php include_once('footer.php'); ?>
</body>
</html>
