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
    //get the json data
    $data = file_get_contents("php://input");
    $dataArray = json_decode($data);
    $userId = $dataArray->userID;
    $userId = mysqli_real_escape_string($conn, $userId);
    $userName = $dataArray->userName;
    $userName = mysqli_real_escape_string($conn, $userName);
    
    $ticketsSql = "SELECT `intTicketId`, `strTitle`, `tickettypes`.`strTicketType`, `strDescription`, `dtSubmitted`, `bitUrgent`, `strImageFilePath`, `gpsLat`, `gpsLong` FROM `maintenancetickets` INNER JOIN  `tickettypes` ON  `maintenancetickets`.`intTypeId` =  `tickettypes`.`intTypeId` WHERE `dtClosed` is null AND `strEmployeeAssigned` = '$userId'";
    $ticketsResults = $conn->query($ticketsSql);
    $ticketsObj = array(); 
    while ($row = $ticketsResults->fetch_array(MYSQLI_ASSOC)) {
        $photoURL = $row['strImageFilePath'];
        if ($photoURL != NULL) {
            $photoURL = "https://virdian-admin-portal-whitbm06.c9users.io/Ticket_System_v2/Images_ticketSize/" . $photoURL;
        }
        $ticket = (object)array();
        $ticket->ticketID = $row['intTicketId'];
        $ticket->title = $row['strTitle'];
        $ticket->ticketType = $row['strTicketType'];
        $ticket->description = $row['strDescription'];
        $ticket->submittedDate = $row['dtSubmitted'];
        $ticket->assigned = $userId;
        $ticket->assignedName = $userName;
        $ticket->photoURL = $photoURL;
        $ticket->lattitude = (double)$row['gpsLat'];
        $ticket->longitude = (double)$row['gpsLong'];
        $ticket->urgent = $row['bitUrgent'];
        array_push($ticketsObj, $ticket);
    }
    echo json_encode($ticketsObj);
?>