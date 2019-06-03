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
                VALUES ( 'Activity Info ".$data."' );";
                
    $result = $conn->query($sql) or die("Query fail");  
    
    if(isset($data)){
        $dataArray = json_decode($data);
        $intActivityId = mysqli_real_escape_string($conn, $dataArray->activityId);
        
        $activitySql = "SELECT `intActivityType`,`timeTotalDuration`,`milesTotalDistance`,
        `calTotalCalories`, `averageSpeed` FROM `activities` WHERE `id` = '$intActivityId'";
        $activityResults = $conn->query($activitySql);
        $row = $activityResults->fetch_array(MYSQLI_ASSOC);
        
            $activityObj = (object)array();
            $activityObj->activityType = $row['intActivityType'];
            $activityObj->duration = $row['timeTotalDuration'];
            $activityObj->distance = $row['milesTotalDistance'];
            $activityObj->calories = $row['calTotalCalories'];
            $activityObj->averageSpeed = $row['averageSpeed'];
        
        $locationSql = "SELECT gpsLat, gpsLong from locationData WHERE intActivityId = '$intActivityId'";
        $locationResults = $conn->query($locationSql);
        $location = array();
        while($row = $locationResults->fetch_array(MYSQLI_ASSOC)){
            $locationObj = (object)array();
            $locationObj->lat = (double) $row['gpsLat'];
            $locationObj->lng = (double) $row['gpsLong'];
            array_push($location, $locationObj);
        }
        
        $activityObj->locationData = $location;
            
        $activityJSON = json_encode($activityObj);
        echo $activityJSON;
    }   
    
?>