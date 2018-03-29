<?php
    include("../MySQL_Connections/config.php");

    $sql = "SELECT * FROM `userActivities`";
    $result = $conn->query($sql) or die("Query fail");  
    
/*
   while($row = $result->fetch_assoc()) {
       $activityType = rand(1,3);
       $user = $row["intUserId"];
       $sqlUpdate = "UPDATE `viridian_capstone_project`.`userActivities` SET `intActivityType` = '$activityType' WHERE `intUserId`='$user'";
        $resultUpdate = $conn->query($sqlUpdate) or die("Query fail");  

   }
*/

   while($row = $result->fetch_assoc()) {
        $activityId = $row['intActivityId'];
        $time = $row['startTime'];
        $date = $row['startDate'];

        //echo $row['intActivityId'] . " ";
        //echo $row['timeTotalDuration'];
        $timeArray = explode(':',$row['timeTotalDuration']);
        //var_dump($timeArray);
        $hour = $timeArray[0];
        $min  = $timeArray[1];
        $sec = $timeArray[2];
        
        $timeTotalDuration = $hour . ":" . $min . ":" . $sec;
        //echo $timeTotalDuration;
        
        $endTime = date('H:i:s',strtotime('+'.$hour.' hour +'. $min . ' minutes +'.$sec. ' seconds',strtotime($time)));
        $endDate = date('Y-m-d',strtotime('+'.$hour.' hour +'. $min . ' minutes +'.$sec. ' seconds',strtotime($date)));
    
        //echo $endDate . " at " . $endTime . "\n\n\n";

        /*if($row['intActivityType']==1){
            $milesTotalDistance = rand (1*10, 3*10) / 10;
            $calTotalCalories = rand (1*10, 300*10) / 10;
            
        }elseif($row['intActivityType']==2){
            $milesTotalDistance = rand (1*10, 7*10) / 10;
            $calTotalCalories = rand (1*10, 800*10) / 10;


        }else{
            $milesTotalDistance = rand (1*10, 10*10) / 10;
            $calTotalCalories = rand (1*10, 500*10) / 10;

        }*/
        
        $sqlUpdate = "UPDATE `userActivities` SET `endDate`='$endDate',`endTime`='$endTime' WHERE `intActivityId`='$activityId'";
        echo $timeTotalDuration . "\n\n\n";
        $resultUpdate = $conn->query($sqlUpdate) or die("Query fail");  
    
        

   }



?>