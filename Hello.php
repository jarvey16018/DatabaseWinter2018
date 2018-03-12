<?php

session_start();
require_once('connection2.php');

if (!isset($_SESSION['username'])) {
	header('Location: login.php');

 }

if(isset($_POST) & !empty($_POST)){
 	$productname = mysqli_real_escape_string($connection2, $_POST['productname']);
 	$color = mysqli_real_escape_string($connection2, $_POST['color']);
 	$size = mysqli_real_escape_string($connection2, $_POST['size']);

 	$sql = "INSERT INTO `Product` (name, color, size) VALUES ('$productname', '$color', '$size')";
 	$result2 = mysqli_query($connection2, $sql);
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
         <h2 class="form-signin-heading">Add Inventory</h2>
         <div class="input-group">
	         <span class="input-group-addon" id="basic-addon1"></span>
	         <input type="text" name="productname" class="form-control" placeholder="Product Name" required>
	     </div>
	      <div class="input-group">
	         <span class="input-group-addon" id="basic-addon1"></span>
	         <input type="text" name="color" class="form-control" placeholder="Color" required>
	     </div>
	      <div class="input-group">
	         <span class="input-group-addon" id="basic-addon1"></span>
	         <input type="text" name="size" class="form-control" placeholder="Size" required>
	     </div>
         <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
         <a class="btn btn-lg btn-primary btn-block" href="logout.php">Logout</a>
         </form>
      <div>
</body>
</html>