<?php
function connect_db(){
	//Connecting code to Database
	$DB_USER ='root';
	$DB_PASSWORD = '';
	$DB_HOST = 'localhost';
	$DB_NAME ='site';
	$db= new mysqli($DB_HOST,$DB_USER, $DB_PASSWORD, $DB_NAME)
	or die("Could not connect to MySQL");
}
?>