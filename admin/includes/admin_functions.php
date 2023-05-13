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
	global $conn, $errors, $role, $username, $email;
	$username = $request_values['username'];
	$firstname = $request_values['firstname'];
	$lastname = $request_values['lastname'];
	$age = $request_values['age'];
	$email = $request_values['email'];
	$password = $request_values['password'];
	$passwordConfirmation = $request_values['passwordConfirmation'];

	if(isset($request_values['role'])){
		$role = $request_values['role'];
	}
	// validation du formulaire : s'assurer que le formulaire est correctement rempli
	if (empty($username)) { array_push($errors, "Oops....Il faut remplir le username!"); }
	if (empty($email)) { array_push($errors, "Oops.. L'Email est obligatoire!"); }
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
		
//*****************Préparer la requete et l'exécuter*/
try
{
	$db = new PDO('mysql:host=localhost;dbname=myblog;charset=utf8', 'root', 'root');

}
catch (Exception $e)
{        die('Erreur : ' . $e->getMessage());
}
			
$query = $db->prepare('INSERT INTO users(username, email, role, password, created_at, updated_at) VALUES ( :username, :email, :role, :password, :created_at, :updated_at)');
			$query->execute([
    		'username' => htmlspecialchars($username),
    		'email' => htmlspecialchars($email), //
    		'password' => htmlspecialchars($password),
    		'role' => htmlspecialchars($role),
			'created_at' => htmlspecialchars(date('Y-m-d')), // 
    		'updated_at' => htmlspecialchars(date('Y-m-d')), 
   			]);
			  
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
	global $conn, $errors, $role, $username, $password, $firstname, $lastname, $age, $isEditingUser, $admin_id, $email;
	// obtenir l'id de l'utilisateur à mettre à jour
	$admin_id = $request_values['admin_id'];
	// modifier statut
	$isEditingUser = false;
	

	$username = $request_values['username'];
	$email = $request_values['email'];
	$password = $request_values['password'];
	$firstname = $request_values['firstname'];
	$lastname = $request_values['lastname'];
	$age = $request_values['age'];
	$passwordConfirmation = $request_values['passwordConfirmation'];
	if(isset($request_values['role'])){
		$role = $request_values['role'];
	}
	// enregistrer l'utilisateur s'il n'y a pas d'erreurs dans le formulaire
	if (count($errors) == 0) {
	//chiffrer le mot de passe (à des fins de sécurité)
		$password = md5($password);
		global $db;
	try
	{
		$db = new PDO('mysql:host=localhost;dbname=myblog;charset=utf8', 'root', 'root');
	}
	catch (Exception $e)
	{
        die('Erreur : ' . $e->getMessage());
	}
	//si il s'agit de mofidifier le mot de passe
	if ($password!=NULL){
		if ($password != $passwordConfirmation) { array_push($errors, "Les deux mots de passe ne correspondent pas!"); }
		$updateAdminUser = $db->prepare('UPDATE users SET username=:username, email=:email, firstname=:firstname, lastname=:lastname, age=:age, role=:role, password=:password, updated_at=:updated_at WHERE id=' . $admin_id);
		$updateAdminUser->execute([
			'username'=>htmlspecialchars($username),
			'email'=>htmlspecialchars($email),
			'role'=>htmlspecialchars($role),
			'password'=>htmlspecialchars($password),
			'firstname'=> htmlspecialchars($firstname),
			'lastname'=>htmlspecialchars( $lastname),
			'age'=> htmlspecialchars($age),
			'updated_at'=>htmlspecialchars(date('Y-m-d')),
		]) or die(print_r($db->errorInfo()));
		$_SESSION['message'] = "L'utilisateur admin est modifié avec succée.";
		header('location: users.php');
		exit(0);
	} 
	//si il le mot de passe est vide
	else
	{
	$updateAdminUser = $db->prepare('UPDATE users SET username=:username, email=:email, firstname=:firstname, lastname=:lastname, age=:age, role=:role, updated_at=:updated_at WHERE id=' . $admin_id);
	$updateAdminUser->execute([
		'username'=>htmlspecialchars($username),
		'email'=>htmlspecialchars($email),
		'role'=>htmlspecialchars($role),
		'firstname'=> htmlspecialchars($firstname),
		'lastname'=>htmlspecialchars($lastname),
		'age'=> htmlspecialchars($age),
		'updated_at'=>htmlspecialchars(date('Y-m-d')),
	]) or die(print_r($db->errorCode()));
				$_SESSION['message'] = "L'utilisateur admin est modifié avec succée.";
		header('location: users.php');
		exit(0);
	}}
}
// supprimer un user 
function deleteAdmin($admin_id) {
	global $db;
	try
	{
		$db = new PDO('mysql:host=localhost;dbname=myblog;charset=utf8', 'root', 'root');
	}
	catch (Exception $e)
	{
        die('Erreur : ' . $e->getMessage());
	}
	//preparer la requete et l'exécuter par la suite
	$deleteAdminUser = $db->prepare('DELETE FROM users WHERE id=:id');
	$deleteAdminUser->execute([
    'id' => $admin_id,
	]) or die(print_r($db->errorInfo()));
		$_SESSION['message'] = "L'utilisateur est supprimé avec succée.";
		header("location: users.php");
		exit(0);
	
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
// Ramener tous les chapos de la BDD
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
	$chapo_name =$request_values['chapo_name'];
	// créer chapo: si chapo est "openclassroom", renvoie "openclassroom" en tant que slug
	$chapo_slug = makeSlug($chapo_name);
	// valider forme
	if (empty($chapo_name)) { 
		array_push($errors, "Nom du chapo obligatoire!"); 
	}
	//S'Assurer qu'aucun chapo n'est enregistré deux fois.
	$chapo_check_query = "SELECT * FROM chapo WHERE slug='$chapo_slug' LIMIT 1";
	
	
	$result = mysqli_query($conn, $chapo_check_query);
	if (mysqli_num_rows($result) > 0) { // si chapo existe
		array_push($errors, "Chapo existe déjà!");
	}
	//Enregistrer chapo s'il n'y a pas d'erreurs dans le formulaire!
	if (count($errors) == 0) {
	
		//*****************Préparer la requete */
try
{
	$db = new PDO('mysql:host=localhost;dbname=myblog;charset=utf8', 'root', 'root');

}
catch (Exception $e)
{        die('Erreur : ' . $e->getMessage());
}
			$query = $db->prepare('INSERT INTO chapo (name, slug) VALUES(:name, :slug)');
					  $query->execute([
						'name'=>htmlspecialchars($chapo_name),
						'slug'=>htmlspecialchars($chapo_slug),
					  ])or die(print_r($db->errorCode()));
					  echo($chapo_name);
					  echo($chapo_slug);
			
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
	$chapo_name = $request_values['chapo_name'];
	$chapo_id = $request_values['chapo_id'];
	// créer slug: si chapo est "inspiration", retourner "inspiration" comme slug
	$chapo_slug = makeSlug($chapo_name);
	// valider formulaire
	if (empty($chapo_name)) { 
		array_push($errors, "nom du chapo obligatoire!"); 
	}
	// enregistrer chapo s'il n'y a pas d'erreurs dans le formulaire
	if (count($errors) == 0) {
		try
	{
		$db = new PDO('mysql:host=localhost;dbname=myblog;charset=utf8', 'root', 'root');
	}
		catch (Exception $e)
	{        die('Erreur : ' . $e->getMessage());
	}
			$query = $db->prepare('UPDATE chapo SET name=:name, slug=:slug WHERE id=$chapo_id');
					  $query->execute([
						'name'=>htmlspecialchars($chapo_name),
						'slug'=>htmlspecialchars($chapo_slug),
					  ])or die(print_r($db->errorCode()));
		
		$_SESSION['message'] = "chapo modifiée  avec succée.";
		header('location: chapos.php');
		exit(0);
	}
}
// Supprimer chapo 
function deleteChapo($chapo_id) {
	global $db;
	try
	{
		$db = new PDO('mysql:host=localhost;dbname=myblog;charset=utf8', 'root', 'root');
	}
		catch (Exception $e)
	{        die('Erreur : ' . $e->getMessage());
	}
			$query = $db->prepare('DELETE FROM chapo WHERE id=:id');
					  $query->execute([
						'id'=>htmlspecialchars($chapo_id),
				  ])or die(print_r($db->errorCode()));
		
		$_SESSION['message'] = "Chapo supprimé avec succeé.";
		header("location: chapos.php");
		
}
?>