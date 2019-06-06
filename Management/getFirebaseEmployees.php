<?php
    require '../Mobile_Connections/vendor/autoload.php';
    include("../MySQL_Connections/config.php");
    
    use Kreait\Firebase\Factory;
    use Kreait\Firebase\ServiceAccount;

    $serviceAccount = ServiceAccount::fromJsonFile('../Mobile_Connections/firebase-adminsdk.json');
    $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->create();
    $auth = $firebase->getAuth();
    
    $employeesSql = "SELECT * FROM `firebaseusers` WHERE `intSecurityLevel` < 4";
    $employeesResults = $conn->query($employeesSql);
    $employeesObj = array();
    while ($row = $employeesResults->fetch_array(MYSQLI_ASSOC)) {
        $user = $auth->getUser($row['userId']);
        $level = $row['intSecurityLevel'];
				    $sql2 = "SELECT strSecurityTitle FROM securitylevels WHERE intSecurityLevelId = $level";
					$result2 = $conn->query($sql2) or die("Query fail");
					$findSecurity = $result2->fetch_array(MYSQLI_ASSOC);
?>

<tr>
            <td><?php echo $user->displayName?></td>
            <td><?php echo $user->email?></td>
            <td><?php echo $findSecurity['strSecurityTitle']?></td>
        </tr>
        
        <?php } ?>