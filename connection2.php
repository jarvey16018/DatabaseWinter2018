<?php
$connection2 = mysqli_connect('localhost', 'root', 'Jarvey16018!');
if (!$connection2){
    die("Database Connection Failed" . mysqli_error($connection2));
}
$select_db = mysqli_select_db($connection2, 'Vinyl');
if (!$select_db){
    die("Database Selection Failed" . mysqli_error($connection2));
}
?>