<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog IBH - Page d'accueil</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">

    <!-- Navigation -->
    <?php include_once('header.php'); ?>

    <!-- Formulaire de connexion -->
    <?php  include_once('login.php'); ?>
        <h1>Blog IBH !</h1>

        <!-- Plus facile à lire -->
      <?php foreach(get_bpost($bposts, $limit) as $bpost) : ?>
            <article>
                <h3><a href="./blogpostes/read.php?id=<?php echo($bpost['id']); ?>"><?php echo($bpost['title']); ?></a></h3>
                 <div><?php echo($bpost['content']); ?></div>  
                 
                             <?php if(isset($loggedUser) &&  $loggedUser['email']==="ibh28031982@yahoo.fr"): ?>    <!-- permettre qu'au admin la manipulation des blogs postes -->
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item"><a class="link-warning" href="./blogpostes/update.php?id=<?php echo($bpost['id']); ?>">Editer l'article</a></li>
                        <li class="list-group-item"><a class="link-danger" href="./blogpostes/delete.php?id=<?php echo($bpost['id']); ?>">Supprimer l'article</a></li>
                        
                    </ul>
                <?php endif; ?>
            </article>
            
        <?php endforeach ?>
    </div>

    <?php  include_once('footer.php'); ?>
</body>
</html>