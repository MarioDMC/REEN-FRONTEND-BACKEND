<?php 

$server = "smoothoperators.com.mx";
$database = "smoothop_REEN";
$user = "smoothop_web";
$password = "Reen_web";
$mysqli = new mysqli($server, $user, $password, $database);
if ($mysqli->connect_errno) {
	echo "Lo sentimos, este sitio web está experimentando problemas.";
	echo "Error: Fallo al conectarse a MySQL debido a: \n";
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";
    exit;
}

try{
	$db = new PDO('mysql:host=smoothoperators.com.mx; dbname=smoothop_REEN', 'smoothop_web', 'Reen_web');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $ex) {
    echo "An Error occured!"; 
    some_logging_function($ex->getMessage());
}
   
?>