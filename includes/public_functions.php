<?php
/* * * * * * * * * * * * * * *
* Returns all published posts
* * * * * * * * * * * * * * */
function getPublishedPosts()
{
	// utilise la variable globale $conn 
	global $conn;
	$sql = "SELECT * FROM posts WHERE published=true order by created_at desc ";
	$result = mysqli_query($conn, $sql);
	// recupere tous les posts dans le tableau $posts
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	if ($posts <> NULL) {
		foreach ($posts as $post) {
			$post['chapo'] = getPostChapo($post['id']);
			array_push($final_posts, $post);
		}
		return $final_posts;
	}
}
/* * * * * * * * * * * * * * *
* Recois le  post id et
* Retourne le chapo de ce post
* * * * * * * * * * * * * * */
function getPostChapo($post_id)
{
	global $conn;
	$sql = "SELECT * FROM chapo WHERE id=
			(SELECT chapo_id FROM posts WHERE id=$post_id) LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$chapo = mysqli_fetch_assoc($result);
	return $chapo;
}

/* * * * * * * * * * * * * * * *
* Retourne tous les postes d'un même chapo
* * * * * * * * * * * * * * * * */
function getPublishedPostsByChapo($chapo_id)
{
	global $conn;
	$sql = "SELECT * FROM posts ps 
			WHERE ps.id IN 
			(SELECT pt.post_id FROM post_chapo pt 
				WHERE pt.chapo_id=$chapo_id GROUP BY pt.chapo_id 
				HAVING COUNT(1) = 1)";
	$result = mysqli_query($conn, $sql);
	// récupère tous les posts dans le tableau $posts
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($posts as $post) {
		$post['chapo'] = getPostChapo($post['id']);
		array_push($final_posts, $post);
	}
	return $final_posts;
}
/* * * * * * * * * * * * * * * *
* Returns chapo name by chapo id
* * * * * * * * * * * * * * * * */
function getChapoNameById($id)
{
	global $conn;
	$sql = "SELECT name FROM chapo WHERE id=$id";
	$result = mysqli_query($conn, $sql);
	$chapo = mysqli_fetch_assoc($result);
	return $chapo['name'];
}
/* * * * * * * * * * * * * * *
* Retourne un post
* * * * * * * * * * * * * * */
function getPost($slug)
{
	global $conn;
	// Get single post slug
	$post_slug = $_GET['post-slug'];
	$sql = "SELECT * FROM posts WHERE slug='$post_slug' AND published=true";
	$result = mysqli_query($conn, $sql);

	// récupérer les résultats de la requête sous forme de tableau 
	//créer un objet une nouvelle class post dans laquelle on recupere  la requete
	$post = mysqli_fetch_assoc($result);
	if ($post) {
		// obtenir le chapo auquel appartient ce post
		$post['chapo'] = getPostChapo($post['id']);
	}
	return $post;
}
/* * * * * * * * * * * *
*  Retourne tous les  chapos
* * * * * * * * * * * * */
function getAllChapos()
{
	global $conn;
	$sql = "SELECT * FROM chapo";
	$result = mysqli_query($conn, $sql);
	$chapos = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $chapos;
}


//
// récupère le message avec l'id  
$post_query_result = mysqli_query($conn, "SELECT * FROM posts ORDER BY created_at ASC");
$post = mysqli_fetch_assoc($post_query_result);

// Get all comments from database
$comments_query_result = mysqli_query($conn, "SELECT * FROM comments WHERE post_id=" . $post['id'] . " ORDER BY created_at DESC");
$comments = mysqli_fetch_all($comments_query_result, MYSQLI_ASSOC);
//!!!!!!!!!!!!!!!!!!!!



//!!!!!!!!!!!!!!!!!!!!!!!!

// Reçoit l' id  d'utilisateur et renvoie le username
function getUsernameById($id)
{
	global $conn;
	$result = mysqli_query($conn, "SELECT username FROM users WHERE id=" . $id . " LIMIT 1");
	// return the username
	return mysqli_fetch_assoc($result)['username'];
}
// Reçoi l'id post et renvoi les comments de ce post
function getCommentId($id)
{
	global $conn;
	$result = mysqli_query($conn, "SELECT * FROM comments WHERE id=$id");
	$comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $comments;
}
// Reçoi le comment_id et retourne le replies
function getRepliesByCommentId($id)
{
	global $conn;
	$result = mysqli_query($conn, "SELECT * FROM replies WHERE comment_id=$id");
	$replies = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $replies;
}
// Reçoi  post_id et retourne le nombre total de commentaires de chaque post
function getCommentsCountByPostId($post_id)
{
	global $conn;
	$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM comments where post_id = $post_id AND published=1");
	$data = mysqli_fetch_assoc($result);
	return $data['total'];
}
//...

