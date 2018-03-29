 <?php 
     include("../MySQL_Connections/config.php");

 
    $typeSelected = $_GET['type'];
     $sqlTickets = "SELECT strTicketType, intTicketId, strDescription, dtSubmitted, strTitle, strImageFilePath, gpsLat,bitUrgent, gpsLong\n"
                    . "from maintenancetickets\n"
                    . "left join tickettypes on tickettypes.intTypeId = maintenancetickets.intTypeId\n"
                    . "where dtClosed IS NULL and intEmployeeAssigned IS NULL and strTicketType = '".$typeSelected . "' LIMIT 0, 30 ";          
                    
            
               
                $result = $conn->query($sqlTickets) or die("Query fail");
?>

        <input type="hidden" name="typeSelected" value="<?php echo $typeSelected;?>">
        <dl style="margin-left: 100px;margin-right:100px">
            <!--Get the tickets for this ticket type-->
                            <ul>
                                <li style="font-size:22px;margin-left: 10px; margin-top:0px;text-align:left;"><?php echo $typeSelected;?></li>
                               <li style=" padding:10px; overflow:visisble">&nbsp;</li>
                               <li style=" padding:10px;overflow:visible">&nbsp;</li>
                               
                               <li style="float:right;">
                                     
                                    <label style="font-size: 20px;">
                                        Assign
                                    </label>
                                    <label  style="font-size: 20px;">
                                        Notify
                                    </label>
                                    <label  style="font-size: 20px;">
                                        Urgent
                                    </label>
                               </li>
                            </ul>
            
            <?php    while($ticket = $result->fetch_array(MYSQLI_ASSOC)){ 
                 
                
            ?>

               
                       
                   <div id="assignDiv">
                       <div>
                           <ul>
                               <li style="text-indent: 25px; padding:10px;"> Ticket #<?php echo $ticket['intTicketId']?></li>
                               <li style=" padding:10px; overflow:visisble"><p><?php echo $ticket['strTitle']?></p></li>
                               <!------><li style=" padding:10px;overflow:visible"><p><?php echo $ticket['strDescription']?></p></li>
                               <!--<li style="float:right;padding:5px;">
                                   <span style="border:2px solid purple; background-color:purple; font-weight:bold;padding:5px; vertical-align:middle;">
            	                        <button class="btn-view-ticket" style="background-color:purple;border:2px solid purple;" type="button" name="myTicketButton" id="myTicketButton" onClick="openTicket(<?php echo $row['intTicketId'];?>);">DETAILS</button>
                                    </span>  
                               </li>
                               <li style="float:right;padding:5px;">
                                   <span style="border:2px solid orange; background-color:orange; font-weight:bold;padding:5px; vertical-align:middle;">
            	                        <button class="btn-view-ticket" style="background-color:orange;border:2px solid orange;" type="button" name="myTicketButton" id="myTicketButton" onClick="openTicket(<?php echo $row['intTicketId'];?>);">IMAGE</button>
                                    </span>  
                               </li>
                               <li style="float:right;padding:5px;">
                                   <span style="border:2px solid blue; background-color:blue; font-weight:bold;padding:5px; vertical-align:middle;">
            	                        <button class="btn-view-ticket" style="border:2px solid blue; background-color:blue;" type="button" name="myTicketButton" id="myTicketButton" onClick="openTicket(<?php echo $row['intTicketId'];?>);">MAP</button>
                                    </span>  
                               </li>-->
                               <li style="float:right;padding:15px;">
                                   <span style="border:2px solid green; background-color:green; font-weight:bold;padding:5px; vertical-align:middle;">
            	                        <button class="btn-view-ticket" type="button" name="myTicketButton" id="myTicketButton<?php echo $ticket['intTicketId'];?>" onClick="openTicket(<?php echo $ticket['intTicketId'] .','.$ticket['gpsLat'].','.$ticket['gpsLong'];?>);">VIEW</button>
                                    </span>  
                                    <label class="container-chkbox" style="margin-left:10px;">
                                      <input type="checkbox" name="assign[]" value="<?php echo $ticket['intTicketId']?>">
                                      <span class="checkmark1"></span>
                                    </label>
                                    <label class="container-chkbox" style="margin-left:10px;">
                                      <input type="checkbox" name="notification[]" value="<?php echo $ticket['intTicketId']?>">
                                      <span class="checkmark2"></span>
                                    </label>
                                    
                                    <label class="container-chkbox" style="margin-left:10px;">
                                      <input type="checkbox" name="urgent[]" value="<?php echo $ticket['intTicketId']?>"<?php if ($ticket['bitUrgent'] == '1'){echo "checked";}?>>
                                      <span class="checkmark3"></span>
                                    </label>
                               </li>
                               
                               <!--
                               <li style="float:right;padding:5px;">
                                   <span style="border:2px solid red; background-color:red; font-weight:bold;padding:5px; vertical-align:middle;">
            	                        <button class="btn-view-ticket" style="border:2px solid red; background-color:red;" type="button" name="myTicketButton" id="myTicketButton" onClick="openTicket(<?php echo $row['intTicketId'];?>);">ASSIGN TO BMWHITEH</button>
                                    </span>  
                               </li>-->
                           </ul>
                               

                       </div>
                       
                    </div>
                </dt>
           <?php } ?> 
        </dl>
                    <br/>
           