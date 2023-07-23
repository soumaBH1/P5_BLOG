<?php
namespace Application\Controllers;
use Application\Lib\DatabaseConnection;
use Application\Repository\PostRepository;
use \Twig;
class ListPosts {
    public function execute()
    {
        $connection =  DatabaseConnection::getConnection();
//var_dump($connection); exit();
        $postRepository = new PostRepository();
        $posts =$postRepository->getPosts();
        $loader=new \Twig\Loader\FilesystemLoader("templates");
        $twig = new Twig\Environment($loader);
        // load template
        $template = $twig->load('ListPosts.html');
        // set template variables
        // render template

        echo $template->render(array("posts"=>$posts));

       //require('templates/ListPosts.html.twig');
    }
}