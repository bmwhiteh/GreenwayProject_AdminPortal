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
    
    $employeesSql = "SELECT * FROM `firebaseusers` WHERE `intSecurityLevel` = 4";
    $employeesResults = $conn->query($employeesSql);
    $employeesObj = array();
    while ($row = $employeesResults->fetch_array(MYSQLI_ASSOC)) {
        $user = $auth->getUser($row['userId']);
              if($row['bitSendPics'] == 0){
?>
        <tr>
           <td><?php echo $user->displayName?></td>
            <td><?php echo $user->email?></td>
            <td>
                <form method="post" action="./grantPicturePermission.php">
                    <input type="hidden" name="id" value="<?php echo $user->uid; ?>"/>
                    <input type="submit" class="grantRemove" value="Grant">
                </form>
            </td>
        </tr>
<?php
		}else{
?>
		    <tr>
            <td><?php echo $user->displayName?></td>
            <td><?php echo $user->email?></td>
            <td><form method="post" action="./removePicturePermission.php">
                    <input type="hidden" name="id" value="<?php echo $user->uid; ?>"/>
                    <input type="submit" class="grantRemove" value="Remove">
                </form>
            </td>
        </tr>
<?php
		}
    }
?>
