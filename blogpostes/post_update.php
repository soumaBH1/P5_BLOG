<?php
session_start();

include_once('./../config/mysql.php');
include_once('./../config/user.php');
include_once('./../variables.php');

$postData = $_POST;

if (
    !isset($postData['id'])
    || !isset($postData['title']) 
    || !isset($postData['content'])
    )
{
	echo('Il manque des informations pour permettre l\'édition du formulaire.');
    return;
}	

$id = $postData['id'];
$title = $postData['title'];
$content = $postData['content'];

$insertBpostStatement = $mysqlClient->prepare('UPDATE posts SET title = :title, content = :content WHERE id = :id');
$insertBpostStatement->execute([
    'title' => htmlspecialchars($title),
    'content' => htmlspecialchars($content),
    'id' => htmlspecialchars($id),
]);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog IBH - Création de blog post</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">

    <?php include_once($rootPath.'/header.php'); ?>
        <h1>Blog post modifiée avec succès !</h1>
        
        <div class="card">
            
            <div class="card-body">
                <h5 class="card-title"><?php echo($title); ?></h5>
                 <p class="card-text"><b>Email</b> : <?php echo($loggedUser['email']); ?></p>
                <p class="card-text"><b>Blog poste</b> : <?php echo strip_tags($content); ?></p>
            </div>
        </div>
    </div>
    <?php include_once($rootPath.'/footer.php'); ?>
</body>
</html>