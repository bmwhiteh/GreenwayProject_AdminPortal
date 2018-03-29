<?php
    /*
    *   author: Bailey Whitehill
    *   description: backend database connection to add notes to the database for a ticket. 
    *               Notes can be used to update the status of a ticket so other rangers
    *               can see that a ticket is in progress, or other updates that make occur
    *               between ticket creation and ticket closing.
    */

    
    //this is the database connection
    include("../MySQL_Connections/config.php");

    //Find the Employee Id to record on the ticket. the Username name is stored in a cookie on the previous page
    $sql = "SELECT intEmployeeId FROM `employees` WHERE `strUsername` = '".$_GET["employee"]."'";
    $result = $conn->query($sql) or die("find employee id fail");
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $employeeId = $row['intEmployeeId'];
    
    //Ticket Id will link the note to the ticket
    $ticket = $_GET["ticketid"];
    $ticket = mysqli_real_escape_string($conn, $ticket);
    
    //date properly orders the ticket notes on a ticket
    $addDate = $_GET["date"];
    $addDate = mysqli_real_escape_string($conn, $addDate);
    
    //this is the note that will go on the ticket
    $fullComment = $_GET["comment"];
    $fullComment = mysqli_real_escape_string($conn, $fullComment);

    //insert note into the database
    $sqlAddNote = "INSERT INTO ticketnotes (intTicketId, intEmployeeId, dateAdded, comment) 
    VALUES('$ticket','$employeeId','$addDate', '$fullComment')";
    $resultAddNote = $conn->query($sqlAddNote) or die("Add note fail. $sqlAddNote");

    
?>