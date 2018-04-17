<?php
$link   = mysql_connect('localhost', 'root', 'Jarvey16018!');
$status = explode('  ', mysql_stat($link));
print_r($status);
?>