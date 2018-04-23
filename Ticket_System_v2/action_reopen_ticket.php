<?php
    /*
    *   Author: Bailey Whitehill
    *   Description: Allow Closed Tickets to be reopened. This covers instances where the wrong ticket was 
                    closed, someone closed a ticket that was not completed, etc.
    */
    
    //connect to the database
    include("../MySQL_Connections/config.php");

    $id = $_GET['ticketid'];

    //if the ticket id is set, then the ticket can be reopened
    if(isset($_GET['ticketid'])){
        
        //delete ticket from mainetnancetickets
        $sqlReopen = "UPDATE `maintenancetickets` SET `dtClosed` = NULL WHERE `intTicketId` = '".$id."'";
        $conn->query($sqlReopen)  or die("Could not reopen Ticket #$id");
        
    }
    
    /*
    *   add a note to the ticket that it is a ticket that a specific employee reopened
    */
    
    //Get the Employee id
    $sql = "SELECT intEmployeeId FROM `employees` WHERE `strUsername` = '".$_COOKIE["user"]."'";
    $result = $conn->query($sql) or die("find employee id fail");
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $employeeId = $row['intEmployeeId'];

    
    $comment = "Ticket Reopened.";
    $date = date("Y-m-d");
     
    //Add the note to the ticket 
    $sqlAddNote = 'INSERT INTO ticketnotes (intTicketId, intEmployeeId, dateAdded, comment) 
    VALUES("'.$id.'","'. $employeeId.'","'.$date.'", "'.$comment.'")';
    $resultAddNote = $conn->query($sqlAddNote) or die("Add note fail. $sqlAddNote");
    
    //return to the cards page   
    header("location: ticket_table_header.php");
        
?>
    