<?php

namespace Application\Model;

class Post
{
    private int $identifier;
    private string $title;
    private string $frenchCreationDate;
    private string $frenchUpdatedDate;
    private string $content;
    private string $image;
    private string $chapo;
    private string $published;
    public function getTitle(): string
    {
        return htmlspecialchars($this->title);
    }
   
    public function setTitle(string $value)
    {
        $this->title = strtoupper($value);
    }
    public function getContent(): string
    {
        return htmlspecialchars($this->content);
    }
    public function setContent(string $value)
    {
        $this->content = $value;
    }
    public function getFrenchCreationDate(): string
    {
        return $this->frenchCreationDate;
    }
    public function setFrenchCreationDate(string $value)
    {
        $this->frenchCreationDate = strtoupper($value);
    }
    public function getIdentifier(): int
    {
        return $this->identifier;
    }
    public function setIdentifier(int $value)
    {
        $this->identifier= $value;
    }
    public function getImage(): string
    {
        return $this->image;
    }
   
    public function setImage(string $value)
    {
        $this->image = strtoupper($value);
    }
    public function getChapo(): string
    {
        return htmlspecialchars($this->chapo);
    }
   
    public function setChapo(string $value)
    {
        $this->chapo = strtoupper($value);
    } 
    public function getPublished(): string
    {
        return htmlspecialchars($this->published);
    }
   
    public function setPublished(bool $value)
    {
        $this->published = $value;
    } 
    public function getFrenchUpdatedDate(): string
    {
        return $this->frenchUpdatedDate;
    }
    public function setFrenchUpdatedDate(string $value)
    {
        $this->frenchUpdatedDate = strtoupper($value);
    }
    public function hydrate(array $value)
    {
        $this->setIdentifier($value['id'] ?? ''); 
        $this->setTitle($value['title'] ?? '');
        $this->setContent($value['body'] ?? ''); //remplace le isset
        $this->setImage($value['image'] ?? '');
        $this->setChapo($value['chapo'] ?? '');
        $this->setPublished($value['published'] ?? '');
        $this->setFrenchCreationDate($value['french_creation_date'] ?? ''); 
        $this->setFrenchUpdatedDate($value['french_updated_date'] ?? ''); 
    }
}

