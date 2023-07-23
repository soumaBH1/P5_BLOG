<?php
namespace Application\Repository;

use Application\Lib\DatabaseConnection;
use Application\Model\Post;


class PostRepository
{
    public \PDO $connection;
    public function __construct(){
    $this->connection = (new DatabaseConnection())->getConnection();

    }

    public function getPost(string $identifier): Post
    {
        $statement = $this->connection->prepare(
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
        $statement = $this->connection->query(
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
