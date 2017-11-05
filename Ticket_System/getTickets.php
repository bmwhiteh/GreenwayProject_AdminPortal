
<?php
    include("../MySQL_Connections/config.php");
    
    $sql = "SELECT `intTicketId`,`strTitle`,`intTypeId`, `dtSubmitted` FROM `maintenancetickets`";
    $result = $conn->query($sql) or die("Query fail");
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
?>
        <tr>
            <td><?php echo $row['intTicketId']?></td>
            <td><?php echo $row['strTitle']?></td>
            <td><?php echo $row['intTypeId']?></td>
            <td><?php echo $row['dtSubmitted']?></td>
            <td><?php echo '<a href="ticketInfo.php?ticketid='.$row['intTicketId'].'">View Ticket</a>'?> </td>
        </tr>
<?php
    }
?>
