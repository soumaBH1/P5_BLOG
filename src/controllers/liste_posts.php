<?php

// inclure l'autoloader


use Application\Lib\DatabaseConnection;
use Application\Repository\CommentRepository;
use Application\Repository\PostRepository;
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
  
