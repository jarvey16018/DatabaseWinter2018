<?php

session_start();
require_once('Connection4.php');



if(isset($_POST) & !empty($_POST)){
 	$username = mysqli_real_escape_string($connection, $_POST['username']);
 	$password = md5($_POST['password']);
 	$firstName = mysqli_real_escape_string($connection, $_POST['firstName']);
 	$lastName = mysqli_real_escape_string($connection, $_POST['lastName']);
 	$email = mysqli_real_escape_string($connection, $_POST['email']);
 	$Address = mysqli_real_escape_string($connection, $_POST['Address']);


 	$sql = "INSERT INTO `Just` (username, password, firstName, lastName, email, Address) VALUES ('$username', '$password', '$firstName', '$lastName', '$email', '$Address')";
 	$result4 = mysqli_query($connection, $sql);
 	if($result4){
 	 	$smsg4 =  "User Added";
 	}else{
 		$fmsg4 = "User Not Added";
 	}
}



?>

<!DOCTYPE html>
<html>
<head>
	<title>Customer</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
	  <div class="container">
	  	 <?php if(isset($smsg3)){?><div class="alert alert-success" role="alert"> <?php echo $smsg3; ?> </div> 	
	  	 <?php } ?>
	  	 <?php if(isset($fmsg3)){?><div class="alert alert-danger" role="alert"> <?php echo $fmsg3; ?> </div> 	
	  	 <?php } ?>
     	 <form class="form-signin" method="POST">
         <h2 class="form-signin-heading">Customer Account</h2>
         <div class="input-group">
	         <span class="input-group-addon" id="basic-addon1"></span>
	         <input type="text" name="username" class="form-control" placeholder="User Name" required>
	     </div>
	      <label for="inputPassword" class="sr-only">Password</label>
         <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
           <div class="input-group">
	         <span class="input-group-addon" id="basic-addon1"></span>
	         <input type="text" name="firstName" class="form-control" placeholder="First Name" required>
	     </div>
	     <div class="input-group">
	         <span class="input-group-addon" id="basic-addon1"></span>
	         <input type="text" name="lastName" class="form-control" placeholder="Last Name" required>
	     </div>
	     <div class="input-group">
	         <span class="input-group-addon" id="basic-addon1"></span>
	         <input type="text" name="email" class="form-control" placeholder="email" required>
	     </div>
	     <div class="input-group">
	         <span class="input-group-addon" id="basic-addon1"></span>
	         <input type="text" name="Address" class="form-control" placeholder="Address" required>
	     </div>
         <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button> 
         <!-- <a class="btn btn-lg btn-primary btn-block" href="register.php">Register</a> -->
         </form>
      <div>
</body>
</html>