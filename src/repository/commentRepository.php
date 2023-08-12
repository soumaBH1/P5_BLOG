<?php
namespace Application\Repository;

use Application\Lib\DatabaseConnection;
use Application\Model\Comment;
class CommentRepository
{
    private \PDO $connection;
    public function __construct() {
            $this->connection = (new DatabaseConnection())->getConnection();
    
       
    }
    public function getComments(string $post): array
    {
        $statement = $this->connection->prepare(
            "SELECT id, post_id, user_id, body, DATE_FORMAT(created_at, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date, DATE_FORMAT(updated_at, '%d/%m/%Y à %Hh%imin%ss') AS french_updated_date FROM comments WHERE post_id = ? ORDER BY created_at DESC"
        );
        $statement->execute([$post]);

        $comments = [];
        while (($row = $statement->fetch())) {
            $comment = new Comment();
            $comment->hydrate( $row);
            $comments[] = $comment;
        }
       

        return $comments;
    }

    public function createComment(string $post, int $user_id, string $comment): bool
    {
    
        $statement = $this->connection->prepare(
            'INSERT INTO comments(post_id, user_id, body, created_at) VALUES(?, ?, ?, NOW())'
        );
        $affectedLines = $statement->execute([$post, $user_id, $comment]);

        return ($affectedLines > 0);
    }
    public function deleteComment($idComment)
    {
        $statement = $this->connection->prepare(
 'DELETE FROM Comment WHERE Comment.id = ' . $idComment );
        return $statement->execute();
    }

}