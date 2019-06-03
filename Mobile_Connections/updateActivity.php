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
    
   /*   $data = '
       {"deviceId":"32E4CD79-1B0F-4914-A259-E7F080B2DC05",
       "activityId":"101"
       }
        ';
    */
    
    $dataArray = json_decode($data);
    $deviceId = $dataArray->deviceId;
    $activityId = $dataArray->activityId;

    $sql = "UPDATE `locationData` SET `intActivityId`= '$activityId' WHERE `intActivityId`= '$deviceId'";
    echo $sql;
    $result = $conn->query($sql) or die("Query fail"); 
    //  $sql = "INSERT INTO `databaseTests` (`dataSent`)
    //              VALUES ( 'Geolocation: ".$data."' );";
                
    //  $result = $conn->query($sql) or die("Query fail");  
    
?>