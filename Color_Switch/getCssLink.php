<?php 
include("../MySQL_Connections/config.php");

$return = $_POST;

//this is the color the user wants 
$colorName = $return['action'];

//use later: WHERE `name` = '. $colorName . '"
$sql = "SELECT `colorCssLink` FROM `colorSchemes` WHERE `name` = 'Carmine'";

$result = $conn->query($sql) or die("Query fail");
    
$row = $result->fetch_array(MYSQLI_ASSOC);
$link = $row['colorCssLink'];

echo $link;

?>
