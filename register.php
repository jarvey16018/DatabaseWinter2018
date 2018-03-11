
<?php
require_once('connection.php');
if(isset($_POST) & !empty($_Post)){
	
	//print_r($_POST);
	$username = $_POST['username'];
	$password = $_POST['password'];
	//echo $username;

	echo $sql = "INSERT INTO 'login' (username, password) VALUES ('$username', '$password')";
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