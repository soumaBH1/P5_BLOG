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
}
