<?php
$con=mysqli_connect("localhost","root","Jarvey16018!","CC");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

echo "System status: ". mysqli_stat($con); 

mysqli_close($con);
?>