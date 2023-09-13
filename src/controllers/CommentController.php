<?php

namespace Application\Controllers;


use Twig\Environment;
use Application\Lib\DatabaseConnection;
use Application\Services\SessionService;
use Application\Repository\CommentRepository;
use Application\Controllers\DefaultController;

class CommentController extends DefaultController
{
    private $commentRepository;
    private $connection;
    private $repository;

    public function __construct()
    {
        $this->connection = DatabaseConnection::getConnection();
        $this->commentRepository = new CommentRepository();
       
    }

    public function index()
    {
        $connection =  DatabaseConnection::getConnection();
        $commentRepository = new CommentRepository();
        $comments = $commentRepository->getAllComments();

        $sessionService = new SessionService();
        $userSession = $sessionService->getUserArray();

        $param = array("comments" => $comments, "userSession" => $userSession);
        $this->render("posts/listComments.html.twig", $param, false);
    }
   
    public function execute(array $input)
    {
        if (isset ($_SESSION ))
        
               $published = 0;
               $post_id = $_GET['id'];
            
        $user_id = $_GET['user_id'];
        $comment = $_POST['comment'];
        
        if (!empty($comment)) {
            
        } else {
            throw new \Exception('Les données du formulaire sont invalides.');
        }
        //
        $success = $this->commentRepository->createComment($post_id, $user_id, $comment);
       
        ////

       
        if (!$success) {
            throw new \Exception('Impossible d\'ajouter le commentaire !');
        } else {
            echo "Commentaire ajoutée avec succée!";
            header('Location: index.php?action=post&id=' . $post_id);
        }
    }
}
