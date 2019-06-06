<?php
    include("../../MySQL_Connections/config.php");
   
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
     
    //TODO: Store URL of Geofence in Images_geofencePhotos & update this!!
    
    //JSON must be decoded using PHP function
    $dataArray = json_decode($data);
    $geofenceName = $dataArray->name;
    $geofenceName = mysqli_real_escape_string($conn, $geofenceName);
    $geofenceRadius = $dataArray->radius;
    $geofenceRadius = mysqli_real_escape_string($conn, $geofenceRadius);
    $latitude = $dataArray->lat;
    $latitude = mysqli_real_escape_string($conn, $latitude);
    $longitude = $dataArray->long;
    $longitude = mysqli_real_escape_string($conn, $longitude);
    $description = $dataArray->description;
    $description = mysqli_real_escape_string($conn, $description);
        
    //insert note into the database
    $sqlAddGeofence = "INSERT INTO `geofences` (`strName`, `intMeterRadius`, `dblLatitude`, `dblLongitude`, `strDescription`) 
        VALUES ('$geofenceName', '$geofenceRadius', '$latitude', '$longitude', '$description')";
    
    $conn->query($sqlAddGeofence) or die("Add note fail. $sqlAddGeofence");
?>