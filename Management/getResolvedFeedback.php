<?php
    include("../MySQL_Connections/config.php");
    
    $sql = "SELECT * FROM `feedback` WHERE `bitResolved` != 0";
    $result = $conn->query($sql) or die("Query fail");
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
        $dt = new DateTime($row['dateReceived']);
        $timeZone = new DateTimeZone("America/Indiana/Indianapolis");
        $dt-> setTimezone($timeZone);
?>
        <tr>
            <td><?php echo $row['intFeedbackId']?></td>
            <td><?php echo $dt->format('m/d/Y h:i:s a');?></td>
            <td><?php echo $row['strErrorLocation']?></td>
            <td><?php echo $row['strFeedback']?></td>
            <td><form method="post" action="./markUnresolved.php">
                    <input type="hidden" name="feedbackId" value="<?php echo htmlspecialchars($row['intFeedbackId']); ?>"/>
                    <input type="submit" value="Unresolve">
                </form>
            </td>
        </tr>
<?php
		}
?>
