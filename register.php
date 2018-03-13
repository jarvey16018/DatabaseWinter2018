<?php

session_start();
require_once('connection.php');

if (!isset($_SESSION['username'])) {
	header('Location: login.php');

 }

if(isset($_POST) & !empty($_POST)){
 	$productname = mysqli_real_escape_string($connection, $_POST['username']);
 	$size = md5($_POST['password']);

 	$sql = "INSERT INTO `login` (username, password) VALUES ('$username', '$password')";
 	$result2 = mysqli_query($connection, $sql);
 	if($result2){
 		$smsg2 =  "Product Added";
 	}else{
 		$fmsg2 = "Product Not Added";
 	}
}



?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
	  <div class="container">
	  	 <?php if(isset($smsg2)){?><div class="alert alert-success" role="alert"> <?php echo $smsg2; ?> </div> 	
	  	 <?php } ?>
	  	 <?php if(isset($fmsg2)){?><div class="alert alert-danger" role="alert"> <?php echo $fmsg2; ?> </div> 	
	  	 <?php } ?>
     	 <form class="form-signin" method="POST">
         <h2 class="form-signin-heading">Add User</h2>
         <div class="input-group">
	         <span class="input-group-addon" id="basic-addon1"></span>
	         <input type="text" name="username" class="form-control" placeholder="User Name" required>
	     </div>
	      <label for="inputPassword" class="sr-only">Password</label>
         <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
         <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
         </form>
      <div>
</body>
</html>

