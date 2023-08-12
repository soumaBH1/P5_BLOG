<title>Blog | Se connecter </title>
</head>

<body>
<? ob_start(); ?>
	<div class="container">
		
		<div style="width: 40%; margin: 20px auto;">
			<form method="post" action="login.php">
				<h2>Connection</h2>
				<?php include(ROOT_PATH . '/includes/errors.php') ?>
				<input type="text" name="username" value="<?php echo $username; ?>" value="" placeholder="Username">
				<input type="password" name="password" placeholder="Password">
				<button type="submit" class="btn" name="login_btn">Connection</button>
				<p>
					Pas encore membre?? <a href="register.php">s'enregistrer :</a>
				</p>
			</form>
		</div>
	</div>