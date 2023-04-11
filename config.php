
<?php

session_start();
	// connect to database
	$conn = mysqli_connect("localhost", "root", "root", "myblog");

	if (!$conn) {
		die("Error connecting to database: " . myblog());
	}
// define global constants
define ('ROOT_PATH', realpath(dirname(__FILE__)));
define('BASE_URL', 'http://localhost/P5/');
?>
