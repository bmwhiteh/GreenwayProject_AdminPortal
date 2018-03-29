

<?php 
	date_default_timezone_set('EST');

    include("../MySQL_Connections/config.php");

$no_of_records_per_page = 20;

$pageno = $_COOKIE['page_number'];
$offset = ($pageno-1) * $no_of_records_per_page;

$status = 'where dtClosed IS NULL';
if ($_COOKIE['ticket_status'] == "closed"){$status = 'where dtClosed IS NOT NULL';}
else if ($_COOKIE['ticket_status'] == "all"){$status = '';}

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
    
	$sql = "SELECT strTicketType, intTicketId, strDescription, dtSubmitted, dtClosed, strTitle, strImageFilePath, bitUrgent\n"
	. "from maintenancetickets\n"
	. "left join tickettypes on tickettypes.intTypeId = maintenancetickets.intTypeId\n"
	. $status. " LIMIT $startingLimit, $no_of_records_per_page";       
	$result = $conn->query($sql) or die($sql);

}




while($row = $result->fetch_array(MYSQLI_ASSOC)){ 
	if($row['strTicketType']=='Litter'){$TicketColor = '#432021';}
	elseif($row['strTicketType']=='Overgrown Brush'){$TicketColor = '#3DB737';}
	elseif($row['strTicketType']=='High Water'){$TicketColor = '#75BBB8';}
	elseif($row['strTicketType']=='Vandalism'){$TicketColor = '#FD9EA1';}
	elseif($row['strTicketType']=='Suspicious Persons'){$TicketColor =  '#C61A1F';}
	$ticketid =$row['intTicketId'];
	
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

<div class="card-1">
	<?php if($row['bitUrgent'] == '1'){?>
		<div class="circle-box"><div class="circle">!</div></div>
	<?php };?>
	<div class="card-number">
		Ticket #<?php echo $row['intTicketId']?>
	</div>
	<div class="card-type" ><span class="<?php echo $TicketColor?>;"><?php echo $row['strTicketType']?></span></div>
	<div class="card-title"><?php echo $row['strTitle']?></div>
	<div class="card-desc"><?php echo $row['strDescription']?></div>
	<div class="card-image" style="width:70%;margin-left:15%;">
		  <?php 
	        $filename = "Images_cardSize/".$row['strImageFilePath'];
	        if(!file_exists($filename) || $row['strImageFilePath'] == ''){
	            $filename = "Images_cardSize/no-image-available.png";
	        }
	    ?>
	        <img src="<?php echo $filename;?>" style="margin:auto;width:100%;height:100%;" alt="Ticket Image Not Found" >       
	</div>
	<div  class="card-date" style="margin:0px 0px <?php echo $submit ?> 0px;">Submitted: <?php echo $row['dtSubmitted']?></div>
	<div class="card-date" style="margin:0px 0px 20px 0px">
		Closed: <?php echo $closed?>
	</div>

<div class="card-action">
	<!---View Button--->
	<button class="btn-view-ticket" type="button" name="myTicketButton" id="myTicketButton" onClick="openTicket(<?php echo $row['intTicketId'];?>);">VIEW</button>
		
<?php echo $reopen_close;//if($row['dtClosed'] ==''){?>

	<!---Reopen Button
	<button class="btn-close-reopen" type="button" name="myTicketButton" id="myTicketButton" onClick="closeTicket(<?php echo $row['intTicketId'];?>);">CLOSE</button>
--->
<?php //}else{?>
	<!--Close
	<button class="btn-close-reopen" type="button" name="myTicketButton" id="myTicketButton" onClick="ReopenTicket(<?php echo $row['intTicketId'];?>);">REOPEN</button>
--><?php //}?> 


</div>

</div>
<?php ;} ?>






</div>



</div>
</div>



<br style="clear:both;"/>

<ul class="pagination" style="background-color:#333;">
    
    
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


