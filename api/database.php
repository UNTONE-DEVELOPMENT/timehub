<?php
	$host = "localhost:3306"; // Host name 
	$db_username = "timehub"; // Mysql username
	$db_password = "password"; // Mysql password 
	$db_name = "timehub"; // Database name 

	$mysqli_conection = mysqli_connect($host, $db_username, $db_password, $db_name)or die("cannot connect"); 

?>