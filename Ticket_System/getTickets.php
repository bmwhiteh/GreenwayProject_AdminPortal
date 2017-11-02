<?php include("../MySQL_Connections/config.php");
    $sql = "SELECT * FROM 'maintenancetickets";
    $result = $conn->query($sql) or die("Query fail");
    
    while($row = $result->fetch_array(MYSQL_ASSOC)){
        echo("<p>".$row['intTicketId']. "</p>");
    }

?>