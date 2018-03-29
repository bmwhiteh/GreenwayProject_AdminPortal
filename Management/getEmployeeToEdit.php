<?php
include("../MySQL_Connections/config.php");
if($_SERVER["REQUEST_METHOD"] == "POST") {
$sql = "SELECT strFirstName, strLastName, strEmailAddress, intSecurityLevel
FROM employees WHERE intEmployeeId='".$_POST['id']."'";

$resultset = $conn->query($sql) or die("Query fail");
$data = array();
while( $rows = $resultset ->fetch_array(MYSQLI_ASSOC)) {
$data = $rows;
}
echo json_encode($data);
}else {
echo 0;
}
?>