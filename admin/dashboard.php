	<?php include('../config.php'); ?>
	<link rel="stylesheet" href="static/css/public_styling.css">
	<?php include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
	<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
	<title>Admin | Dashboard</title>
	</head>

	<body>
		<div class="header">
			<div class="logo">
				<a href="<?php echo BASE_URL . 'admin/dashboard.php' ?>">
					<h1>Blog IBH - Admin</h1>
				</a>
			</div>
			<?php if (isset($_SESSION['user'])) : ?>
				<div class="user-info">
					<span><?php echo $_SESSION['user']['username'] ?></span> &nbsp; &nbsp;
					<a href="<?php echo BASE_URL . '/logout.php'; ?>" class="logout-btn">Logout</a>
				</div>
			<?php endif ?>
		</div>
		<div class="container dashboard">
			<h1>Bienvenue</h1>
			<div class="stats">
				<a href="users.php" class="first">
					<span>20</span> <br>
					<span>Utilisateurs enregistrés</span>
				</a>
				<a href="posts.php">
					<span>20</span> <br>
					<span>Blog posts</span>
				</a>
				<a href="chapos.php">
					<span>20</span> <br>
					<span>Chapos</span>
				</a>
			</div>
			<br><br><br>
			<div class="buttons">
				<a href="users.php">Ajouter des utilisateurs</a>
				<a href="posts.php">Ajouter des blog posts</a>
				<a href="chapos.php">Ajouter des chapos</a>
			</div>
		</div>
	</body>

	</html>