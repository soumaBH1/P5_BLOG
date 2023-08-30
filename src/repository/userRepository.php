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
        
        $statement = $this->connection->query( "SELECT * FROM users WHERE email=$email  LIMIT 1");
        $statement->execute();
        $row = $statement->fetch();
        if (!$row) {
            return null; // User not found
        }
    
        $hashedPasswordFromDatabase = $row['password'];
    
        if (!password_verify($password, $hashedPasswordFromDatabase)) {
            return null; // Password does not match
        }
        $user = new User();
       // var_dump($row);exit();
       if ($row != false) {
            }
        $user->hydrate( $row);
        return $user;}

    

public function addUser(array $row)
{
 
    $username = $row['username'];
    $email = $row['email'];
    $password = password_hash($row['password'], PASSWORD_DEFAULT); // Hash the password
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $age = $row['age'];
    $role = $row['role'];

    $statement = $this->connection->prepare("INSERT INTO users (username, email, password, created_at, updated_at, firstname, lastname, age, role) 
                          VALUES(:username, :email, :password, now(), now(), :firstname, :lastname, :age, :role)");
    
    $statement->bindParam(':username', $username);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':password', $password);
    $statement->bindParam(':firstname', $firstname);
    $statement->bindParam(':lastname', $lastname);
    $statement->bindParam(':age', $age);
    $statement->bindParam(':role', $role);

    $statement->execute();

    session_start(); // Start the session
    $_SESSION['message'] = "User added successfully.";
    header('location: index.php');	
}
}