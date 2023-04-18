<?php 
	// variable declaration
	$username = "";
	$email    = "";
	$firstname ="";
	$lastname ="";
	$age=NULL;
	$errors = array(); 

	// REGISTER USER
	if (isset($_POST['reg_user'])) {
		// receive all input values from the form
		$username = esc($_POST['username']);
		$email = esc($_POST['email']);
		$firstname = esc($_POST['firstname']);
		$lastname = esc($_POST['lastname']);
		$age = esc($_POST['age']);
		$password_1 = esc($_POST['password_1']);
		$password_2 = esc($_POST['password_2']);

		// form validation: ensure that the form is correctly filled
		if (empty($username)) {  array_push($errors, "Username obligatoire !"); }
		if (empty($email)) { array_push($errors, "Oops.. vous avez oublié l'Email !'"); }
		if (empty($firstname)) { array_push($errors, "Oops.. vous avez oublié le nom!'"); }
		if (empty($lastname)) { array_push($errors, "Oops.. vous avez oublié le prénom !'"); }
		if (empty($age)) { array_push($errors, "Oops.. vous avez oublié l'age' !'"); }
		if (empty($password_1)) { array_push($errors, "Oops.. vous avez oublié le mot de passe !"); }
		if ($password_1 != $password_2) { array_push($errors, "les deux mots de passe ne correspondent pas !");}

			// s'assurer qu'il n'ya pas de doublons. 
		// l' email et le usernames doivent être uniques
		$user_check_query = "SELECT * FROM users WHERE username='$username' 
								OR email='$email' LIMIT 1";

		$result = mysqli_query($conn, $user_check_query);
		$user = mysqli_fetch_assoc($result);

		if ($user) { // if user exists
			if ($user['username'] === $username) {
			  array_push($errors, "Username existe déjà!");
			}
			if ($user['email'] === $email) {
			  array_push($errors, "Email existe déjà!");
			}
		}
		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database
			$query = "INSERT INTO users (username, email, password, created_at, updated_at, firstname, lastname, age, admin) 
					  VALUES('$username', '$email', '$password', now(), now(), '$firstname', '$lastname', '$age', '$admin')";
			mysqli_query($conn, $query);

			// get id of created user
			$reg_user_id = mysqli_insert_id($conn); 

			// put logged in user into session array
			$_SESSION['user'] = getUserById($reg_user_id);

			// if user is admin, redirect to admin area
			if ( in_array($_SESSION['user']['role'], ["Admin", "Author"])) {
				$_SESSION['message'] = "Vous êtes maintenant connecté .";
				// redirect to admin area
				header('location: ' . BASE_URL . 'admin/dashboard.php');
				exit(0);
			} else {
				$_SESSION['message'] = "Vous êtes maintenant connecté .";
				// redirect to public area
				header('location: index.php');				
				exit(0);
			}
		}
	}

	// LOG USER IN
	if (isset($_POST['login_btn'])) {
		$username = esc($_POST['username']);
		$password = esc($_POST['password']);

		if (empty($username)) { array_push($errors, "Username required"); }
		if (empty($password)) { array_push($errors, "Password required"); }
		if (empty($errors)) {
			$password = md5($password); // encrypt password
			$sql = "SELECT * FROM users WHERE username='$username' and password='$password' LIMIT 1";

			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) {
				// get id of created user
				$reg_user_id = mysqli_fetch_assoc($result)['id']; 

				// put logged in user into session array
				$_SESSION['user'] = getUserById($reg_user_id); 

				// if user is admin, redirect to admin area
				if ( in_array($_SESSION['user']['role'], ["Admin", "Author"])) {
					$_SESSION['message'] = "You are now logged in";
					// redirect to admin area
					header('location: ' . BASE_URL . '/admin/dashboard.php');
					exit(0);
				} else {
					$_SESSION['message'] = "You are now logged in";
					// redirect to public area
					header('location: index.php');				
					exit(0);
				}
			} else {
				array_push($errors, 'Informations de connection erronées');
			}
		}
	}
	// escape value from form
	function esc(String $value)
	{	
		// bring the global db connect object into function
		global $conn;

		$val = trim($value); // remove empty space sorrounding string
		$val = mysqli_real_escape_string($conn, $value);

		return $val;
	}
	// Get user info from user id
	function getUserById($id)
	{
		global $conn;
		$sql = "SELECT * FROM users WHERE id=$id LIMIT 1";

		$result = mysqli_query($conn, $sql);
		$user = mysqli_fetch_assoc($result);

		// returns user in an array format: 
		// ['id'=>1 'username' => 'Awa', 'email'=>'a@a.com', 'password'=> 'mypass']
		return $user; 
	}
?>