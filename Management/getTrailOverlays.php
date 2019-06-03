<?php
    include("../MySQL_Connections/config.php");
    
    $sql = "SELECT * FROM `trailOverlay` ORDER BY `dateUploaded` DESC LIMIT 5";
    $result = $conn->query($sql) or die("Query fail");
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
        $dt = new DateTime($row['dateUploaded']);
        $timeZone = new DateTimeZone("America/Indiana/Indianapolis");
        $dt-> setTimezone($timeZone);
        if($row['active']){
?>
        <tr>
            <td><?php echo $row['id']?></td>
            <td><?php echo $row['fileName']?></td>
            <td><?php echo $dt->format('m/d/Y h:i:s a');?></td>
            <td>Active</td>
        <!--    <td><form method="post" action="./setActiveTrailOverlay.php">
                    <input type="hidden" name="feedbackId" value="<?php echo htmlspecialchars($row['intFeedbackId']); ?>"/>
                    <input type="submit" value="Unresolve">
                </form>
            </td>-->
        </tr>
<?php
		}else{
?>
		        <tr>
            <td><?php echo $row['id']?></td>
            <td><?php echo $row['fileName']?></td>
            <td><?php echo $dt->format('m/d/Y h:i:s a');?></td>
           <td><form method="post" action="./setActiveTrailOverlay.php">
                    <input type="hidden" name="overlayId" value="<?php echo htmlspecialchars($row['id']); ?>"/>
                    <input type="submit" value="Set Active">
                </form>
            </td>
        </tr>
        <?php }
    }
?>
