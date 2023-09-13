<?php

namespace Application\Controllers;

use connection;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;
use Application\Lib\DatabaseConnection;
use Application\Services\SessionService;
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

        $sessionService=new SessionService();
        $userSession=$sessionService->getUserArray();
        
        $param=array("user" => $user, "userSession"=> $userSession);
        $this->render("users/show.html.twig", $param, false);
   
    }
    public function index()
    {
        $connection =  DatabaseConnection::getConnection();
        $userRepository = new UserRepository();
        $users = $userRepository->getUsers();

        $sessionService=new SessionService();
        $userSession=$sessionService->getUserArray();

        $param=array("users" => $users, "userSession"=> $userSession);
        $this->render("users/listUsers.html.twig", $param, false);
    }
}