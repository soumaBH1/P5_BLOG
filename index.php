<?php
require_once __DIR__ . '/vendor/autoload.php';

require_once('src/controllers/homepage.php');
require_once('src/controllers/post.php');
use Application\Controllers\Post;
use Application\Controllers\User;
use Application\Controllers\Homepage;
use Application\Controllers\ListPosts;
use Application\Controllers\AddComment;
use Tracy\Debugger;

require 'vendor/autoload.php' ; // 

Debugger::enable();
try {
      if (isset($_GET['action']) && $_GET['action'] !== '') {
        if ($_GET['action'] === 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];
                (new Post())->show($identifier);
                
            } else {
                throw new Exception('Aucun identifiant de post envoyé.');
            }
        }
            elseif ($_GET['action'] === 'listPosts') { 
                (new Post())->index();
       
        }elseif ($_GET['action'] === 'listUsers') { 
            (new User())->index();
   
    } elseif ($_GET['action'] === 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];
                //var_dump($identifier, $_POST);exit;

               
            } else {
                throw new Exception('Aucun identifiant de post envoyé.');
            }
         
        }else {
            throw new Exception("La page que vous recherchez n'existe pas.");
    }
   } else {
      (new Homepage())->execute();
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();

    require('templates/error.php');
}
