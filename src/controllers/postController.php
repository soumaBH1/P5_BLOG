<?php

namespace Application\Controllers;

use App\Services\SessionService;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Application\Lib\DatabaseConnection;
use Application\Repository\PostRepository;
use Application\Repository\CommentRepository;
use Application\Controllers\DefaultController;
use Twig\Environment;
use connection;

class PostController extends DefaultController
{
    private $connection;
    private $repository;
    private $sessionService;
    public function __construct()
    {
        $this->connection = DatabaseConnection::getConnection();
        $this->repository = new PostRepository();
       
      
    }
    public function show(string $identifier)
    {

        $post = $this->repository->getPost($identifier);

        $commentRepository = new CommentRepository();
        $comments = $commentRepository->getComments($identifier);
        $param = array("post" => $post,
                        "comments" => $comments,);
        $this->render("posts/show.html.twig", $param, false);
    }
    public function index()
    {
        $connection =  DatabaseConnection::getConnection();
        $postRepository = new PostRepository();
        $posts = $postRepository->getPosts();
        $param = array("posts" => $posts);
        $this->render("posts/listPosts.html.twig", $param, false);
    }
    public function createPostMethod()
    {
        if ($_SESSION['role'] = "admin") {
         // declaration des variables 
         $title = "";
         $body    = "";
         $chapo = "";
         $image = "";
         $errors = array();
         $row = array();
         // créer UN post
        
             $this->render("posts/createPost.html.twig");
             // recevoir toutes les valeurs d'entrée du formulaire
             $title = htmlspecialchars($_POST['title']);
             $body = htmlspecialchars($_POST['body']);
             $chapo = htmlspecialchars($_POST['chapo']);
             //$image = htmlspecialchars($_POST['image']);
             $row['title']=$title;
             $row['body']=$body;
             $row['chapo']=$chapo;
             $row['user_id']= $_SESSION['user_id'];
            $connection =  DatabaseConnection::getConnection();
            $postRepository = new PostRepository();
            $postRepository->addPost($row);
                       
            $_SESSION['message'] = "Post crée avec  succée.";
            header('location: index.php');
             
        }
    }
}
