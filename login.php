

<?php
session_start();
require_once('connection.php');
if(isset($_POST) & !empty($_POST)){
	
	//print_r($_POST);
	$username = mysqli_real_escape_string($connection, $_POST['username']);
	$password = $_POST['password'];
	//echo $username;

	//echo $sql = "INSERT INTO 'login' (username, password) VALUES ('$username', '$password')";
	$query = "SELECT * FROM `login` WHERE username='$username' and password='$password'";
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
	<title>Login</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
	  <div class="container">
	  	 <?php if(isset($smsg)){?><div class="alert alert-success" role="alert"> <?php echo $smsg; ?> </div> 	
	  	 <?php } ?>
	  	  <?php if(isset($fmsg)){?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div> 	
	  	 <?php } ?>
     	 <form class="form-signin" method="POST">
         <h2 class="form-signin-heading">Please Login</h2>
         <div class="input-group">
	         <span class="input-group-addon" id="basic-addon1">@</span>
	         <input type="text" name="username" class="form-control" placeholder="Username" required>
	     </div>
         <label for="inputPassword" class="sr-only">Password</label>
         <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
         <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
        <!-- <a class="btn btn-lg btn-primary btn-block" href="register.php">Register</a> -->
         </form>
      <div>
</body>
</html>