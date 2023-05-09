<?php 
//  variables du Post
$post_id = 0;
$isEditingPost = false;
$published = 0;
$title = "";
$post_slug = "";
$body = "";
$featured_image = "";
$post_chapo = "";

/* - - - - - - - - - - 
-   functions du Post
- - - - - - - - - - -*/
// Ramener tous les postes de le BDD
function getAllPosts()
{
	global $conn;
	
	// l'Admin peut voir tous les posts
	// l'Author ne peut voir que ses posts
	if ($_SESSION['user']['role'] == "admin") {
		$sql = "SELECT * FROM posts";
	} elseif ($_SESSION['user']['role'] == "author") {
		$user_id = $_SESSION['user']['id'];
		$sql = "SELECT * FROM posts WHERE user_id=$user_id";
		
	}
	//$sql = "SELECT * FROM posts";
	$result = mysqli_query($conn, $sql);
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$final_posts = array();
	foreach ($posts as $post) {
		$post['author'] = getPostAuthorById($post['user_id']);
		array_push($final_posts, $post);
	}
	return $final_posts;
}
// obtenir l'auteur/username d'un post
function getPostAuthorById($user_id)
{
	global $conn;
	$sql = "SELECT username FROM users WHERE id=$user_id";
	$result = mysqli_query($conn, $sql);
	if ($result) {
		// retourne username
		return mysqli_fetch_assoc($result)['username'];
	} else {
		return null;
	}
}
/* - - - - - - - - - - 
-   actions sur Post
- - - - - - - - - - -*/
// si l'utilisateur clique sur le bouton Créer un post

if (isset($_POST['create_post'])) { 
// 	var_dump($_POST);
// exit;
	createPost($_POST); }
// si l'utilisateur clique sur le bouton MAJ un post
if (isset($_GET['edit-post'])) {
	$isEditingPost = true;
	$post_id = $_GET['edit-post'];
	editPost($post_id);
}
// si l'utilisateur clique sur le bouton modifier un post
if (isset($_POST['update_post'])) {
	updatePost($_POST);
}
// si l'utilisateur clique sur le bouton supprimer un post
if (isset($_GET['delete-post'])) {
	$post_id = $_GET['delete-post'];
	deletePost($post_id);
}

