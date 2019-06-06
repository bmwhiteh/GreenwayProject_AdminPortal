<?php
    include("../../MySQL_Connections/config.php");
    include("../../Emails/assignedProblemEmail.php");
    
    require '../vendor/autoload.php';
    
    use Kreait\Firebase\Factory;
    use Kreait\Firebase\ServiceAccount;
    
    $serviceAccount = ServiceAccount::fromJsonFile('../firebase-adminsdk.json');
    $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->create();
    $auth = $firebase->getAuth();
   
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
    $assignedUserId = $dataArray->assignedUserID;
    $assignedUserId = mysqli_real_escape_string($conn, $assignedUserId);
    $assignedUserName = $dataArray->assignedUserName;
    $assignedUserName = mysqli_real_escape_string($conn, $assignedUserName);
    $assignerUserId = $dataArray->assignerUserID;
    $assignerUserId = mysqli_real_escape_string($conn, $assignerUserId);
    $assignerUserName = $dataArray->assignerUserName;
    $assignerUserName = mysqli_real_escape_string($conn, $assignerUserName);
    $dateStart = new DateTime('now'); 
    $dateStart->setTimeZone(new DateTimeZone('UTC'));
    $date =$dateStart->format('Y-m-d');
    $dateReceived =$dateStart->format('Y-m-d h:i:s a');
    
    if ($assignedUserId != '') {
        $user = $auth->getUser($assignedUserId);
        $email = $user->email;
    }
        
    // //update ticket in mainetnancetickets
    if ($assignedUserId != '') {
        $sqlClose = "UPDATE `maintenancetickets` SET `strEmployeeAssigned` = '$assignedUserId', `strEmployeeName` = '$assignedUserName' WHERE `intTicketId` = '$ticketId'";
    } else {
        $sqlClose = "UPDATE `maintenancetickets` SET `strEmployeeAssigned` = NULL, `strEmployeeName` = NULL WHERE `intTicketId` = '$ticketId'";
    }
    $conn->query($sqlClose)  or die("Update dtClosed FAIL  $id");
    
    $getTicketSql = "SELECT `bitUrgent` FROM `maintenancetickets` WHERE `intTicketId` ='$ticketId'";
    $getTicketResults = $conn->query($getTicketSql) or die("Get ticket info");
    $row = $getTicketResults->fetch_array(MYSQLI_ASSOC);
    
    if($row['bitUrgent']) {
        $urgentCount = 1;
    } else {
        $urgentCount = 0;
    }
    
    if ($assignedUserId != '') {
        sendNewAssignmentEmail($email, '1', $urgentCount);
        $note = "Ticket assigned to " . $assignedUserName . ".";
    } else {
        $note = "Ticket has been unassigned.";
    }
    
    //insert note into the database
    $sqlAddNote = "INSERT INTO `ticketnotes` (`intTicketId`, `strUserId`, `strEmployeeName`, `dateAdded`, `comment`) 
                    VALUES ('$ticketId', '$assignerUserId', '$assignerUserName', '$date', '$note')";
    
    $resultAddNote = $conn->query($sqlAddNote) or die("Add note fail. $sqlAddNote");
    
    $sqlTask = "UPDATE `tasks` SET `lastCompleted`= '$dateReceived' WHERE `taskId`= '7'";
    $resultTask = $conn->query($sqlTask) or die("Update fail");
    
?>