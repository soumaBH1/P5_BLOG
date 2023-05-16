<?php include('config.php'); ?>
<?php include('includes/public_functions.php'); ?>
<?php
global $comments, $comment;
if (isset($_GET['post-slug'])) {
	$post = getPost($_GET['post-slug']);
}
?>
<?php include('includes/head_section.php'); ?>
<title> <?php echo $post['title'] ?> | Blog IBH</title>
</head>

<body>
	<div class="container">
		<!-- Navbar -->
		<?php include(ROOT_PATH . '/includes/navbar.php'); ?>
		<!-- // Navbar -->

		<div class="content">
			<!-- affichage de l'enveloppe de posts -->
			<div class="post-wrapper">
				<!-- affichage du post  -->
				<div class="full-post-div">
					<?php if ($post['published'] == false) : ?>
						<h2 class="post-title">Désolé... Ce post n'est pas encore publié</h2>
					<?php else : ?>
						<?php $chapo = getPostChapo($post['id']);
						echo ($chapo) ?>
						<div class="post" style="margin-left: 0px;">
							<img src="<?php echo BASE_URL . '/static/images/' . $post['image']; ?>" class="post_image" alt="">
							<!-- ... -->
							<?php if (isset($chapo)) : ?>

								<a href="<?php echo BASE_URL . 'single_post.php?chapo=' . $post['chapo']['id'] ?>" class="btn category">
									<?php echo $chapo ?>
									<a href="single_post.php?post-slug=<?php echo $post['slug']; ?>">

										<span><?php echo date("F j, Y ", strtotime($post["date_updated"])); ?></span>


									</a>
								<?php endif ?>


						</div>

						<h2 class="post-title"><?php echo $post['title']; ?></h2>
						<div class="post-body-div">
							<?php echo html_entity_decode($post['body']); ?>

							<div class="post-body-div-details">
								<?php echo ("modifié le:"); ?>
								<?php echo html_entity_decode($post['date_updated']); ?>
								<?php echo ("Uername:"); ?>
								<?php echo html_entity_decode(getUsernameById($post['user_id'])); ?>
							</div>
						</div>
					<?php endif ?>
				</div>
			</div>
			<!-- affichage du post -->
		</div>
	</div>
	<!-- comments section -->
	<!--Afficher les enregistrements de la BDD -->
	<div class="table-div">


		<!-- comment form  ceci est visible pour les admin il est possible de calider, modifier ou supprimer un commentaire-->
		<!-- Afficher les commentaires de ce post-->
		<?php $post_id = $post['id'];
		$comments = getAllCommentsByPostId($post_id); ?>
		<table class="table">
			<thead>
				<th>N</th>
				<th>commentaire</th>
				<th colspan="2">Action</th>
			</thead>
			<tbody>
				<?php foreach ($comments as $key => $comment) : ?>
					<tr>
						<td><?php echo $key + 1; ?></td>
						<td><?php echo $comment['body']; ?></td>
						<td>
							<a class="fa fa-pencil btn edit" 
							href="single_post.php?edit-comment=<?php echo $comment['id'] ?>">
							</a>
						</td>
						<td>
							<a class="fa fa-trash btn delete" 
							href="comment.php?delete-comment=<?php echo $comment['id'] ?>">
							</a>
						</td>
					</tr>

					<div class="table-div">
						<h2 class="post-title">Commentaires:</h2>
						<h3><?php echo $comment['body'] ?></h3>
						<div class=".comment-details">
							<span><?php echo date("F j, Y ", strtotime($comment["created_at"])); ?></span>

						<?php endforeach ?>

						</div>
					</div>
	</div>

				</body>

		<?php include(ROOT_PATH . '/includes/footer.php'); ?>