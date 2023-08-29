<?php

namespace Application\Controllers;

use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use connection;
use Twig\Environment;
use Application\Lib\DatabaseConnection;
use Application\Repository\UserRepository;
use Application\Repository\CommentRepository;
use Application\Controllers\DefaultController;
class UserController extends DefaultController
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
        
        $param=array("user" => $user);
        $this->render("users/show.html.twig", $param, false);
   
    }
    public function index()
    {
        $connection =  DatabaseConnection::getConnection();
        $userRepository = new UserRepository();
        $users = $userRepository->getUsers();
       

        $param=array("users" => $users);
        $this->render("users/listUsers.html.twig", $param, false);
    }
}
