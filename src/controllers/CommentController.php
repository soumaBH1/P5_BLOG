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

    public function execute($row)
    {
        $sessionService = new SessionService();
        $userSession = $sessionService->getUserArray();
       
        
        if (isset($userSession)) {
            
            if ($userSession['role']="admin") {

                $published = 0;
                $post_id = $_GET['id'];
                $user_id = $_GET['user_id'];
                $comment = $_POST['comment'];
                
                if (empty($comment)) {
                  
                 header('Location: index.php?action=post&id=' . $post_id);
                    //ajouter un message d'erreur
                    $errors = "Le champ commentaire est vide!";
            
                     //throw new \Exception('Les données du formulaire sont invalides.');
                } else {
       
                    //
                    $success = $this->commentRepository->createComment($post_id, $user_id, $comment);

                    if (!$success) {
                        throw new \Exception('Impossible d\'ajouter le commentaire !');
                    } else {
                     $successMessage = "Commentaire ajoutée avec succée!";
                        header('Location: index.php?action=post&id=' . $post_id);
                        // return $this->render('posts/show.html.twig', ['post_id' => $post_id, 'successMessage' => $successMessage, 'userSession' => $userSession]);
                    } 
                 }
             }
             header('Location: index.php?action=post&id=' . $post_id);
        }else{
                header('Location: index.php');
             }
       
                        
    }
    public function deleteCommentMethod(string $comment_id)
    {
        
        $sessionService = new SessionService();
        $userSession = $sessionService->getUserArray();
       
        if (isset($userSession)) {
           
            if ($userSession['role']="admin") {
              
               $success = $this->commentRepository->deleteComment($comment_id);
               
                if($success==true){     
                    $successMessage="Commentaire supprimé avec succée!";
                   (new AdminController())->execute();
                }else{
                    (new AdminController())->execute();
                
                }
                }else{
                header('Location: index.php'); 
            }
             
        }else{
        header('Location: index.php');
     }
    }
     function publishCommentMethod(string $comment_id)
    {
        
        $sessionService = new SessionService();
        $userSession = $sessionService->getUserArray();
       
        if (isset($userSession)) {
           
            if ($userSession['role']="admin") {
              
               $success = $this->commentRepository->publishComment($comment_id);
               
                if($success==true){     
                    $successMessage="Commentaire publiée avec succée!";
                   (new AdminController())->execute();
                }else{
                    (new AdminController())->execute();
                
                }
                }else{
                header('Location: index.php'); 
            }
             
        }else{
        header('Location: index.php');
     }
    }
}
   