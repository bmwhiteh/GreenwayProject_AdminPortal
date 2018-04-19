<?php
include("../MySQL_Connections/config.php");

    $startDate = '04-01-2018';//$_POST["start"];

    $data = $POST["data"];

    $data = 't1=true&t2=true&t3=true&t4=false&t5=false&t6=false&t7=false&t8=false&t9=false&start=2018-04-01&end=2018-05-13' ;  

//break the string into "t#=false" bits
$dataArray = explode("&",$data);

//get just the true/false of each checkbox
$myObj = array();
for ($i = 0; $i<count($dataArray); $i++){
    $temp = explode("=",$dataArray[$i]);
    $myObj[$i] = $temp[1];
}

//now we add to the query string the tickets to avoid (false)
$includedTickets = "";
for ($i = 0; $i<count($myObj)-2; $i++){
    if ($myObj[$i] == 'false'){
        $id = $i + 1;
    $includedTickets = $includedTickets. "AND intTypeId != '$id'";
    }
}


    $sqlTickets = "SELECT intTicketId, dtEstFinish\n"
    . "FROM `maintenancetickets`\n"
    . "where dtEstFinish > '".$startDate."' and dtClosed IS NULL\n"
    . $includedTickets;

    $resultTickets = $conn->query($sqlTickets) or die($sqlTickets);
                    var_dump($resultTickets); $resultTickets->fetch_array(MYSQLI_ASSOC);
                    var_dump($row);

?>