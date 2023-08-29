<?php
namespace Application\Repository;

use Application\Lib\DatabaseConnection;
use Application\Model\User;


class UserRepository
{
    public \PDO $connection;
    public function __construct(){
    $this->connection = (new DatabaseConnection())->getConnection();

    }
    public function getUserByEmail(string $email): User
    {
        $statement = $this->connection->prepare(
            "SELECT id, firstname, lastname, email, password, role, username, DATE_FORMAT(created_at, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date, DATE_FORMAT(updated_at, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM users WHERE email = ?"
        );
        $statement->execute([$email]);

        $row = $statement->fetch();
        $user = new User();
        $user->hydrate( $row);
        return $user;
    }

    public function getUser(string $identifier): User
    {
        $statement = $this->connection->prepare(
            "SELECT id, firstname, lastname, email, password, role, username, DATE_FORMAT(created_at, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date, DATE_FORMAT(updated_at, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM users WHERE id = ?"
        );
        $statement->execute([$identifier]);

        $row = $statement->fetch();
        $user = new User();
        $user->hydrate( $row);
        return $user;
    }

    public function getUsers(): array
    {
        $statement = $this->connection->query(
            "SELECT id, firstname, lastname, email, password, role, username, DATE_FORMAT(created_at, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date, DATE_FORMAT(updated_at, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM users"
        );
        $users = [];
        while (($row = $statement->fetch())) {
            $user = new User();
           $user->hydrate( $row);
            $users[] = $user;
        }

        return $users;
    }
    public function authentifyUser(string $email, string $password): User
    {
        
        $statement = $this->connection->query( "SELECT * FROM users WHERE email='$email' and password='$password' LIMIT 1");
        $statement->execute();
        $row = $statement->fetch();
        $user = new User();
       // var_dump($row);exit();
        $user->hydrate( $row);
        return $user;}

    }

    

