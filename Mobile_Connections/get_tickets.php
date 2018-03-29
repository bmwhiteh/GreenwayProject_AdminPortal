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
                VALUES ( '".$data."' );";
                
    $result = $conn->query($sql) or die("Query fail");  
    
    //echo $data. "\n";
    
  /*  $data = '{
        "userId":"1160"
        }';
    */
    
    if(isset($data)){
        $dataArray = json_decode($data);
        //$intUserId = mysqli_real_escape_string($conn, $dataArray->userId);
        
        $ticketsSql = "SELECT `intTicketId`, `strTitle`, `tickettypes`.`strTicketType`, `strDescription`, `dtSubmitted`, `bitUrgent`, `gpsLat`, `gpsLong` FROM `maintenancetickets` INNER JOIN  `tickettypes` ON  `maintenancetickets`.`intTypeId` =  `tickettypes`.`intTypeId` WHERE `intEmployeeAssigned` = '11' && `dtClosed` is null";
        $ticketsResults = $conn->query($ticketsSql);
        
        $ticketsObj = array(); // object(stdClass)
        while($row = $ticketsResults->fetch_array(MYSQLI_ASSOC)){
            $ticket = (object)array();
            $ticket->ticketId = $row['intTicketId'];
            $ticket->title = $row['strTitle'];
            $ticket->type = $row['strTicketType'];
            $ticket->desc = $row['strDescription'];
            $ticket->dateSub = $row['dtSubmitted'];
            $ticket->urgent = $row['bitUrgent'];
            
    /*    $im = file_get_contents('../Ticket_System_v2/Submitted_Images/ticketid_90.png');
        $imdata = base64_encode($im);  
            $ticket->img = $imdata;*/

            $ticket->gpsLat = (double)$row['gpsLat'];
            $ticket->gpsLong = (double)$row['gpsLong'];
        array_push($ticketsObj, $ticket);
        }
        $ticketsJSON = json_encode($ticketsObj);
        echo $ticketsJSON;
    }   
    
?>