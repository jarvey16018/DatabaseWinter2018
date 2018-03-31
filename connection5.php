<?php
$connection5 = mysqli_connect('localhost', 'root', 'Jarvey16018!');
if (!$connection5){
    die("Database Connection Failed" . mysqli_error($connection5));
}
$select_db = mysqli_select_db($connection5, 'order');
if (!$select_db){
    die("Database Selection Failed" . mysqli_error($connection5));
}
?>
