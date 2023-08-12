<?php $title = "blog IBH"; ?>

<?php ob_start(); ?>
<!-- container -  -->
<div class="container">


<!-- Page content -->
<div class="content">
    <h2 class="content-title">Liste des utilisateurs:</h2>
    <hr>
    <!-- liste des users ... -->
    <!--  ... -->
    <div class="users" style="margin-left: 0px;">
        <h3>
            <?= htmlspecialchars($user->getUsername()) ?>

        </h3>

              <?= htmlspecialchars($post->getEmail()) ?>
               <div class="info">
        
            <em>le <?= $post->getFrenchCreationDate() ?></em>
        </div>
    </div>


<?php
foreach ($users as $user) {
?>
    <p><strong><?= htmlspecialchars($user->getId()) ?></strong> le <?= $user->getFrenchCreationDate() ?></p>
    <p><?= nl2br(htmlspecialchars($user->getUsername())) ?></p>
<?php
}
?></div>
</div>
<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>