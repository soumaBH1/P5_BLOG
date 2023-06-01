<?php include('config.php'); ?>
<!-- Code source pour gérer l'enregistrement et la connexion-->
<?php include('includes/registration_login.php'); ?>
<?php include('config/mysql.php'); ?>
<?php include('includes/head_section.php'); ?>

<title>Blog IBH | Créatin de compte </title>
</head>

<body>
	<div class="container">
		<!-- Navbar -->
		<?php include(ROOT_PATH . '/includes/navbar.php'); ?>
		<!-- // Navbar -->

		<div style="width: 40%; margin: 20px auto;">
			<form method="post" action="register.php">
				<h2>Création de compte sur Blog IBH</h2>
				<?php include(ROOT_PATH . '/includes/errors.php') ?>
				<input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username">
				<input type="email" name="email" value="<?php echo $email ?>" placeholder="Email">
				<input type="firstname" name="firstname" value="<?php echo $firstname  ?>" placeholder="Firstname">
				<input type="lastname" name="lastname" value="<?php echo $lastname ?>" placeholder="Lastname">
				<input type="age" name="age" value="<?php echo $age ?>" placeholder="Age">
				<input type="password" name="password_1" placeholder="Password">
				<input type="password" name="password_2" placeholder="Password confirmation">
				<button type="submit" class="btn" name="reg_user">Register</button>
				<p>
					Vous avez déjà un compte? <a href="login.php">Connection</a>
				</p>
			</form>
		</div>
	</div>
	<!-- // container -->
	<!-- Footer -->
	<?php include(ROOT_PATH . '/includes/footer.php'); ?>
	<!-- // Footer -->