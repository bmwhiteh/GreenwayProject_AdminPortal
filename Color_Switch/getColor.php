<?php

include("../MySQL_Connections/config.php");

$color = $_POST['color'];
echo $color;
$sql = "SELECT `colorCssLink`, `bannerCssLink`, `colorArray` FROM `colorSchemes` WHERE `name` = '$color'";
    $result = $conn->query($sql) or die("Query fail");
        
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $cssLink = $row['colorCssLink'];
    $bannerLink = $row['bannerCssLink'];
    $colorArray = $row['colorArray'];

    setcookie("colorCssLink", $cssLink, time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie("bannerLink", $bannerLink, time() + (86400 *30), "/"); // 86400 = 1 day
    setcookie("colorArray", $colorArray, time() + (86400 *30), "/"); // 86400 = 1 day

    
    $sql = "UPDATE `colorSchemes` SET `active`= 1 WHERE `name` = '$color'";
    $result = $conn->query($sql) or die("Query fail");
    
    $sql = "UPDATE `colorSchemes` SET `active`= 0 WHERE `name` != '$color'";
    $result = $conn->query($sql) or die("Query fail");
    
    header("location: ../Dashboard_Pages/dashboard.php");
?>