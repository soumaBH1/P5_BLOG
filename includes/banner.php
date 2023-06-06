<div class="banner">
	<div class="welcome_msg">
		<!-- message inspiration -->
		<h1>Inspiration</h1>
		<p>
			“Un voyage de mille lieues <br>
			commence toujours <br>
			par un premier pas.” <br>
			<span>~ De Lao-Tseu Philosophe</span>
		</p>

	</div>
	<!-- si l'utilisateur est déja connecté : mettre un message de bienvenu personnaliséavec son username -->
	<?php if (isset($_SESSION['user']['username'])) { ?>
		<div class="logged_in_info">
			<span>Bienvenue <?php echo $_SESSION['user']['username'] ?></span>
			|
			<span><a class="logout-link" href="logout.php">Se déconnecter</a></span>
		</div>
	<?php } else { ?>
		<!-- si non : mettre un message 'Rejoigner nous' et  le formulaire de connection-->
		<div class="banner">
			<div class="welcome_msg">

				<a href="register.php" class="btn">Rejoignez-nous!</a>
			</div>
			<div class="login_div">
				<form action="<?php echo BASE_URL . 'index.php'; ?>" method="post">
					<h2>Connection</h2>
					<div style="width: 60%; margin: 0px auto;">
						<?php include(ROOT_PATH . '/includes/errors.php') ?>
					</div>
					<input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username">
					<input type="password" name="password" placeholder="Password">
					<button class="btn" type="submit" name="login_btn">Se connecter</button>
				</form>
			</div>
		</div>
	<?php } ?>