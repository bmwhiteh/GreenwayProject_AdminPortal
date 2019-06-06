<?php

 include("../MySQL_Connections/config.php");
 //$ticketId = $_GET['ticketId'];
 $ticketId = '266';
 
 $sql = "SELECT bitUrgent FROM maintenancetickets WHERE intTicketId = '$ticketId'";
		$result = $conn->query($sql) or die("Query fail");
		$row = $result->fetch_array(MYSQLI_ASSOC);
		
if($row['bitUrgent']){
     $sqlMobileDisplay = "UPDATE `maintenancetickets` SET `bitUrgent`='0' WHERE `intTicketId`='".$ticketId."'";
    $resultMobileDisplay = $conn->query($sqlMobileDisplay) or die("Could Not Set Urgent to 1");
}else{
    $sqlMobileDisplay = "UPDATE `maintenancetickets` SET `bitUrgent`='1' WHERE `intTicketId`='".$ticketId."'";
    $resultMobileDisplay = $conn->query($sqlMobileDisplay) or die("Could Not Set Urgent to 1");
}
echo 1;
?>