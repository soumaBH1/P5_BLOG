<?php

namespace Application\Model\Comment;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class Comment
{
    private string $author;
    private string $post_id;
    private string $user_id;
    private string $id;
    private string $frenchCreationDate;
    private string $frenchUpdatedDate;
    private string $comment;
    public function getAuthor(): string
    {
        return $this->author;
    }
    public function setAuthor(string $value)
    {
        $this->author= strtoupper($value);
    }
    public function getFrenchCreationDate(): string
    {
        return $this->frenchCreationDate;
    }
    public function setFrenchCreationDate(string $value)
    {
        $this->frenchCreationDate= strtoupper($value);
    }
    public function getComment(): string
    {
        return $this->comment;
    }
    public function setComment(string $value)
    {
        $this->comment= strtoupper($value);
    }
    public function getPost_id(): string
    {
        return $this->post_id;
    }
    public function setPost_id(string $value)
    {
        $this->post_id= strtoupper($value);
    }   
    public function getUser_id(): string
    {
        return $this->user_id;
    }
    public function setUser_id(string $value)
    {
        $this->user_id= strtoupper($value);
    }   
    public function getId(): string
    {
        return $this->id;
    }
    public function setId(string $value)
    {
        $this->id= strtoupper($value);
    }   
    public function getFrenchUpdatedDate(): string
    {
        return $this->frenchUpdatedDate;
    }
    public function setFrenchUpdatedDate(string $value)
    {
        $this->frenchUpdatedDate= strtoupper($value);
    }
    public function hydrate(array $value)
    {
        $this->setId($value['id'] ?? ''); 
        $this->setPost_id($value['post_id'] ?? ''); 
        $this->setUser_id($value['user_id'] ?? ''); 
        $this->setAuthor($value['author'] ?? ''); 
        $this->setComment($value['comment'] ?? ''); //remplace le isset
        $this->setFrenchCreationDate($value['french_creation_date'] ?? ''); 
        $this->setFrenchUpdatedDate($value['french_updated_date'] ?? ''); 
        
    }
}

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
