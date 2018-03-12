<?php

session_start();
require_once('connection2.php');

if (!isset($_SESSION['username'])) {
	header('Location: login.php');

 }
?>

<?php
echo "HELLO WORLD"
?>