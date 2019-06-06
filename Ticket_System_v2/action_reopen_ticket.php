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
    
    $comment = "Ticket Reopened.";
     date_default_timezone_set('EST');
    $date = date("Y-m-d");
     
    //Add the note to the ticket 
    $sqlAddNote = 'INSERT INTO ticketnotes (intTicketId, strUserId, strEmployeeName, dateAdded, comment) 
    VALUES("'.$id.'","'. $_COOKIE['user'].'","'. $_COOKIE['displayName'].'","'.$date.'", "'.$comment.'")';
    $resultAddNote = $conn->query($sqlAddNote) or die("Add note fail. $sqlAddNote");
    
    //return to the cards page   
    header("location: ticket_table_header.php");
        
?>
    