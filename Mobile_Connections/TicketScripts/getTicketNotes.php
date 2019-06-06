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
    $ticketId = $dataArray->ticketID;
    $ticketId = mysqli_real_escape_string($conn, $ticketId);
    
    $ticketsSql = "SELECT `comment`, `dateAdded`, `strEmployeeName` FROM `ticketnotes` WHERE `intTicketId` = '$ticketId' ORDER BY `dateAdded` ASC";
    $ticketsResults = $conn->query($ticketsSql);
    $ticketsObj = array();
    while ($row = $ticketsResults->fetch_array(MYSQLI_ASSOC)) {
        $ticket = (object)array();
        $ticket->comment = $row['comment'];
        $ticket->dateAdded = $row['dateAdded'];
        $ticket->employeeName = $row['strEmployeeName'];
        array_push($ticketsObj, $ticket);
    }
    echo json_encode($ticketsObj);
?>