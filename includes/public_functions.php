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
* Recoisle  post id et
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
?>