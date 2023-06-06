<?php include('../config.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>

<?php
// ramener tous les commentaires de la BDD
$comments = getAllComments();

?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
<title>Admin | Gérer les Commentaire</title>
</head>

<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>
	<div class="container content">
		<!-- menu du gauche -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>
		<!-- formulaire du milieu - pour créer et MAJ  -->
		<div class="action">
			<h1 class="page-title">Créer / Modifier les commentaires</h1>

			<form method="post" action="<?php echo BASE_URL . 'admin/comments.php'; ?>">

				<!-- erreurs de validation du formulaire -->
				<?php include(ROOT_PATH . '/includes/errors.php') ?>

				<!--si vous modifiez un commentaire, l'id  est requis pour identifier ce commentaire -->
				<?php if ($isEditingComment === true) : ?>
					<input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>">
				<?php endif ?>

				<label style="float: left; margin: 5px auto 5px;">Id utilisateur:</label>
				<input type="user_id" name="comment_user_id" value="<?php echo $comment_user_id; ?>" placeholder="N auteur">
				<label style="float: left; margin: 5px auto 5px;">Id post:</label>
				<input type="post_id" name="comment_post_id" value="<?php echo $comment_post_id ?>" placeholder="N post">
				<label style="float: left; margin: 5px auto 5px;">Commentaire:</label>
				<input type="text" name="comment_body" value="<?php echo $comment_body  ?>" placeholder="Commentaire">

				<!-- La case à cocher Publier est visible que pour les profils Admin -->
				<?php if ($_SESSION['user']['role'] == "admin") : ?>

					<!-- mettre la case à coché selon si le commentaire est publié ou non -->
					<?php if ($comment_published == true) : ?>
						<label for="publish">
							Publier
							<input type="checkbox" value="1" name="publish" checked="checked">&nbsp;
						</label>
					<?php else : ?>
						<label for="publish">
							Publier
							<input type="checkbox" value="0" name="publish">&nbsp;
						</label>
					<?php endif ?>
				<?php endif ?>


				<!-- si vous modifiez le commentaire, affichez le bouton de mise à jour au lieu du bouton de création -->
				<?php if ($isEditingComment === true) : ?>
					<button type="submit" class="btn" name="update_comment">Modifier</button>
				<?php else : ?>
					<button type="submit" class="btn" name="submit_comment">Enregistrer</button>
				<?php endif ?>
			</form>
		</div>
		<!-- // formulaire du milieu - pour créer et MAJ  -->

		<!--Afficher les enregistrements de la BDD -->
		<div class="table-div">
			<!-- Afficher le message de  notification -->
			<?php include(ROOT_PATH . '/admin/includes/messages.php') ?>

			<?php if (empty($comments)) : ?>
				<h1>Pas de commentaires dans la BDD.</h1>
			<?php else : ?>
				<table class="table">
					<thead>
						<th>Id</th>
						<th> Id Auteur</th>
						<th> Id Post</th>
						<th>Commentaire</th>
						<!-- que l'Admin est autorisé à publier / dépublier un commentaire -->

						<?php if ($_SESSION['user']['role'] == "admin") : ?>
							<th> Publier </th>
						<?php endif ?>
						<th colspan="2">Action</th>
					</thead>
					<tbody>
						<?php foreach ($comments as $key => $comment) : ?>
							<tr>
								<!-- <td><?php echo $key + 1; ?></td> -->
								<td> <?php echo $comment['id']; ?></td>
								<td> <?php echo $comment['user_id'];
										echo $comment['username']; ?> </td>
								<td> <?php echo $comment['post_id'];
										echo $comment['title']; ?> </td>
								<td> <?php echo $comment['body']; ?></td>
								<!-- que l'Admin est autorisé à publier / dépublier un commentaire -->
								<?php if ($_SESSION['user']['role'] == "admin") : ?>
									<td>
										<?php if ($comment['published'] == true) : ?>
											<a class="fa fa-check btn unpublish" href="comments.php?unpublish=<?php echo $comment['id'] ?>">
											</a>
										<?php else : ?>
											<a class="fa fa-times btn publish" href="comments.php?publish=<?php echo $comment['id'] ?>">
											</a>
										<?php endif ?>
									</td>
								<?php endif ?>


								<!-- Actions sur comments : editer et supprimer -->

								<td>
									<a class="fa fa-pencil btn edit" href="comments.php?edit-comment=<?php echo $comment['id'] ?>">
									</a>
								</td>

								<td>
									<a class="fa fa-trash btn delete" href="comments.php?delete-comment=<?php echo $comment['id'] ?>">
									</a>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
		<!-- // Afficher les enregistrements de la BDD -->
	</div>
</body>

</html>