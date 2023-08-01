<?php

namespace Application\Controllers;

require_once('src/lib/database_connection.php');
require_once('src/model/comment.php');

use Twig\Environment;
use Application\Lib\DatabaseConnection;
use Application\Repository\CommentRepository;

class Comment
{
    private $commentRepository;
    private $twig;

    public function __construct(CommentRepository $commentRepository, Environment $twig)
    {
        $this->commentRepository = $commentRepository;
        $this->twig = $twig;
    }

   
    public function execute(string $post, array $input)
    {
        $author = null;
        $comment = null;
        $published = 0;
        $user_id = 1;
        if (!empty($input['author']) && !empty($input['comment'])) {
            $author = $input['author'];
            $comment = $input['comment'];
        } else {
            throw new \Exception('Les données du formulaire sont invalides.');
        }
        //
        $connection =  DatabaseConnection::getConnection();

        $commentRepository = new CommentRepository();
        $success = $commentRepository->createComment($post, $user_id, $comment);
       ////

       
        if (!$success) {
            throw new \Exception('Impossible d\'ajouter le commentaire !');
        } else {
            header('Location: index.php?action=post&id=' . $post);
        }
    }
}
