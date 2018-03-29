<?php
    /*
    *   Author: Bailey Whitehill
    *   Description: Backend database script to mark a ticket as urgent
    *
    */
    
    //connect to the database
    include("../MySQL_Connections/config.php");

    $id = $_GET['ticketid'];
    $urgent = $_GET['urgent'];
    
    
    //Change the intEmployeeAssigned value to that of the selected employee
    $sqlTicket = "UPDATE `maintenancetickets` SET `bitUrgent`='$urgent' WHERE `intTicketId`='".$id."'";
    $resultTicket = $conn->query($sqlTicket) or die("Could Not Set Urgent to 1");
        
    header("location: ticket_table_header.php");
        
?>
    