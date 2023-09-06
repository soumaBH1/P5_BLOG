<?php

namespace App\Controllers;


/**
 * Class SessionService
 * @package App\Services
 */
class SessionService
{
    const ADMIN = 'Administrateur';

    const USER = 'Utilisateur';

    /**
     * @var mixed
     */
    private $session;

    /**
     * @var
     */
    private $user;

    /**
     * SessionController constructor.
     */
    public function __construct()
    {
        $this->session = filter_var_array($_SESSION);

        if (isset($this->session['user'])) {
            $this->user = $this->session['user'];
        }
    }

    /**
     * @param array $data
     */
    public function createSession(array $data)
    {
        if ($data['role'] == 1) $data['role'] = self::ADMIN;
        elseif ($data['role'] == 2) $data['role'] = self::USER;

        $this->session['user'] = [
            'sessionId' => session_id(),
            'username' => $data['username'],
            'id' => $data['id'],
            'email' => $data['email'],
            'created_at' => $data['created_at'],
            'role' => $data['role']
        ];
        $this->user = $this->session['user'];
        $_SESSION['user'] = $this->session['user'];
        $this->verifyRole();
    }

    public function logout()
    {
        unset($_SESSION);
        session_destroy();
    }

    /**
     * @return bool
     */
    public function isLogged()
    {
        if (!empty($this->getUserVar('sessionId'))) {
            return true;
        }
        return false;
    }

    public function isAdmin()
    {
        if ($this->getUserVar('role') !== 'Administrateur') {
            header('Location: index.php?page=home');
        }
        return true;
    }

    public function isUser()
    {
        if ($this->getUserVar('role') !== 'Utilisateur') {
            header('Location: index.php?page=home');
        }
        return true;
    }


    /**
     * @return mixed
     */
    public function getUserArray()
    {
        return $this->user;
    }

    /**
     * @param $var
     * @return mixed
     */
    public function getUserVar($var)
    {
        return $this->user[$var];
    }


    /**
     * @param string $var
     * @param $data
     */
    public function setUserVar(string $var, $data)
    {
        $this->user[$var] = $data;
    }

    /**
     *
     */
    private function verifyRole()
    {
        if ($this->getUserVar('role') == 1) {
            $this->setUserVar('role', self::ADMIN);
        } elseif ($this->getUserVar('role') == 2) {
            $this->setUserVar('role', self::USER);
        }
    }

}