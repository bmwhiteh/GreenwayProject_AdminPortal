<?php

 include("../MySQL_Connections/config.php");
 //$ticketId = $_GET['ticketId'];
 $ticketId = '266';
 
 $sql = "SELECT bitMobileDisplay FROM maintenancetickets WHERE intTicketId = '$ticketId'";
		$result = $conn->query($sql) or die("Query fail");
		$row = $result->fetch_array(MYSQLI_ASSOC);
		
if($row['bitMobileDisplay']){
     $sqlMobileDisplay = "UPDATE `maintenancetickets` SET `bitMobileDisplay`='0' WHERE `intTicketId`='".$ticketId."'";
    $resultMobileDisplay = $conn->query($sqlMobileDisplay) or die("Could Not Set Urgent to 1");
}else{
    $sqlMobileDisplay = "UPDATE `maintenancetickets` SET `bitMobileDisplay`='1' WHERE `intTicketId`='".$ticketId."'";
    $resultMobileDisplay = $conn->query($sqlMobileDisplay) or die("Could Not Set Urgent to 1");
    
    //NEEDS FINISHED: CODE TO ADD GEOFENCES FOR TICKETS
    
    // $sqlGetTicket = "SELECT * from `maintenancetickets` WHERE `intTicketId`='".$ticketId."'";
    // $resultGetTicket = $conn->query($sqlGetTicket) or die("Could not retrieve ticket");
    // $row = $getTicketResults->fetch_array(MYSQLI_ASSOC);
    // $ticketId = $row['intTicketId'];
    // $lat = $row['gpsLat'];
    // $long = $row['gpsLong'];
    // $date = new DateTime();
    // if($row['geofenceId'] == NULL){
    //     $sqlInsertGeofence = "INSERT INTO `geofences`(`strName`, `btActive`, `intMeterRadius`, `dblLatitude`, `dblLongitude`, `dtCreatedAt`, `strNotifText`, `strDescription`, `dtEventDate`) VALUES ('TicketGeofence $ticketId','1','100','$lat','$long',$date,'Be careful!','There has been a $ticketType issue reported nearby!',[value-10])";
    // }
}
echo 1;
?>