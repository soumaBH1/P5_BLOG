<?php

namespace Application\Controllers;

require_once('src/lib/database_connection.php');
require_once('src/model/post.php');

use Application\Lib\DatabaseConnection;
use Application\Repository\PostRepository;

class Homepage
{
    public function execute()
    {
        $connection =  DatabaseConnection::getConnection();
        $postRepository = new PostRepository();
        $posts =$postRepository->getPosts();
        
       require('templates/homepage.php');
    }
}
