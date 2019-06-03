<?php 
    include("../MySQL_Connections/config.php");
    
    $eventId = $_POST['listOfEvents'];
    $sql = "UPDATE `geofences` SET `btActive`= '0' WHERE `intId` = '$eventId'";
    $result = $conn->query($sql) or die("Query fail");
      header("location: ./eventMap.php");
?>