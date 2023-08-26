<?php

namespace Application\Controllers;


use DateTime;
use Exception;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Application\Lib\DatabaseConnection;
use Application\Repository\UserRepository;
/**
 * Class LoginController
 * @package App\Controller
 */
class login
{
    private $connection;
    private $repository;
    private $sessionService;
    public function __construct()
    {
        $this->connection = DatabaseConnection::getConnection();
        $this->repository = new UserRepository();
      //  $this->sessionService= new SessionService();
    }
    public function show(string $identifier)
    {
       
        $post = $this->repository->getPost($identifier);

        $commentRepository = new CommentRepository();
        $comments = $commentRepository->getComments($identifier);
        $loader = new FilesystemLoader("templates");
        $twig = new Environment($loader);
        $twig->addExtension(new DebugExtension());
        // load template
        $template = $twig->load('posts/show.html.twig');
        // set template variables
        // render template
    
        echo $template->render(array("post" => $post));
        
    }
   
    public function logoutMethod()
    {
        unset($_SESSION);
        session_destroy();
    }
    
}