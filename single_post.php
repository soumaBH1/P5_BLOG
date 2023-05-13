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
				<div class="post" style="margin-left: 0px;">
				<img src="<?php echo BASE_URL . '/static/images/' . $post['image']; ?>" class="post_image" alt="">
       		 <!-- ... -->
				<?php if (isset($post['topic']['name'])): ?>
					 
						href="<?php echo BASE_URL . 'filtered_posts.php?topic=' . $post['topic']['id'] ?>"
						class="btn category">
						<?php echo $post['topic']['name'] ?>
						<a href="single_post.php?post-slug=<?php echo $post['slug']; ?>">
											
							<span><?php echo date("F j, Y ", strtotime($post["created_at"])); ?></span>
						
				
					</a>
				<?php endif ?>

		
			</div>
				<h2 class="post-title"><?php echo $post['title']; ?></h2>
				<div class="post-body-div">
					<?php echo html_entity_decode($post['body']); ?>
				</div>
			<?php endif ?>
			</div>
			 <!-- affichage du post -->
			<!-- comments section -->
		<div class="col-md-6 col-md-offset-3 comments-section">
			<!-- comment form -->
			<form class="clearfix" action="index.php" method="post" id="comment_form">
				<h4>Envoyer un commentaire:</h4>
				<textarea name="comment_text" id="comment_text" class="form-control" cols="30" rows="3"></textarea>
				<button class="btn btn-primary btn-sm pull-right" id="submit_comment">Submit comment</button>
			</form>

			<!-- Display total number of comments on this post  -->
			<h2><span id="comments_count">0</span> Comment(s)</h2>
			<hr>
			
		<!-- // comments section -->
	</div>
</div>

<!-- // content -->

<?php include( ROOT_PATH . '/includes/footer.php'); ?>