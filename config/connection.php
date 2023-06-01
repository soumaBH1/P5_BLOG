<?php
 global $db;
	try {
		$db = new PDO('mysql:host=localhost;dbname=myblog;charset=utf8', 'root', 'root');
	} catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
	}
    
?>