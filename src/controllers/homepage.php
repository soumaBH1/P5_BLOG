<?php

namespace Application\Controllers;

require_once('src/lib/database.php');
require_once('src/model/post.php');

use Application\Lib\DatabaseConnection;
use Application\Repository\PostRepository;
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
