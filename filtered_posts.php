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
			<!-- full post div -->
			<div class="full-post-div">
			<?php if ($post['published'] == false): ?>
				<h2 class="post-title">Sorry... ce post n'a pas éte publié</h2>
			<?php else: ?>
				<h2 class="post-title"><?php echo $post['title']; ?></h2>
				<div class="post-body-div">
					<?php echo html_entity_decode($post['body']); ?>
				</div>
			<?php endif ?>
			</div>
			<!-- // full post div -->
			
			
		</div>
		<!-- // Page wrapper -->

		<!-- post sidebar -->
		<div class="post-sidebar">
			<div class="card">
				<div class="card-header">
					<h2>chapos</h2>
				</div>
				<div class="card-content">
					<?php foreach ($chapos as $chapo): ?>
						<a 
							href="<?php echo BASE_URL . 'filtered_posts.php?chapo=' . $chapo['id'] ?>">
							<?php echo $chapo['name']; ?>
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