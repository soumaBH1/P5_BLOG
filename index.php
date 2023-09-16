<?php
require_once __DIR__ . '/vendor/autoload.php';

use Exception;
use Tracy\Debugger;
use Application\Controllers\PostController;
use Application\Controllers\UserController;
use Application\Controllers\AdminController;
use Application\Controllers\LoginController;
use Application\Controllers\CommentController;
use Application\Controllers\ContactController;
use Application\Controllers\HomepageController;

require 'vendor/autoload.php'; // 
session_start();

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

        } elseif ($_GET['action'] === 'listPosts') {
            (new PostController())->index();

        } elseif ($_GET['action'] === 'adminDashboard') {
              
            (new AdminController())->execute();

        } elseif ($_GET['action'] === 'login') {
            (new LoginController())->login();

        } elseif ($_GET['action'] === 'contact') {
            (new ContactController())->execute();

        } elseif ($_GET['action'] === 'logout') {
            (new LoginController())->logoutMethod();

        } elseif ($_GET['action'] === 'register') {
            (new LoginController())->register();
        
        } elseif ($_GET['action'] === 'createPost') {
            (new PostController())->createPostMethod();
        
        } elseif ($_GET['action'] === 'adminlistPosts') {
                (new PostController())->listPostsAdmin();
   
            } elseif ($_GET['action'] === 'adminlistUsers') {
            (new UserController())->index();

 
        }elseif ($_GET['action'] === 'publishComment') {
                $identifier = $_GET['id'];
             (new CommentController())->publishCommentMethod($identifier);
 
        }elseif ($_GET['action'] === 'publishPost') {
                $identifier = $_GET['id'];
             (new PostController())->publishPostMethod($identifier);

        }elseif ($_GET['action'] === 'deleteUser') {
            $identifier = $_GET['id'];
            (new UserController())->deleteUserMethod($identifier);
        
        }elseif ($_GET['action'] === 'editUser') {
            $id = $_GET['id'];
            (new UserController())->editUserMethod($id);

        }elseif ($_GET['action'] === 'editPost') {
            $id = $_GET['id'];
            (new PostController())->editPostMethod($id);

        }elseif ($_GET['action'] === 'deletePost') {
            $identifier = $_GET['id'];
         (new PostController())->deletePostMethod($identifier);
        
        }elseif ($_GET['action'] === 'deleteComment') {
            $identifier = $_GET['id'];
         (new CommentController())->deleteCommentMethod($identifier);

        } elseif ($_GET['action'] === 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $post_id = $_GET['id'];
                $user_id = $_GET['user_id'];
                $comment = $_POST['comment'];
                $row = ["post_id" => $post_id, "user_id" => $user_id, "comment" => $comment];
             (new CommentController())->execute($row);  

            }
        } else {
            throw new Exception("La page que vous recherchez n'existe pas.");
            }
        } else {
            
        (new HomepageController)->execute();
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
    require('templates/error.php');
}

