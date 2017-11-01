<?php 
include("../MySQL_Connections/config.php");

$sql = "SELECT * FROM `pushnotifications` WHERE `dtSentToUsers` = curdate() - interval 1 day";

$result = $conn->query($sql) or die("Query fail");
    
$row = $result->fetch_array(MYSQLI_ASSOC);
$active = $row['active'];

$count =  $result->num_rows;
echo $count;
?>