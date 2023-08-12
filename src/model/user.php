<?php

namespace Application\Model;


class User
{
    private ?int $id = null;
    private string $email;
    private string $username;
    private string $firstname;
    private string $lastname;
    private string $password;
    private mixed $role;
    private string $frenchUpdatedDate;
    private string $frenchCreationDate;


    public function __construct(array  $data=null)
    {
      if( isset($data)  ){
        $this->hydrate($data);
      }
    }
    public function isAdmin(): bool
    {
        if ($this->role == 'admin') {
            return true;
        } else {
            return false;
        }
    }
    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): User
    {
        $this->username = $username;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;

    }

    public function getRole(): mixed
    {
        return $this->role;
    }

    public function setRole(mixed $role): User
    {
        $this->role = $role;
        return $this;
    }
    public function getFirstname(): mixed
    {
        return $this->firstname;
    }

    public function setFirstname(mixed $firstname): User
    {
        $this->firstname = $firstname;
        return $this;
    }
    public function getLastname(): mixed
    {
        return $this->lastname;
    }

    public function setLastname(mixed $lastname): User
    {
        $this->lastname = $lastname;
        return $this;
    }
    public function getFrenchUpdatedDate(): string
    {
        return $this->frenchUpdatedDate;
    }
    public function setFrenchUpdatedDate(string $value)
    {
        $this->frenchUpdatedDate = strtoupper($value);
    }
    public function getFrenchCreationDate(): string
    {
        return $this->frenchCreationDate;
    }
    public function setFrenchCreationDate(string $value)
    {
        $this->frenchCreationDate = strtoupper($value);
    }
    public function hydrate(array $value)
    {
        $this->setId($value['id'] ?? ''); 
        $this->setUsername($value['username'] ?? '');
        $this->setRole($value['role'] ?? ''); //remplace le isset
        $this->setEmail($value['email'] ?? '');
        $this->setPassword($value['password'] ?? '');
        $this->setfirstname($value['firstname'] ?? '');
        $this->setLastname($value['lastname'] ?? '');
        $this->setFrenchCreationDate($value['french_creation_date'] ?? ''); 
        $this->setFrenchUpdatedDate($value['french_updated_date'] ?? ''); 
    }

}


