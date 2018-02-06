<?php
    include("../MySQL_Connections/config.php");
    
    $sql = "SELECT `intEmployeeId`,`strUsername`,`strFirstName`,`strLastName`,
    `strEmailAddress`,`intSecurityLevel`, `accountLocked` FROM `employees` 
    where `activeUser` = 0 ";
    $result = $conn->query($sql) or die("Query fail");
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
         $level = $row['intSecurityLevel'];
				    $sql2 = "SELECT strSecurityTitle FROM securitylevels WHERE intSecurityLevelId = $level";
					$result2 = $conn->query($sql2) or die("Query fail");
					$findSecurity = $result2->fetch_array(MYSQLI_ASSOC);
?>
        <tr>
            <td><?php echo $row['intEmployeeId']?></td>
            <td><?php echo $row['strUsername']?></td>
            <td><?php echo $row['strFirstName']?></td>
            <td><?php echo $row['strLastName']?></td>
            <td><?php echo $row['strEmailAddress']?></td>
            <td><?php echo $findSecurity['strSecurityTitle']?></td>
            <td>
                <form method="get" action="./reactivateUser.php">
                    <input type="hidden" name="username" value="<?php echo htmlspecialchars($row['strUsername']); ?>"/>
                    <input type="submit" value="Reactivate">
                </form>
            </td>
<?php
		}


?>
