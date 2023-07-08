<!-- index.php -->
<!-- inclusion des variables et fonctions -->

<?php use Application\Model\Post;
// definir les constantes globales

 ob_start(); ?>


<?php
foreach ($posts as $post) {
?>
     <div class="post" style="margin-left: 0px;">
			<img src="<?php echo  'static/images/' . $post->getImage(); ?>" class="post_image" alt="">
				
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

