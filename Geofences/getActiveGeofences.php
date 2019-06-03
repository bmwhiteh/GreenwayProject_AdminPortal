<?php
    include("../MySQL_Connections/config.php");
    
    $sql = "SELECT `strNotifText`,`strDescription`, `dtEventDate`, `dtEndDate` FROM `geofences` where btActive = '1'";
    $result = $conn->query($sql) or die("Query fail");
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
?>
        <tr>
            <td><?php echo $row['dtEventDate']?></td>
            <td><?php echo $row['dtEndDate']?></td>
            <td><?php echo $row['strNotifText']?></td>
            <td><?php echo $row['strDescription']?></td>
        </tr>
<?php
    }
?>
