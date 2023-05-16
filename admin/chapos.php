<?php include('../config.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
<!-- ramener tous les chapos de BDD -->
<?php $chapos = getAllChapos();	?>
<title>Admin | gérer chapos</title>
</head>

<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>
	<div class="container content">
		<!-- Afficher le menu sur la -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

		<!-- Middle form - to create and edit -->
		<div class="action">
			<h1 class="page-title">Créer/ Modifier Chapos</h1>
			<form method="post" action="<?php echo BASE_URL . 'admin/chapos.php'; ?>">
				<!-- validation errors for the form -->
				<?php include(ROOT_PATH . '/includes/errors.php') ?>
				<!-- if editing chapo, the id is required to identify that chapo -->
				<?php if ($isEditingChapo === true) : ?>
					<input type="hidden" name="chapo_id" value="<?php echo $chapo_id; ?>">
				<?php endif ?>
				<input type="text" name="chapo_name" value="<?php echo $chapo_name; ?>" placeholder="Chapo">
				<!-- if editing chapo, display the update button instead of create button -->
				<?php if ($isEditingChapo === true) : ?>
					<button type="submit" class="btn" name="update_chapo">Modifier</button>
				<?php else : ?>
					<button type="submit" class="btn" name="create_chapo">Enregistrer Chapo</button>
				<?php endif ?>
			</form>
		</div>
		<!-- // Formulaire de création et modification de chapos -->

		<!-- Affichage des enregistrement de la BDD-->
		<div class="table-div">
			<!-- Afficher les messages de notification -->
			<?php include(ROOT_PATH . '/admin/includes/messages.php') ?>
			<?php if (empty($chapos)) : ?>
				<h1>La liste des chapos est vide.</h1>
			<?php else : ?>
				<table class="table">
					<thead>
						<th>N</th>
						<th>Nom du Chapo</th>
						<th colspan="2">Action</th>
					</thead>
					<tbody>
						<?php foreach ($chapos as $key => $chapo) : ?>
							<tr>
								<td><?php echo $key + 1; ?></td>
								<td><?php echo $chapo['name']; ?></td>
								<td>
									<a class="fa fa-pencil btn edit" href="chapos.php?edit-chapo=<?php echo $chapo['id'] ?>">
									</a>
								</td>
								<td>
									<a class="fa fa-trash btn delete" href="chapos.php?delete-chapo=<?php echo $chapo['id'] ?>">
									</a>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>

	</div>
</body>

</html>