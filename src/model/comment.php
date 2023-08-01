<?php

namespace Application\Model;

//require_once('src/lib/database.php');


class Comment
{
    private string $post_id;
    private string $user_id;
    private string $id;
    private string $frenchCreationDate;
    private string $frenchUpdatedDate;
    private string $body;
    
    public function getFrenchCreationDate(): string
    {
        return $this->frenchCreationDate;
    }
    public function setFrenchCreationDate(string $value)
    {
        $this->frenchCreationDate= strtoupper($value);
    }
    public function getBody(): string
    {
        return $this->body;
    }
    public function setBody(string $value)
    {
        $this->body= strtoupper($value);
    }
    public function getPost_id(): string
    {
        return $this->post_id;
    }
    public function setPost_id(string $value)
    {
        $this->post_id= strtoupper($value);
    }   
    public function getUser_id(): string
    {
        return $this->user_id;
    }
    public function setUser_id(string $value)
    {
        $this->user_id= strtoupper($value);
    }   
    public function getId(): string
    {
        return $this->id;
    }
    public function setId(string $value)
    {
        $this->id= strtoupper($value);
    }   
    public function getFrenchUpdatedDate(): string
    {
        return $this->frenchUpdatedDate;
    }
    public function setFrenchUpdatedDate(string $value)
    {
        $this->frenchUpdatedDate= strtoupper($value);
    }
    public function hydrate(array $value)
    {
        $this->setId($value['id'] ?? ''); 
        $this->setPost_id($value['post_id'] ?? ''); 
        $this->setUser_id($value['user_id'] ?? ''); 
        $this->setBody($value['body'] ?? ''); //remplace le isset
        $this->setFrenchCreationDate($value['french_creation_date'] ?? ''); 
        $this->setFrenchUpdatedDate($value['french_updated_date'] ?? ''); 
        
    }
}

