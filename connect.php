<?php
	//database connection details
	try{
	$db_hostname = "127.0.0.1";
	$db_username = "root";
	$db_password = "";
	$db_name = "repository";
	$pdo = new PDO("mysql:host=$db_hostname;dbname=$db_name",$db_username,$db_password);
	}catch(PDOException $e){
		echo " connection error ".$e->getMessage();
	}
?>
