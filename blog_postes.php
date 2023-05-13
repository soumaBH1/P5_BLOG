<!-- index.php -->
<!-- inclusion des variables et fonctions -->
<?php require_once('config.php') ?>
<?php require_once( ROOT_PATH . '/includes/public_functions.php') ?>
<?php require_once( ROOT_PATH . '/includes/registration_login.php') ?>
<!-- Retrieve all posts from database  -->
<?php $posts = getPublishedPosts(); ?>

<?php require_once('includes/head_section.php') ?>
</head>
<body>
	<!-- container -  -->
	<div class="container">
		<!-- navbar -->
		<?php include('includes/navbar.php') ?>
		<!-- // navbar -->

		<!-- Page content -->
		<div class="content">
			<h2 class="content-title">Blogs posts récents</h2>
			<hr>
			<!-- listes des blog postes ... -->
			<!--  ... -->
		<?php foreach ($posts as $post): ?>
			<div class="post" style="margin-left: 0px;">
				<img src="<?php echo BASE_URL . '/static/images/' . $post['image']; ?>" class="post_image" alt="">
       		 <!-- Added this if statement... -->
				<?php if (isset($post['topic']['name'])): ?>
					<a 
						href="<?php echo BASE_URL . 'filtered_posts.php?topic=' . $post['topic']['id'] ?>"
						class="btn category">
						<?php echo $post['topic']['name'] ?>
					</a>
				<?php endif ?>

				<a href="single_post.php?post-slug=<?php echo $post['slug']; ?>">
					<div class="post_info">
						<h3><?php echo $post['title'] ?></h3>
						<div class="info">
							<span><?php echo date("F j, Y ", strtotime($post["created_at"])); ?></span>
							<span class="read_more">Lire plus...</span>
						</div>
					</div>
				</a>
			</div>
		<?php endforeach ?>
		
		</div>
	


		<!-- footer -->
		<?php include('includes/footer.php') ?>
		<!-- // footer -->

	</div>
	<!-- // container -->
</body>
</html>