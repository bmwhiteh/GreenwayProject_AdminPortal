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

   
    
    $sqlTypes = "SELECT strTicketType\n"
    . "from maintenancetickets\n"
    . "left join tickettypes on tickettypes.intTypeId = maintenancetickets.intTypeId\n"
    . "GROUP BY strTicketType ";
   
    $resultTypes = $conn->query($sqlTypes) or die("Query fail");
    require("ticket_table_header.php");
?>

        

    
    
            <div style="border:2px solid grey; background-color:white; border-radius: 10px; ; padding:10px; margin:20px 15px 20px 30px; vertical-align:top;">
            
    <br/>
    <div style="font-size:20px;text-align:center;">Tickets By Ticket Type</div><br/><br/>
    
    <!--Loop through the ticket types and create separate lists-->
    <?php    while($row = $resultTypes->fetch_array(MYSQLI_ASSOC)){ ?>
    
        <span style="font-size:18px;margin-left: 100px;"><?php echo $row['strTicketType']?></span> <br/>
    
    
        <dl style="margin-left: 100px;">
            <!--Get the tickets for this ticket type-->
            <?php
            
                 if($_GET['tickets'] == "open"){
                      $sqlTickets = "SELECT strTicketType, intTicketId, strDescription, dtSubmitted, strTitle, strImageFilePath\n"
                . "from maintenancetickets\n"
                . "left join tickettypes on tickettypes.intTypeId = maintenancetickets.intTypeId\n"
                . "where dtClosed IS NULL and strTicketType = '".$row['strTicketType'] . "' LIMIT 0, 30 ";          
                }
                else{
                    $sqlTickets = "SELECT strTicketType, intTicketId, strDescription, dtSubmitted, strTitle, strImageFilePath\n"
                . "from maintenancetickets\n"
                . "left join tickettypes on tickettypes.intTypeId = maintenancetickets.intTypeId\n"
                . "where dtClosed IS NOT NULL and strTicketType = '".$row['strTicketType'] . "' LIMIT 0, 30 ";
                }
            
               
                $result = $conn->query($sqlTickets) or die("Query fail");
            ?>
            <?php    while($ticket = $result->fetch_array(MYSQLI_ASSOC)){ 
                 if($row['strTicketType']=='Litter'){$TicketColor = pink;}
                    elseif($row['strTicketType']=='Overgrown Brush'){$TicketColor = '#8080ff';}
                    elseif($row['strTicketType']=='High Water'){$TicketColor = '#1aff1a';}
                    elseif($row['strTicketType']=='Vandalism'){$TicketColor = '#00e600';}
                    elseif($row['strTicketType']=='Suspicious Persons'){$TicketColor =  '#00b300';}
            ?>

               <dt style="text-indent: 25px; padding:10px;">- Ticket #<?php echo $ticket['intTicketId']?>
              
                   <?php echo $ticket['strTitle']?>
                       
                   <div style="display:inline-block;float:right;">
                        <span style="border:2px solid green; background-color:green; font-weight:bold;padding:5px;">
                                <a href="ticket_info_single.php?ticketid=<?php echo $ticket['intTicketId']?>&page=list"style="text-decoration:none; color:white; font-weight:bold;">VIEW</a>
                        </span>
                        <span style="border:2px solid red; background-color:red; font-weight:bold;padding:5px;">
                             <?php if(($_GET['tickets'] == "open")|| $row['dtClosed'] ==''){?>
                                    <a href="action_close_ticket.php?ticketid=<?php echo $row['intTicketId']?>" style="text-decoration:none; color:white; font-weight:bold;">CLOSE</a>
                            <?php }else{?>
                                <a href="action_reopen_ticket.php?ticketid=<?php echo $row['intTicketId']?>" style="text-decoration:none; color:white; font-weight:bold;">REOPEN</a>
                            <?php }?>
                        </span>
                    </div>
                </dt>
           <?php } ?> 
        </dl>
        <br/><br/>
     <?php } ?>
    
    
      




                
                
                
            </div>



    </div>
</div>



    </div>


    
</div>

</body>


</html>
