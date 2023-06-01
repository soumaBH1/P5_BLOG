<?php
const MYSQL_HOST = 'localhost';
const MYSQL_PORT = 3306;
const MYSQL_NAME = 'myblog';
const MYSQL_USER = 'root';
const MYSQL_PASSWORD = 'root';
try {
    $mysqlClient = new PDO(
        sprintf('mysql:host=%s;dbname=%s;port=%s', MYSQL_HOST, MYSQL_NAME, MYSQL_PORT),
        MYSQL_USER,
        MYSQL_PASSWORD
    );
    $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $exception) {
    die('Erreur : '.$exception->getMessage());
}
global $db;
	try {
		$db = new PDO('mysql:host=localhost;dbname=myblog;charset=utf8', 'root', 'root');
	} catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
	}
    
?>