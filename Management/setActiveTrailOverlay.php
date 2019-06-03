<?php
include("../MySQL_Connections/config.php");

    $overlayId = $_POST['overlayId'];
    $removeActiveSql = "UPDATE `trailOverlay` SET `active`='0' WHERE `active`= '1'";
    $removeResult = $conn->query($removeActiveSql) or die("Query 1 fail");
             
    $sql = "UPDATE `trailOverlay` SET `active`='1' WHERE `id`= '$overlayId'";
    $result = $conn->query($sql) or die ("Query 2 fail");
         
    header("location: ./manageOverlays.php");
?>