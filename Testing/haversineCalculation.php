<?php 

include("../MySQL_Connections/config.php");
    $sql = "SELECT `gpsLat`,`gpsLong` FROM `locationData` WHERE `intActivityId` = 708";
    //sql execution
    $result = $conn->query($sql) or die("Query fail"); 
                
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
        echo "(".$row['gpsLat'].",".$row['gpsLong'].")";
        //echo "<option value=".$row['id'].">" . $row['question'] . "</option>";
    }
?>