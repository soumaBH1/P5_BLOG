<?php

// Récupération des variables à l'aide du client MySQL
$usersStatement = $mysqlClient->prepare('SELECT * FROM users');
$usersStatement->execute();
$users = $usersStatement->fetchAll();

$postsStatement = $mysqlClient->prepare('SELECT * FROM posts WHERE is_enabled is TRUE');
$postsStatement->execute();
$bposts = $postsStatement->fetchAll();

if(isset($_GET['limit']) && is_numeric($_GET['limit'])) {
    $limit = (int) $_GET['limit'];
} else {
    $limit = 100;
}

// Si le cookie est présent
if (isset($_COOKIE['LOGGED_USER']) || isset($_SESSION['LOGGED_USER'])) {
    $loggedUser = [
        'email' => $_COOKIE['LOGGED_USER'] ?? $_SESSION['LOGGED_USER'],
    ];
}

$rootPath = $_SERVER['DOCUMENT_ROOT'].'/P5/';
$rootUrl = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/P5_BLOG/';
?>