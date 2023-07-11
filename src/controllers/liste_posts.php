<?php
// list_posts.php
// inclure l'autoloader
require_once('src/lib/database.php');
require_once('src/model/comment.php');
require_once('src/model/post.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\Comment\CommentRepository;
use Application\Model\Post\PostRepository;
include 'vendor/autoload.php';
try {
// le dossier ou on trouve les templates
$loader = new \Twig\Loader\FilesystemLoader('templates');
// initialiser l'environement Twig
$twig = new Twig\Environment($loader);
// load template
$template = $twig->load('ListePosts.twig.html');
// set template variables
// render template
$connection =  DatabaseConnection::getConnection();
$postRepository = new PostRepository();
        $posts =$postRepository->getPosts();
echo $template->render(array(
 
//var_dump($connection); exit();
        
));
} catch (Exception $e) {
die ('ERROR: ' . $e->getMessage());
}

       require('templates/homepage.php');
  
