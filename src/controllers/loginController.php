<?php

namespace Application\Controllers;


use DateTime;
use Exception;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Application\Lib\DatabaseConnection;
use Application\Repository\UserRepository;
use Application\Controllers\DefaultController;

/**
 * Class LoginController
 * @package App\Controller
 */
class LoginController extends DefaultController
{
    private $connection;
    private $repository;
    private $sessionService;
    public function __construct()
    {
        $this->connection = DatabaseConnection::getConnection();
        $this->repository = new UserRepository();
        //  $this->sessionService= new SessionService();
    }
    public function register()
    {
        // declaration des variables 
        $username = "";
        $email    = "";
        $firstname = "";
        $lastname = "";
        $age = NULL;
        $errors = array();

        // ENREGISTRER UN UTILISATEUR
        if ($_POST['action'] = 'register') {
            $this->render("login/register.html.twig");
            // recevoir toutes les valeurs d'entrée du formulaire
            $username = htmlspecialchars($_POST['username']);
            $email = htmlspecialchars($_POST['email']);
            //$firstname = htmlspecialchars($_POST['firstname']);
            // $lastname = htmlspecialchars($_POST['lastname']);
            //$age = htmlspecialchars($_POST['age']);
            $password_1 = htmlspecialchars($_POST['password1']);
            $password_2 = htmlspecialchars($_POST['password2']);

            // validation du formulaire : s'assurer que le formulaire est correctement rempli
            if (empty($username)) {
                array_push($errors, "Username obligatoire !");
            }
            if (empty($email)) {
                array_push($errors, "Oops.. vous avez oublié l'Email !'");
            }
            /* if (empty($firstname)) {
               array_push($errors, "Oops.. vous avez oublié le nom!'");
            }
            if (empty($lastname)) {
               array_push($errors, "Oops.. vous avez oublié le prénom !'");
           }
           if (empty($age)) {
                array_push($errors, "Oops.. vous avez oublié l'age' !'");
            }*/
            if (empty($password_1)) {
                array_push($errors, "Oops.. vous avez oublié le mot de passe !");
            }
            if ($password_1 != $password_2) {
                array_push($errors, "les deux mots de passe ne correspondent pas !");
            }
        }
    }
    public function login()
    {
        // declaration des variables 

        $email    = "";
        $firstname = "";
        $password = "";
        $errors = array();

        // // CONNEXION DE L'UTILISATEUR
        if ($_POST['action'] = 'login') {
            $this->render("login/login.html.twig");
            // recevoir toutes les valeurs d'entrée du formulaire
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            // validation du formulaire : s'assurer que le formulaire est correctement rempli

            if (empty($email)) {
                array_push($errors, "Oops.. vous avez oublié l'Email !'");
            }
            if (empty($password)) {
                array_push($errors, "Oops.. vous avez oublié le mot de passe !");
            }
            $password = md5($password); // chiffrer le mot de passe

            if (empty($errors)) {
                $password = md5($password); // chiffrer le mot de passe
              $userRepository = new UserRepository();
                $userRepository->authentifyUser($email, $password);
                
                 }
        }
    }



    public function logoutMethod()
    {
        unset($_SESSION);
        session_destroy();
    }
}
