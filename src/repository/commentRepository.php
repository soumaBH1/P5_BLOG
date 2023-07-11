<?php
namespace Application\Repository;
use Application\Model\Comment;
use Application\Lib\Database;
class CommentRepository
{
    private \PDO $connection;
    public function __construct() {
            $this->connection = DatabaseConnection::getConnection();
    
       
    }
    public function getComments(string $post): array
    {
        $statement = $this->connection->prepare(
            "SELECT id, post_id, user_id, comment, DATE_FORMAT(created_at, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date, DATE_FORMAT(updated_at, '%d/%m/%Y à %Hh%imin%ss') AS french_updated_date FROM comments WHERE post_id = ? ORDER BY comment_date DESC"
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
}