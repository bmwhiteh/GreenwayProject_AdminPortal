<?php
    include("../../MySQL_Connections/config.php");
    /*To avoid a CORS issue with Ionic include this check*/
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Max-Age: 86400"); //what's this do?
    }
    /*This appears to be something included in the JSON*/
    if ($_SERVER['REQUEST_METHOD']=='OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        }
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        }
        exit(0);
    }
    
    $geofencesSql = "SELECT `strName` FROM `geofences` WHERE `btActive` = 0";
    $geofencesResults = $conn->query($geofencesSql);
    $geofencesObj = array(); 
    while ($row = $geofencesResults->fetch_array(MYSQLI_ASSOC)) {
        $geofence = (object)array();
        $geofence->name = $row['strName'];
        array_push($geofencesObj, $geofence);
    }
    echo json_encode($geofencesObj);
?>