<?php
    include("../../MySQL_Connections/config.php");
   
    /*To avoid a CORS issue with Ionic include this check*/
    if(isset($_SERVER['HTTP_ORIGIN'])){
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Max-Age: 86400"); //what's this do
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
     
    //JSON must be decoded using PHP function
    $dataArray = json_decode($data);
    $ticketId = $dataArray->ticketID;
    $ticketId = mysqli_real_escape_string($conn, $ticketId);
    $userId = $dataArray->userID;
    $userId = mysqli_real_escape_string($conn, $userId);
    $userName = $dataArray->userName;
    $userName = mysqli_real_escape_string($conn, $userName);
    $dateStart = new DateTime('now'); 
    $dateStart->setTimeZone(new DateTimeZone('UTC'));
    $date =$dateStart->format('Y-m-d');
        
    //update ticket in mainetnancetickets
    $sqlClose = "UPDATE `maintenancetickets` SET `dtClosed` = NULL WHERE `intTicketId` = '".$ticketId."'";
    $conn->query($sqlClose)  or die("Update dtClosed FAIL  $id");
    
    //insert note into the database
    $sqlAddNote = "INSERT INTO `ticketnotes` (`intTicketId`, `strUserId`, `strEmployeeName`, `dateAdded`, `comment`) 
                    VALUES ('$ticketId', '$userId', '$userName', '$date', 'Ticket Reopened.')";
    
    $resultAddNote = $conn->query($sqlAddNote) or die("Add note fail. $sqlAddNote");
?>