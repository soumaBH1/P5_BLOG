<?php session_start();
    include_once('./../config/mysql.php');
    include_once('./../config/user.php');
    include_once('./../variables.php');

$getData = $_GET;

if (!isset($getData['id']) && is_numeric($getData['id']))
{
	echo('Il faut un identifiant de blog post pour le modifier.');
    return;
}	

$retrieveBpostStatement = $mysqlClient->prepare('SELECT * FROM posts WHERE id = :id');
$retrieveBpostStatement->execute([
    'id' => htmlspecialchars($getData['id']),
]);

$bpost = $retrieveBpostStatement->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog IBH - Edition de Blog poste</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">

    <?php include_once($rootPath.'/header.php'); ?>
        <h1>Mettre à jour <?php echo($bpost['title']); ?></h1>
        <form action="<?php echo($rootUrl . 'blogpostes/post_update.php'); ?>" method="POST">
            <div class="mb-3 visually-hidden">
                <label for="id" class="form-label">Identifiant du blog poste</label>
                <input type="hidden" class="form-control" id="id" name="id" value="<?php echo($getData['id']); ?>">
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Titre du blog poste</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="title-help" value="<?php echo($bpost['title']); ?>">
                <div id="title-help" class="form-text">Choisissez un titre percutant !</div>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Contenue du blog poste</label>
                <textarea class="form-control" placeholder="Seulement du contenu vous appartenant ou libre de droits." id="content" name="content">
                <?php echo strip_tags($bpost['content']); ?>
                </textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
        <br />
    </div>

    <?php include_once($rootPath.'/footer.php'); ?>
</body>
</html>
