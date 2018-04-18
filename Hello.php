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
         <a class="btn btn-lg btn-primary btn-block" href="Delete.php">Delete Inventory</a>
         <a class="btn btn-lg btn-primary btn-block" href="display.php">View Customers</a>
         <a class="btn btn-lg btn-primary btn-block" href="logout.php">Logout</a>
         <a class="btn btn-lg btn-primary btn-block" href="backupage.php">Backups and Stats</a>
          <a class="btn btn-lg btn-primary btn-block" href="http://192.168.50.27:9200/_cat/indices?v">View Shakespeare Quotes info for Future Products</a>
         </form>
      <div>
</body>
</html>

<?php

$db_host = 'localhost'; // Server Name
$db_user = 'root'; // Username
$db_pass = 'Jarvey16018!'; // Password
$db_name = 'Vinyl'; // Database Name

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());	
}

$sql = 'SELECT * 
		FROM Product';
		
$query = mysqli_query($conn, $sql);

if (!$query) {
	die ('SQL Error: ' . mysqli_error($conn));
}
?>
<html>
<head>
	<title>Displaying MySQL Data in HTML Table</title>
	<style type="text/css">
		body {
			font-size: 15px;
			color: #343d44;
			font-family: "segoe-ui", "open-sans", tahoma, arial;
			padding: 0;
			margin: 0;
		}
		table {
			margin: auto;
			font-family: "Lucida Sans Unicode", "Lucida Grande", "Segoe Ui";
			font-size: 12px;
		}

		h1 {
			margin: 25px auto 0;
			text-align: center;
			text-transform: uppercase;
			font-size: 17px;
		}

		table td {
			transition: all .5s;
		}
		
		/* Table */
		.data-table {
			border-collapse: collapse;
			font-size: 14px;
			min-width: 537px;
		}

		.data-table th, 
		.data-table td {
			border: 1px solid #e1edff;
			padding: 7px 17px;
		}
		.data-table caption {
			margin: 7px;
		}

		/* Table Header */
		.data-table thead th {
			background-color: #508abb;
			color: #FFFFFF;
			border-color: #6ea1cc !important;
			text-transform: uppercase;
		}

		/* Table Body */
		.data-table tbody td {
			color: #353535;
		}
		.data-table tbody td:first-child,
		.data-table tbody td:nth-child(4),
		.data-table tbody td:last-child {
			text-align: right;
		}

		.data-table tbody tr:nth-child(odd) td {
			background-color: #f4fbff;
		}
		.data-table tbody tr:hover td {
			background-color: #ffffa2;
			border-color: #ffff0f;
		}

		/* Table Footer */
		.data-table tfoot th {
			background-color: #e5f5ff;
			text-align: right;
		}
		.data-table tfoot th:first-child {
			text-align: left;
		}
		.data-table tbody td:empty
		{
			background-color: #ffcccc;
		}
	</style>
</head>
<body>
	<h1>Inventory</h1>
	<table class="data-table">
		<thead>
			<tr>
				<th>Product ID</th>
				<th>Name</th>
				<th>Color</th>
				<th>Size</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$no 	= 1;
		$total 	= 0;
		while ($row = mysqli_fetch_array($query))
		{
			$amount  = $row['amount'] == 0 ? '' : number_format($row['amount']);
			echo '<tr>
					<td>'.$row['prodID'].'</td>
					<td>'.$row['name'].'</td>
					<td>'.$row['color'].'</td>
					<td>'.$row['size'].'</td>
				</tr>';
		}?>
		</tbody>
	</table>
</body>
</html>
