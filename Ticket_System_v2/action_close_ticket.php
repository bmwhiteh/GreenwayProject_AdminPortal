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
    
      
    //if the ticket id value is set, then we can close the ticket. Without it, we risk closing ALL tickets
     if(isset($_GET['ticketid'])){
        
       //update ticket in mainetnancetickets
       $sqlClose = "UPDATE `maintenancetickets` SET `dtClosed` = '". date("Y-m-d") ."', `strUserId` = '". $_COOKIE['user'] ."' WHERE `intTicketId` = '".$id."'";
       $conn->query($sqlClose)  or die("Update dtClosed FAIL  $id");
       
       //add information for tasks page into database
        date_default_timezone_set('UTC');
        $date2 = date('m/d/Y h:i:s a', time());
        $sql = "UPDATE `tasks` SET `lastCompleted`= '$date2' WHERE `taskId`= '8'";
        $result = $conn->query($sql) or die("Update fail");
        
    }
    date_default_timezone_set('EST');
    $date = date("Y-m-d");
    
    //add a note to the ticket that the ticket has been closed by the employee
    $sqlAddNote = 'INSERT INTO ticketnotes (intTicketId, strUserId, strEmployeeName, dateAdded, comment) 
    VALUES("'.$id.'","'.$_COOKIE['user'].'","'.$_COOKIE['displayName'].'","'.$date.'", "'.$comment.'")';
    $resultAddNote = $conn->query($sqlAddNote) or die("Add note fail. $sqlAddNote");
        
    header("location: ticket_table_header.php");
        
?>
    