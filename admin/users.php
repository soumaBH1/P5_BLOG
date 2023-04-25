<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php 
	// ramener tous les admin users de la BDD
	$admins = getAdminUsers();
	$roles = ['Admin', 'Author'];				
?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
	<title>Admin | Manage users</title>
</head>
<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>
	<div class="container content">
		<!-- menu du gauche -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>
		<!-- formulaire du milieu - pour créer et MAJ  -->
		<div class="action">
			<h1 class="page-title">Create/Edit Admin User</h1>

			<form method="post" action="<?php echo BASE_URL . 'admin/users.php'; ?>" >

				<!-- erreurs de validation du formulaire -->
				<?php include(ROOT_PATH . '/includes/errors.php') ?>

				<!--si vous modifiez un utilisateur, l'id  est requis pour identifier cet utilisateur -->
				<?php if ($isEditingUser === true): ?>
					<input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
				<?php endif ?>

				<input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username">
				<input type="email" name="email" value="<?php echo $email ?>" placeholder="Email">
				<input type="firstname" name="firstname" value="<?php echo $firstname  ?>" placeholder="Firstname">
				<input type="lastname" name="lastname" value="<?php echo $lastname ?>" placeholder="Lastname">
				<input type="age" name="age" value="<?php echo $age ?>" placeholder="Age">
				<input type="password" name="password" placeholder="Password">
				
				<input type="password" name="passwordConfirmation" placeholder="Password confirmation">
				<select name="role">
					<option value="" selected disabled>Assign role</option>
					<?php foreach ($roles as $key => $role): ?>
						<option value="<?php echo $role; ?>"><?php echo $role; ?></option>
					<?php endforeach ?>
				</select>

				<!-- si vous modifiez l'utilisateur, affichez le bouton de mise à jour au lieu du bouton de création -->
				<?php if ($isEditingUser === true): ?> 
					<button type="submit" class="btn" name="update_admin">Modifier</button>
				<?php else: ?>
					<button type="submit" class="btn" name="create_admin">Enregistrer</button>
				<?php endif ?>
			</form>
		</div>
		<!-- // formulaire du milieu - pour créer et MAJ  -->

		<!--Afficher les enregistrements de la BDD -->
		<div class="table-div">
			<!-- Afficher le message de  notification -->
			<?php include(ROOT_PATH . '/admin/includes/messages.php') ?>

			<?php if (empty($admins)): ?>
				<h1>Pas d'admin dans la BDD.</h1>
			<?php else: ?>
				<table class="table">
					<thead>
						<th>N</th>
						<th>Admin</th>
						<th>Role</th>
						<th colspan="2">Action</th>
					</thead>
					<tbody>
					<?php foreach ($admins as $key => $admin): ?>
						<tr>
							<!-- <td><?php echo $key + 1; ?></td> -->
							<td>
								<?php echo $admin['username']; ?>, &nbsp;
								<?php echo $admin['email']; ?>	
							</td>
							<td><?php echo $admin['role']; ?></td>
							<td>
								<a class="fa fa-pencil btn edit"
									href="users.php?edit-admin=<?php echo $admin['id'] ?>">
								</a>
							</td>
							<td>
								<a class="fa fa-trash btn delete" 
								    href="users.php?delete-admin=<?php echo $admin['id'] ?>">
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