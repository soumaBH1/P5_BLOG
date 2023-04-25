<?php  include('config.php'); ?>
<?php  include('includes/public_functions.php'); ?>
<?php 
	if (isset($_GET['post-slug'])) {
		$post = getPost($_GET['post-slug']);
	}
	$chapos = getAllChapos();
?>
<?php include('includes/head_section.php'); ?>
<title> <?php echo $post['title'] ?> | Blog IBH</title>
</head>
<body>
<div class="container">
	<!-- Navbar -->
		<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
	<!-- // Navbar -->
	
	<div class="content" >
		<!-- affichage de l'enveloppe de posts -->
		<div class="post-wrapper">
			<!-- affichage du post  -->
			<div class="full-post-div">
			<?php if ($post['published'] == false): ?>
				<h2 class="post-title">Désolé... Ce post n'est pas encore publié</h2>
			<?php else: ?>
				<h2 class="post-title"><?php echo $post['title']; ?></h2>
				<div class="post-body-div">
					<?php echo html_entity_decode($post['body']); ?>
				</div>
			<?php endif ?>
			</div>
			 <!-- affichage du post -->
			
			<!-- comments section -->
			<!--  coming soon ...  -->
		</div>
		

		
	</div>
</div>
<!-- // content -->

<?php include( ROOT_PATH . '/includes/footer.php'); ?>