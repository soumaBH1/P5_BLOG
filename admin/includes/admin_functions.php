<?php  include(ROOT_PATH . '/config/mysql.php'); ?>
<?php 
// Variables utilisateur administrateur
$admin_id = 0;
$isEditingUser = false;
$username = "";
$role = "";
$email = "";
$firstname ="";
$lastname ="";
$age ="";
// variables générales
$errors = [];
// variables du chapo 
$chapo_id = 0;
$isEditingChapo = false;
$chapo_name = "";

/* - - - - - - - - - - 
-  Actions des utilisateurs administrateurs
- - - - - - - - - - -*/
// si l'admin clique sur le bouton Créer un utilisateur
if (isset($_POST['create_admin'])) {
	createAdmin($_POST);
}
// si l'admin clique sur le bouton éditer un utilisateur
if (isset($_GET['edit-admin'])) {
	$isEditingUser = true;
	$admin_id = $_GET['edit-admin'];
	editAdmin($admin_id);
}
// si l'admin clique sur le bouton modifier un utilisateur
if (isset($_POST['update_admin'])) {
	updateAdmin($_POST);
}
// si l'admin clique sur le bouton supprimer un utilisateur
if (isset($_GET['delete-admin'])) {
	$admin_id = $_GET['delete-admin'];
	deleteAdmin($admin_id);
}

