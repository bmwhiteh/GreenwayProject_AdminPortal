<?php
            include("../MySQL_Connections/config.php");

    //echo "Comment".$_POST['comment'];
    /*echo $_POST["intTicketId"];
    echo $_POST["strEmployeeUsername"];
    echo $_POST["date"];*/
                       
    $sql = "SELECT intEmployeeId FROM `employees` WHERE `strUsername` = '".$_POST["strEmployeeUsername"]."'";
    
        $result = $conn->query($sql) or die("find employee id fail");
   
    $row = $result->fetch_array(MYSQLI_ASSOC);
   
    $employeeId = $row['intEmployeeId'];
    
    $ticket = $_POST["intTicketId"];
   
    $ticket = mysqli_real_escape_string($conn, $ticket);
    
    $addDate = $_POST["date"];
    $addDate = mysqli_real_escape_string($conn, $addDate);
    
    $fullComment = $_POST["comment"];
    $fullComment = mysqli_real_escape_string($conn, $fullComment);

    $sqlAddNote = "INSERT INTO ticketnotes (intTicketId, intEmployeeId, dateAdded, comment) 
    VALUES('$ticket','$employeeId','$addDate', '$fullComment')";
    
    echo "Query: " . $sqlAddNote . "\n";
   
    $resultAddNote = $conn->query($sqlAddNote) or die("Add note fail. $sqlAddNote");
   
    echo "Result:" . $resultAddNote;
    header("location: ticket_info_single.php?ticketid=".$_POST['intTicketId']."");
?>