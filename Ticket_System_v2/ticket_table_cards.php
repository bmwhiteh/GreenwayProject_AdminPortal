<!DOCTYPE html>
<html lang="en">
<head>
    <title>Maintenance Tickets</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
   
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />


    <style>
        .contentBox{
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

        body {
            background-color: #1B371A ;

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
<?php include "../Dashboard_Pages/navBar.php"; ?>
    
<div class="contentBox" >

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
     if($row['strTicketType']=='Litter'){$TicketColor = pink;}
    elseif($row['strTicketType']=='Overgrown Brush'){$TicketColor = '#8080ff';}
    elseif($row['strTicketType']=='High Water'){$TicketColor = '#1aff1a';}
    elseif($row['strTicketType']=='Vandalism'){$TicketColor = '#00e600';}
    elseif($row['strTicketType']=='Suspicious Persons'){$TicketColor =  '#00b300';}
?>
                    
    <div style="border:2px solid grey; background-color:white; border-radius: 10px; width:20%; padding:10px;display:inline-block; margin:20px 15px 20px 30px; vertical-align:top; text-align:center;">
        <div style="font-size:20px;">Ticket #<?php echo $row['intTicketId']?></div>
        <div style="font-size:16px; color:darkgrey; margin:0px 0px 20px 10px;background-color:<?php echo $TicketColor?>;"><?php echo $row['strTicketType']?></div>
        <div style="font-size:14px;text-overflow: ellipsis;text-align:center; font-weight:bold;"><?php echo $row['strTitle']?></div>
        <div style="font-size:14px;text-align:center;"><?php echo $row['strDescription']?></div>
        <br/>
<?php if($row['strImageFilePath'] != ''){ ?><img src="<?php echo $row['strImageFilePath'];?>" style="max-width:100%;margin:auto;" alt="Ticket Image Not Found"><?php }else{ ?>No Image to Display<?php } ?>        
        <div style="font-size:14px;text-align:center;">Submitted: <?php echo $row['dtSubmitted']?></div>
        <?php if($row['dtClosed'] != ''){?><div style="font-size:14px;text-align:center;">Closed: <?php echo $row['dtClosed']?></div><?php } ?>
        <br/>
        <div style="display:inline-block;">
            <span style="border:2px solid green; background-color:green; font-weight:bold;padding:5px;">
                    <a href="ticket_info_single.php?ticketid=<?php echo $row['intTicketId']?>&page=card"style="text-decoration:none; color:white; font-weight:bold;">VIEW</a>
            </span>
            <span style="border:2px solid red; background-color:red; font-weight:bold;padding:5px;">
                <?php if(($_GET['tickets'] == "open")|| $row['dtClosed'] ==''){?>
                        <a href="action_close_ticket.php?ticketid=<?php echo $row['intTicketId']?>" style="text-decoration:none; color:white; font-weight:bold;">CLOSE</a>
                <?php }else{?>
                    <a href="action_reopen_ticket.php?ticketid=<?php echo $row['intTicketId']?>" style="text-decoration:none; color:white; font-weight:bold;">REOPEN</a>
                <?php }?>
                
            </span>
        </div>
    
    </div>
<?php } ?>




                
                
                
            </div>



    </div>
</div>



    


    
</div>

</body>


</html>
