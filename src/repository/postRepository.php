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
            "SELECT posts.id, posts.user_id, posts.title, posts.body, posts.published, posts.image, posts.chapo, DATE_FORMAT(posts.created_at, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date, users.username FROM posts 
            INNER JOIN users ON posts.user_id = users.id WHERE posts.id = ?"
        );
        $statement->execute([$identifier]);

        $row = $statement->fetch();
        $post = new Post();
        //var_dump($row); exit();
        $post->hydrate( $row);
        return $post;
    }

    public function getPosts(): array
    {
        $statement = $this->connection->query(
            "SELECT posts.id, posts.user_id, posts.title, posts.body, posts.published, posts.image, posts.chapo, DATE_FORMAT(posts.created_at, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date, users.username FROM posts 
            INNER JOIN users ON posts.user_id = users.id "
        );
        $posts = [];
        while (($row = $statement->fetch())) {
            $post = new Post();
            $post->hydrate( $row);
            $posts[] = $post;
        }

        return $posts;
    }
    public function addPost(Array $row) {

            $title = $row['title'];
            $body = $row['body'];
            $chapo = $row['chapo'];
            $user_id = $row['user_id'];
           $published=0;
            
            $statement = $this->connection->prepare('INSERT INTO posts (user_id, post_id, body, published, created_at) VALUES(:user_id, :post_id, :body, :published, now())');
           
                $statement->bindParam(':user_id', $user_id);
                $statement->bindParam(':published', $published);
                $statement->bindParam(':title', $title);
                $statement->bindParam(':body', $body);
                $statement->bindParam(':chapo', $chapo);
                $statement->execute();
    } 
}
