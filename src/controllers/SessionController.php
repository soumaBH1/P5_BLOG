<?php

namespace Application\Controllers;

class SessionController
{
    private $id;
    private $username;

    private $firstname;

    private $lastname;

    private $email;
    private $role;

    public function __construct(array $row)
    {
        // Démarrez la session si elle n'est pas déjà démarrée
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
            // Définir les variables de session
            $this->id = $row['id'];
            $this->set('id', $row['id']);
            $this->set('username', $row['username']);
            $this->set('lastname', $row['lastname']);
            $this->set('email', $row['email']);
            $this->set('role', $row['role']);
            $this->set('created_at', $row['created_at']);
            $this->set('valid', $row['valid']);
            $this->set('updated_at', $row['updated_at']);
        }
    }

    // Définir une variable de session
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    // Obtenir une variable de session
    public function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    // Supprimer une variable de session
    public function remove($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    // Détruire la session actuelle
    public function destroy()
    {
        session_destroy();
        // Détruire la session
        //$session->destroy();
    }
}
