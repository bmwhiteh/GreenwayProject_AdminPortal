<?php
    /*
    *   Author: Bailey Whitehill
    *   Description: Backend database script to assign a ticket to an employee.
    */
    
    //connect to the database
    include("../MySQL_Connections/config.php");

    
    //echo $_POST['assignedEmployee'];
    //var_dump($_POST['assign']);
    //var_dump($_POST['notification']);

    $assignedEmployee = $_POST['assignedEmployee'];
    
    if (isset($_POST['assign'])){
        
    
        foreach($_POST['assign'] as $assign) {
    
        
    
            //Change the intEmployeeAssigned value to that of the selected employee
            $sqlAssignTicket = "UPDATE `maintenancetickets` SET `intEmployeeAssigned`='".$assignedEmployee."' WHERE `intTicketId`='".$assign."'";
            $resultAssignTicket = $conn->query($sqlAssignTicket) or die("Could Not Assign Ticket");
        
            date_default_timezone_set('UTC');
           $date = date('m/d/Y h:i:s a', time());
           
           $sql = "UPDATE `tasks` SET `lastCompleted`= '$date' WHERE `taskId`= '7'";
           $result = $conn->query($sql) or die("Update fail");
    
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
            . "and `intEmployeeAssigned` IS NULL \n"
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
    
        
    
            //Change the intEmployeeAssigned value to that of the selected employee
            $sqlTicket = "UPDATE `maintenancetickets` SET `bitUrgent`='1' WHERE `intTicketId`='".$ticket."'";
            $resultTicket = $conn->query($sqlTicket) or die("Could Not Set Urgent to 1");
        
    
        } 
        
        //Accomodate for the user de-selecting a ticket
        foreach($result as $nonUrgentTicket){
             //Change the intEmployeeAssigned value to that of the selected employee
            $sqlTicket = "UPDATE `maintenancetickets` SET `bitUrgent`='0' WHERE `intTicketId`='".$ticket."'";
            $resultTicket = $conn->query($sqlTicket) or die("Could Not Set Urgent to 0");
        
        }
        
        
    }
    
    //header("location: ticket_assignments.php");
?>