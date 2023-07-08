<?php

namespace Application\Controllers\Post;

require_once('src/lib/database.php');
require_once('src/model/comment.php');
require_once('src/model/post.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\Comment\CommentRepository;
use Application\Model\Post\PostRepository;

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