/* - - - - - - - - - - 
-   actions chapos
- - - - - - - - - - -*/
// si l'admin clique sur le bouton créer un chapo
if (isset($_POST['create_chapo'])) { createChapo($_POST); }
// si l'admin clique sur le bouton modifier un chapo
if (isset($_GET['edit-chapo'])) {
	$isEditingChapo = true;
	$chapo_id = $_GET['edit-chapo'];
	editChapo($chapo_id);
}
// si l'admin clique sur le bouton update un chapo
if (isset($_POST['update_chapo'])) {
	updateChapo($_POST);
}
// si l'admin clique sur le bouton supprimer un chapo
if (isset($_GET['delete-chapo'])) {
	$chapo_id = $_GET['delete-chapo'];
	deleteChapo($chapo_id);
}
/* - - - - - - - - - - - -
-  Fonctions des utilisateurs administrateurs
- - - - - - - - - - - - -*/
/* * * * * * * * * * * * * * * * * * * * * * *
* - Reçevoir les données du nouvel'admin à partir du formulaire
* - Créer un nouvel utilisateur administrateur
* - Renvoie tous les utilisateurs administrateurs avec leurs rôles 
* * * * * * * * * * * * * * * * * * * * * * */
function createAdmin($request_values){
	//var_dump($request_values);
	//exit;
	global $conn, $errors, $role, $username, $email;
	$username = esc($request_values['username']);
	$email = esc($request_values['email']);
	$password = esc($request_values['password']);
	$passwordConfirmation = esc($request_values['passwordConfirmation']);

	if(isset($request_values['role'])){
		$role = esc($request_values['role']);
	}
	// validation du formulaire : s'assurer que le formulaire est correctement rempli
	if (empty($username)) { array_push($errors, "Oops....Il faut remplir le username!"); }
	if (empty($email)) { array_push($errors, "Oops.. Email est obligatoire!"); }
	if (empty($role)) { array_push($errors, "Oops..Le rôle est obligatoire!");}
	if (empty($password)) { array_push($errors, "Oops.. Vous avez oubliés le password!"); }
	if ($password != $passwordConfirmation) { array_push($errors, "Les deux mots de passe ne correspondent pas!"); }
	// S'Assurez qu'aucun utilisateur n'est enregistré deux fois.
	// l'e-mail et les noms d'utilisateur doivent être uniques
	$user_check_query = "SELECT * FROM users WHERE username='$username' 
							OR email='$email' LIMIT 1";
	$result = mysqli_query($conn, $user_check_query);
	$user = mysqli_fetch_assoc($result);
	if ($user) { // Si le user existe
		if ($user['username'] === $username) {
		  array_push($errors, "Username existe déjà!");
		}

		if ($user['email'] === $email) {
		  array_push($errors, "L'Email existe déjà!");
		}
	}
	// enregistrer l'utilisateur s'il n'y a pas d'erreurs dans le formulaire
	if (count($errors) == 0) {
		$password = md5($password);//crypter le mot de passe avant de l'enregistrer dans la base de données
		//$query = "INSERT INTO users (username, email, role, password, created_at, updated_at) 
				 // VALUES('$username', '$email', '$role', '$password', now(), now())";

			//__________
			try
			{
				$conn = new PDO('mysql:host=localhost;dbname=myblog;charset=utf8', 'root', 'root');
			}
			catch (Exception $e)
			{
					die('Erreur : ' . $e->getMessage());
			}
			$query = $conn->prepare('INSERT INTO users(username, email, role, password, created_at, updated_at) VALUES ( :username, :email, :role, :password, :created_at, :updated_at)');
			$query->execute([
    		'username' => htmlspecialchars($username),
    		'email' => htmlspecialchars($email), //sécuriser les entrees de donnees
    		'password' => htmlspecialchars($password),
    		'role' => htmlspecialchars($role),
			'created_at' => htmlspecialchars(date('Y-m-d')), // insert current date,
    		'updated_at' => htmlspecialchars(date('Y-m-d')), 
   			]);
			   var_dump($query); exit;
   ///-----------	  
	//	mysqli_query($conn, $query);

		$_SESSION['message'] = "Admin user created successfully";
		header('location: users.php');
		exit(0);
	}
}
/* * * * * * * * * * * * * * * * * * * * *
* - Prend l'id de l'administrateur comme paramètre
* - Récupère l'admin de la BDD
* - Définit les champs d'admin sur le formulaire pour l'édition
* * * * * * * * * * * * * * * * * * * * * */
function editAdmin($admin_id)
{
	global $conn, $username, $role, $isEditingUser, $admin_id, $email;

	$sql = "SELECT * FROM users WHERE id=$admin_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$admin = mysqli_fetch_assoc($result);

	// définir les valeurs du formulaire ($username et $email) sur le formulaire à mettre à jourv
	$username = $admin['username'];
	$email = $admin['email'];
}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* - Reçoit la demande d'admin du formulaire et MAJ dans la BDD
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function updateAdmin($request_values){
	global $conn, $errors, $role, $username, $isEditingUser, $admin_id, $email;
	// obtenir l'id de l'admin à mettre à jour
	$admin_id = $request_values['admin_id'];
	// modifier statut
	$isEditingUser = false;


	$username = esc($request_values['username']);
	$email = esc($request_values['email']);
	$password = esc($request_values['password']);
	$passwordConfirmation = esc($request_values['passwordConfirmation']);
	if(isset($request_values['role'])){
		$role = $request_values['role'];
	}
	// enregistrer l'utilisateur s'il n'y a pas d'erreurs dans le formulaire
	if (count($errors) == 0) {
		//chiffrer le mot de passe (à des fins de sécurité)
		$password = md5($password);

		$query = "UPDATE users SET username='$username', email='$email', role='$role', password='$password' WHERE id=$admin_id";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "L'utilisateur admin est modifié avec succée.";
		header('location: users.php');
		exit(0);
	}
}
// supprimer l'admin user 
function deleteAdmin($admin_id) {
	global $conn;
	$sql = "DELETE FROM users WHERE id=$admin_id";
	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = "L'utilisateur est supprimé avec succée.";
		header("location: users.php");
		exit(0);
	}
}



