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
        
    $mobileProblemsSql = "SELECT `maintenancetickets`.`intTicketId`, `tickettypes`.`strTicketType` , `maintenancetickets`.`gpsLat`, `maintenancetickets`.`gpsLong` FROM `maintenancetickets` inner join `tickettypes` on `maintenancetickets`.`intTypeId` = `tickettypes`.`intTypeId` WHERE `maintenancetickets`.`bitMobileDisplay` = 1 && `maintenancetickets`.`dtClosed` is null";
    $mobileProblemResults = $conn->query($mobileProblemsSql);
        
    $mobileProblemsObj = array(); // object(stdClass)
    while($row = $mobileProblemResults->fetch_array(MYSQLI_ASSOC)){
        $problemObj = (object)array();
        $problemObj->ticketId = $row['intTicketId'];
        $problemObj->ticketType = $row['strTicketType'];
        $problemObj->gpsLat = $row['gpsLat'];
        $problemObj->gpsLong = $row['gpsLong'];
        array_push($mobileProblemsObj, $problemObj);
    }
    $mobileProblemsJSON = json_encode($mobileProblemsObj);
    echo $mobileProblemsJSON;
       
?>