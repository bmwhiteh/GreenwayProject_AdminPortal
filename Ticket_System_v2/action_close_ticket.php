<?php
    /*
    *   Author: Bailey Whitehill
    *   Description: Backend database script to mark a ticket as closed
    *
    */
    
    //connect to the database
    include("../MySQL_Connections/config.php");

    $id = $_GET['ticketid'];
    $comment = "Ticket Closed.";
    $date = date("Y-m-d");
       
    //get the employeeId of the person closing the ticket using the username cookie
    $sql = "SELECT intEmployeeId FROM `employees` WHERE `strUsername` = '".$_COOKIE['user']."'";
    $result = $conn->query($sql) or die("find employee id fail");
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $employeeId = $row['intEmployeeId'];

    //if the ticket id value is set, then we can close the ticket. Without it, we risk closing ALL tickets
     if(isset($_GET['ticketid'])){
        
       //update ticket in mainetnancetickets
       $sqlClose = "UPDATE `maintenancetickets` SET `dtClosed` = '". date("Y-m-d") ."', `intEmployeeAssigned` = '". $employeeId ."' WHERE `intTicketId` = '".$id."'";
       $conn->query($sqlClose)  or die("Update dtClosed FAIL  $id");
       
       //add information for tasks page into database
        date_default_timezone_set('UTC');
        $date = date('m/d/Y h:i:s a', time());
        $sql = "UPDATE `tasks` SET `lastCompleted`= '$date' WHERE `taskId`= '8'";
        $result = $conn->query($sql) or die("Update fail");
        
    }
    
    //add a note to the ticket that the ticket has been closed by the employee
    $sqlAddNote = 'INSERT INTO ticketnotes (intTicketId, intEmployeeId, dateAdded, comment) 
    VALUES("'.$id.'","'. $employeeId.'","'.$date.'", "'.$comment.'")';
    $resultAddNote = $conn->query($sqlAddNote) or die("Add note fail. $sqlAddNote");
        
    header("location: ticket_table_header.php");
        
?>
    