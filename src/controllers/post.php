<?php

namespace Application\Controllers\Post;

use Application\Lib\DatabaseConnection;
use Application\Repository\CommentRepository;
use Application\Repository\PostRepository;

class Post
{
    public function execute(string $identifier)
    {
        $connection =  DatabaseConnection::getConnection();

        $postRepository = new PostRepository();
        $post =$postRepository->getPost($identifier);
        
        $commentRepository = new CommentRepository();
        $comment =$commentRepository->getComments($identifier);

        require('templates/post.php');
    }
}
