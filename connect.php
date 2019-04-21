<?php
//CODE TO CONNECT PHP WITH DATABASE.
$hostname="localhost"; 		//hostname
$username="root"; 			//username for database
$password=""; 				//database password
$dbname="register"; 		//database name
$conn=mysqli_connect($hostname,$username,$password,$dbname) or die("Error Connecting ".  mysqli_connect_error()); 		//make connection
//$connect becomes the OBJECT/VARIABLE we’ll use to fire queries to database
?>
