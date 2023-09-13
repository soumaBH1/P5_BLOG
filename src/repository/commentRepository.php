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
             "SELECT comments.id, comments.post_id, comments.user_id, comments.body, comments.published, DATE_FORMAT(comments.created_at, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date, DATE_FORMAT(comments.updated_at, '%d/%m/%Y à %Hh%imin%ss') AS french_updated_date, users.username FROM comments inner join users ON users.id = comments.user_id WHERE comments.post_id = ? ORDER BY comments.created_at DESC"
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
    public function getAllComments(): array
    {
       
        $statement = $this->connection->prepare(
            "SELECT comments.id, comments.post_id, comments.user_id, comments.body, comments.published, DATE_FORMAT(comments.created_at, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date, DATE_FORMAT(comments.updated_at, '%d/%m/%Y à %Hh%imin%ss') AS french_updated_date, users.username FROM comments inner join users ON users.id = comments.user_id ORDER BY comments.created_at DESC"
        );
        $statement->execute();

        $comments = [];
        while (($row = $statement->fetch())) {
            $comment = new Comment();
            $comment->hydrate( $row);
            $comments[] = $comment;
        }
       

        return $comments;
    }
    public function createComment(string $post_id, int $user_id, string $comment): bool
    {
    
        $statement = $this->connection->prepare(
            'INSERT INTO comments(post_id, user_id, body, created_at) VALUES(:post_id, :user_id, :comment, NOW())'
        );
        $statement->bindParam(':post_id', $post_id);
        $statement->bindParam(':user_id', $user_id);
        $statement->bindParam(':comment', $comment);
        $affectedLines = $statement->execute();
       
        return ($affectedLines > 0);
    }
    public function deleteComment($idComment)
    {
        $statement = $this->connection->prepare(
 'DELETE FROM Comment WHERE Comment.id = :?');
 $statement->bindParam(':?', $idcomment);
        return $statement->execute();
    }

}