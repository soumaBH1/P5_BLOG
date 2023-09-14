<?php

namespace Application\Controllers;


use DateTime;
use Exception;
use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Twig\Error\RuntimeError;
use Application\Services\SessionService;
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
        $password_1 = "";
        $password_2 = "";
        $email = "";
        $age = NULL;
        $errors = array();

        // ENREGISTRER UN UTILISATEUR
        if ($_POST['action'] = 'register') {
            $this->render("login/register.html.twig");
            // recevoir toutes les valeurs d'entrée du formulaire
            if (isset($_POST['username'])){ $username = htmlspecialchars($_POST['username']);}
            if (isset($_POST['email'])){ $email = htmlspecialchars($_POST['email']);}
            if (isset($_POST['firstname'])){ $firstname = htmlspecialchars($_POST['firstname']);}
            if (isset($_POST['lastname'])){ $lastname = htmlspecialchars($_POST['lastname']);}
            if (isset($_POST['age'])){ $age = htmlspecialchars($_POST['age']);}
            if (isset($_POST['password1'])){ $password_1 = htmlspecialchars($_POST['password1']);}
            if (isset($_POST['password2'])){ $password_2 = htmlspecialchars($_POST['password2']);}

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
            
            if (empty($errors)) {
                $row['email'] = $email;
                $row['username'] = $email;
                $row['password'] = $password_1;
                $row['firstname'] = $firstname;
                $row['lastname'] = $lastname;
                $row['age'] = $age;
                $userRepository = new UserRepository();
               
                $userRepository->addUser($row);
            } else {

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
            
            if ((isset($_POST['email'])) && (isset($_POST['password']))){
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
           

                if (empty($errors)) {
                    $userRepository = new UserRepository();
                
                    $row= $userRepository->authentifyUser($email, $password);
                    
                    // mettre l'utilisateur connecté dans le tableau de session
                    // Exemple d'utilisation
                    if($row === NULL){
                    array_push($errors, "Oops.. Réessayer vos coordonnées ne correspondent pas !");
           
                    }else{
                    $_SESSION['message'] = "You are now logged in";
                    $session = new SessionService();
                    $session->createSession($row);
                    
                    }
                }
                     //redirection vers dashboard si admin
                    // si l'utilisateur est administrateur, rediriger vers la zone d'administration
			        if (isset($session)){	
                       
                        if ( in_array($session->getUserArray()['role'], ["admin"])) {
					    $_SESSION['message'] = "Vous êtes maintenant connecté.";
                       
                        // rediriger vers la zone d'administration
					    header('location: index.php');
                        //exit(0);
					   
				    } else {
					    $_SESSION['message'] = "Vous êtes maintenant connecté.";
					    // rediriger vers la zone publique
					    header('location: index.php');	
                        //exit(0);			
					   
				    }    
                }
            }    
        }
        }
    public function logoutMethod()
    {
        unset($_SESSION);
        session_destroy();
        $_SESSION['message'] = "Vous êtes maintenant déconnecté.";
					// rediriger vers la zone publique
					header('location: index.php');				
					exit(0);
    }
}
