<?php
    include("../MySQL_Connections/config.php");
    
    $sql = "SELECT * FROM `tasks`";
    $result = $conn->query($sql) or die("Query fail");
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
        $lastCompleted = $row['lastCompleted'];
        $dt = new DateTime($row['lastCompleted']);
        $timeZone = new DateTimeZone("America/Indiana/Indianapolis");
        $dt-> setTimezone($timeZone);
?>
        <tr>
            <td><?php echo $row['taskId']?></td>
            <td><?php echo $row['task']?></td>
            <td><?php echo $dt->format('m/d/Y h:i:s a');?></td>
        </tr>
<?php
    }
?>