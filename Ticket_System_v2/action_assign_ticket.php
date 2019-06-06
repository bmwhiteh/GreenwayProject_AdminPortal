<?php
    /*
    *   Author: Bailey Whitehill
    *   Description: Backend database script to assign a ticket to an employee.
    */
    
    //connect to the database
    include("../MySQL_Connections/config.php");
    include("../Emails/assignedProblemEmail.php");
    require '../Mobile_Connections/vendor/autoload.php';
        
    use Kreait\Firebase\Factory;
    use Kreait\Firebase\ServiceAccount;
    
    $serviceAccount = ServiceAccount::fromJsonFile('../Mobile_Connections/firebase-adminsdk.json');
    $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->create();
    $auth = $firebase->getAuth();
    
    $assignedEmployee = $_POST['assignedEmployee'];
    $assignedUser = $auth->getUser($assignedEmployee);
    $assignedEmployeeName = $assignedUser->displayName;
    $assignedEmployeeEmail = $assignedUser->email;
    $ticketCount = 0;
    $urgentCount = 0;
    
    $assignTickets = $_POST['assign'];
    
    //single tickets come in as a string, not an array which breaks the foreach loop
    if(!is_array($assignTickets)){
            $assignTickets = array($_POST['assign']);
    }

    if (isset($assignTickets)){
        
    
        foreach($assignTickets as $assign) {

            //Change the strEmployeeAssigned value to that of the selected employee
            $sqlAssignTicket = "UPDATE `maintenancetickets` SET `strEmployeeAssigned`='".$assignedEmployee."', `strEmployeeName`='".$assignedEmployeeName."' WHERE `intTicketId`='".$assign."'";
            $resultAssignTicket = $conn->query($sqlAssignTicket) or die("Could Not Assign Ticket");
        
            date_default_timezone_set('UTC');
            $date = date('m/d/Y h:i:s a', time());
            
            $sql = "UPDATE `tasks` SET `lastCompleted`= '$date' WHERE `taskId`= '7'";
            $result = $conn->query($sql) or die("Update fail");
    
            $ticketCount++;
            
    
        } 
    }
    if (isset($_POST['notification'])){

        foreach($_POST['notification'] as $ticket) {
    
            //Change the intEmployeeAssigned value to that of the selected employee
            $sqlTicket = "UPDATE `maintenancetickets` SET `bitMobileDisplay`='1' WHERE `intTicketId`='".$ticket."'";
            $resultTicket = $conn->query($sqlTicket) or die("Could Not Set Bit to 1");
        
        } 
    }
    
    if (isset($_POST['urgent'])){

        $typeSelected = $_POST['typeSelected'];
        echo "Type".$typeSelected;
        
        //Get the tickets that have been submitted as urgent but not assigned
        $sqlUrgentTickets = "SELECT intTicketId \n"
            . "FROM `maintenancetickets` \n"
            . "LEFT JOIN `tickettypes` on tickettypes.intTypeId = maintenancetickets.intTypeId\n"
            . "WHERE `bitUrgent` = '1' \n"
            . "and `strEmployeeAssigned` IS NULL \n"
            . "and `strTicketType` = '$typeSelected' \n"
            . "and `dtClosed` IS NULL";;
        $resultUrgentTickets = $conn->query($sqlUrgentTickets) or die("Could Not Find Urgent Tickets");
        
        $arrayCurrentUrgent = array();
        $arrayCount = 0;
        
        while($ticket = $resultUrgentTickets->fetch_array(MYSQLI_ASSOC)){ 
            $arrayCurrentUrgent[$arrayCount] = $ticket['intTicketId'];
            $arrayCount = $arrayCount + 1;
        }
        
        $result = array_diff($arrayCurrentUrgent, $_POST['urgent']);
        var_dump($result);

        foreach($_POST['urgent'] as $ticket) {
    
            //Change the bitUrgent value to urgent
            $sqlTicket = "UPDATE `maintenancetickets` SET `bitUrgent`='1' WHERE `intTicketId`='".$ticket."'";
            $resultTicket = $conn->query($sqlTicket) or die("Could Not Set Urgent to 1");
    
        } 
        
        //Accomodate for the user de-selecting a ticket
        foreach($result as $nonUrgentTicket){
             //Change the bitUrgent value to not urgent
            $sqlTicket = "UPDATE `maintenancetickets` SET `bitUrgent`='0' WHERE `intTicketId`='".$ticket."'";
            $resultTicket = $conn->query($sqlTicket) or die("Could Not Set Urgent to 0");
        
        }
        
        $urgentCount = count($_POST['assign'])-count(array_diff($_POST['assign'], $_POST['urgent']));
        
        
    }
    
    sendNewAssignmentEmail($assignedEmployeeEmail, $ticketCount, $urgentCount);
    header("location: ticket_assignments.php");
?>