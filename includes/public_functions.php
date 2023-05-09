<?php 
/* * * * * * * * * * * * * * *
* Returns all published posts
* * * * * * * * * * * * * * */
function getPublishedPosts() {
	// utilise la variable globale $conn 
	global $conn;
	$sql = "SELECT * FROM posts WHERE published=true";
	$result = mysqli_query($conn, $sql);
	// recupere tous les posts dans le tableau $posts
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	if ($posts<>NULL) {
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
function getPostChapo($post_id){
	global $conn;
	$sql = "SELECT * FROM chapo WHERE id=
			(SELECT chapo_id FROM post_chapo WHERE post_id=$post_id) LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$chapo = mysqli_fetch_assoc($result);
	return $chapo;
}

/* * * * * * * * * * * * * * * *
* Retourne tous les postes d'un même chapo
* * * * * * * * * * * * * * * * */
function getPublishedPostsByChapo($chapo_id) {
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
function getPost($slug){
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

	// Set logged in user id: This is just a simulation of user login. We haven't implemented user log in
	// But we will assume that when a user logs in, 
	// they are assigned an id in the session variable to identify them across pages
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
		$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM comments");
		$data = mysqli_fetch_assoc($result);
		return $data['total'];
	}
?>