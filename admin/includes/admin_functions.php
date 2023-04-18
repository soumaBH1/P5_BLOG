<?php 
// Admin user variables
$admin_id = 0;
$isEditingUser = false;
$username = "";
$role = "";
$email = "";
$firstname ="";
$lastname ="";
$age ="";
// general variables
$errors = [];
// chapos variables
$chapo_id = 0;
$isEditingChapo = false;
$chapo_name = "";

/* - - - - - - - - - - 
-  Admin users actions
- - - - - - - - - - -*/
// if user clicks the create admin button
if (isset($_POST['create_admin'])) {
	createAdmin($_POST);
}
// if user clicks the Edit admin button
if (isset($_GET['edit-admin'])) {
	$isEditingUser = true;
	$admin_id = $_GET['edit-admin'];
	editAdmin($admin_id);
}
// if user clicks the update admin button
if (isset($_POST['update_admin'])) {
	updateAdmin($_POST);
}
// if user clicks the Delete admin button
if (isset($_GET['delete-admin'])) {
	$admin_id = $_GET['delete-admin'];
	deleteAdmin($admin_id);
}

/* - - - - - - - - - - 
-   actions chapos
- - - - - - - - - - -*/
// if user clicks the create chapo button
if (isset($_POST['create_chapo'])) { createChapo($_POST); }
// if user clicks the Edit chapo button
if (isset($_GET['edit-chapo'])) {
	$isEditingChapo = true;
	$chapo_id = $_GET['edit-chapo'];
	editChapo($chapo_id);
}
// if user clicks the update chapo button
if (isset($_POST['update_chapo'])) {
	updateChapo($_POST);
}
// if user clicks the Delete chapo button
if (isset($_GET['delete-chapo'])) {
	$chapo_id = $_GET['delete-chapo'];
	deleteChapo($chapo_id);
}
/* - - - - - - - - - - - -
-  Admin users functions
- - - - - - - - - - - - -*/
/* * * * * * * * * * * * * * * * * * * * * * *
* - Receives new admin data from form
* - Create new admin user
* - Returns all admin users with their roles 
* * * * * * * * * * * * * * * * * * * * * * */
function createAdmin($request_values){
	global $conn, $errors, $role, $username, $email;
	$username = esc($request_values['username']);
	$email = esc($request_values['email']);
	$password = esc($request_values['password']);
	$passwordConfirmation = esc($request_values['passwordConfirmation']);

	if(isset($request_values['role'])){
		$role = esc($request_values['role']);
	}
	// form validation: ensure that the form is correctly filled
	if (empty($username)) { array_push($errors, "Uhmm...We gonna need the username"); }
	if (empty($email)) { array_push($errors, "Oops.. Email is missing"); }
	if (empty($role)) { array_push($errors, "Role is required for admin users");}
	if (empty($password)) { array_push($errors, "uh-oh you forgot the password"); }
	if ($password != $passwordConfirmation) { array_push($errors, "The two passwords do not match"); }
	// Ensure that no user is registered twice. 
	// the email and usernames should be unique
	$user_check_query = "SELECT * FROM users WHERE username='$username' 
							OR email='$email' LIMIT 1";
	$result = mysqli_query($conn, $user_check_query);
	$user = mysqli_fetch_assoc($result);
	if ($user) { // if user exists
		if ($user['username'] === $username) {
		  array_push($errors, "Username already exists");
		}

		if ($user['email'] === $email) {
		  array_push($errors, "Email already exists");
		}
	}
	// register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = md5($password);//encrypt the password before saving in the database
		$query = "INSERT INTO users (username, email, role, password, created_at, updated_at) 
				  VALUES('$username', '$email', '$role', '$password', now(), now())";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Admin user created successfully";
		header('location: users.php');
		exit(0);
	}
}
/* * * * * * * * * * * * * * * * * * * * *
* - Takes admin id as parameter
* - Fetches the admin from database
* - sets admin fields on form for editing
* * * * * * * * * * * * * * * * * * * * * */
function editAdmin($admin_id)
{
	global $conn, $username, $role, $isEditingUser, $admin_id, $email;

	$sql = "SELECT * FROM users WHERE id=$admin_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$admin = mysqli_fetch_assoc($result);

	// set form values ($username and $email) on the form to be updated
	$username = $admin['username'];
	$email = $admin['email'];
}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* - Receives admin request from form and updates in database
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function updateAdmin($request_values){
	global $conn, $errors, $role, $username, $isEditingUser, $admin_id, $email;
	// get id of the admin to be updated
	$admin_id = $request_values['admin_id'];
	// set edit state to false
	$isEditingUser = false;


	$username = esc($request_values['username']);
	$email = esc($request_values['email']);
	$password = esc($request_values['password']);
	$passwordConfirmation = esc($request_values['passwordConfirmation']);
	if(isset($request_values['role'])){
		$role = $request_values['role'];
	}
	// register user if there are no errors in the form
	if (count($errors) == 0) {
		//encrypt the password (security purposes)
		$password = md5($password);

		$query = "UPDATE users SET username='$username', email='$email', role='$role', password='$password' WHERE id=$admin_id";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Admin user updated successfully";
		header('location: users.php');
		exit(0);
	}
}
// delete admin user 
function deleteAdmin($admin_id) {
	global $conn;
	$sql = "DELETE FROM users WHERE id=$admin_id";
	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = "User successfully deleted";
		header("location: users.php");
		exit(0);
	}
}



