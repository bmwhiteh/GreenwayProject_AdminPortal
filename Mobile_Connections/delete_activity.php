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
            "activityId": "",
            "userId": ""
        }';
    */
    //echo $data;
    
     if(isset($data)){     
        //JSON must be decoded using PHP function
        $dataArray = json_decode($data);
        $intActivityId = $dataArray->activityId;
        $intUserId = $dataArray->userId;
        
        $sqlDeleteUserActivity = "DELETE FROM `userActivities` WHERE `intActivityId` = '$intActivityId'";
        $resultDeleteUserActivity = $conn->query($sqlDeleteUserActivity);

        $sqlDeleteLocationData = "DELETE FROM `locationData` WHERE `intActivityId` = '$intActivityId'";
        $resultDeleteLocationData = $conn->query($sqlDeleteLocationData);
        
        $sqlSetInactive = "UPDATE `users` SET `active`= '0' WHERE `intUserId` = '$intUserId'";
        $resultSetInactive = $conn->query($sqlSetInactive);
     }
    
?>