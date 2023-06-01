<?php include('config.php'); ?>
<?php include('includes/public_functions.php'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
<?php


global $comments, $comment, $user_id;
if (isset($_GET['post-slug'])) {
	$post = getPost($_GET['post-slug']);
	$post_id = $post['id'];
	$user_id = $post['user_id'];
	//Ramener tous les commentaires d'un post 
	$comments = getAllCommentsByPostId($post_id);
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
			<div class="post-wrapper-singleP">
				<!-- affichage du post  -->
				<div class="full-post-div">
					<?php if ($post['published'] == false) : ?>
						<h2 class="post-title">Désolé... Ce post n'est pas encore publié</h2>
					<?php else : ?>
						<?php $chapo = getPostChapo($post['id']);
						//A voir comment faire pour résoudre!
						$chapo1 = '' . implode(', ', $chapo); ?>
						<div class="post" style="margin-left: 0px;">
							<img src="<?php echo BASE_URL . '/static/images/' . $post['image']; ?>" class="post_image" alt="">
							<!-- ... -->
							<?php if (isset($chapo)) : ?>

								<a <?php echo BASE_URL . 'single_post.php?chapo=' . $chapo1 ?>" class="btn category">
									<?php echo $chapo1 ?>
									<a href="single_post.php?post-slug=<?php echo $post['slug']; ?>">

										<span><?php echo date("F j, Y ", strtotime($post["date_updated"])); ?></span>


									</a>
								<?php endif ?>
								<div class="post-body-div-details">
									<?php echo ("modifié le:"); ?>
									<?php echo html_entity_decode($post['date_updated']); ?>
									<?php echo ("Uername:"); ?>
									<?php echo html_entity_decode(getUsernameById($post['user_id'])); ?>
								</div>

						</div>

						<h2 class="post-title"><?php echo $post['title']; ?></h2>
						<div class="post-body-div">
							<?php echo html_entity_decode($post['body']); ?>


						</div>
					<?php endif ?>
				</div>
			</div>
			<!-- affichage du post -->
		</div>
		<hr>
		<!-- Afficher tous les commentaires publiés de ce post-->

		<?php $post_id = $post['id'];
		$comments = getAllCommentsByPostId($post_id); ?>
		<?php echo (getCommentsCountByPostId($post_id)); ?> Commentaires:
		<hr>


		<table class="tableC">
			<thead>
				<th>Commentaire</th>
				<th>Auteur</th>
				<th>Date</th>
			</thead>
			<tbody>
				<?php foreach ($comments as $key => $comment) : ?>
					<tr>
						<td><?php $key + 1;
							echo $comment['body']; ?></td>
						<td><?php echo getUsernameById($comment['user_id']); ?></td>
						<td><?php echo date("F j, Y ", strtotime($comment['created_at'])); ?></td>
					</tr>
			</tbody>
		<?php endforeach ?>
		</table>
		<hr>
		<!-- /* - - - - - - - - - - -->
		<!-- -   actions Comments-->
		<!-- - - - - - // si l'utilisateur clique sur le bouton Commentaire- - - - - -*/-->
		<!-- - - - - -Que les utilisateurs connectés sont autorisés a envoyer des commentaires - - - - - -*/-->
		<?php if (isset($_SESSION['user'])) : ?>
			<?php if (isset($_POST['create_comment'])) {
				$nouvelleCle = "user_id";
				$nouvelleValeur = $post['user_id'];
				$_POST[$nouvelleCle] = $nouvelleValeur;
				//print_r($_POST); exit;;
				createComment($_POST);
			} ?> <?php endif ?>
		<!-- Middle form - créer des commentaires-->
		<div class="action">
			<!-- Si l'utililistateur est connecté alors il peut commenter -->
			<?php if (isset($_SESSION['user'])) : ?>
				<h2 class="page-title">Ajouter un Commentaire</h1>
					<form method="post" action="<?php echo BASE_URL . 'single_post.php'; ?>">
						<!--  -->


						<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
						<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

						<input type="text" name="comment_body" value="">
						<button type="submit" class="btn" name="create_comment">Enregistrer commentaire</button>
					<?php endif ?>
					</form>
		</div>
		<!-- // Formulaire de création de commentaires -->





	</div>
	<!-- // container -->
	<?php include(ROOT_PATH . '/includes/footer.php'); ?>
</body>

</html>