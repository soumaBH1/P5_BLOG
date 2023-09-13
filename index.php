<?php
require_once __DIR__ . '/vendor/autoload.php';


use Exception;
use Tracy\Debugger;
use Application\Controllers\PostController;
use Application\Controllers\UserController;
use Application\Controllers\AdminController;
use Application\Controllers\LoginController;
use Application\Controllers\CommentController;
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
        } elseif ($_GET['action'] === 'logout') {

            (new LoginController())->logoutMethod();
        } elseif ($_GET['action'] === 'register') {

            (new LoginController())->register();
        } elseif ($_GET['action'] === 'listUsers') {
            (new UserController())->index();
        } elseif ($_GET['action'] === 'createPost') {
            (new PostController())->createPostMethod();
        } elseif ($_GET['action'] === 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
               $post_id = $_GET['id'];
               
               $user_id = $_GET['user_id'];
               $comment = $_POST['comment'];
               $row = ["post_id" => $post_id, "user_id" => $user_id, "comment" => $comment];
              
               (new CommentController())->execute($row);
            } else {
                throw new Exception('Aucun identifiant de post envoyé.');
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
