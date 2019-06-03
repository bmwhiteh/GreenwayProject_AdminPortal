<?php
       
//this is the database connection
    include("../MySQL_Connections/config.php");

    
    $strEventType = 'personal';
    $strEventTitle = $_POST["event_title"];
    $strEventDescription = $_POST["event_description"];
    $userId = $_POST["userId"];
    $startDate = $_POST["event_start"];
    $dtStartTime = $_POST["time_start"];
    $endDate = $_POST["event_end"];
    $dtEndTime = $_POST["time_end"];
    $strEventColor = $_POST["color_choice"];
    
    $alldayEvent = $_POST["event_allday"];
    if($alldayEvent == "on"){
        $dtStartTime = "00:00:00";
        $dtEndTime = "23:59:59";
    }
    
    date_default_timezone_set('EST');
    $offset =  date('Z') / 3600;
    $offsetString = (string) $offset;
    $hours = $offsetString[1];
    
    
     $combinedStart = date('Y-m-d H:i:s', strtotime("$startDate $dtStartTime"));
     $combinedStart = new DateTime($combinedStart);
     $date = date_format($combinedStart,"Y-m-d H:i:s");
     $dtStartDate=date("Y-m-d H:i:s", strtotime("$date + $hours hours"));


     $combinedEnd = date('Y-m-d H:i:s', strtotime("$endDate $dtEndTime"));
     $combinedEnd = new DateTime($combinedEnd);
     $date = date_format($combinedEnd,"Y-m-d H:i:s");
     $dtEndDate=date("Y-m-d H:i:s", strtotime("$date + $hours hours"));

    echo $dtStartDate;
    echo $dtEndDate;
    

    
    $sqlAddEvent = "INSERT INTO `CalendarEvents`( `strEventType`, `strEventTitle`, `strEventDescription`, `strEmployeeId`, `dtStartDate`, `dtEndDate`, `strEventColor`) 
            VALUES ('$strEventType','$strEventTitle','$strEventDescription','$userId','$dtStartDate','$dtEndDate','$strEventColor')";

    $resultAddEvent = $conn->query($sqlAddEvent);
    
    header("location: calendar.php");
?>