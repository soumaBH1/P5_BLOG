<?php

namespace Application\Model\Post;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class Post
{
    private string $title;
    private string $frenchCreationDate;
    private string $content;
    private string $identifier;
    public function getTitle(): string
    {
        return $this->title;
    }
   
    public function setTitle(string $value)
    {
        $this->title = strtoupper($value);
    }
    public function geContent(): string
    {
        return $this->content;
    }
    public function setContent(string $value)
    {
        $this->content = $value;
    }
    public function getFrenchCreationDate(): string
    {
        return $this->frenchCreationDate;
    }
    public function setFrenchCreationDate(string $value)
    {
        $this->frenchCreationDate = strtoupper($value);
    }
    public function getIdentifier(): string
    {
        return $this->identifier;
    }
    public function setIdentifier(string $value)
    {
        $this->identifier= strtoupper($value);
    }
   
       
    public function hydrate(array $value)
    {
        $this->setIdentifier($value['id'] ?? ''); 
        $this->setTitle($value['title'] ?? '');
        $this->setContent($value['content'] ?? ''); //remplace le isset
        $this->setFrenchCreationDate($value['french_creation_date'] ?? ''); 
    }
}

class PostRepository
{
    public DatabaseConnection $connection;

    public function getPost(string $identifier): Post
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts WHERE id = ?"
        );
        $statement->execute([$identifier]);

        $row = $statement->fetch();
        $post = new Post();
        $post->hydrate( $row);
        return $post;
    }

    public function getPosts(): array
    {
        $statement = $this->connection->getConnection()->query(
            "SELECT id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts ORDER BY creation_date DESC LIMIT 0, 5"
        );
        $posts = [];
        while (($row = $statement->fetch())) {
            $post = new Post();
            $post->hydrate( $row);
            $posts[] = $post;
        }

        return $posts;
    }
}
