<?php

namespace Application\Controllers;

use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use connection;
use Twig\Environment;
use Application\Lib\DatabaseConnection;
use Application\Repository\UserRepository;
use Application\Repository\CommentRepository;

class User
{
    private $connection;
    private $repository;
    public function __construct()
    {
        $this->connection = DatabaseConnection::getConnection();
        $this->repository = new UserRepository();
    }
    public function show(string $identifier)
    {
       
        $User = $this->repository->getUser($identifier);

        $userRepository = new userRepository();
        $user = $userRepository->getUser($identifier);
        $loader = new FilesystemLoader("templates");
        $twig = new Environment($loader);
        $twig->addExtension(new DebugExtension());
        // load template
        $template = $twig->load('users/show.html.twig');
        // set template variables
        // render template
    
        echo $template->render(array("user" => $user));
        
    }
    public function index()
    {
        $connection =  DatabaseConnection::getConnection();
        $userRepository = new UserRepository();
        $users = $userRepository->getUsers();
        $loader = new FilesystemLoader("templates");
        $twig = new Environment($loader);
        $twig->addExtension(new DebugExtension());
        // load template
        $template = $twig->load('users/listUsers.html.twig');
        // set template variables
        // render template
        echo $template->render(array("users" => $users));
    }
}
