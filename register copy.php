<?php

session_start();
require_once('connection.php');



if(isset($_POST) & !empty($_POST)){
 	$username = mysqli_real_escape_string($connection, $_POST['username']);
 	$password = md5($_POST['password']);

 	$sql = "INSERT INTO `login` (username, password) VALUES ('$username', '$password')";
 	$result3 = mysqli_query($connection, $sql);
 	if($result3){
 		$smsg3 =  "User Added";
 	}else{
 		$fmsg3 = "User Not Added";
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
	  	 <?php if(isset($smsg3)){?><div class="alert alert-success" role="alert"> <?php echo $smsg3; ?> </div> 	
	  	 <?php } ?>
	  	 <?php if(isset($fmsg3)){?><div class="alert alert-danger" role="alert"> <?php echo $fmsg3; ?> </div> 	
	  	 <?php } ?>
     	 <form class="form-signin" method="POST">
         <h2 class="form-signin-heading">Add User</h2>
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
         <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
         </form>
      <div>
</body>
</html>

