

<?php

date_default_timezone_set('EST');

    include("../MySQL_Connections/config.php");
    
$pageno = $_COOKIE['page_number'];

$no_of_records_per_page = 20;

$status = 'where dtClosed IS NULL';
if ($_GET['status'] == "closed"){$status = 'where dtClosed IS NOT NULL';}
else if ($_GET['status'] == "all"){$status = '';}

if(isset($status)){

    $sqlCount = "SELECT count(intTicketId) as numTickets\n"
	. "from maintenancetickets\n"
	. $status;
    $result = mysqli_query($conn,$sqlCount);
    $total_rows = mysqli_fetch_array($result)[0];
    $total_pages = ceil($total_rows / $no_of_records_per_page);

    if($pageno > $total_pages){
        $pageno = 1;
        setcookie("page_number", $pageno, time() + (86400 * 30), "/"); // 86400 = 1 day
    }
    $offset = ($pageno-1) * $no_of_records_per_page;

	if($offset < 0){
		$startingLimit = 0;
	}else{
		$startingLimit = $offset;
	}
    
	$sql = "SELECT strTicketType, intTicketId, strDescription, dtSubmitted, dtClosed, strTitle, strImageFilePath, gpsLat, gpsLong, bitUrgent\n"
	. "from maintenancetickets\n"
	. "left join tickettypes on tickettypes.intTypeId = maintenancetickets.intTypeId\n"
	. $status. " LIMIT $startingLimit, $no_of_records_per_page";       
	$result = $conn->query($sql) or die($sql);

}


?>

        <table id="ticketTable" style=" background-color:white; padding:20px; margin:auto; vertical-align:top; text-align:center;border-collapse:collapse;">
            <tr>
                <th style="width:20px;"></th>
                <th style=" padding:20px;" onclick="sortTable(0);">
                     Ticket Id 
                </th>
                <th onclick="sortTable(1);">
                    Ticket Type 
                </th>
                <th onclick="sortTable(2);">
                    Title 
                </th>
                <th onclick="sortTable(3)">
                    Status 
                </th>
                <th style="text-align:center;" onclick="sortTable(4)">Actions</th>
                <!--<th onclick="sortTable(5)">Assigned To</th>-->
            </tr>
            <?php    while($row = $result->fetch_array(MYSQLI_ASSOC)){ 
                    if($row['strTicketType']=='Litter'){$TicketColor = '#432021';}
                    elseif($row['strTicketType']=='Overgrown Brush'){$TicketColor = '#3DB737';}
                    elseif($row['strTicketType']=='High Water'){$TicketColor = '#75BBB8';}
                    elseif($row['strTicketType']=='Vandalism'){$TicketColor = '#FD9EA1';}
                    elseif($row['strTicketType']=='Suspicious Persons'){$TicketColor =  '#C61A1F';}
                    $sqlRangers = "SELECT strFirstName, strLastName, intEmployeeId\n"
                        . "from employees\n"
                        . "where intSecurityLevel = '3'\n";
                        
                    $resultRangers = $conn->query($sqlRangers) or die("Query Rangers fail");
                   $ticketid=  $row['intTicketId'];
    	if($row['dtClosed'] == ''){ 
		$submit = "0px"; 
		$closed = '';	
		$reopen_close = '<a href="action_close_ticket.php?ticketid='.$ticketid.'" class="btn-close-reopen">CLOSE</a>';
	
		//'<button class="btn-close-reopen" type="button" name="myTicketButton" id="myTicketButton" onClick="closeTicket('.$row['intTicketId'].');">CLOSE</button>';

	}else{ 
	$submit =  "20px";
		$closed = $row['dtClosed'];

	
	$reopen_close = '<a href="action_reopen_ticket.php?ticketid='.$ticketid.'" class="btn-close-reopen">REOPEN</a>';

	//'<button class="btn-close-reopen" type="button" name="myTicketButton" id="myTicketButton" onClick="ReopenTicket('.$row['intTicketId'].');">REOPEN</button>';

	}
            ?>
            <!-- -->
    
            <tr style="border:2px solid grey;">
                <td class="image-table">
                    <?php if($row['bitUrgent'] == '1'){?>
                		<div class="circle-box"><div class="circle">!</div></div>
                	<?php };?>
                    <?php 
                            $filename = "Images_ticketSize/".$row['strImageFilePath'];
                            if(!file_exists($filename)){
                                $filename = "Images_ticketSize/no-image-available.png";
                            }
                        ?>

                     <span class="popup" >
                       <img src="<?php echo $filename;?>" style="width:40px;vertical-align:middle;"  onClick="ShowImagePopup(<?php echo $row['intTicketId'];?>);"  class="hoverImage">

                        <span class="popuptext" id="ticketPopup_<?php echo $row['intTicketId'];?>"><img src="<?php echo $filename;?>" style="max-width:100%;margin:auto;" alt="Ticket Image Not Found"></span>
                    </span>
                    
                </td>
                <td  style=" text-align:left;padding:20px;">
                    Ticket  #<?php echo $row['intTicketId']?>
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
                        <button class="btn-view-ticket" type="button" name="myTicketButton" id="myTicketButton" onClick="openTicket(<?php echo $row['intTicketId'] . ','.$row['gpsLat'].','.$row['gpsLat'];?>);">VIEW</button>
                        
                       <?php echo $reopen_close;?>

                    </div>
                </td>
                <!---
                <td>
                    
                    
                    <form method="get" action="action_assign_ticket.php">
                        <input type="hidden" name="intTicketId" value="<?php /* echo $row['intTicketId']?>">
                        <input type="hidden" name="currentPage" value="<?php echo $_SERVER['REQUEST_URI']?>">
                        <select name="assignedEmployee" onChange="this.form.submit();">
                            <?php /*
                                if($row[intEmployeeAssigned]== NULL){
                            ?>
                                <option value="%">Choose Employee</option>
                            <?php/*
                                }else{
                            ?>
                                <option value="<?php echo $row['intEmployeeAssigned']?>">
                                    <?php echo "".$row['strFirstName']." ".$row['strLastName']?>
                                </option>
                            <?php/*
                                }
                                
                                while($ranger = $resultRangers->fetch_array(MYSQLI_ASSOC)){ */
                            ?>   
                               
                                <option value="<?php //echo $ranger['intEmployeeId']?>">
                                    <?php // echo "".$ranger['strFirstName']." ".$ranger['strLastName']?>
                                </option>
                            <?php
                               // }
                            ?>
                        </select>
                    </form>
                    
                   
                </td>--->
            </tr><?php } ?>
        </table>
        
     <br/>





                
                
                
            </div>



    </div>
</div>



    


    
</div>
<br style="clear:both;"/>

<ul class="pagination"  style="background-color:#333;">

     <?php
    $pageno = $_COOKIE['page_number'];
    for ($x = 1; $x <= $total_pages; $x++) {
        if($pageno == $x){
            $class = 'class="active"';
        }else{
            $class = '';
        }
       echo '<li> <a onClick="FilterResults('.$x.');"'.$class.'>'.$x.'</a></li>';
    }?>

    
</ul>