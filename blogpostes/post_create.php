<?php
session_start();

include_once('./../config/mysql.php');
include_once('./../config/user.php');
include_once('./../variables.php');

$postData = $_POST;

if (
    !isset($postData['title']) 
    || !isset($postData['post'])
    )
{
	echo('Il faut un titre et un  blog post pour soumettre le formulaire.');
    return;
}	

$title = $postData['title'];
$blogpost = $postData['post'];
$userid=1;

$insertblogpost = $mysqlClient->prepare('INSERT INTO posts( title, content,date, users_id, is_enabled, date_deleated) VALUES ( :title, :content, :date, :users_id, :is_enabled, :date_deleated)');
$insertblogpost->execute([
    'date' => htmlspecialchars(date('Y-m-d')), // insert current date and time,
    'title' => htmlspecialchars($title),
    'content' => htmlspecialchars($blogpost), //sécuriser les entrees de donnees
     'users_id' => htmlspecialchars($userid),
     'is_enabled' => '1',
     'date_deleated' => NULL, 
   ]);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes - Création de recette</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">

    <?php $rootPath = "C:\MAMP\htdocs"; include_once($rootPath.'/header.php'); ?>
        <h1>Blog post ajouté avec succès !</h1>
        
        <div class="card">
            
            <div class="card-body">
                <h5 class="card-title"><?php echo($title); ?></h5>
                <p class="card-text"><b>Email</b> : <?php echo($loggedUser['email']); ?></p>
                <p class="card-text"><b>Blog post</b> : <?php echo strip_tags($blogpost); ?></p>
            </div>
        </div>
    </div>
    <?php $rootPath = "C:\MAMP\htdocs";  include_once($rootPath.'/footer.php'); ?>
</body>
</html>