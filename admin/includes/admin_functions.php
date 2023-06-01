<?php
// Variables utilisateur administrateur
$admin_id = 0;
$isEditingUser = false;
$username = "";
$role = "";
$email = "";
$firstname = "";
$lastname = "";
$age = "";
$valid = 0;
// variables générales
$errors = [];
// variables du chapo 
$chapo_id = 0;
$isEditingChapo = false;
$chapo_name = "";

// variables du commentaires 
$isEditingComment = false;
$comment_id;
$comment_user_id=1;
$comment_post_id=1;
$comment_body="";
$comment_publish=1;
$comment_unpublish=0;
$comment_published=0;
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
if (isset($_POST['create_chapo'])) {
	createChapo($_POST);
}
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
function createAdmin($request_values)
{
	global $conn, $errors, $role, $username, $email, $valid, $firstname, $lastname, $age, $password;
	$username = $request_values['username'];
	$firstname = $request_values['firstname'];
	$lastname = $request_values['lastname'];
	$age = $request_values['age'];
	$email = $request_values['email'];
	$password = $request_values['password'];
	$passwordConfirmation = $request_values['passwordConfirmation'];

	if (isset($request_values['role'])) {
		$role = $request_values['role'];
	}
	//if (isset($request_values['valid'])) {
	//	$valid = $request_values['valid'];
	//}
	// validation du formulaire : s'assurer que le formulaire est correctement rempli
	if (empty($username)) {
		array_push($errors, "Oops....Il faut remplir le username!");
	}
	if (empty($email)) {
		array_push($errors, "Oops.. L'Email est obligatoire!");
	}
	if (empty($role)) {
		array_push($errors, "Oops..Le rôle est obligatoire!");
	}
	if (empty($password)) {
		array_push($errors, "Oops.. Vous avez oubliés le password!");
	}
	if ($password != $passwordConfirmation) {
		array_push($errors, "Les deux mots de passe ne correspondent pas!");
	}
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
		$password = md5($password); //crypter le mot de passe avant de l'enregistrer dans la base de données

		//*****************Préparer la requête et l'exécuter*/
		include(ROOT_PATH . '/config/connection.php'); 
		$query = $db->prepare('INSERT INTO users(username, email, password, firstname, lastname, age, role, created_at) VALUES ( :username, :email, :password, :firstname, :lastname, :age, :role, :created_at)');
		$query->execute([
			'username' => htmlspecialchars($username), //htmlspecialchars pour éviter les attaques xss
			'email' => htmlspecialchars($email), //
			'password' => htmlspecialchars($password),
			'firstname' => htmlspecialchars($firstname),
			'lastname' => htmlspecialchars($lastname),
			'age' => $age,
			'role' => htmlspecialchars($role),
			'created_at' => htmlspecialchars(date('Y-m-d')), 
			// 'updated_at' => htmlspecialchars(NULL),
		]);
		//var_dump($valid);
		//exit;
		$_SESSION['message'] = "Admin user created successfully";
		header('location: users.php');
		exit(0);
	}
} //die(print_r($db->errorCode()));
/* * * * * * * * * * * * * * * * * * * * *
* - Prend l'id de l'administrateur comme paramètre
* - Récupère l'admin de la BDD
* - Définit les champs d'admin sur le formulaire pour l'édition
* * * * * * * * * * * * * * * * * * * * * */
function editAdmin($admin_id)
{
	global $conn, $username, $age, $firstname, $lastname, $role, $admin_id, $email;

	$sql = "SELECT * FROM users WHERE id=$admin_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$admin = mysqli_fetch_assoc($result);

	// définir les valeurs du formulaire ($username , $email..) sur le formulaire à mettre à jourv
	$username = $admin['username'];
	$email = $admin['email'];
	$firstname = $admin['firstname'];
	$lastname = $admin['lastname'];
	$age = $admin['age'];
	$role = $admin['role'];
	//$valid = $admin['valid'];
}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* - Reçoit la demande d'admin du formulaire et MAJ dans la BDD
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function updateAdmin($request_values)
{
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
	if (isset($request_values['role'])) {
		$role = $request_values['role'];
	}
	//}

	// enregistrer l'utilisateur s'il n'y a pas d'erreurs dans le formulaire
	if (count($errors) == 0) {
		//chiffrer le mot de passe (à des fins de sécurité)
		$password = md5($password);
		global $db;
		include(ROOT_PATH . '/config/connection.php'); 
		//si il s'agit de mofidifier le mot de passe
		if ($password != NULL) {
			if ($password != $passwordConfirmation) {
				array_push($errors, "Les deux mots de passe ne correspondent pas!");
			}
			$updateAdminUser = $db->prepare('UPDATE users SET username=:username, email=:email, firstname=:firstname, lastname=:lastname, age=:age, role=:role, password=:password, updated_at=:updated_at WHERE id=' . $admin_id);
			$updateAdminUser->execute([
				'username' => htmlspecialchars($username),
				'email' => htmlspecialchars($email),
				'role' => htmlspecialchars($role),
				'password' => htmlspecialchars($password),
				'firstname' => htmlspecialchars($firstname),
				'lastname' => htmlspecialchars($lastname),
				'age' => htmlspecialchars($age),
				'updated_at' => htmlspecialchars(date('Y-m-d')),
			]) or die(print_r($db->errorInfo()));
			$_SESSION['message'] = "L'utilisateur admin est modifié avec succée.";
			header('location: users.php');
			exit(0);
		}
		//si il le mot de passe est vide
		else {
			$updateAdminUser = $db->prepare('UPDATE users SET username=:username, email=:email, firstname=:firstname, lastname=:lastname, age=:age, role=:role, updated_at=:updated_at WHERE id=' . $admin_id);
			$updateAdminUser->execute([
				'username' => htmlspecialchars($username),
				'email' => htmlspecialchars($email),
				'role' => htmlspecialchars($role),
				'firstname' => htmlspecialchars($firstname),
				'lastname' => htmlspecialchars($lastname),
				'age' => htmlspecialchars($age),
				'updated_at' => htmlspecialchars(date('Y-m-d')),
			]) or die(print_r($db->errorCode()));
			$_SESSION['message'] = "L'utilisateur admin est modifié avec succée.";
			header('location: users.php');
			exit(0);
		}
	}
}
// supprimer un user 
function deleteAdmin($admin_id)
{
	global $db;
	include(ROOT_PATH . '/config/connection.php'); 
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
function getAdminUsers()
{
	global $conn, $roles;
	$sql = "SELECT * FROM users WHERE role IS NOT NULL";
	$result = mysqli_query($conn, $sql);
	$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $users;
}

// Receives a string like 'Some Sample String'
// and returns 'some-sample-string'
function makeSlug(String $string)
{
	$string = strtolower($string);
	$slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
	return $slug;
}

/* - - - - - - - - - - 
-   fonctions du chapos
- - - - - - - - - - -*/
// Ramener tous les chapos de la BDD
function getAllChapos()
{
	global $conn;
	$sql = "SELECT * FROM chapo";
	$result = mysqli_query($conn, $sql);
	$chapos = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $chapos;
}
// Créer un nouveau chapos
function createChapo($request_values)
{
	global $conn, $errors, $chapo_name;
	$chapo_name = $request_values['chapo_name'];
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
		include(ROOT_PATH . '/config/connection.php'); 
		$query = $db->prepare('INSERT INTO chapo (name, slug) VALUES(:name, :slug)');
		$query->execute([
			'name' => htmlspecialchars($chapo_name),
			'slug' => htmlspecialchars($chapo_slug),
		]) or die(print_r($db->errorCode()));
		echo ($chapo_name);
		echo ($chapo_slug);

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
function editChapo($chapo_id)
{
	global $conn, $chapo_name, $isEditingChapo, $chapo_id;
	$sql = "SELECT * FROM chapo WHERE id=$chapo_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$chapo = mysqli_fetch_assoc($result);
	// remplir le formulaire pour modifier le chapo ($chapo_name)
	$chapo_name = $chapo['name'];
}
function updateChapo($request_values)
{
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
		include(ROOT_PATH . '/config/connection.php'); 
		$query = $db->prepare('UPDATE chapo SET name=:name, slug=:slug WHERE id=$chapo_id');
		$query->execute([
			'name' => htmlspecialchars($chapo_name),
			'slug' => htmlspecialchars($chapo_slug),
		]) or die(print_r($db->errorCode()));

		$_SESSION['message'] = "chapo modifiée  avec succée.";
		header('location: chapos.php');
		exit(0);
	}
}
// Supprimer chapo 
function deleteChapo($chapo_id)
{
	global $db;
	include(ROOT_PATH . '/config/connection.php'); 
		$query = $db->prepare('DELETE FROM chapo WHERE id=:id');
	$query->execute([
		'id' => htmlspecialchars($chapo_id),
	]) or die(print_r($db->errorCode()));

	$_SESSION['message'] = "Chapo supprimé avec succeé.";
	header("location: chapos.php");
}
// si l'utilisateur clique sur le bouton de validation pour valider (ou l'inverse) un user
if (isset($_GET['valid']) || isset($_GET['unvalid'])) {
	$message = "";
	if (isset($_GET['valid'])) {
		$message = "Utlilisateur validé avec succée.";
		$user_id = $_GET['valid'];
	} else if (isset($_GET['unvalid'])) {
		$message = "Utlilisateur invalidé avec succée.";
		$user_id = $_GET['unvalid'];
	}
	toggleValidUser($user_id, $message);
}
// modifier le statut validé d'un utilisateur
function toggleValidUser($user_id, $message)
{
	global $conn;
	include(ROOT_PATH . '/config/connection.php'); 
	$query = $db->prepare('UPDATE users SET valid= NOT valid WHERE id=:id');
	$query->execute([
		'id' => htmlspecialchars($user_id),
	]) or die(print_r($db->errorCode()));
	//......=====================================================================================================
	//var_dump($sql);
	//exit;

	//if (mysqli_query($conn, $sql)) {
	$_SESSION['message'] = $message;
	header("location: users.php");
	exit(0);
	//}
}
//...

/* - - - - - - - - - - - - - - - - - -  
-  Actions sur les commentaires
- - - - - - - - - - - - - - - - - - - */
// Si le user appuit sur envoyer commentaire...
if (isset($_POST['submit_comment'])) {
	//var_dump($_POST);
	//exit;
	$comment_body = $_POST['comment_body'];
	$comment_post_id = $_POST['submit_comment'];
	$comment_user_id = $_POST['submit_comment'];
	createComment($_POST);
	
}
// si l'admin clique sur le bouton modifier un commentaire

if (isset($_GET['edit-comment'])) {
	$isEditingComment = true;
	$comment_id = $_GET['edit-comment'];
	editComment($comment_id);
}
// si l'admin clique sur le bouton modifier un commentaire
if (isset($_POST['update_comment'])) {
	updateComment($_POST);
	$comment_id = $_GET['edit-comment'];
	}
// si l'admin clique sur le bouton supprimer un commentaire
if (isset($_GET['delete-comment'])) {
	$comment_id = $_GET['delete-comment'];
	deleteComment($comment_id);
}
//* - - - - - - - - - - 
//-   fonctions du Comments
//- - - - - - - - - - -*/
// Ramener tous les commentaires d'un post de la BDD
function getAllCommentsByPostId($post_id)
{
	global $conn, $post_id;
	$sql = "SELECT * FROM comments where post_id = " . $post_id ." AND published = 1" ;
	//var_dump($sql); exit;
	$result = mysqli_query($conn, $sql);
	$comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	return $comments;
}
// Créer un nouveau commentaire
function createcomment($request_values)
{
	//var_dump($request_values);
	//exit;
	global $conn, $errors, $comment_body, $published, $comment_user_id, $comment_post_id, $comment_published;
	//$user_id = $_SESSION['user']['id'] ;
	//var_dump($request_values);
		//exit;
	$comment_body = $request_values['comment_body'];
		$comment_user_id = $request_values['comment_user_id'];
	$comment_post_id = $request_values['comment_post_id'];
	$comment_published=$request_values['publish'];
	// valider forme
	if (empty($comment_body)) {
		array_push($errors, "Il faut remplir un commentaire!");
	} else {

		//*****************Préparer la requete */
		include(ROOT_PATH . '/config/connection.php'); 
		$query = $db->prepare('INSERT INTO comments (user_id, post_id, body, published, created_at) VALUES(:user_id, :post_id, :body, :published, :created_at)');
		$query->execute([
			'user_id' => htmlspecialchars($comment_user_id),
			'post_id' => htmlspecialchars($comment_post_id),
			'body' => htmlspecialchars($comment_body),
			'published' => htmlspecialchars($comment_published),
			'created_at' => htmlspecialchars(date('Y-m-d')),
		]) or die(print_r($query));
		//var_dump($query);
		//exit;
		$_SESSION['message'] = "Commentaire crée avec succée.";
		header('location: comments.php');
		exit(0);
	}
}

/* * * * * * * * * * * * * * * * * * * * *
* - Actions sur les commentaires
* * * * * * * * * * * * * * * * * * * * * */
/* * * * * * * * * * * * * * * * * * * * *
* - Prend l'identifiant commentaire comme paramètre
* - Récupère le commentaire de la BDD
* - Définit les champs commentaire sur le formulaire d'édition
* * * * * * * * * * * * * * * * * * * * * */
function editComment($comment_id)
{
	global $conn, $comment_user_id, $comment_post_id, $comment_published, $comment_body, $isEditingComment, $comment_id;
	$sql = "SELECT * FROM comments WHERE id=$comment_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$comment = mysqli_fetch_assoc($result);
	//var_dump($comment);
	//exit;
	// variables pour remplir le formulaire pour modifier le commentaire ()
	$comment_user_id = $comment['user_id'];
	$comment_post_id = $comment['post_id'];
	$comment_body = $comment['body'];
	$comment_published = $comment['published'];
	
}
//Modifier un commentaire
function updateComment($request_values)
{
	//var_dump($request_values);
	//exit;
	global  $errors, $comment_body, $comment_id, $comment_published, $comment_post_id, $comment_user_id ;
	$comment_body = $request_values['comment_body'];
	$comment_id = $request_values['comment_id'];
	$comment_post_id = $request_values['comment_post_id'];
	$comment_user_id = $request_values['comment_user_id'];
		if (isset($request_values['publish'])) {
		$comment_published = $request_values['publish'];
	}
	// valider formulaire
	if (empty($comment_body)) {
		array_push($errors, "If aut remplir un commentaire!");
	}
	// enregistrer commentaire s'il n'y a pas d'erreurs dans le formulaire
	if (count($errors) == 0) {
		include(ROOT_PATH . '/config/connection.php'); 
		$query = $db->prepare('UPDATE comments SET body=:body, published=:published, updated_at=:updated_at WHERE id=:id');
		$query->execute([
			'body' => htmlspecialchars($comment_body),
			'published' => htmlspecialchars($comment_published),
			'updated_at' => htmlspecialchars(date('Y-m-d')),
			'id' => htmlspecialchars($comment_id),
		]) or die(print_r($db->errorCode()));

		$_SESSION['message'] = "commentaire modifiée  avec succée.";
		header('location: comments.php');
		exit(0);
	}
}
// Supprimer un commentaire 
function deleteComment($comment_id)
{
	global $db;
	include(ROOT_PATH . '/config/connection.php'); 
	$query = $db->prepare('DELETE FROM comments WHERE id=:id');
	$query->execute([
		'id' => htmlspecialchars($comment_id),
	]) or die(print_r($db->errorCode()));

	$_SESSION['message'] = "Commentaire supprimé avec succeé.";
	header("location: comments.php");
}
// si l'utilisateur clique sur le bouton de publier pour dépublier (ou l'inverse) un commentaire
if (isset($_GET['publish']) || isset($_GET['unpublish'])) {
	$message = "";
	
	if (isset($_GET['publish'])) {
		$message = "Commentaire publiée avec succée.";
		$comment_id = $_GET['publish'];
	} else if (isset($_GET['unpublish'])) {
		$message = "Commentaire dépubliée avec succée.";
		$comment_id = $_GET['unpublish'];
	}
	togglePublishComment($comment_id, $message);
}
// modifier le statut publié d'un commentaire
function togglePublishComment($comment_id, $message)
{
	global $db;
	include(ROOT_PATH . '/config/connection.php'); 
	$query = $db->prepare('UPDATE comments SET published= NOT published WHERE id=:id');
	$query->execute([
		'id' => htmlspecialchars($comment_id),
	]) or die(print_r($db->errorCode()));
	//......=====================================================================================================
	//var_dump($sql);
	//exit;

	//if (mysqli_query($conn, $sql)) {
	$_SESSION['message'] = $message;
	header("location: comments.php");
	exit(0);
	//}
}


// Ramener tous les commentaires de la BDD
function getAllComments()
{
	global $conn, $post_id;
	//$sql = "SELECT * FROM comments" ;
	$sql ="SELECT t1.id, t1.user_id, t1.post_id,t1.body,t1.created_at, t1.updated_at, t1.published, t2.title, t3.username
FROM comments t1
JOIN posts t2 ON t1.post_id = t2.id
JOIN users t3 ON t1.user_id = t3.id";
	
	$result = mysqli_query($conn, $sql);
	$comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
	//var_dump($comments); exit;
	return $comments;
}
