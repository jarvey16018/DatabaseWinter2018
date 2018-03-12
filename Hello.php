



<?php

session_start();

if (!isset($_SESSION['username'])) {
	header('Location: login.php');

 }
?>

<?php
echo "HELLO WORLD"
?>