/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* - Renvoie tous les utilisateurs et leurs rôles correspondants
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function getAdminUsers(){
	global $conn, $roles;
	$sql = "SELECT * FROM users WHERE role IS NOT NULL";
	$result = mysqli_query($conn, $sql);
	$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $users;
}
/* * * * * * * * * * * * * * * * * * * * *
* - Cette fonction permet de nettoyer et sécuriser les chaînes de caractères d'entrée pour prévenir les attaques de BDD
* * * * * * * * * * * * * * * * * * * * * */
function esc(String $value){
	// bring the global db connect object into function
	global $conn;
	// remove empty space sorrounding string
	$val = trim($value); 
	$val = mysqli_real_escape_string($conn, $value);
	return $val;
}
// Receives a string like 'Some Sample String'
// and returns 'some-sample-string'
function makeSlug(String $string){
	$string = strtolower($string);
	$slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
	return $slug;
}

/* - - - - - - - - - - 
-   fonctions du chapos
- - - - - - - - - - -*/
// obtenir tous les chapos de la BDD
function getAllChapos() {
	global $conn;
	$sql = "SELECT * FROM chapo";
	$result = mysqli_query($conn, $sql);
	$chapos = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $chapos;
}
// Créer un nouveau chapos
function createChapo($request_values){
	global $conn, $errors, $chapo_name;
	$chapo_name = esc($request_values['chapo_name']);
	// créer chapo: si chapo est "openclassroom", renvoie "openclassroom" en tant que slug
	$chapo_slug = makeSlug($chapo_name);
	// valider forme
	if (empty($chapo_name)) { 
		array_push($errors, "Nom du chapo obligatoire!"); 
	}
	//Assurez-vous qu'aucun chapo n'est enregistré deux fois.
	$chapo_check_query = "SELECT * FROM chapo WHERE slug='$chapo_slug' LIMIT 1";
	
	
	$result = mysqli_query($conn, $chapo_check_query);
	if (mysqli_num_rows($result) > 0) { // si chapo existe
		array_push($errors, "Chapo existe déjà!");
	}
	//Enregistrer chapo s'il n'y a pas d'erreurs dans le formulaire!
	if (count($errors) == 0) {
		$query = "INSERT INTO chapo (name, slug) 
				  VALUES('$chapo_name', '$chapo_slug')";
				  echo($chapo_name);
				  echo($chapo_slug);
				  
		mysqli_query($conn, $query);

		$_SESSION['message'] = "chapo creé avec  succée.";
		header('location: chapos.php');
		exit(0);
	}
}
/* * * * * * * * * * * * * * * * * * * * *
* - Prend l'identifiant chapo comme paramètre
* - Récupère le chapo de la BDD
* - Définit les champs chapo sur le formulaire d'édition
* * * * * * * * * * * * * * * * * * * * * */
function editChapo($chapo_id) {
	global $conn, $chapo_name, $isEditingChapo, $chapo_id;
	$sql = "SELECT * FROM chapo WHERE id=$chapo_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$chapo = mysqli_fetch_assoc($result);
	// remplir le formulaire pour modifier le chapo ($chapo_name)
	$chapo_name = $chapo['name'];
}
function updateChapo($request_values) {
	global $conn, $errors, $chapo_name, $chapo_id;
	$chapo_name = esc($request_values['chapo_name']);
	$chapo_id = esc($request_values['chapo_id']);
	// créer slug: si chapo est "inspiration", retourner "inspiration" comme slug
	$chapo_slug = makeSlug($chapo_name);
	// valider formulaire
	if (empty($chapo_name)) { 
		array_push($errors, "nom du chapo obligatoire!"); 
	}
	// enregistrer chapo s'il n'y a pas d'erreurs dans le formulaire
	if (count($errors) == 0) {
		$query = "UPDATE chapo SET name='$chapo_name', slug='$chapo_slug' WHERE id=$chapo_id";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "chapo modifiée  avec succée.";
		header('location: chapos.php');
		exit(0);
	}
}
// Supprimer chapo 
function deleteChapo($chapo_id) {
	global $conn;
	$sql = "DELETE FROM chapo WHERE id=$chapo_id";
	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = "Chapo supprimé avec succeé.";
		header("location: chapos.php");
		exit(0);
	}
}
?>