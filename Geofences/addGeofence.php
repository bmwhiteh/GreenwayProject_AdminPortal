<?php
    include("../MySQL_Connections/config.php");
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
    $text = $_POST['strNotificationText'];
    $text = mysqli_real_escape_string($conn, $text);
    $description = $_POST['eventDescription'];
    $description = mysqli_real_escape_string($conn, $description);
    $eventDate = $_POST['eventDate'];
    $endDate = $_POST['endDate'];
    $geofenceRadius = $_POST['geofenceRadius'];
    if($geofenceRadius < 200){
        $geofenceRadius = 200;
    }
    $date = date("Y/m/d H:i:s");
    $active = 1;
    $gpsLat  = $_POST['gpsLat'];
    $gpsLong = $_POST['gpsLong'];
    
    $sqlCount= "SELECT * FROM `geofences`";
    $result = $conn->query($sqlCount) or die("Query fail");
    $count = $result->num_rows;
    $count = $count + 2;
    
    $geofenceName = 'Geofence' . $count;
    
     $sql = "INSERT INTO `geofences`(`strName`, `btActive`, `intMeterRadius`,
    `dblLatitude`, `dblLongitude`, `dtCreatedAt`, `strNotifText`, `strDescription`, `dtEventDate`, `dtEndDate`) 
    VALUES ('$geofenceName','$active','$geofenceRadius','$gpsLat','$gpsLong','$date','$text','$description','$eventDate', '$endDate')";

    $result = $conn->query($sql) or die("Query fail");  
    
    header("location: /Geofences/eventMap.php");
   }
?>
   