/* - - - - - - - - - - - - - - - - - -  
-  Actions su les commentaires
- - - - - - - - - - - - - - - - - - - */
// Si le user appuit sur envoyer...
if (isset($_POST['submit_comment'])) {
	$comment_text = $_POST['comment_text'];
	$post_id = $_GET['submit_comment'];
	createComment($_POST);
	//insert comment into database
	//$sql = "INSERT INTO comments (post_id, user_id, body, created_at, updated_at, published) VALUES (1, " . $user_id . ", '$comment_text', now(), null, 0)";
	//$result = mysqli_query($db, $sql);
	// Query same comment from database to send back to be displayed

}

// si l'admin clique sur le bouton modifier un commentaire
if (isset($_POST['update_comment'])) {
	updateComment($_POST);
	$post_id = $_GET['edit-post'];
	$post_id = $_GET['edit-post'];
}
// si l'admin clique sur le bouton supprimer un commentaire
if (isset($_GET['delete-comment'])) {
	$admin_id = $_GET['delete-comment'];
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
	global $conn, $errors, $comment_text, $published, $user_id, $post_id;
	//$user_id = $_SESSION['user']['id'] ;
	//var_dump($request_values);
		//exit;
	$comment_text = $request_values['comment_body'];
	//$comment_id = $request_values['Post_id'];
	//$published = $request_values['comment_published'];
	$user_id = $request_values['user_id'];
	$post_id = $request_values['post_id'];
	$published=0;
	// valider forme
	if (empty($comment_text)) {
		array_push($errors, "Il faut remplir un commentaire!");
	} else {

		//*****************Préparer la requete */
		try {
			$db = new PDO('mysql:host=localhost;dbname=myblog;charset=utf8', 'root', 'root');
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
		$query = $db->prepare('INSERT INTO comments (user_id, post_id, body, published, created_at) VALUES(:user_id, :post_id, :body, :published, :created_at)');
		$query->execute([
			'user_id' => htmlspecialchars($user_id),
			'post_id' => htmlspecialchars($post_id),
			'body' => htmlspecialchars($comment_text),
			'published' => htmlspecialchars($published),
			'created_at' => htmlspecialchars(date('Y-m-d')),
		]) or die(print_r($query));
		//var_dump($query);
		//exit;
		$_SESSION['message'] = "Commentaire crée avec  succée.";
		header('location: single_post.php');
		exit(0);
	}
}

/* * * * * * * * * * * * * * * * * * * * *
* - Actions sur les commentaires
* * * * * * * * * * * * * * * * * * * * * */

//Modifier un commentaire
function updateComment($request_values)
{
	global $conn, $errors, $comment_text, $comment_id, $published;
	$comment_text = $request_values['comment_text'];
	$comment_id = $request_values['comment_id'];
	$published = $request_values['comment_published'];

	// valider formulaire
	if (empty($comment_text)) {
		array_push($errors, "If aut remplir un commentaire!");
	}
	// enregistrer chapo s'il n'y a pas d'erreurs dans le formulaire
	if (count($errors) == 0) {
		try {
			$db = new PDO('mysql:host=localhost;dbname=myblog;charset=utf8', 'root', 'root');
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
		$query = $db->prepare('UPDATE comments SET body=:body, published=:published, updated_at=:updated_at WHERE id=:id');
		$query->execute([
			'body' => htmlspecialchars($comment_text),
			'published' => htmlspecialchars($published),
			'updated_at' => htmlspecialchars(date('Y-m-d')),
			'id' => htmlspecialchars($comment_id),
		]) or die(print_r($db->errorCode()));

		$_SESSION['message'] = "chapo modifiée  avec succée.";
		header('location: chapos.php');
		exit(0);
	}
}
// Supprimer un commentaire 
function deleteComment($comment_id)
{
	global $db;
	try {
		$db = new PDO('mysql:host=localhost;dbname=myblog;charset=utf8', 'root', 'root');
	} catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
	}
	$query = $db->prepare('DELETE FROM comment WHERE id=:id');
	$query->execute([
		'id' => htmlspecialchars($comment_id),
	]) or die(print_r($db->errorCode()));

	$_SESSION['message'] = "Commentaire supprimé avec succeé.";
	header("location: chapos.php");
}
// si l'utilisateur clique sur le bouton de validation pour valider (ou l'inverse) un user
if (isset($_GET['publish']) || isset($_GET['unpublish'])) {
	$message = "";
	if (isset($_GET['unpublish'])) {
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
	global $conn;
	try {
		$db = new PDO('mysql:host=localhost;dbname=myblog;charset=utf8', 'root', 'root');
	} catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
	}
	$query = $db->prepare('UPDATE comment SET published= NOT published WHERE id=:id');
	$query->execute([
		'id' => htmlspecialchars($comment_id),
	]) or die(print_r($db->errorCode()));
	//......=====================================================================================================
	//var_dump($sql);
	//exit;

	//if (mysqli_query($conn, $sql)) {
	$_SESSION['message'] = $message;
	header("location: single_post.php");
	exit(0);
	//}
}

