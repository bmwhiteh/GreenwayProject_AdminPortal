<?php
    include("../MySQL_Connections/config.php");
    
    $sql = "SELECT `intUserId`,`strUsername`,`strFirstName`,`strLastName`,
    `strEmailAddress`, `bitSendPictures` FROM `users`";
    $result = $conn->query($sql) or die("Query fail");
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
        
        if($row['bitSendPictures'] == 0){
?>
        <tr>
            <td><?php echo $row['intUserId']?></td>
            <td><?php echo $row['strUsername']?></td>
            <td><?php echo $row['strFirstName']?></td>
            <td><?php echo $row['strLastName']?></td>
            <td><?php echo $row['strEmailAddress']?></td>
            <td>
                <form method="post" action="./grantPicturePermission.php">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['intUserId']); ?>"/>
                    <input type="submit" class="grantRemove" value="Grant">
                </form>
            </td>
        </tr>
<?php
		}else{
?>
		    <tr>
            <td><?php echo $row['intUserId']?></td>
            <td><?php echo $row['strUsername']?></td>
            <td><?php echo $row['strFirstName']?></td>
            <td><?php echo $row['strLastName']?></td>
            <td><?php echo $row['strEmailAddress']?></td>
            <td><form method="post" action="./removePicturePermission.php">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['intUserId']); ?>"/>
                    <input type="submit" class="grantRemove" value="Remove">
                </form>
            </td>
        </tr>
<?php
		}
    }
?>