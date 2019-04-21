<?php
	$connection = mysqli_connect('localhost', 'root', 'YES', 'register');
		if (!$connection){
			die("Database Connection Failed" . $connection->connect_error);
}
$select_db = mysqli_select_db($connection, 'test');
	if (!$select_db){
		die("Database Selection Failed" . mysqli_error($connection));
}
?>


