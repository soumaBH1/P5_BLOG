<?php $title = "blog IBH"; ?>

<?php ob_start(); ?>
<!-- container -  -->
<div class="container">
<p><a href="index.php">Retour à la liste des billets</a></p>


<!-- Page content -->
<div class="content">
    <h2 class="content-title">Blogs posts récents</h2>
    <hr>
    <!-- liste des blog posts ... -->
    <!--  ... -->
    <div class="post" style="margin-left: 0px;">
        <h3>
            <?= htmlspecialchars($post->getTitle()) ?>

        </h3>

        <div class="post_info">
            <?= htmlspecialchars($post->getContent()) ?>
        </div>
        <div class="info">
        
            <em>le <?= $post->getFrenchCreationDate() ?></em>
        </div>
    </div>

	<!-- // container -->
<h2>Commentaires</h2>

<form action="index.php?action=addComment&id=<?= $post->getIdentifier() ?>" method="post">
    <div>
        <label for="author">Auteur</label><br />
        <input type="text" id="author" name="author" />
    </div>
    <div>
        <label for="comment">Commentaire</label><br />
        <textarea id="comment" name="comment"></textarea>
    </div>
    <div>
        <input type="submit" />
    </div>
</form>

<?php
foreach ($comments as $comment) {
?>
    <p><strong><?= htmlspecialchars($comment->getUser_id()) ?></strong> le <?= $comment->getFrenchCreationDate() ?></p>
    <p><?= nl2br(htmlspecialchars($comment->getBody())) ?></p>
<?php
}
?></div>
</div>
<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>