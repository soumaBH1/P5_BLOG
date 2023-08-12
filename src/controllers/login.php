<?php

namespace Application\Controllers;


use DateTime;
use Exception;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class LoginController
 * @package App\Controller
 */
class LoginController extends MainController
{
    /**
     *
     */
    const TWIG_LOGIN = 'login/login.twig';
    /**
     *
     */
    const TWIG_FORGET = 'login/forget.twig';
    /**
     *
     */
    const TWIG_REGISTER = 'login/register.twig';
    /**
     *
     */
    const TWIG_CHANGEPASS = 'login/changepassword.twig';
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function DefaultMethod()
    {
        if ($this->session->isLogged()) {
            $this->redirect('home');
        }
        return $this->render(self::TWIG_LOGIN);
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     */
    public function loginMethod()
    {
        $post = $this->post->getPostArray();
        $errorMsg = null;

        if(empty($post)){
            return $this->twig->render(self::TWIG_LOGIN);
        } //Si $_POST est vide

        $data = $this->loginSql->getUser($post['email']); //Récupère les données de l'utilisateur avec l'email

        if ($data === false) {
            $errorMsg = 'Mauvaise adresse mail';
            goto ifError;
        }//Si l'adresse email n'est pas bonne


        if(!password_verify($post['password'], $data['password'])){
            $errorMsg = "Mot de passe incorrect";
            goto ifError;
        }


        $this->auth($data);

        ifError:
        return $this->renderTwigErr(self::TWIG_LOGIN, $errorMsg);

    }

    /**
     * @param array $data
     * @throws Exception
     */
    private function auth($data = [])
    {
        $this->session->createSession($data);
        if ($this->session->getUserVar('rank') === 'Administrateur'){
            $this->redirect('admin');
        }
        elseif ($this->session->getUserVar('rank') === 'Utilisateur'){
            $this->redirect('user');
        }
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * Forgot password method on login page
     */
    public function passwordForgetMethod(){
        $post = $this->post->getPostVar('email');

        if(empty($post)){
            return $this->twig->render(self::TWIG_FORGET);
        }//Affiche le formulaire si $_POST est vide

        $search = $this->loginSql->getUser($post);
        if ($search === false){
            $errorMsg = 'Vous n\'avez pas de compte chez nous';
            goto ifError;
        }//Vérifie si l'utilisateur est dans la base de données

        $user = array('email' => $search['email'],
            'idUser' => $search['idUser']);
        $mail = $this->mail->sendForgetPassword($user); //Envoi le mail

        if ($mail === false){
            $errorMsg = 'Une erreur est survenue lors de l\'envoi du mail';
            goto ifError;
        }//Si il y a une erreur dans l'envoi du mail

        return $this->renderTwigSuccess(self::TWIG_FORGET, 'Nous vous avons envoyé un lien par email. Il ne sera actif que 15 minutes.');

        ifError:
        return $this->renderTwigErr(self::TWIG_FORGET, $errorMsg);
    }

    /**
     *
     */
    public function logoutMethod()
    {
        unset($_SESSION);
        session_destroy();
        $this->redirect('home');
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
   
}