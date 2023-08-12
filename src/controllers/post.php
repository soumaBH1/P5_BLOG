<?php

namespace Application\Controllers;

use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Application\Lib\DatabaseConnection;
use Application\Repository\PostRepository;
use Application\Repository\CommentRepository;
use Twig\Environment;

class Post
{
    private $connection;
    private $repository;
    public function __construct()
    {
        $this->connection = DatabaseConnection::getConnection();
        $this->repository = new PostRepository();
    }
    public function show(string $identifier)
    {
       
        $post = $this->repository->getPost($identifier);

        $commentRepository = new CommentRepository();
        $comments = $commentRepository->getComments($identifier);
        $loader = new FilesystemLoader("templates");
        $twig = new Environment($loader);
        $twig->addExtension(new DebugExtension());
        // load template
        $template = $twig->load('posts/show.html.twig');
        // set template variables
        // render template
    
        echo $template->render(array("post" => $post));
        
    }
    public function index()
    {
        $connection =  DatabaseConnection::getConnection();
        $postRepository = new PostRepository();
        $posts = $postRepository->getPosts();
        $loader = new FilesystemLoader("templates");
        $twig = new Environment($loader, ['debug' => true]);
        $twig->addExtension(new DebugExtension());
        // load template
        $template = $twig->load('posts/listPosts.html.twig');
        // set template variables
        // render template
        echo $template->render(array("posts" => $posts, "test"=>1));
    }
    
}
