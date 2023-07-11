<!-- index.php -->
<!-- inclusion des variables et fonctions -->
<link rel="stylesheet" href="static/css/public_styling.css">
<?php require_once('config.php') ?>
<?php require_once(ROOT_PATH . '/includes/public_functions.php') ?>
<?php require_once(ROOT_PATH . '/includes/registration_login.php') ?>
<!-- ramener les postes publiees de la BDD  -->
<?php $posts = getPublishedPosts(); ?>

    require('templates/error.php');
}
