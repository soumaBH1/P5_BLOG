<?php 

class Post {
    private $title;
    private $description;

    function __construct($data)
    {
        $this->setTitle($data['title']);
        $this->setDescription($data['description']);
    }

    function setTitle($value) {
        $this->title = $value;
    }

    function setDescription($value) {
        $this->description = $value;
    }

    function getTitle() {
        return $this->title;
    }

    function getDescription() {
        return $this->description;
    }
}

$post1 = new Post(['title' => "Ceci est mon titre", 'description' => "Ceci est ma description"]);

var_dump($post1->getTitle());
var_dump($post1->getDescription());