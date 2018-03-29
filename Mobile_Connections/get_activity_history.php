<?php
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
    
    //echo $data. "\n";
    
  /*  $data = '{
        "userId":"1160"
        }';
    
   */ 
    if(isset($data)){
        $dataArray = json_decode($data);
        $intUserId = mysqli_real_escape_string($conn, $dataArray->userId);
        
        $activityHistorySql = "SELECT `intActivityId`,`intActivityType`,`startDate`,`startTime` FROM `userActivities` WHERE `intUserId` = '$intUserId'";
        $activityHistoryResults = $conn->query($activityHistorySql);
        
        $activityHistoryObj = array(); // object(stdClass)
        while($row = $activityHistoryResults->fetch_array(MYSQLI_ASSOC)){
            $activityObj = (object)array();
            $activityObj->activityId = $row['intActivityId'];
            $activityObj->activityType = $row['intActivityType'];
            $activityObj->startDate = $row['startDate'];
            $activityObj->startTime = $row['startTime'];
        array_push($activityHistoryObj, $activityObj);
        }
        $activityHistoryJSON = json_encode($activityHistoryObj);
        echo $activityHistoryJSON;
    }   
    
?>