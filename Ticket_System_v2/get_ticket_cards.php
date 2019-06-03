

<?php 
	date_default_timezone_set('EST');

    include("../MySQL_Connections/config.php");

$no_of_records_per_page = 20;

$pageno = $_COOKIE['page_number'];
$offset = ($pageno-1) * $no_of_records_per_page;

if ($_COOKIE['ticket_status'] == "closed"){
	$status = 'where dtClosed IS NOT NULL';
}
else if ($_COOKIE['ticket_status'] == "all"){
	$status = 'where (dtClosed IS NOT NULL or dtClosed IS NULL)';
}else{
	$status = 'where dtClosed IS NULL';
}

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
	$assigned = $_GET['assigned'];
	if($assigned != 'all'){
		
		$assignedEmployee = "AND strEmployeeAssigned = '".$_COOKIE['user']."'";
		$startingLimit = 0;
		$pageno = 1;
		setcookie("page_number", $pageno, time() + (86400 * 30), "/"); // 86400 = 1 day

	}else{
		$assignedEmployee = '';
	}
    $stop = $no_of_records_per_page+$startingLimit;
	$sql = "SELECT strTicketType, intTicketId, strDescription, dtSubmitted, dtClosed, strTitle, strImageFilePath, bitUrgent, gpsLat, gpsLong\n"
	. "from maintenancetickets\n"
	. "left join tickettypes on tickettypes.intTypeId = maintenancetickets.intTypeId\n"
	. $status. " ".$assignedEmployee." LIMIT $startingLimit, $stop";   
	$result = $conn->query($sql) or die($sql);
}

$colorArray = explode(",",$_COOKIE['colorArray']);


echo "<div class='cardsList'>";

while($row = $result->fetch_array(MYSQLI_ASSOC)){ 
	
	if(isset($colorArray)) {
		switch($row['strTicketType']){
		case 'High Water':
			$TicketColor = $colorArray[0];
			break;
		case 'Pothole':
			$TicketColor = $colorArray[1];
			break;
		case 'Tree/Branch':
			$TicketColor = $colorArray[2];
			break;
		case 'Trash Full':
			$TicketColor = $colorArray[3];
			break;
		case 'Litter':
			$TicketColor = $colorArray[4];
			break;
		case 'Overgrown Brush':
			$TicketColor = $colorArray[5];
			break;
		case 'Vandalism':
			$TicketColor = $colorArray[6];
			break;
		case 'Suspicious Persons':
			$TicketColor = $colorArray[7];
			break;
		case 'Other':
			$TicketColor = $colorArray[8];
			break;
		default:
			break;
		}
	}
	
	
	
	
	$ticketid =$row['intTicketId'];
	
	if($row['dtClosed'] == ''){ 
		$submit = "0px"; 
		$closed = '';	
		$reopen_close = '<a href="action_close_ticket.php?ticketid='.$ticketid.'" class="ticketClose">CLOSE</a>';
	
		//'<button class="btn-close-reopen" type="button" name="myTicketButton" id="myTicketButton" onClick="closeTicket('.$row['intTicketId'].');">CLOSE</button>';

	}else{ 
	$submit =  "20px";
		$closed = $row['dtClosed'];

	
	$reopen_close = '<a href="action_reopen_ticket.php?ticketid='.$ticketid.'" class="ticketClose">REOPEN</a>';

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
	<div class="card-type" ><span style="background-color:<?php echo $TicketColor?>;"><?php echo $row['strTicketType']?></span></div>
	<div class="card-title"><?php echo $row['strTitle']?></div>
	<div class="card-desc"><?php echo $row['strDescription']?></div>
	<div class="card-image">
		  <?php 
	        $filename = "Images_cardSize/".$row['strImageFilePath'];
	        if(!file_exists($filename) || $row['strImageFilePath'] == ''){
	            $filename = "Images_cardSize/no-image-available.png";
	        }
	    ?>
	        <img src="<?php echo $filename;?>" alt="Ticket Image Not Found" >       
	</div>
	<div  class="card-date" style="margin:0px 0px <?php echo $submit ?> 0px;">Submitted: <?php echo $row['dtSubmitted']?></div>
	<div class="card-date-closed">
		Closed: <?php echo $closed?>
	</div>

<div class="card-action">
	<!---View Button--->
	<button class="ticketView" type="button" name="myTicketButton" id="myTicketButton" 
	onClick="openTicket(<?php echo $row['intTicketId'].",".$row['gpsLat'].",".$row['gpsLong'];?>);">VIEW</button>
		
<?php echo $reopen_close;?>


</div>

</div>
<?php ;} ?>

</div>



</div>



</div>
</div>



<br style="clear:both;"/>

<ul class="pagination">
    
    
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


