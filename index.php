
<!-- index.php -->
 <!-- inclusion des variables et fonctions -->
 <?php require_once('config.php') ?>
<?php require_once( ROOT_PATH . '/includes/public_functions.php') ?>
<?php require_once( ROOT_PATH . '/includes/registration_login.php') ?>
<!-- ramener les postes publiees de la BDD  -->
<?php $posts = getPublishedPosts(); ?>

<?php require_once('includes/head_section.php') ?>
</head>
<body>
	<!-- container - -->
	<div class="container">
        
		<!-- navbar -->
		<?php include('includes/navbar.php') ?>
		<!-- // navbar -->
        <!-- banner -->
        <?php include('includes/banner.php') ?>
		

		<!-- footer -->
		<?php include('includes/footer.php') ?>
		

	</div>
	<!-- // container -->
</body>
</html>
