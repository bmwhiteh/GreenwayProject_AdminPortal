 <?php

    include("../MySQL_Connections/config.php");
/*
        $startDate = "11-01-2017";
         $startTime = "08:00 PM";
         $combinedStart = date('Y-m-d H:i:s', strtotime("$startDate $startTime"));
         $combinedStart = new DateTime($combinedStart);
         $timeZone = new DateTimeZone("UTC");
         $combinedStart-> setTimeZone($timeZone);
         $startDate = $combinedStart->format('Y-m-d');
         $startTime = $combinedStart->format('H:i:s');
         $endDate = "4-01-2018";
         $endTime = "08:00 PM";
         $combinedEnd = date('Y-m-d H:i:s', strtotime("$endDate $endTime"));
         $combinedEnd = new DateTime($combinedEnd);
         $combinedEnd-> setTimeZone($timeZone);
         $endDate = $combinedEnd->format('Y-m-d');
         $endTime = $combinedEnd->format('H:i:s');
         
         
        //this is the sql state that will go into the query
        $sql = "SELECT `gpsLat`,`gpsLong` FROM `locationData` where `activityDate` > '". $startDate ."' and `activityDate` < '". $endDate ."'
            or ( `activityDate`= '". $startDate ."' and `time` > '". $startTime ."' ) or ( `activityDate`= '". $endDate ."' and `time` < '". $endTime ."' );";
 
        echo $sql;*/
?>

<?php 
 //get the just created id
    $sqlGetResponse = "SELECT intActivityId FROM `userActivities` ORDER BY intActivityId desc LIMIT 0, 1 ";            
    $resultGetResponse = $conn->query($sqlGetResponse);

     if ($resultGetResponse->num_rows > 0) {
        // output data of each row
        while($row = $resultGetResponse->fetch_assoc()) {
            $newActivityId = $row["intActivityId"];
            //echo $row["intActivityId"];
        }
    } else {
        //echo -1;
    }
  
    if(isset($newActivityId)){
        $intActivityId = $newActivityId;
        
        var_dump($intActivityId);
    }
?>