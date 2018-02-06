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
            margin: 0px 100px 150px 100px;
            
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
        
    tr:hover {
        background-color:lightgreen;
    }
    </style>
</head>
<body >
<?php require_once("../Login_System/verifyAuth.php"); ?>
<?php include "../Dashboard_Pages/navBar.php"; ?>
    
<div class="contentBox" >

<?php date_default_timezone_set('EST');?>

<!-- if($_GET['orderby'] == "open"){}
         elseif( $_GET['tickets'] == "open"){}
         elseif( $_GET['tickets'] == "open"){}--->

<?php 

    if($_GET['tickets'] == "open"){
         $sql = "SELECT strTicketType, intTicketId, strDescription, dtSubmitted, dtClosed, strTitle, strImageFilePath\n"
        . "from maintenancetickets\n"
        . "left join tickettypes on tickettypes.intTypeId = maintenancetickets.intTypeId\n"
        . "where dtClosed IS NULL or dtClosed = '' \n"
        . "LIMIT 0, 30 ";           
    }
    else{
        $sql = "SELECT strTicketType, intTicketId, strDescription, dtSubmitted, dtClosed, strTitle, strImageFilePath, intEmployeeAssigned, strFirstName, strLastName\n"
        . "from maintenancetickets\n"
        . "left join tickettypes on tickettypes.intTypeId = maintenancetickets.intTypeId\n"
        . "left join employees on employees.intEmployeeId = maintenancetickets.intEmployeeAssigned\n"
        . "where dtClosed IS NOT NULL LIMIT 0, 30 \n";
    }
    
    include("../MySQL_Connections/config.php");

   
    $result = $conn->query($sql) or die("Query fail");
    
     $sqlRangers = "SELECT strFirstName, strLastName, intEmployeeId\n"
        . "from employees\n"
        . "where intSecurityLevel = '4'\n";
        
    $resultRangers = $conn->query($sqlRangers) or die("Query Rangers fail");
    
    require("ticket_table_header.php");
?>

        <table style=" background-color:white; padding:20px; margin:auto; vertical-align:top; text-align:center;border-collapse:collapse;">
            <tr>
                <th style=" padding:20px;">
                    Ticket Id
                    <a href="ticket_table_table.php?tickets=<?php echo $_GET['tickets']?>&orderby=id">sort icon</a>
                </th>
                <th>
                    Ticket Type 
                    <a href="ticket_table_table.php?tickets=<?php echo $_GET['tickets']?>&orderby=type">sort icon</a>
                </th>
                <th>
                    Title 
                    <a href="ticket_table_table.php?tickets=<?php echo $_GET['tickets']?>&orderby=title">sort icon</a>
                </th>
                <th>
                    Status 
                    <a href="ticket_table_table.php?tickets=<?php echo $_GET['tickets']?>&orderby=date">sort icon</a>
                </th>
                <th style="text-align:center;">Actions</th>
                <th>Assigned To</th>
            </tr>
            <?php    while($row = $result->fetch_array(MYSQLI_ASSOC)){ 
                    if($row['strTicketType']=='Litter'){$TicketColor = pink;}
                    elseif($row['strTicketType']=='Overgrown Brush'){$TicketColor = '#8080ff';}
                    elseif($row['strTicketType']=='High Water'){$TicketColor = '#1aff1a';}
                    elseif($row['strTicketType']=='Vandalism'){$TicketColor = '#00e600';}
                    elseif($row['strTicketType']=='Suspicious Persons'){$TicketColor =  '#00b300';}
                    
            ?>
            
    
            <tr style="border:2px solid grey;">
                <td style="text-align:left;padding:20px 20px 20px 20px;">
                    <span style="font-size:20px">Ticket #<?php echo $row['intTicketId']?></span>
                </td>
                <td style=" text-align:left;padding:20px;">
                    <span style="font-size:16px; color:black; margin:0px 0px 20px 10px;background-color:<?php echo $TicketColor?>;"><?php echo $row['strTicketType']?></span>
    
                </td>
                <td style=" text-align:left;padding:20px;">
                    <span style="font-size:14px;text-overflow: ellipsis;text-align:center; font-weight:bold;"><?php echo $row['strTitle']?></span>
    
                </td>
                <td style=" text-align:left;padding:20px;">
                    <span style="font-size:14px;text-overflow: ellipsis;text-align:center;">Submitted: <?php echo $row['dtSubmitted']?></span><br/>
                    <span style="font-size:14px;text-overflow: ellipsis;text-align:center;">Closed: <?php echo $row['dtClosed']?></span>

                </td>
                <td style=" text-align:right;padding:20px;">
                    <div style="display:inline-block;">
                        <span style="border:2px solid green; background-color:green; font-weight:bold;padding:5px;">
                                <a href="ticket_info_single.php?ticketid=<?php echo $row['intTicketId']?>&page=table"style="text-decoration:none; color:white; font-weight:bold;">VIEW</a>
                        </span>
                        <span style="border:2px solid red; background-color:red; font-weight:bold;padding:5px;">
                             <?php if(($_GET['tickets'] == "open")|| $row['dtClosed'] ==''){?>
                                    <a href="action_close_ticket.php?ticketid=<?php echo $row['intTicketId']?>" style="text-decoration:none; color:white; font-weight:bold;">CLOSE</a>
                            <?php }else{?>
                                <a href="action_reopen_ticket.php?ticketid=<?php echo $row['intTicketId']?>" style="text-decoration:none; color:white; font-weight:bold;">REOPEN</a>
                            <?php }?>
                        </span>
                    </div>
                </td>
                <td>
                    
                    
                    <form method="post" action="action_assign_ticket.php">
                        <input type="hidden" name="intTicketId" value="<?php echo $row['intTicketId']?>">
                        <select name="assignedEmployee">
                            <?php 
                                if($row[intEmployeeAssigned]!= NULL){
                            ?>
                                <option value="%">Choose Employee</option>
                            <?php
                                }else{
                            ?>
                                <option value="<?php echo $row['intEmployeeAssigned']?>">
                                    <?php echo "".$row['strFirstName']." ".$row['strLastName']?>
                                </option>
                            <?php
                                }
                                
                                while($ranger = $resultRangers->fetch_array(MYSQLI_ASSOC)){ 
                            ?>   
                               
                                <option value="<?php echo $ranger['intEmployeeId']?>">
                                    <?php echo "".$ranger['strFirstName']." ".$ranger['strLastName']?>
                                </option>
                            <?php
                                }
                            ?>
                        </select>
                    </form>
                    
                   
                </td>
            </tr><?php } ?>
        </table>
        
     <br/>





                
                
                
            </div>



    </div>
</div>



    


    
</div>

</body>


</html>
