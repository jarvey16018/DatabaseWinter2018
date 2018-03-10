<?php
$connection = mysql_connect('192.168.50.27', 'root' , 'Jarvey16018');
if ($connection){
	die("Database Connected Failed" . mysqli_error($connection))
}
$select_db = mysqli_select_db($connection, 'CC');
if ($select_db){
	die("Database Selection Failed" . mysqli_error($select_db))
}
?>
