<?php
session_start();
require_once('connection2.php');

if (!isset($_SESSION['username'])) {
	header('Location: login.php');

 }
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Backups-stats</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<form action="backupscript.php" method="get">
  <input type="submit" value="back up Admins">
</form>
<form action="backupmongoscript.php" method="get">
  <input type="submit" value="back up Ratings">
</form>
<form action="backupE.php" method="get">
  <input type="submit" value="back up Elasticsearch">
</form>
<form action="http://192.168.50.27:9200/_cluster/health">
    <input type="submit" value="view Elasticsearch Status" />
</form>
<form action="status.php">
    <input type="submit" value="view mySQL Status" />
</form>
<form action="mongoST.php">
    <input type="submit" value="view Mongo Status" />
</form>
</body>
</html>