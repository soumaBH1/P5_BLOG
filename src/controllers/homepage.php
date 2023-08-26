<?php

namespace Application\Controllers;

require_once('src/lib/database_connection.php');
require_once('src/model/post.php');
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;
use Application\Lib\DatabaseConnection;
use Application\Repository\PostRepository;

class Homepage
{
    public function execute()
    {
        $connection =  DatabaseConnection::getConnection();
       //$postRepository = new PostRepository();
        //$posts =$postRepository->getPosts();
        $loader = new FilesystemLoader("templates");
        $twig = new Environment($loader);
        $twig->addExtension(new DebugExtension());
        // load template
        $template = $twig->load('homepage.html.twig');
       //require('templates/homepage.html.twig');
       echo $template->render(array());
    }
}
