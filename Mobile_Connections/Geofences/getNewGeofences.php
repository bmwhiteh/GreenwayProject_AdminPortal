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
    
    $geofencesSql = "SELECT * FROM `geofences` WHERE `btActive` = 1";
    $geofencesResults = $conn->query($geofencesSql);
    $geofencesObj = array(); 
    while ($row = $geofencesResults->fetch_array(MYSQLI_ASSOC)) {
        $file = 'https://virdian-admin-portal-whitbm06.c9users.io/Mobile_Connections/Images_geofencePhotos/geofence_' . $row['intId'] . '.jpg';
        $file_headers = @get_headers($file);
        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
            //No photo found for this geofence, use default
            $file = 'https://virdian-admin-portal-whitbm06.c9users.io/Mobile_Connections/Images_geofencePhotos/default.png';
        }
        $geofence = (object)array();
        $geofence->geofenceID = $row['intId'];
        $geofence->name = $row['strName'];
        $geofence->radius = $row['intMeterRadius'];
        $geofence->lat = $row['dblLatitude'];
        $geofence->long = $row['dblLongitude'];
        $geofence->notifText = $row['strNotifText'];
        $geofence->description = $row['strDescription'];
        $geofence->photoURL = $file;
        $geofence->eventDate = $row['dtEventDate'];
        array_push($geofencesObj, $geofence);
    }
    echo json_encode($geofencesObj);
?>