<!-- inclusion des variables et fonctions -->
<?php include('config.php'); ?>
<?php include('includes/registration_login.php'); ?>
<?php include('includes/head_section.php'); ?>
<title>LifeBlog | Sign in </title>
</head>

<body>
	<div class="container">
		<!-- Navbar -->
		<?php include(ROOT_PATH . '/includes/navbar.php'); ?>
		<!-- // Navbar -->

		<div style="width: 40%; margin: 20px auto;">
			<form method="post" action="login.php">
				<h2>Connection</h2>
				<?php include(ROOT_PATH . '/includes/errors.php') ?>
				<input type="text" name="username" value="<?php echo $username; ?>" value="" placeholder="Username">
				<input type="password" name="password" placeholder="Password">
				<button type="submit" class="btn" name="login_btn">Connection</button>
				<p>
					Pas encore membre?? <a href="register.php">s'enregistrer</a>
				</p>
			</form>
		</div>
	</div>
	<!-- // container -->

	<!-- Footer -->
	<?php include(ROOT_PATH . '/includes/footer.php'); ?>
	<!-- // Footer -->