/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* - Returns all admin users and their corresponding roles
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function getAdminUsers(){
	global $conn, $roles;
	$sql = "SELECT * FROM users WHERE role IS NOT NULL";
	$result = mysqli_query($conn, $sql);
	$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $users;
}
/* * * * * * * * * * * * * * * * * * * * *
* - Escapes form submitted value, hence, preventing SQL injection
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
-  chapos functions
- - - - - - - - - - -*/
// get all chapos from DB
function getAllChapos() {
	global $conn;
	$sql = "SELECT * FROM chapo";
	$result = mysqli_query($conn, $sql);
	$chapos = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $chapos;
}
function createChapo($request_values){
	global $conn, $errors, $chapo_name;
	$chapo_name = esc($request_values['chapo_name']);
	// create slug: if chapo is "Life Advice", return "life-advice" as slug
	$chapo_slug = makeSlug($chapo_name);
	// validate form
	if (empty($chapo_name)) { 
		array_push($errors, "Nom du chapo obligatoire"); 
	}
	// Ensure that no chapo is saved twice. 
	$chapo_check_query = "SELECT * FROM chapo WHERE slug='$chapo_slug' LIMIT 1";
	$result = mysqli_query($conn, $chapo_check_query);
	if (mysqli_num_rows($result) > 0) { // if chapo exists
		array_push($errors, "Chapo existe déjà");
	}
	// register chapo if there are no errors in the form
	if (count($errors) == 0) {
		$query = "INSERT INTO chapo (name, slug) 
				  VALUES('$chapo_name', '$chapo_slug')";
				  echo($chapo_name);
				  echo($chapo_slug);

		mysqli_query($conn, $query);

		$_SESSION['message'] = "chapo creé avec  succée";
		header('location: chapos.php');
		exit(0);
	}
}
/* * * * * * * * * * * * * * * * * * * * *
* - Takes chapo id as parameter
* - Fetches the chapo from database
* - sets chapo fields on form for editing
* * * * * * * * * * * * * * * * * * * * * */
function editChapo($chapo_id) {
	global $conn, $chapo_name, $isEditingChapo, $chapo_id;
	$sql = "SELECT * FROM chapo WHERE id=$chapo_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$chapo = mysqli_fetch_assoc($result);
	// set form values ($chapo_name) on the form to be updated
	$chapo_name = $chapo['name'];
}
function updateChapo($request_values) {
	global $conn, $errors, $chapo_name, $chapo_id;
	$chapo_name = esc($request_values['chapo_name']);
	$chapo_id = esc($request_values['chapo_id']);
	// create slug: if chapo is "Life Advice", return "life-advice" as slug
	$chapo_slug = makeSlug($chapo_name);
	// validate form
	if (empty($chapo_name)) { 
		array_push($errors, "nom du chapo obligatoire"); 
	}
	// register chapo if there are no errors in the form
	if (count($errors) == 0) {
		$query = "UPDATE chapo SET name='$chapo_name', slug='$chapo_slug' WHERE id=$chapo_id";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "chapo modifiée  avec succée";
		header('location: chapos.php');
		exit(0);
	}
}
// delete chapo 
function deleteChapo($chapo_id) {
	global $conn;
	$sql = "DELETE FROM chapo WHERE id=$chapo_id";
	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = "Chapo supprimé avec succeé";
		header("location: chapos.php");
		exit(0);
	}
}
?>