<?php
require('vendor/autoload.php');


use Exception;
use Application\Controllers\Post;
use Application\Controllers\ListPosts;
use Application\Controllers\Homepage;
use Application\Controllers\AddComment;
try {
    if (isset($_GET['action']) && $_GET['action'] !== '') {
        if ($_GET['action'] === 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];

                (new Post())->execute($identifier);
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }
            elseif ($_GET['action'] === 'posts') { 
                (new ListPosts())->execute();
       
        } elseif ($_GET['action'] === 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];

                (new AddComment())->execute($identifier, $_POST);
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
         } elseif ($_GET['action'] === 'test') {
            (new Homepage())->test();
        } else {
            throw new Exception("La page que vous recherchez n'existe pas.");
    }
    } else {
        (new Homepage())->execute();
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();

    require('templates/error.php');
}
