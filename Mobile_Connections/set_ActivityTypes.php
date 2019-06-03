<?php
    include("../MySQL_Connections/config.php");

    $sql = "SELECT * FROM `activities`";
    $result = $conn->query($sql) or die("Query fail");  
   while($row = $result->fetch_assoc()) {
        $activityId = $row['intActivityId'];
        $time = $row['startTime'];
        $date = $row['startDate'];
        $timeArray = explode(':',$row['timeTotalDuration']);
        $hour = $timeArray[0];
        $min  = $timeArray[1];
        $sec = $timeArray[2];
        
        $timeTotalDuration = $hour . ":" . $min . ":" . $sec;
        
        $endTime = date('H:i:s',strtotime('+'.$hour.' hour +'. $min . ' minutes +'.$sec. ' seconds',strtotime($time)));
        $endDate = date('Y-m-d',strtotime('+'.$hour.' hour +'. $min . ' minutes +'.$sec. ' seconds',strtotime($date)));

        
        $sqlUpdate = "UPDATE `activities` SET `endDate`='$endDate',`endTime`='$endTime' WHERE `intActivityId`='$activityId'";
        echo $timeTotalDuration . "\n\n\n";
        $resultUpdate = $conn->query($sqlUpdate) or die("Query fail");  
    
   }
?>