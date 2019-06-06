<?php require_once("../Login_System/verifyAuth.php"); ?>
<?php include "../Dashboard_Pages/navBar.php"; ?>
<?php
require '../Mobile_Connections/vendor/autoload.php';
        include("../MySQL_Connections/config.php");
        
        use Kreait\Firebase\Factory;
        use Kreait\Firebase\ServiceAccount;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Maintenance Tickets</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

      <script src="../js/jquery-3.2.1.min.js"></script>
      <link rel="stylesheet" type="text/css" href=<?php echo $_COOKIE['colorCssLink']; ?>>

      <!---Ticket System CSS--->
      <link rel="stylesheet" href="../Ticket_System_v2/ticket_system.css">
      
      <!---Bootrap for the Modals--->
      <link rel="stylesheet" href="./bootstrap.css">
      <script src="../Push_Notifications/customBootstrap/js/bootstrap.min.js"></script>
      
      <!---Javascript file to use Google Maps API--->
      <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVZ9qSBrT-dnmrBaxkX2PzWbfmxv6xZgM&v=3&sensor=true&libraries=visualization"></script>
      
      
      <!---Javascript to open & Close Modals, and populate the Google Maps with the Markers--->
            <script src=/Ticket_System_v2/functions.js></script>


    <script>
        function AllowAssign(){
            var btnAssign1 = document.getElementById("btnAssign1");
            var btnAssign2 = document.getElementById("btnAssign2");

            var empAssign = document.getElementById("assignedEmployee").value;
            if(empAssign == '%'){
                btnAssign1.style.opacity= 0.6;
                 btnAssign1.style.cursor= "not-allowed";
                 btnAssign1.disabled = true;
                 
                 btnAssign2.style.opacity= 0.6;
                 btnAssign2.style.cursor= "not-allowed";
                 btnAssign2.disabled = true;
            }else{
                btnAssign1.style.opacity= 1;
                btnAssign1.style.cursor= "default";
                btnAssign1.disabled = false;

                btnAssign2.style.opacity= 1;
                btnAssign2.style.cursor= "default";
                btnAssign2.disabled = false;
            }
        };
        
        
        function ShowType(ticketType){
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            
            xmlhttp.onreadystatechange = function() {
    
                if (this.readyState == 4 && this.status == 200) {
                    $("txtLoading").fadeOut("slow");
    
                    document.getElementById("TicketList").innerHTML = this.responseText;
    
                }else if (this.readyState == 4 && this.status != 200) {
                    document.getElementById("TicketList").innerHTML = "There was a problem loading the tickets.";
                }
                                                      $("txtLoading").fadeOut("slow");
    
    
            }
    
            xmlhttp.open("GET","get_unassigned_tickets.php?type="+ticketType,true);
                        $(".txtLoading").fadeOut("slow");
    
            xmlhttp.send();
        }
        
        
        
    </script>
</head>
<!--onLoad="getTheGraphs();"-->
<body class="genericBody" onLoad="ShowType('High Water');AllowAssign();">

            <div id="txtLoading" class="txtLoading"></div>

<div class="contentBox">
            <!---<div id="txtLoading" class="txtLoading"></div>--->
 <!---View Ticket Modal Window--->
      <div id="myTicket" class="modal" style="display:none;"></div>


<?php date_default_timezone_set('EST');?>

<?php 
        include("../MySQL_Connections/config.php");

   
    
    $sqlTypes = "SELECT strTicketType\n"
    . "from maintenancetickets\n"
    . "left join tickettypes on tickettypes.intTypeId = maintenancetickets.intTypeId\n"
    . "WHERE strEmployeeAssigned IS NULL and strTicketType IS NOT NULL GROUP BY strTicketType ";
   
    $resultTicketTypes = $conn->query($sqlTypes) or die("Query fail 1");
    $resultTypes = $conn->query($sqlTypes) or die("Query fail 2");

   $serviceAccount = ServiceAccount::fromJsonFile('../Mobile_Connections/firebase-adminsdk.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->create();
        $auth = $firebase->getAuth();
        
        $employeesSql = "SELECT * FROM `firebaseusers` WHERE `intSecurityLevel` < 4";
        $employeesResults = $conn->query($employeesSql);

    // $sqlRangers = "SELECT strFirstName, strLastName, intEmployeeId\n"
    //                     . "from fi\n";
                        
    //                 $resultRangers = $conn->query($sqlRangers) or die("Query Rangers fail");
                    
                $sqlRangerTickets = "SELECT count(intTicketId) as assignedTickets, strEmployeeAssigned, strEmployeeName\n"
                    . "from maintenancetickets\n"
                    . "left join firebaseusers on firebaseusers.userId = maintenancetickets.strEmployeeAssigned\n"
                    . "where dtClosed IS NULL and strEmployeeAssigned IS NOT NULL GROUP BY strEmployeeAssigned LIMIT 0, 30 ";          
               
                $resultRangerTickets = $conn->query($sqlRangerTickets) or die("Query fail 3");
                
?>

     <div class="assign_box">

    <form method="post" action="action_assign_ticket.php">
        <div>
            <div class="assign_choose_employee">
                <br/>
                <span>Assign Tickets to Employees </span><br/><br/>
                Choose Employee: 
                <select name="assignedEmployee" id="assignedEmployee" onChange="AllowAssign();">
                    <?php 
                                 if ($row['strEmployeeAssigned']!=''){
                                     echo "<option value='".$row['strEmployeeAssigned']."'>".$EmployeeName."</option>";
                                 }else{
                                     echo "<option value='%'>Select Employee</option>";
                                 }
                                $employeesSql = "SELECT * FROM `firebaseusers` WHERE `intSecurityLevel` < 4";
                                $employeesResults = $conn->query($employeesSql);
                                $employeesObj = array();
                                while ($row2 = $employeesResults->fetch_array(MYSQLI_ASSOC)) {
                                        $user = $auth->getUser($row2['userId']);
                                        $userId = $user->uid;
                                        $displayName = $user->displayName;
                                        echo "<option value='$userId'> $displayName</option>";
                                }
                                ?>
                </select>
    
            </div>
        
    <br/><br/>
            <div class="wrapper">
                <ul class="assign_ranger_counts">
                    <?php while($ranger = $resultRangerTickets->fetch_array(MYSQLI_ASSOC)){ ?>
                        <li>
                            <?php echo $ranger['strEmployeeName'];?>
                            <br/>
                            <?php echo $ranger['assignedTickets'];?>
                        </li>
                    <?php
                        }
                    ?>
                </ul>
                
            </div>
        
            <br/>
            <div class="typesList">
                <ul>
                    <?php while($type = $resultTicketTypes->fetch_array(MYSQLI_ASSOC)){?>
                    <li onClick="ShowType('<?php echo $type['strTicketType'];?>');" >
                        <?php  
                                        $colorArray = explode(",",$_COOKIE['colorArray']);

                        if(isset($colorArray)) {
                		switch($type['strTicketType']){
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
                            echo "<span style='background-color:".$TicketColor."'>".$type['strTicketType']."</span>";?>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <br/>
        <div>
                <button name="AssignTickets" id="btnAssign1" type="submit" class="assign_btn">Assign Tickets</button>
    
            </div>
            <div id="TicketList"></div>
        
        
         <div>
                <button name="AssignTickets" id="btnAssign2" type="submit" class="assign_btn">Assign Tickets</button>
    
            </div>
        <br/><br/>
          
    
    
    
    
                    
                    
                    
</form>
</div>

    </div>
</div>
</body>


</html>
