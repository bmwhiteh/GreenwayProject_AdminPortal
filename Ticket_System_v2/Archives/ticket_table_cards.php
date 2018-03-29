<!DOCTYPE html>
<html lang="en">
<head>
    <title>Maintenance Tickets</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<link rel="shortcut icon" href="../Dashboard_Pages/favicon.ico" type="image/x-icon">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />


    <style>
        .theBox{
            background-color: #8c8c8c;
            margin: 0px 100px 50px 100px;
            
            
        }

        * {
            margin: 0;
            padding: 0;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        

        ul { list-style-type: none; }

        a {
            color: #b63b4d;
            text-decoration: none;
        }

       


        .tile {
            height:300px;
            width:300px;
            
        }
        

        

    </style>
</head>
<!--onLoad="getTheGraphs();"-->
<body >
<?php require_once("../Login_System/verifyAuth.php"); ?>
<?php include "../Dashboard_Pages/navBar.php"; 
   ?>


<div class="theBox" >
    
<?php date_default_timezone_set('EST');?>

<?php 
        include("../MySQL_Connections/config.php");

     if($_GET['tickets'] == "open"){
         $sql = "SELECT strTicketType, intTicketId, strDescription, dtSubmitted, strTitle, strImageFilePath\n"
        . "from maintenancetickets\n"
        . "left join tickettypes on tickettypes.intTypeId = maintenancetickets.intTypeId\n"
        . "where dtClosed IS NULL LIMIT 0, 30 ";           
    }
    else{
        $sql = "SELECT strTicketType, intTicketId, strDescription, dtSubmitted, dtClosed, strTitle, strImageFilePath\n"
        . "from maintenancetickets\n"
        . "left join tickettypes on tickettypes.intTypeId = maintenancetickets.intTypeId\n"
        . "where dtClosed IS NOT NULL LIMIT 0, 30 ";
    }
    $result = $conn->query($sql) or die("Query fail");
    require("ticket_table_header.php");

    while($row = $result->fetch_array(MYSQLI_ASSOC)){ 
     if($row['strTicketType']=='Litter'){$TicketColor = '#432021';}
    elseif($row['strTicketType']=='Overgrown Brush'){$TicketColor = '#3DB737';}
    elseif($row['strTicketType']=='High Water'){$TicketColor = '#75BBB8';}
    elseif($row['strTicketType']=='Vandalism'){$TicketColor = '#FD9EA1';}
    elseif($row['strTicketType']=='Suspicious Persons'){$TicketColor =  '#C61A1F';}
?>
                    
    <div style="border:2px solid grey; background-color:white; border-radius: 10px; width:20%; padding:10px;display:inline-block; margin:20px 15px 20px 30px; vertical-align:top; text-align:center;">
        <div style="font-size:20px;">Ticket #<?php echo $row['intTicketId']?></div>
        <div style="font-size:16px; color:black; margin:0px 0px 20px 10px;background-color:<?php echo $TicketColor?>;"><?php echo $row['strTicketType']?></div>
        <div style="font-size:14px;text-overflow: ellipsis;text-align:center; font-weight:bold;"><?php echo $row['strTitle']?></div>
        <div style="font-size:14px;text-align:center;text-overflow: ellipsis;height:50px;"><?php echo $row['strDescription']?></div>
        <div style="max-height:300px; margin:0px 0px 0px 10px;">
            <?php if($row['strImageFilePath'] != ''){ ?><img src="<?php echo $row['strImageFilePath'];?>" style="max-width:100%;margin:auto;" alt="Ticket Image Not Found"><?php }else{ ?>No Image to Display<?php } ?>        
        </div>
        <div style="font-size:14px;text-align:center; margin:0px 0px <?php if($row['dtClosed'] != ''){ echo "0px"; }else{ echo "20px";}?> 0px;">Submitted: <?php echo $row['dtSubmitted']?></div>
        <?php if($row['dtClosed'] != ''){?><div style="font-size:14px;text-align:center;margin:0px 0px 20px 0px">Closed: <?php echo $row['dtClosed']?></div><?php } ?>
    
        <div style="display:inline-block; margin:0px 0px 20px 0px;">
            <!---View Button--->
            <button style="border:2px solid green; background-color:green;padding:5px;color:white; font-weight:bold; color:white; font-weight:bold;" type="button" name="myTicketButton" id="myTicketButton" onClick="openTicket(<?php echo $row['intTicketId'];?>);">VIEW</button>
            
            <?php if($row['dtClosed'] ==''){?>

                 <!---Reopen Button--->
                <button style="border:2px solid red; background-color:red;padding:5px;color:white; font-weight:bold; color:white; font-weight:bold;" type="button" name="myTicketButton" id="myTicketButton" onClick="closeTicket(<?php echo $row['intTicketId'];?>);">CLOSE</button>
            
            <?php }else{?>
                <!--Close-->
                <button style="border:2px solid red; background-color:red;padding:5px;color:white; font-weight:bold; color:white; font-weight:bold;" type="button" name="myTicketButton" id="myTicketButton" onClick="ReopenTicket(<?php echo $row['intTicketId'];?>);">REOPEN</button>
             <?php }?> 
             
             
             
            <!--<span style="border:2px solid red; background-color:red; font-weight:bold;padding:5px;">
                <?php //if(($_GET['tickets'] == "open")|| $row['dtClosed'] ==''){?>
                        <a href="action_close_ticket.php?ticketid=<?php //echo $row['intTicketId']?>" style="text-decoration:none; color:white; font-weight:bold;">CLOSE</a>
                <?php //}else{?>
                    <a href="action_reopen_ticket.php?ticketid=<?php //echo $row['intTicketId']?>" style="text-decoration:none; color:white; font-weight:bold;">REOPEN</a>
                <?php// }?> 
                
            </span>--->
        </div>
    
    </div>
<?php } ?>




                
                
                
            </div>



    </div>
</div>



    


    
</div>

</body>


</html>
