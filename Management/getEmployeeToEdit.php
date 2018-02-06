<?php
include("../MySQL_Connections/config.php");
if($_REQUEST['intEmployeeId']) {

$sql = "SELECT strFirstName, strLastName, strEmailAddress, intSecurityLevel
FROM employee WHERE intEmployeeId='".$_REQUEST['intEmployeeId']."'";

$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
$data = array();
while( $rows = mysqli_fetch_assoc($resultset) ) {
$data = $rows;
}
echo json_encode($data);
} else {
echo 0;
}
?>