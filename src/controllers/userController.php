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

        $sessionService = new SessionService();
        $userSession = $sessionService->getUserArray();

        $param = array("user" => $user, "userSession" => $userSession);
        $this->render("users/show.html.twig", $param, false);
    }
    public function index()
    {
        $connection =  DatabaseConnection::getConnection();
        $userRepository = new UserRepository();
        $users = $userRepository->getUsers();

        $sessionService = new SessionService();
        $userSession = $sessionService->getUserArray();
        if (isset($userSession)) {

            if ($userSession['role'] = "admin") {
                $param = array("users" => $users, "userSession" => $userSession);
                $this->render("users/listUsers.html.twig", $param, false);
            } else {
                $this->render("homepage.html.twig", ["userSession" => $userSession], false);
            }
        }
    }
    public function editUserMethod(string $identifier)
    {
        $connection =  DatabaseConnection::getConnection();
        $userRepository = new UserRepository();
       $user = $userRepository->getUser($identifier);

        $sessionService = new SessionService();
        $userSession = $sessionService->getUserArray();
        if (isset($userSession)) {

            if ($userSession['role'] = "admin") {
                // declaration des variables 

                $email    = "";
                $firstname = "";
                $password = "";
                $errors = array();
                $param = array("user" => $user, "userSession" => $userSession);
               
                // // charger la page modification de l'utilisateur
                $this->render("admin/editUser.html.twig", $param, false);
           
        if ((isset($_POST['email'])) && (isset($_POST['password']))) {
            // recevoir toutes les valeurs d'entrée du formulaire
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            // validation du formulaire : s'assurer que le formulaire est correctement rempli

             // recevoir toutes les valeurs d'entrée du formulaire
             if (isset($_POST['username'])) {
                $username = htmlspecialchars($_POST['username']);
            }
            if (isset($_POST['email'])) {
                $email = htmlspecialchars($_POST['email']);
            }
            if (isset($_POST['firstname'])) {
                $firstname = htmlspecialchars($_POST['firstname']);
            }
            if (isset($_POST['lastname'])) {
                $lastname = htmlspecialchars($_POST['lastname']);
            }
            if (isset($_POST['age'])) {
                $age = htmlspecialchars($_POST['age']);
            }
           

            // validation du formulaire : s'assurer que le formulaire est correctement rempli
            if (empty($username)) {
                array_push($errors, "Username obligatoire !");
            }
            if (empty($email)) {
                array_push($errors, "Oops.. vous avez oublié l'Email !'");
            }


            if (empty($errors)) {
                $row['email'] = $email;
                $row['username'] = $username;
                $row['firstname'] = $firstname;
                $row['lastname'] = $lastname;
                $row['age'] = $age;
                $row['role'] = $age;
              
                $success=$userRepository->editUser($row);
                if ($success == true) {
                    $successMessage = "User modifié avec succée!";
                    (new AdminController())->execute();
                } else {
                    (new AdminController())->execute();
                }
            } else {
            }
            
        }
        ////////////////
           
           
            } else {
                $this->render("homepage.html.twig", ["userSession" => $userSession], false);
            }
        }
        ////////////////


        
      
    }
    public function deleteUserMethod(string $User_id)
    {

        $sessionService = new SessionService();
        $userSession = $sessionService->getUserArray();

        if (isset($userSession)) {

            if ($userSession['role'] = "admin") {

                $success = $this->repository->deleteUser($User_id);

                if ($success == true) {
                    $successMessage = "User supprimé avec succée!";
                    (new AdminController())->execute();
                } else {
                    (new AdminController())->execute();
                }
            } else {
                header('Location: index.php');
            }
        } else {
            header('Location: index.php');
        }
    }
}
