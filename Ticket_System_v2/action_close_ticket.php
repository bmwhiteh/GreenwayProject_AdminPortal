<?php
            include("../MySQL_Connections/config.php");

        $id = $_GET['ticketid'];

       
        
        $sql = "SELECT intEmployeeId FROM `employees` WHERE `strUsername` = '".$_COOKIE['user']."'";
    
        $result = $conn->query($sql) or die("find employee id fail");
   
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $comment = "Ticket Closed.";
        $date = date("Y-m-d");
        $employeeId = $row['intEmployeeId'];
        echo $employeeId;
         if(isset($_GET['ticketid'])){
            
           
            //update ticket in mainetnancetickets
            $sqlClose = "UPDATE `maintenancetickets` SET `dtClosed` = '". date("Y-m-d") ."', `intEmployeeAssigned` = '". $employeeId ."' WHERE `intTicketId` = '".$id."'";
            $conn->query($sqlClose)  or die("Update dtClosed FAIL  $id");
            
        }
        
        $sqlAddNote = 'INSERT INTO ticketnotes (intTicketId, intEmployeeId, dateAdded, comment) 
        VALUES("'.$id.'","'. $employeeId.'","'.$date.'", "'.$comment.'")';
       
        $resultAddNote = $conn->query($sqlAddNote) or die("Add note fail. $sqlAddNote");
        
    //header("location: ticket_table_cards.php?tickets=open");
        
?>
    