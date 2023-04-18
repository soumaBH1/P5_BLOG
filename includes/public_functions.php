<?php 
/* * * * * * * * * * * * * * *
* Returns all published posts
* * * * * * * * * * * * * * */
function getPublishedPosts() {
	// use global $conn object in function
	global $conn;
	$sql = "SELECT * FROM posts WHERE published=true";
	$result = mysqli_query($conn, $sql);
	// fetch all posts as an associative array called $posts
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($posts as $post) {
		$post['chapo'] = getPostChapo($post['id']); 
		array_push($final_posts, $post);
	}
	return $final_posts;
}
/* * * * * * * * * * * * * * *
* Receives a post id and
* Returns chapo of the post
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
* Returns all posts under a chapo
* * * * * * * * * * * * * * * * */
function getPublishedPostsByChapo($chapo_id) {
	global $conn;
	$sql = "SELECT * FROM posts ps 
			WHERE ps.id IN 
			(SELECT pt.post_id FROM post_chapo pt 
				WHERE pt.chapo_id=$chapo_id GROUP BY pt.chapo_id 
				HAVING COUNT(1) = 1)";
	$result = mysqli_query($conn, $sql);
	// fetch all posts as an associative array called $posts
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
* Returns a single post
* * * * * * * * * * * * * * */
function getPost($slug){
	global $conn;
	// Get single post slug
	$post_slug = $_GET['post-slug'];
	$sql = "SELECT * FROM posts WHERE slug='$post_slug' AND published=true";
	$result = mysqli_query($conn, $sql);

	// fetch query results as associative array.
	$post = mysqli_fetch_assoc($result);
	if ($post) {
		// get the chapo to which this post belongs
		$post['chapo'] = getPostChapo($post['id']);
	}
	return $post;
}
/* * * * * * * * * * * *
*  Returns all chapos
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