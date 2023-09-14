<?php

namespace Application\Controllers;

use Application\Services\SessionService;
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

        $sessionService = new SessionService();
        $userSession = $sessionService->getUserArray();
        $param = array(
            "post" => $post,
            "comments" => $comments, "userSession" => $userSession
        );
        //var_dump($param); exit();
        $this->render("posts/show.html.twig", $param, false);
    }
    public function index()
    {
        $connection =  DatabaseConnection::getConnection();
        $postRepository = new PostRepository();
        $posts = $postRepository->getPosts();

        $sessionService = new SessionService();
        $userSession = $sessionService->getUserArray();

        $param = array("posts" => $posts, "userSession" => $userSession);
        $this->render("posts/listPosts.html.twig", $param, false);
    }
    public function createPostMethod()
    {
        if (isset($userSession)) { //vérifier si un utilisateur estconnecté
            
                //vérifier si l'utilisateur connecté est admin
            
            if ($userSession['role'] = "admin") {
                // declaration des variables 
                $title = "";
                $body    = "";
                $chapo = "";
                $image = "";
                $errors = array();
                $row = array();
                $published = 0;
                 //afficher le template creation de post   
                $this->render("posts/createPost.html.twig", ["userSession" => $userSession, "errors" => $errors]);

                // recevoir toutes les valeurs d'entrée du formulaire
                if (!empty($_POST)) {
                    $title = htmlspecialchars($_POST['title']);
                    $body = htmlspecialchars($_POST['content']);
                    $chapo = htmlspecialchars($_POST['chapo']);
                    $fituredImage = htmlspecialchars($_POST['featured_image']);
                    $published = $_POST['publish'];

                    $row['title'] = $title;
                    $row['body'] = $body;
                    $row['chapo'] = $chapo;
                    $row['user_id'] = $userSession['id'];
                    $row['featured_image'] =  $fituredImage;
                    $row['published'] =  $published;
                    $connection =  DatabaseConnection::getConnection();
                    $postRepository = new PostRepository();
                    
                    $postRepository->addPost($row);
                    $_SESSION['message'] = "Post crée avec  succée.";
                    header('Location: index.php?action=listPost');
                }
            } else {
                $this->render("homepage.html.twig", ["userSession" => $userSession], false);
            }
        }
    }
}
