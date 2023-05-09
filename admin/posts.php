<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/post_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
<!-- Ramener les posts de la BDD -->
<?php $posts = getAllPosts(); ?>
	<title>Admin | Gérer les blog Posts</title>
</head>
<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>

	<div class="container content">
		<!-- menu du gauche -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

		<!-- Afficher les enregistrements de la BDD-->
		<div class="table-div"  style="width: 80%;">
			<!-- afficher les  messages de notification -->
			<?php include(ROOT_PATH . '/admin/includes/messages.php') ?>

			<?php if (empty($posts)): ?>
				<h1 style="text-align: center; margin-top: 20px;">La liste des posts dans la base de données est vide.</h1>
			<?php else: ?>
				<table class="table">
						<thead>
						<th>N</th>
						<th>Auteur</th>
						<th>Titre</th>
						<th>Views</th>
						<!-- que l'Admin est autorisé à publier / dépublier post -->
						
						<?php if ($_SESSION['user']['role'] == "admin"): ?>
							<th><small>Publier</small></th>
						<?php endif ?>
						<th><small>Modifier</small></th>
						<th><small>Supprimer</small></th>
					</thead>
					<tbody>
					<?php foreach ($posts as $key => $post): ?>
						<tr>
							<td><?php echo $key + 1; ?></td>
							<td><?php echo $post['author']; ?></td>
							<td>
								<a 	target="_blank"
								href="<?php echo BASE_URL . 'single_post.php?post-slug=' . $post['slug'] ?>">
									<?php echo $post['title']; ?>	
								</a>
							</td>
							<td><?php echo $post['views']; ?></td>
							
							<!-- si Admin donc autorisé à publier / dépublier post -->
							<?php if ($_SESSION['user']['role'] == "admin" ): ?>
								<td>
								<?php if ($post['published'] == true): ?>
									<a class="fa fa-check btn unpublish"
										href="posts.php?unpublish=<?php echo $post['id'] ?>">
									</a>
								<?php else: ?>
									<a class="fa fa-times btn publish"
										href="posts.php?publish=<?php echo $post['id'] ?>">
									</a>
								<?php endif ?>
								</td>
							<?php endif ?>

							<td>
								<a class="fa fa-pencil btn edit"
									href="create_post.php?edit-post=<?php echo $post['id'] ?>">
								</a>
							</td>
							<td>
								<a  class="fa fa-trash btn delete" 
									href="create_post.php?delete-post=<?php echo $post['id'] ?>">
								</a>
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
		<!-- Afficher les enregistrements de la BDD-->
	</div>
</body>
</html>