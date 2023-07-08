<?php

namespace Application\Controllers\AddComment;

require_once('src/lib/database.php');
require_once('src/model/comment.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\Comment\CommentRepository;

class AddComment
{
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
//var_dump($connection); exit();
$commentRepository = new CommentRepository();
        $success = $commentRepository->createComment($post, $user_id, $comment);
        //

        //$commentRepository = new CommentRepository();
       // $commentRepository->connection = new DatabaseConnection();
        //$success = $commentRepository->createComment($post, $user_id, $comment);
        if (!$success) {
            throw new \Exception('Impossible d\'ajouter le commentaire !');
        } else {
            header('Location: index.php?action=post&id=' . $post);
        }
    }
}
