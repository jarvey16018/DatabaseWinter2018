



<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//PUT THIS HEADER ON TOP OF EACH UNIQUE PAGE

if (!isset($_SESSION['username'])) {
header('Location: login.php');
exit();
}
?>

<?php
echo "HELLO WORLD"
?>