<?php 
include("../MySQL_Connections/config.php");

$sql = "SELECT * FROM `users` WHERE `active`= 1";

$result = $conn->query($sql) or die("Query fail");
    
$row = $result->fetch_array(MYSQLI_ASSOC);

$count =  $result->num_rows;
echo $count;
?>