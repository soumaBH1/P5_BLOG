<?php
session_start();

include_once('./../config/mysql.php');
include_once('./../config/user.php');
include_once('./../variables.php');

$getData = $_GET;
if (!isset($getData['id']) && is_numeric($getData['id']))
{
	echo('Le blog poste n\'existe pas');
    return;
}	

$bpostId = $getData['id'];

$retrieveBpostWithCommentsStatement = $mysqlClient->prepare('SELECT * FROM posts p LEFT JOIN comments c on p.id = c.posts_id WHERE p.id = :id ');
$retrieveBpostWithCommentsStatement->execute([
    'id' => $bpostId,
]);

$bpostWithComments = $retrieveBpostWithCommentsStatement->fetchAll(PDO::FETCH_ASSOC);

$bpost = [
    'id' => $bpostWithComments[0]['id'],
    'title' => $bpostWithComments[0]['title'],
    'content' => $bpostWithComments[0]['content'],
    'user_id' => $bpostWithComments[0]['user_id'],
    'comments' => [],
];

foreach($bpostWithComments as $comment) {
    if (!is_null($comment['comment_id'])) {
        $bpost['comments'][] = [
            'comment_id' => $comment['comment_id'],
            'comment' => $comment['comment'],
            'user_id' => (int) $comment['user_id'],
        ];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog IBH - <?php echo($bpost['title']); ?></title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">

    <?php $rootPath = "C:\MAMP\htdocs"; include_once($rootPath.'/header.php'); ?>
        <h1><?php echo($bpost['title']); ?></h1>
        <div class="row">
            <article class="col">
                <?php echo($bpost['content']); ?>
            </article>
            <aside class="col">
                <p><i>Contribuée par <?php echo($bpost['user_id']); ?></i></p>
            </aside>
        </div>

        <?php if(count($bpost['comments']) > 0): ?>
        <hr />
        <h2>Commentaires</h2>
        <div class="row">
            <?php foreach($bpost['comments'] as $comment): ?>
                <div class="comment">
                    <p><?php echo($comment['comment']); ?></p>
                    <i>(<?php echo(display_user($comment['id'], $users)); ?>)</i>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <hr />
        <?php if (isset($loggedUser)) : ?>
            <?php $rootPath = "C:\MAMP\htdocs";  include_once($rootPath.'/comments/create.php'); ?>
        <?php endif; ?>
    </div>
    <?php $rootPath = "C:\MAMP\htdocs";  include_once($rootPath.'/footer.php'); ?>
</body>
</html>