<?php 
	// declaration des variables 
	$username = "";
	$email    = "";
	$firstname ="";
	$lastname ="";
	$age=NULL;
	$errors = array(); 

	// ENREGISTRER UN UTILISATEUR
	if (isset($_POST['reg_user'])) {
		// recevoir toutes les valeurs d'entrée du formulaire
		$username =esc($_POST['username']);
		$email = esc($_POST['email']);
		$firstname = esc($_POST['firstname']);
		$lastname = esc($_POST['lastname']);
		$age = esc($_POST['age']);
		$password_1 = esc($_POST['password_1']);
		$password_2 = $_POST['password_2'];

		// validation du formulaire : s'assurer que le formulaire est correctement rempli
		if (empty($username)) {  array_push($errors, "Username obligatoire !"); }
		if (empty($email)) { array_push($errors, "Oops.. vous avez oublié l'Email !'"); }
		if (empty($firstname)) { array_push($errors, "Oops.. vous avez oublié le nom!'"); }
		if (empty($lastname)) { array_push($errors, "Oops.. vous avez oublié le prénom !'"); }
		if (empty($age)) { array_push($errors, "Oops.. vous avez oublié l'age' !'"); }
		if (empty($password_1)) { array_push($errors, "Oops.. vous avez oublié le mot de passe !"); }
		if ($password_1 != $password_2) { array_push($errors, "les deux mots de passe ne correspondent pas !");}

			// s'assurer qu'il n'y a pas de doublons.
			// l'email et les noms d'utilisateur doivent être uniques
			//try
			//{
			//	$db = new PDO('mysql:host=localhost;dbname=myblog;charset=utf8', 'root', 'root');
			//}
			//	catch (Exception $e)
			//{        die('Erreur : ' . $e->getMessage());
			//}
			//$user_check_query = $db->prepare('SELECT * FROM users WHERE username=:username OR email=:email LIMIT 1');
						//	$user_check_query->execute([
							//	'username'=>htmlspecialchars('$username'),
						//		'email'=>htmlspecialchars('$email'),//htmlhtmlspecialchars pour prévenir les attaques xss(Cross Site Scripting)
								
						 // ])or die(print_r($db->errorCode()));
		$user_check_query = "SELECT * FROM users WHERE username='$username' 
								OR email='$email' LIMIT 1";

		$result = mysqli_query($conn, $user_check_query);
		$user = mysqli_fetch_assoc($result);
		//chaque utilisateur enregistré est un auteur par défaut! est ce bon?
		$role="author";
		if ($user) { //si l'utilisateur existe
			if ($user['username'] === $username) {
			  array_push($errors, "Username existe déjà!");
			}
			if ($user['email'] === $email) {
			  array_push($errors, "Email existe déjà!");
			}
		}
		// enregistrer l'utilisateur s'il n'y a pas d'erreurs dans le formulaire
		 //var_dump($username, $email, $password_1, $firstname, $lastname, $age, $role);
		//exit;
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database
			$query = "INSERT INTO users (username, email, password, created_at, updated_at, firstname, lastname, age, role) 
					  VALUES('$username', '$email', '$password', now(), NULL, '$firstname', '$lastname', '$age', '$role')";
			mysqli_query($conn, $query);

			// obtenir l'identifiant de l'utilisateur créé
			$reg_user_id = mysqli_insert_id($conn);

			// mettre l'utilisateur connecté dans le tableau de session
			$_SESSION['user'] = getUserById($reg_user_id);

			// si l'utilisateur est un admin, rediriger vers la zone d'administration
			if ( in_array($_SESSION['user']['role'], ["Admin", "Author"])) {
				$_SESSION['message'] = "Vous êtes maintenant connecté .";
				// rediriger vers la zone d'administration
				header('location: ' . BASE_URL . 'admin/dashboard.php');
				exit(0);
			} else {
				$_SESSION['message'] = "Vous êtes maintenant connecté .";
				// rediriger vers la zone publique
				header('location: index.php');				
				exit(0);
			}
		}
	}

	// CONNEXION DE L'UTILISATEUR
	if (isset($_POST['login_btn'])) {
		$username = esc($_POST['username']);
		$password = esc($_POST['password']);

		if (empty($username)) { array_push($errors, "Username required"); }
		if (empty($password)) { array_push($errors, "Password required"); }
		if (empty($errors)) {
			$password = md5($password); // chiffrer le mot de passe
			$sql = "SELECT * FROM users WHERE username='$username' and password='$password' LIMIT 1";

			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) {
				// obtenir l'identifiant de l'utilisateur créé
				$reg_user_id = mysqli_fetch_assoc($result)['id']; 

				// mettre l'utilisateur connecté dans le tableau de session
				$_SESSION['user'] = getUserById($reg_user_id); 

				// si l'utilisateur est administrateur, rediriger vers la zone d'administration
				if ( in_array($_SESSION['user']['role'], ["Admin", "Author"])) {
					$_SESSION['message'] = "Vous êtes maintenant connecté.";
					// rediriger vers la zone d'administration
					header('location: ' . BASE_URL . '/admin/dashboard.php');
					exit(0);
				} else {
					$_SESSION['message'] = "Vous êtes maintenant connecté.";
					// rediriger vers la zone publique
					header('location: index.php');				
					exit(0);
				}
			} else {
				array_push($errors, 'Informations de connection erronées');
			}
		}
	}
	// Cette fonction est une implémentation de la désinfection d'entrée en PHP pour une utilisation dans une application de base de données.
	function esc(String $value)
	{	
		// mettre l'objet global db connect
		global $conn;

		$val = trim($value); // supprimer les caractères d'espacement au début et à la fin de la chaîne en utilisant la fonction trim()
		$val = mysqli_real_escape_string($conn, $value); //échapper les caractères qui ont une signification spéciale dans les requêtes SQL, tels que les guillemets et les points-virgules

		return $val;
	}
	// Obtenir des informations sur l'utilisateur à partir de l'id
	function getUserById($id)
	{
		global $conn;
		$sql = "SELECT * FROM users WHERE id=$id LIMIT 1";

		$result = mysqli_query($conn, $sql);
		$user = mysqli_fetch_assoc($result);

		return $user; 
	}
?>