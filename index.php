<?php
require_once __DIR__ . '/vendor/autoload.php';

//require_once('src/controllers/homepageController.php');
require_once('src/controllers/postController.php');
//require_once('src/controllers/loginController.php');
//use Exception;
use Exception;
use Tracy\Debugger;
use Application\Controllers\CommentController;
use Application\Controllers\HomepageController;
use Application\Controllers\PostController;
use Application\Controllers\UserController;
use Application\Controllers\LoginController;

require 'vendor/autoload.php' ; // 

Debugger::enable();



try {
      if (isset($_GET['action']) && $_GET['action'] !== '') {
        if ($_GET['action'] === 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];
                (new PostController())->show($identifier);
                
            } else {
                throw new Exception('Aucun identifiant de post envoyé.');
            }
        }
            elseif ($_GET['action'] === 'listPosts') { 
                (new PostController())->index();
            }
            elseif ($_GET['action'] === 'login') { 
                
                (new LoginController())->login();
            }
            elseif ($_GET['action'] === 'register') { 
                
                (new LoginController())->register();
        }elseif ($_GET['action'] === 'listUsers') { 
            (new UserController())->index();
   
        }elseif ($_GET['action'] === 'createPost') { 
            (new PostController())->createPostMethod();
   
    }  elseif ($_GET['action'] === 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $idPost = $_GET['id'];
                var_dump($_SESSION['id']); exit();
                (new CommentControler())->execute($idPost, $_SESSION['id']);
               
            } else {
                throw new Exception('Aucun identifiant de post envoyé.');
            }
        }else {
            throw new Exception("La page que vous recherchez n'existe pas.");
    }
   } else {
    (new HomepageController)->execute();
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
    require('templates/error.php');
}
