<?php
            include("../MySQL_Connections/config.php");

        $id = $_GET['ticketid'];

        if(isset($_GET['ticketid'])){
            
           
            echo "here";
           
            //delete ticket from mainetnancetickets
            $sqlReopen = "UPDATE `maintenancetickets` SET `dtClosed` = NULL WHERE `intTicketId` = '".$id."'";
            $conn->query($sqlReopen)  or die("Update dtClosed FAIL  $id");
            
        }
        
        $sql = "SELECT intEmployeeId FROM `employees` WHERE `strUsername` = '".$_POST["strEmployeeUsername"]."'";
    
        $result = $conn->query($sql) or die("find employee id fail");
   
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $comment = "Ticket Reopened.";
        $date = date("Y-m-d");
        $employeeId = $row['intEmployeeId'];
        
        $sqlAddNote = 'INSERT INTO ticketnotes (intTicketId, intEmployeeId, dateAdded, comment) 
        VALUES("'.$id.'","'. $employeeId.'","'.$date.'", "'.$comment.'")';
       
        $resultAddNote = $conn->query($sqlAddNote) or die("Add note fail. $sqlAddNote");
        
    header("location: ticket_table_cards.php?tickets=open");
        
?>
    