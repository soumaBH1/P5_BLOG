<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/post_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
<!-- Ramener les chapos de la BDD -->
<?php $chapos = getAllChapos();	?>
	<title>Admin | Céer un Blog Post</title>
</head>
<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>

	<div class="container content">
		<!-- afficher le menu sur la gauche -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

		<!-- Formulaire de création et modification de blog posts -->
		<div class="action create-post-div">
			<h1 class="page-title">Créer/ Gérer les Blog Posts</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo BASE_URL . 'admin/create_post.php'; ?>" >
				<!-- validation errors for the form -->
			

				<!-- Si MAJ de post, id nécessaire pour identifier ce post -->
				<?php if ($isEditingPost === true): ?>
					<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
				<?php endif ?>

				<input type="text" name="title" value="<?php echo $title; ?>" placeholder="Title">
				<label style="float: left; margin: 5px auto 5px;">Image</label>
				<input type="file" name="featured_image" >
				<textarea name="body" id="body" cols="30" rows="10"><?php echo $body; ?></textarea>
				<select name="chapo_id">
					<option value="" selected disabled>Choisir un chapo</option>
					<?php foreach ($chapos as $chapo): ?>
						<option value="<?php echo $chapo['id']; ?>">
							<?php echo $chapo['name']; ?>
						</option>
					<?php endforeach ?>
				</select>
			
				<!-- La case à cocher Publier est visible que pour les profils Admin -->
				<?php if ($_SESSION['user']['role'] == "admin"): ?>
					
					<!-- mettre la case à coché selon si le post est publié ou non -->
					<?php if ($published == true): ?>
						<label for="publish">
							Publier
							<input type="checkbox" value="1" name="publish" checked="checked">&nbsp;
						</label>
					<?php else: ?>
						<label for="publish">
							Publier
							<input type="checkbox" value="0" name="publish">&nbsp;
						</label>
					<?php endif ?>
				<?php endif ?>
				
				<!-- s'il s agit de modifier le post, afficher le boutton modifier a la place du boutton créer  -->
				<?php if ($isEditingPost === true): ?> 
					<button type="submit" class="btn" name="update_post">Modifier</button>
				<?php else: ?>
					<button type="submit" class="btn" name="create_post">Créer</button>
				<?php endif ?>

			</form>
		</div>
		<!-- // Formulaire de création et modification de blog posts -->
	</div>
</body>
</html>
