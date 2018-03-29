<?php 
include("../MySQL_Connections/config.php");

$feedbackId = $_POST['feedbackId'];
$sql = "UPDATE `feedback` SET `bitResolved`= '0' WHERE `intFeedbackId`= '$feedbackId'";

$result = $conn->query($sql) or die("Query fail");
header("location: ./appFeedback.php");
?>