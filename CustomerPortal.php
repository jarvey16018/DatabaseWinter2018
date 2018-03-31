<?php

session_start();
require_once('Connection4.php');



if(isset($_POST) & !empty($_POST)){
 	$username = mysqli_real_escape_string($connection, $_POST['username']);
 	$password = md5($_POST['password']);
 	

	$query = "SELECT * FROM `Just` WHERE username='$username' and password='$password'";
 	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	$count = mysqli_num_rows($result);
	if($count == 1){
		$_SESSION['username'] = $username;
		header('Location: Hello.php');
		exit();
	}else{
		$fmsg =  "Invalid Username or Password";
	}


}
if(isset($_SESSION['username'])){
	$smsg = "User already logged in";
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
         
         <button class="btn btn-lg btn-primary btn-block" type="submit">login</button> 
          <a class="btn btn-lg btn-primary btn-block" href="register.php">Register</a> 
          <a class="btn btn-lg btn-primary btn-block" href="node-page copy/index.html">Rate us</a> 
         </form>
      <div>
</body>
</html>