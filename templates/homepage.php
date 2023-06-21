<!-- index.php -->
<!-- inclusion des variables et fonctions -->
<?php use Application\Model\Post;
 ob_start(); ?>
<h1>Le super blog de  !</h1>
<p>Derniers billets du blog :</p>


<?php

foreach ($posts as $post) {
?>
    <div class="news">
        <h3>
            <?= htmlspecialchars($post->getTitle()); ?>
            <em>le <?=  $post->getFrenchCreationDate(); ?></em>
        </h3>
        <p>
            <?= htmlspecialchars($post->getContent()); ?>
            <br />
            <em><a href="index.php?action=post&id=<?= urlencode($post->getIdentifier()) ?>">Commentaires</a></em>
        </p>
    </div>
<?php
}
?>
<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>
