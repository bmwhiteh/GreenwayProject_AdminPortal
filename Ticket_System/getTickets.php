<?php include("../MySQL_Connections/config.php");
    $sql = "SELECT * FROM maintenancetickets";
    $result = $conn->query($sql) or die("Query fail");
    
    while($row = $result->fetch_array(MYSQL_ASSOC)){
        ?>
        <tr>
            <td><?php $row['intTicketId'] ?></td>
            <td><?php $row['strTitle'] ?></td>
            <td><?php $row['intTypeId'] ?></td>
            <td><?php $row['dtSubmitted'] ?></td>
        </tr>
<?php
    }
    ?>

<?php
/*
 <tr>
            <td>8</td>
            <td>Tree blocking path</td>
            <td>3</td>
            <td>8-21-2017</td>
            <td><a href="ticketInfo.php?ticketid=8">View Ticket</a></td>
        </tr>
*/
?>