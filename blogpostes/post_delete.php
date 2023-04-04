<?php
session_start();

include_once('./../config/mysql.php');
include_once('./../config/user.php');
include_once('./../variables.php');

$postData = $_POST;

if (!isset($postData['id']))
{
	echo('Il faut un identifiant valide pour supprimer un blog poste.');
    return;
}	

$id = $postData['id'];

$deleteBpostStatement = $mysqlClient->prepare('DELETE FROM posts WHERE id = :id');
$deleteBpostStatement->execute([
    'id' => $id,
]);

header('Location: '.$rootUrl.'home.php');
?>