<?php
    include("../MySQL_Connections/config.php");
    
    $sql = "SELECT * FROM `trailFriendlyBusinesses`";
    $result = $conn->query($sql) or die("Query fail");
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
?>
        <tr>
            <td><?php echo $row['id']?></td>
            <td><?php echo $row['businessName']?></td>
            <td><?php echo $row['address']?></td>
            <?php if($row['bathroom']){ ?>
            <td>Yes</td>
            <?php }else{ ?>
                <td>No</td>
            <?php }
            
            if($row['waterRefill']){?>
            <td>Yes</td>
            <?php }else{ ?>
                <td>No</td>
            <?php }
            
             if($row['bikeRepair']){?>
             <td>Yes</td>
            <?php }else{ ?>
                <td>No</td>
            <?php } ?>
        </tr>
<?php
		}
?>