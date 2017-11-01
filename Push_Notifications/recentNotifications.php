<?php
    include("../MySQL_Connections/config.php");
    
    $sql = "SELECT `dtSentToUsers`,`intUsersSentTo`,`strJSONMessage` FROM `pushnotifications`";
    $result = $conn->query($sql) or die("Query fail");
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
?>
        <tr>
            <td><?php echo $row['dtSentToUsers']?></td>
            <td><?php echo $row['intUsersSentTo']?></td>
            <td><?php echo $row['strJSONMessage']?></td>
        </tr>
<?php
    }
?>