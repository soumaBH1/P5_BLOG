<?php

namespace Application\Controllers;

require_once('src/lib/database_connection.php');
require_once('src/model/comment.php');

use Twig\Environment;
use Application\Lib\DatabaseConnection;
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

   
    public function execute(string $post_id, array $input)
    {
        if (isset ($_SESSION ))
        
        $comment = null;
        $published = 0;
        $user_id = 1;
        if (!empty($input['comment'])) {
            $user_id = $_SESSION['user_id'];
            $comment = $input['comment'];
        } else {
            throw new \Exception('Les données du formulaire sont invalides.');
        }
        //
        $success = $this->commentRepository->createComment($post_id, $user_id, $comment);
       ////

       
        if (!$success) {
            throw new \Exception('Impossible d\'ajouter le commentaire !');
        } else {
            header('Location: index.php?action=post&id=' . $post_id);
        }
    }
}
