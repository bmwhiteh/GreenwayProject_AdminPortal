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
/* //get the just created id
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
    }*/
    /*
    $phoneDateTime = "4/10/2018, 6:44:35 PM"; //example: 2018-02-19T18:13:19.952Z
            $dateStart = new DateTime($phoneDateTime); 
            $dateStart->setTimeZone(new DateTimeZone('UTC'));
            $startDate =$dateStart->format('Y-m-d');
            $startTime =$dateStart->format('H:i:s');   
    
    echo $startDate;
    echo $startTime;*/
?>

<?php
/*<!--- This is where the jsons will be sent--->*/

    include("../MySQL_Connections/config.php");
   
    /*To avoid a CORS issue with Ionic include this check*/
    if(isset($_SERVER['HTTP_ORIGIN'])){
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Max-Age: 86400"); //what's this do?
    }
    
    /*This appears to be something included in the JSON*/
    if($_SERVER['REQUEST_METHOD']=='OPTIONS'){
        
        if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])){
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        }
        
        if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])){
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        }
        
        exit(0);
    }
    
    
    
    $data = 
        '{
            "userId":"1186"
        
        }';
        
    //echo $data;
    
     if(isset($data)){     
        //JSON must be decoded using PHP function
        $dataArray = json_decode($data);
        $intUserId = $dataArray->userId;
        
        if(isset($intUserId) and $intUserId > 0){
            $sqlWalking = "SELECT sum(milesTotalDistance) as totalDistance_Walking, 3600 * SUM( milesTotalDistance ) / ( SUM( TIME_TO_SEC( timeTotalDuration ) ) ) as avgSpeed_Walking,\n"
                . "sum(calTotalCalories) as totalCalories_Walking\n"
                . "FROM userActivities\n"
                . "WHERE intUserId = '$intUserId' and intActivityType = '2'";
                
            $sqlRunning = "SELECT sum(milesTotalDistance) as totalDistance_Running, 3600 * SUM( milesTotalDistance ) / ( SUM( TIME_TO_SEC( timeTotalDuration ) ) )  as avgSpeed_Running,\n"
                . "sum(calTotalCalories) as totalCalories_Running\n"
                . "FROM userActivities\n"
                . "WHERE intUserId = '$intUserId' and intActivityType = '1'";
                
            $sqlBiking = "SELECT sum(milesTotalDistance) as totalDistance_Biking, 3600 * SUM( milesTotalDistance ) / ( SUM( TIME_TO_SEC( timeTotalDuration ) ) )  as avgSpeed_Biking,\n"
                . "sum(calTotalCalories) as totalCalories_Biking\n"
                . "FROM userActivities\n"
                . "WHERE intUserId = '$intUserId' and intActivityType = '3'";
                
            $sqlOverall = "SELECT avg(milesTotalDistance) as totalDistance_Overall, 3600 * SUM( milesTotalDistance ) / ( SUM( TIME_TO_SEC( timeTotalDuration ) ) )  as avgSpeed_Overall,\n"
                . "sum(calTotalCalories) as totalCalories_Overall\n"
                . "FROM userActivities\n"
                . "WHERE intUserId = '$intUserId'";
                
            $sqlAllTickets = "SELECT count(intTicketId) as hazards_reported \n"
                . "FROM maintenancetickets\n"
                . "WHERE intUserId = '$intUserId'";
                
            $sqlClosedTickets = "SELECT count(intTicketId) as hazards_removed \n"
                . "FROM maintenancetickets\n"
                . "WHERE intUserId = '$intUserId' and dtClosed IS NOT NULL";
            
            $resultWalking = $conn->query($sqlWalking) or die($sqlWalking);  
            $resultRunning = $conn->query($sqlRunning) or die($sqlRunning);  
            $resultBiking = $conn->query($sqlBiking) or die($sqlBiking);  
            $resultOverall = $conn->query($sqlOverall) or die($sqlOverall);  
            $resultAllTickets = $conn->query($sqlAllTickets) or die($sqlAllTickets);  
            $resultClosedTickets = $conn->query($sqlClosedTickets) or die($sqlClosedTickets);  

            $rowWalking = $resultWalking->fetch_assoc();
            $rowRunning = $resultRunning->fetch_assoc();
            $rowBiking = $resultBiking->fetch_assoc();
            $rowOverall = $resultOverall->fetch_assoc();
            $rowAllTickets = $resultAllTickets->fetch_assoc();
            $rowClosedTickets = $resultClosedTickets->fetch_assoc();
            
             $dataResponse = array(
            
            "totalDistance_Walking"     => $rowWalking['totalDistance_Walking'],
            "avgSpeed_Walking"          => $rowWalking['avgSpeed_Walking'],
            "totalCalories_Walking"     => $rowWalking['totalCalories_Walking'],
            "totalDistance_Running"     => $rowRunning['totalDistance_Running'],
            "avgSpeed_Running"          => $rowRunning['avgSpeed_Running'],
            "totalCalories_Running"     => $rowRunning['totalCalories_Running'],
            "totalDistance_Biking"      => $rowBiking['totalDistance_Biking'],
            "avgSpeed_Biking"           => $rowBiking['avgSpeed_Biking'],
            "totalCalories_Biking"      => $rowBiking['totalCalories_Biking'],
            "totalDistance_Overall"     => $rowOverall['totalDistance_Overall'],
            "avgSpeed_Overall"          => $rowOverall['avgSpeed_Overall'],
            "totalCalories_Overall"     => $rowOverall['totalCalories_Overall'],
            "hazards_reported"          => $rowAllTickets['hazards_reported'],
            "hazards_removed"           => $rowClosedTickets['hazards_removed']
            );
            
            echo json_encode($dataResponse, JSON_PRETTY_PRINT);
        }
        
     }
     
?>