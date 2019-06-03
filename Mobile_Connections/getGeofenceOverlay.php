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
        
    $geofenceSql = "SELECT `strNotifText`,`strDescription`, `dblLatitude`, `dblLongitude` FROM `geofences` where btActive = '1' and curdate() between `dtEventDate` and `dtEndDate`";
    $geofenceResults = $conn->query($geofenceSql);
        
    $geofenceArrayObj = array(); // object(stdClass)
    while($row = $geofenceResults->fetch_array(MYSQLI_ASSOC)){
        $geofenceObj = (object)array();
        $geofenceObj->notificationText = $row['strNotifText'];
        $geofenceObj->description = $row['strDescription'];
        $geofenceObj->gpsLat = $row['dblLatitude'];
        $geofenceObj->gpsLong = $row['dblLongitude'];
        array_push($geofenceArrayObj, $geofenceObj);
    }
    $geofenceJSON = json_encode($geofenceArrayObj);
    echo $geofenceJSON;
       
?>