<?php

namespace Application\Services;


/**
 * Class SessionService
 * @package App\Services
 */
class SessionService
{
    const ADMIN = 'admin';

    const USER = 'user';

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
        if(!isset($_SESSION)){
            return;
        }
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
        if ($data['role'] == "admin") $data['role'] = self::ADMIN;
        elseif ($data['role'] =="user") $data['role'] = self::USER;

        $this->session['user'] = [
            'sessionId' => session_id(),
            'username' => $data['username'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
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
        if ($this->getUserVar('role') !== 'admin') {
           // header('Location: index.php?action=homePage');
        }
        return true;
    }

    public function isUser()
    {
        if ($this->getUserVar('role') !== 'user') {
            //header('Location: index.php?action=homePage');
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
    private function verifyRole() :string
    {
        if ($this->getUserVar('role') == "admin") {
           //$this->setUserVar('role', self::ADMIN); 
           return "admin";
        } else {
            //$this->setUserVar('role', self::USER);
            return "user";
        }
    }

}