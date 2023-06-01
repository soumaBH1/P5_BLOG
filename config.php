<!-- // configuration de la BDD et le root path -->
<?php

session_start();
// connection à la BDD
$conn = mysqli_connect("localhost", "root", "root", "myblog");

if (!$conn) {
	die("Error connecting to database: " . mysqli_connect_error());
}
// definir les constantes globales
define('ROOT_PATH', realpath(dirname(__FILE__)));
define('BASE_URL', 'http://localhost/P5/');
?>