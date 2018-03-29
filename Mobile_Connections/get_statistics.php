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
    
    //get the json data
    $data = file_get_contents("php://input");
    
    
    $sql = "INSERT INTO `databaseTests` (`dataSent`)
                VALUES ( '".$data."' );";
                
    $result = $conn->query($sql) or die("Query fail");  
    
   /* $data = 
        '{
            "userId":"1160"
        
        }';
        */
    //echo $data;
    
     if(isset($data)){     
        //JSON must be decoded using PHP function
        $dataArray = json_decode($data);
        $intUserId = $dataArray->userId;
        
        if(isset($intUserId) and $intUserId > 0){
            $sqlWalking = "SELECT sum(milesTotalDistance) as totalDistance_Walking, sum(milesTotalDistance)/sum(timeTotalDuration) as avgSpeed_Walking,\n"
                . "sum(calTotalCalories) as totalCalories_Walking\n"
                . "FROM userActivities\n"
                . "WHERE intUserId = '$intUserId' and intActivityType = '1'";
                
            $sqlRunning = "SELECT sum(milesTotalDistance) as totalDistance_Running, sum(milesTotalDistance)/sum(timeTotalDuration) as avgSpeed_Running,\n"
                . "sum(calTotalCalories) as totalCalories_Running\n"
                . "FROM userActivities\n"
                . "WHERE intUserId = '$intUserId' and intActivityType = '2'";
                
            $sqlBiking = "SELECT sum(milesTotalDistance) as totalDistance_Biking, sum(milesTotalDistance)/sum(timeTotalDuration) as avgSpeed_Biking,\n"
                . "sum(calTotalCalories) as totalCalories_Biking\n"
                . "FROM userActivities\n"
                . "WHERE intUserId = '$intUserId' and intActivityType = '3'";
                
            $sqlOverall = "SELECT avg(milesTotalDistance) as totalDistance_Overall, sum(milesTotalDistance)/sum(timeTotalDuration) as avgSpeed_Overall,\n"
                . "avg(calTotalCalories) as totalCalories_Overall\n"
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