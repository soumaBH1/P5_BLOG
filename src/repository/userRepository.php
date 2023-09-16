<?php

namespace Application\Repository;

use PDO;
use Application\Model\User;
use Application\Controllers\SessionController;
use Application\Lib\DatabaseConnection;


class UserRepository
{
    public \PDO $connection;
    public function __construct()
    {
        $this->connection = (new DatabaseConnection())->getConnection();
    }
    public function getUserByEmail(string $email): User
    {
        $statement = $this->connection->prepare(
            "SELECT id, firstname, lastname, email, password, role, username, created_at AS french_creation_date, updated_at AS french_creation_date FROM users WHERE email = ?"
        );
        $statement->execute([$email]);

        $row = $statement->fetch();
        $user = new User();
        $user->hydrate($row);
        return $user;
    }

    public function getUser(string $identifier): User
    {
        $statement = $this->connection->prepare(
            "SELECT id, firstname, lastname, email, password, role, username, created_at AS french_creation_date, updated_at AS french_creation_date FROM users WHERE id = ?"
        );
        $statement->execute([$identifier]);

        $row = $statement->fetch();
        $user = new User();
        $user->hydrate($row);
        return $user;
    }

    public function getUsers(): array
    {
        $statement = $this->connection->query(
            "SELECT id, firstname, lastname, email, password, role, username, created_at AS french_creation_date, updated_at AS french_creation_date FROM users"
        );
        $users = [];
        while (($row = $statement->fetch())) {
            $user = new User();
            $user->hydrate($row);
            $users[] = $user;
        }

        return $users;
    }
    public function authentifyUser(string $email, string $password): ?array
    {
        // Validate email and password
        if (empty($email) || empty($password)) {
            return null;
        }
        $statement = $this->connection->prepare('SELECT * FROM users WHERE email = :email  LIMIT 1');
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        // $statement->bindParam(':password', $password, PDO::PARAM_STR);
        $statement->execute();
        $row = $statement->fetch();

        //var_dump($row); exit();
        if (!$row) {

            return null; // User not found
        }

        $hashedPasswordFromDatabase = $row['password'];
        //var_dump('test'); exit();
        // if (!password_verify($password, $hashedPasswordFromDatabase)) {

        // return null; //
        // }

        $user = new User();


        if ($row != false) {
        }
        $user->hydrate($row);


        $_SESSION['user']["id"] = $row['id'];
        $_SESSION['user']["username"] = $row['username'];
        $_SESSION['user']["lastname"] = $row['lastname'];
        $_SESSION['user']["email"] = $row['email'];
        $_SESSION['user']["role"] = $row['role'];
        $_SESSION['user']["created_at"] = $row['created_at'];
        $_SESSION['user']["updated_at"] = $row['updated_at'];
        $_SESSION['user']["valid"] = $row['valid'];
        return $row;
    }



    public function editUser(array $row)
    {
        $id = $row['id'];
        $username = $row['username'];
        $email = $row['email'];
        //$password = password_hash($row['password'], PASSWORD_DEFAULT); // Hash the password
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $age = $row['age'];
        $role = $row['role'];

        $statement = $this->connection->prepare("UPDATE users SET username = :username, email = :email,
       role =:role, firstname = :firstname, lastname = :lastname, age = :age  WHERE id = :id");

        $statement->bindParam(':username', $username);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':role', $role);
        $statement->bindParam(':firstname', $firstname);
        $statement->bindParam(':lastname', $lastname);
        $statement->bindParam(':age', $age);
        $statement->bindParam(':id', $id);
        $test = $statement->execute();

        return $test;
    }
    public function deleteUser(string $id)
    {
        $statement = $this->connection->prepare(
            'DELETE FROM users WHERE id = :id'
        );
        $statement->bindParam(':id', $id);
        return $statement->execute();
    }
    public function addUser(array $row)
    {

        $username = $row['username'];
        $email = $row['email'];
        $password = password_hash($row['password'], PASSWORD_DEFAULT); // Hash the password
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $age = $row['age'];
        //$role = $row['role'];
        //un utilisateur est auteur par défaut et l'admin peut modifier en Admin
        $statement = $this->connection->prepare("INSERT INTO users (username, email, password, created_at, updated_at, firstname, lastname, age, role) 
                          VALUES(:username, :email, :password, now(), now(), :firstname, :lastname, :age, 'author')");

        $statement->bindParam(':username', $username);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':password', $password);
        $statement->bindParam(':firstname', $firstname);
        $statement->bindParam(':lastname', $lastname);
        $statement->bindParam(':age', $age);

        $test = $statement->execute();


        session_start(); // Start the session
        $_SESSION['message'] = "User added successfully.";

        header('location: index.php');
    }
}