/* - - - - - - - - - - 
-  Fonctions Post 
- - - - - - - - - - -*/
function createPost($request_values)
	{
		global $conn, $errors, $title, $featured_image, $chapo_id, $body, $published;
		$title = esc($request_values['title']);
		//$body = htmlentities(esc($request_values['body']));
		$body = $request_values['body'];
		if (isset($request_values['chapo_id'])) {
			$chapo_id = esc($request_values['chapo_id']);
		}
		if (isset($request_values['publish'])) {
			$published = esc($request_values['publish']);
		}
		// créer slug: si titre   "test", return "test" comme slug
		$post_slug = makeSlug($title);
		// valider formulaire
		if (empty($title)) { array_push($errors, "Titre du post est obligatoire!"); }
		if (empty($body)) { array_push($errors, "Le contenue du post est obligatoire!"); }
		if (empty($chapo_id)) { array_push($errors, "Le chapo est obligatoire!"); }
		// Get image name
	  	 $featured_image = $_FILES['featured_image']['name'];

		 //ici finalement j'ai choisi que l'image ne soit pas obligatoire
	  	//if (empty($featured_image)) { array_push($errors, "L'image du blog post est obligatoire!"); }
	  	// image file directory
		  if (!empty($featured_image)) { 
	  		$target = "../static/images/" . basename($featured_image);
	  		if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
	  			array_push($errors, "Échec du téléchargement de l'image. Veuillez vérifier les paramètres de fichier pour votre serveur");
	  	
			}
		}
		// S'assurez qu'aucune publication n'est enregistrée deux fois 
		$post_check_query = "SELECT * FROM posts WHERE slug='$post_slug' LIMIT 1";
		$result = mysqli_query($conn, $post_check_query);
		
		if (mysqli_num_rows($result) > 0) { // si post existe
			array_push($errors, "Un poste existe déjà avec ce titre!");
		}
		
		  
		
		// créer un message s'il n'y a pas d'erreurs dans le formulaire
		//var_dump($errors);
		 // exit;
		if (count($errors) == 0) {
			
			$query = "INSERT INTO posts (user_id, title, slug, image, body, published, created_at, date_updated, date_deleated) VALUES(1, '$title', '$post_slug', '$featured_image', '$body', $published, now(), NULL, NULL)";
			//var_dump($query);
		 	//exit;
			$queryresult=mysqli_query($conn, $query);
			
			if($queryresult){ // si le post a été créé avec succès
				
				$inserted_post_id = mysqli_insert_id($conn);
				// créer une relation entre le post et le chapo
				$sql = "INSERT INTO post_chapo (post_id, chapo_id) VALUES($inserted_post_id, $chapo_id)";
				mysqli_query($conn, $sql);

				$_SESSION['message'] = "Post crée avec succée.";
				header('location: posts.php');
				exit(0);
			}
		}
	}

	/* * * * * * * * * * * * * * * * * * * * *
	* - Prend l'id du post comme paramètre
	* - Récupère le post de la BDD
	* - remplir les champs de post sur le formulaire pour l'édition
	* * * * * * * * * * * * * * * * * * * * * */
	function editPost($role_id)
	{
		global $conn, $title, $post_slug, $body, $published, $isEditingPost, $post_id;
		$sql = "SELECT * FROM posts WHERE id=$role_id LIMIT 1";
		$result = mysqli_query($conn, $sql);
		$post = mysqli_fetch_assoc($result);
		// remplir des valeurs de formulaire sur le formulaire à mettre à jour
		$title = $post['title'];
		$body = $post['body'];
		$published = $post['published'];
	}

	function updatePost($request_values)
	{
		global $conn, $errors, $post_id, $title, $featured_image, $chapo_id, $body, $published;

		$title = esc($request_values['title']);
		$body = esc($request_values['body']);
		$post_id = esc($request_values['post_id']);
		if (isset($request_values['chapo_id'])) {
			$chapo_id = esc($request_values['chapo_id']);
		}
		// créer slug
		$post_slug = makeSlug($title);

		if (empty($title)) { array_push($errors, "Le titre du post est obligatoire"); }
		if (empty($body)) { array_push($errors, "Le contenue du post est obligatoire"); }
		// si une nouvelle image est sélectionnée
		if (isset($_POST['featured_image'])) {
			// Obtenir le nom de l'image
		  	$featured_image = $_FILES['featured_image']['name'];
		  	// répertoire des fichiers images
		  	$target = "../static/images/" . basename($featured_image);
		  	if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
		  		array_push($errors, "Échec du téléchargement de l'image. Veuillez vérifier les paramètres de fichier pour votre serveur");
	  	
		  	}
		}

		// enregistrer le chapo s'il n'y a pas d'erreurs dans le formulaire
		
		if (count($errors) == 0) {
//préparer ma requete sql pour toutes les requetes -----a faire!
		if (!empty($featured_image)) { 
			$query = "UPDATE posts SET title='$title', slug='$post_slug', views=0, image='$featured_image', body='$body', published=$published, date_updated=now() WHERE id=$post_id";
		} else  {
			$query = "UPDATE posts SET title='$title', slug='$post_slug', views=0, body='$body', published=$published, date_updated=now() WHERE id=$post_id";
		
		}
			//var_dump($query);
		//exit;
			// attacher chapo au post dans la table post_topic
			if(mysqli_query($conn, $query)){ // si le post est crée avec succée
				if (isset($chapo_id)) {
					$inserted_post_id = mysqli_insert_id($conn);
					// créer une relation entre le post and le chapo
					$sql = "INSERT INTO post_chapo (post_id, chapo_id) VALUES($inserted_post_id, $chapo_id)";
					mysqli_query($conn, $sql);
					$_SESSION['message'] = "Post crée avec succée.";
					header('location: posts.php');
					exit(0);
				}
			}
			$_SESSION['message'] = "Post modifiée avec succée.";
			header('location: posts.php');
			exit(0);
			
		}
	}
	// supprimer le blogpost
	function deletePost($post_id)
	{
		global $conn;
		$sql = "DELETE FROM posts WHERE id=$post_id";
		if (mysqli_query($conn, $sql)) {
			$_SESSION['message'] = "Post supprimée avec succée.";
			header("location: posts.php");
			exit(0);
		}
	}
    // si l'utilisateur clique sur le bouton de publication pour modifier le statut de publication
if (isset($_GET['publish']) || isset($_GET['unpublish'])) {
	$message = "";
	if (isset($_GET['publish'])) {
		$message = "Post publiée avec succée.";
		$post_id = $_GET['publish'];
	} else if (isset($_GET['unpublish'])) {
		$message = "Post publiée avec succée.";
		$post_id = $_GET['unpublish'];
	}
	togglePublishPost($post_id, $message);
}
// modifier le statut publiée
function togglePublishPost($post_id, $message)
{
	global $conn;
	$sql = "UPDATE posts SET published=!published WHERE id=$post_id";
	
	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = $message;
		header("location: posts.php");
		exit(0);
	}
}
?>