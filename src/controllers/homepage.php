<?php

namespace Application\Controllers\Homepage;

require_once('src/lib/database.php');
require_once('src/model/post.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\Post\PostRepository;
use Application\Controllers\Post;
class Homepage
{
    public function execute()
    {
        $connection =  DatabaseConnection::getConnection();
//var_dump($connection); exit();
        $postRepository = new PostRepository();
        $posts =$postRepository->getPosts();
        
       require('templates/homepage.php');
    }
}
