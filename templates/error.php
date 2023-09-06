<?php $title = "Le blog de IBH"; ?>

<?php ob_start(); ?>
<h1>Erreur !</h1>
<p>Une erreur est survenue : <?= $errorMessage ?></p>
<?php $content = ob_get_clean(); ?>

