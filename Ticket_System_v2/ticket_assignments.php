<?php require_once("../Login_System/verifyAuth.php"); ?>
<?php include "../Dashboard_Pages/navBar.php"; ?>
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
        <style>
            .txtLoading {
                position: fixed;
                left: 0px;
                top: 0px;
                width: 100%;
                height: 100%;
                z-index: 9999;
                background: url('/Ticket_System_v2/Iconography/loadingGIF.gif') 50% 50% no-repeat rgb(249,249,249);
                opacity: .8;
            }
            /* Customize the label (the container) */
            .container-chkbox {
              /*display: block;*/
              position: relative;
              padding-left: 35px;
              margin-bottom: 12px;
              cursor: pointer;
              font-size: 22px;
              -webkit-user-select: none;
              -moz-user-select: none;
              -ms-user-select: none;
              user-select: none;
            }
            
            
            
            /* Hide the browser's default checkbox */
            .container-chkbox input {
              position: absolute;
              opacity: 0;
              cursor: pointer;
            }
            /* Create a custom checkbox */
            .checkmark1 {
              position: absolute;
              top: 0;
              left: 0;
              height: 35px;
              width: 35px;
              background-color: #eee;
            }
            
            /* Create a custom checkbox */
            .checkmark2 {
              position: absolute;
              top: 0;
              left: 0;
              height: 35px;
              width: 35px;
              background-color: #eee;
            }
            
            /* Create a custom checkbox */
            .checkmark3 {
              position: absolute;
              top: 0;
              left: 0;
              height: 35px;
              width: 35px;
              background-color: #eee;
            }
            
            
            /* When the checkbox is checked, add a blue background */
            .container-chkbox input:checked ~ .checkmark1 {
              background-color: #194400;
            }
            
            .container-chkbox input:checked ~ .checkmark2 {
              background-color: #37721b;
            }
            
            .container-chkbox input:checked ~ .checkmark3 {
              background-color: red;
            }
            
            /* Create the checkmark/indicator (hidden when not checked) */
            .checkmark1:after, .checkmark2:after, .checkmark3:after {
              content: "";
              position: absolute;
              display: none;
            }
            
            /* Show the checkmark when checked */
            .container-chkbox input:checked ~ .checkmark1:after , .container-chkbox input:checked ~ .checkmark2:after  , .container-chkbox input:checked ~ .checkmark3:after{
              display: block;
            }
            
            /* Style the checkmark/indicator */
            .container-chkbox .checkmark1:after,.container-chkbox .checkmark2:after,.container-chkbox .checkmark3:after {
              left: 9px;
              top: 5px;
              width: 12px;
              height: 20px;
              border: solid white;
              border-width: 0 6px 6px 0;
              -webkit-transform: rotate(45deg);
              -ms-transform: rotate(45deg);
              transform: rotate(45deg);
            }
            
            
            
            .typesList{
                margin-left:50px;
                text-align:center;
            }
            .typesList li{
                padding: 10px;
                text-align:center;
            }
        </style>

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

<div class="theBox" style="padding:10px;">
            <!---<div id="txtLoading" class="txtLoading"></div>--->
 <!---View Ticket Modal Window--->
      <div id="myTicket" class="modal" style="display:none;"></div>


<?php date_default_timezone_set('EST');?>

<?php 
        include("../MySQL_Connections/config.php");

   
    
    $sqlTypes = "SELECT strTicketType\n"
    . "from maintenancetickets\n"
    . "left join tickettypes on tickettypes.intTypeId = maintenancetickets.intTypeId\n"
    . "WHERE intEmployeeAssigned IS NULL and strTicketType IS NOT NULL GROUP BY strTicketType ";
   
    $resultTicketTypes = $conn->query($sqlTypes) or die("Query fail");
    $resultTypes = $conn->query($sqlTypes) or die("Query fail");

    
    $sqlRangers = "SELECT strFirstName, strLastName, intEmployeeId\n"
                        . "from employees\n"
                        . "where intSecurityLevel = '3'\n";
                        
                    $resultRangers = $conn->query($sqlRangers) or die("Query Rangers fail");
                    
                $sqlRangerTickets = "SELECT count(intTicketId) as assignedTickets, strUsername\n"
                    . "from maintenancetickets\n"
                    . "left join employees on employees.intEmployeeId = maintenancetickets.intEmployeeAssigned\n"
                    . "where dtClosed IS NULL and intEmployeeAssigned IS NOT NULL GROUP BY intEmployeeAssigned LIMIT 0, 30 ";          
                    
            
               
                $resultRangerTickets = $conn->query($sqlRangerTickets) or die("Query fail");
                
?>

     <div style="border:2px solid grey; background-color:white; border-radius: 10px; width:80%;  margin:auto; vertical-align:top; text-align:center;">

    <div style=" margin-top:20px; margin-bottom:20px;">
    <form method="post" action="action_assign_ticket.php">
        <div>
            <div style="margin:auto; font-size: 22px;">
                <br/>
                <span style="text-decoration: underline">Assign Tickets to Employees </span><br/><br/>
                Choose Employee: 
                <select name="assignedEmployee" id="assignedEmployee" onChange="AllowAssign();">
                    <?php 
                        if($row[intEmployeeAssigned]== NULL){
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
                       
                        <option value="<?php echo $ranger['intEmployeeId']?>;">
                            <?php echo "".$ranger['strFirstName']." ".$ranger['strLastName']?>
                        </option>
                    <?php
                        }
                    ?>
                </select>
    
            </div>
        
    <br/><br/>
            <div class="wrapper">
                <ul class="ranger-counts" style="background-color:white;margin:auto;text-align:center;">
                    <?php while($ranger = $resultRangerTickets->fetch_array(MYSQLI_ASSOC)){ ?>
                        <li style="background-color:white">
                            <?php echo $ranger['strUsername'];?>
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
                        <?php   if($type['strTicketType']=='High Water')            {$TicketColor = 'color1';}
                                elseif($type['strTicketType']=='Pothole')           {$TicketColor = 'color2';}
                                elseif($type['strTicketType']=='Tree/Branch')       {$TicketColor = 'color3';}
                                elseif($type['strTicketType']=='Trash Full')        {$TicketColor = 'color4';}
                                elseif($type['strTicketType']=='Litter')            {$TicketColor =  'color5';}
                                elseif($type['strTicketType']=='Overgrown Brush')   {$TicketColor =  'color6';}
                                elseif($type['strTicketType']=='Vandalism')         {$TicketColor =  'color7';}
                                elseif($type['strTicketType']=='Suspicious Persons'){$TicketColor =  'color8';}
                                elseif($type['strTicketType']=='Other')             {$TicketColor =  'color9';}
                            echo "<span class='".$TicketColor."' style='padding: 5px;'>".$type['strTicketType']."</span>";?>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <br/>
        <div>
                <button name="AssignTickets" id="btnAssign1" type="submit" style="width:100px; height:50px;margin-right: 100px;margin-left: 100px;">Assign Tickets</button>
    
            </div>
            <div id="TicketList"></div>
        
        
         <div>
                <button name="AssignTickets" id="btnAssign2" type="submit" style="width:100px; height:50px;margin-right: 100px;margin-left: 100px;">Assign Tickets</button>
    
            </div>
        <br/><br/>
          
    
    
    
    
                    
                    
                    
        </div>
</form>
</div>

    </div>
</div>
</body>


</html>
