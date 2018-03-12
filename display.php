<?php
$connection = mysql_connect('localhost', 'root', 'Jarvey16018!'); //The Blank string is the password
mysql_select_db('Vinyl');

$query = "SELECT * FROM Product"; //You don't need a ; like you do in SQL
$result = mysql_query($query);

echo "<table>"; // start a table tag in the HTML

while($row = mysql_fetch_array($result)){   //Creates a loop to loop through results
echo "<tr><td>" . $row['prodID'] . "</td><td>" . $row['name'] . "</td></tr>" . $row['color'] . "</td></tr>" . . $row['size'] . "</td></tr>";  //$row['index'] the index here is a field name
}

echo "</table>"; //Close the table in HTML

mysql_close();

?>