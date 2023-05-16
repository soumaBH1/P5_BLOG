<?php  include('config.php'); ?>
<?php  include('includes/public_functions.php'); ?>
 <?php $posts = getPublishedPosts(); ?>
 <?php
	if (isset($_GET['post-slug'])) {
		$post = getPost($_GET['post-slug']);
	}
	$chapos = getAllChapos();
	?>
<?php include('includes/head_section.php'); ?>
<title> <?php echo $post['title'] ?> | BLOG IBH</title>
</head>
<body>
<div class="container">
	<!-- Navbar -->
		<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
	<!-- // Navbar -->
	
	<div class="content" >
		<!-- Page wrapper -->
		<div class="post-wrapper">
			<!-- div Post complet-->
			<div class="full-post-div">
			<?php if ($post['published'] == false): ?>
				<h2 class="post-title">Désolé... ce post n'a pas éte publié</h2>
			<?php else: ?>
				<!-- Afficher le titre-->
				<h2 class="post-title"><?php echo $post['title']; ?></h2>
				<div class="post-body-div">
					<!-- Afficher le body-->
					<?php echo html_entity_decode($post['body']); ?>
				</div>
					<!-- Afficher la dernière date update-->
				<div class=".post-sidebar">
					<?php echo html_entity_decode($post['date_updated']); ?>
					<!-- Afficher l'auteur-->
					<?php echo html_entity_decode(getUsernameById($post['user_id'])); ?>
				</div>
				<div class="post-body-div">
					
					<?php echo html_entity_decode( getPostChapo($post['id'])); ?>
					
				</div>
			<?php endif ?>
			</div>
			<!-- // div post complet -->
			
			
		</div>
		<!-- // Page wrapper -->

		<!-- post sidebar -->
		<div class="post-Comments">
			<div class="card">
				<div class="card-header">
					<h2>Commentaires</h2>
				</div>
				<div class="card-content">
					<?php foreach ($comments as $comment): ?>
						<a 
							href="<?php echo BASE_URL . 'filtered_posts.php?comment=' . $comment['title'] ?>">
							<?php echo $comment['title']; ?>
						</a> 
					<?php endforeach ?>
				</div>
			</div>
		</div>
		<!-- // post sidebar -->
	</div>
</div>
<!-- // content -->

<?php include( ROOT_PATH . '/includes/footer.php'); ?>