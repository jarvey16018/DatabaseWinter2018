<?php
$connection = mysqli_connect('localhost', 'root', 'Jarvey16018!');
if (!$connection){
    die("Database Connection Failed" . mysqli_error($connection));
}
$select_db = mysqli_select_db($connection, 'login');
if (!$select_db){
    die("Database Selection Failed" . mysqli_error($connection));
}











//$link = mysqli_connect("localhost", "root", "Jarvey16018!", "CC");


//$connection = mysqli_connect('localhost', 'root', 'Jarvey16018!');

//$select_db = mysqli_connect_db($connection, 'login');


//if (!$link) {
  // echo "Error: Unable to connect to MySQL." . PHP_EOL;
  // echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
  // echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
   //exit;
//}

//echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
//echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;

//mysqli_close($link);
?>