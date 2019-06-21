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
    
    // $data = '{
    //     "userId":"4UM6AgUPuxgZwS3JaPkywSLVrE43"
    
    //     }';
    
  
    if(isset($data)){
        $dataArray = json_decode($data);
        $userId = mysqli_real_escape_string($conn, $dataArray->userId);
        
        $sql = "INSERT INTO `databaseTests` (`dataSent`)
                VALUES ( 'User Id: $userId' );";
                
    $result = $conn->query($sql) or die("Query fail");  
        
        $activityHistorySql = "SELECT `id`,`intActivityType`,`startDate`,`startTime`, `timeTotalDuration`, `milesTotalDistance`, `calTotalCalories`, `averageSpeed` FROM `activities` WHERE `userId` = '$userId' order by `id` desc";
        $activityHistoryResults = $conn->query($activityHistorySql);
        
        $activityHistoryObj = array(); // object(stdClass)
        while($row = $activityHistoryResults->fetch_array(MYSQLI_ASSOC)){
            $activityObj = (object)array();
            $activityObj->activityId = $row['id'];
            $activityObj->activityType = $row['intActivityType'];
            
            $date = $row['startDate'] . " " . $row['startTime'];
            $startDateTime = new DateTime($date);
        $startDateTime->setTimeZone(new DateTimeZone('EST'));
        $startDate =$startDateTime->format('Y-m-d');
        $startTime =$startDateTime->format('H:i:s'); 
        
            $activityObj->startDate = $startDate;
            $activityObj->startTime = $startTime;
            $activityObj->duration = $row['timeTotalDuration'];
            $activityObj->distance = $row['milesTotalDistance'];
            $activityObj->calories = $row['calTotalCalories'];
            $activityObj->averageSpeed = $row['averageSpeed'];
        array_push($activityHistoryObj, $activityObj);
        }
        $activityHistoryJSON = json_encode($activityHistoryObj);
        echo $activityHistoryJSON;
    }   
    
?>