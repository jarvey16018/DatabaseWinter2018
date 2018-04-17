<?php
    mysql_connect("localhost", "root", "Jarvey16018!");
    $array = explode("  ", mysql_stat());
    foreach ($array as $value){
        echo $value . "<br />";
    }
    echo "done";
?>