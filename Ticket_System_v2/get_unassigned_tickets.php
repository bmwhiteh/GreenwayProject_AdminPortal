 <?php 
     include("../MySQL_Connections/config.php");

 
    $typeSelected = $_GET['type'];
     $sqlTickets = "SELECT strTicketType, intTicketId, strDescription, dtSubmitted, strTitle, strImageFilePath, gpsLat,bitUrgent, bitMobileDisplay, gpsLong\n"
                    . "from maintenancetickets\n"
                    . "left join tickettypes on tickettypes.intTypeId = maintenancetickets.intTypeId\n"
                    . "where dtClosed IS NULL and strEmployeeAssigned IS NULL and strTicketType = '".$typeSelected . "' LIMIT 0, 30 ";          
                    
            
               
                $result = $conn->query($sqlTickets) or die("Query fail");
?>
        <script src=/Ticket_System_v2/functions.js></script>
        <input type="hidden" name="typeSelected" value="<?php echo $typeSelected;?>">
        <dl class="unassignedList">
            <!--Get the tickets for this ticket type-->
                            <ul>
                                <li class="unassignedType"><?php echo $typeSelected;?></li>
                               <li class="unassignedSpace">&nbsp;</li>
                               <li class="unassignedSpace">&nbsp;</li>
                               
                               <li class="unassignedBtns">
                                     
                                    <label>
                                        Assign
                                    </label>
                                    <label>
                                        Notify
                                    </label>
                                    <label>
                                        Urgent
                                    </label>
                               </li>
                            </ul>
            
            <?php    while($ticket = $result->fetch_array(MYSQLI_ASSOC)){ 
                 
                
            ?>

               
                       
                   <div id="assignDiv">
                       <div>
                           <ul>
                               <li class="unassignedTicketNumber"> Ticket #<?php echo $ticket['intTicketId']?></li>
                               <li class="unassignedTicketTile"><p><?php echo $ticket['strTitle']?></p></li>
                               <li class="unassignedTicketTile"><p><?php echo $ticket['strDescription']?></p></li>
                               
                               <li class="unassignedCheckboxes">
                                   <span>
            	                        <button class="ticketView" type="button" name="myTicketButton" id="myTicketButton<?php echo $ticket['intTicketId'];?>" onClick="openTicket(<?php echo $ticket['intTicketId'] .','.$ticket['gpsLat'].','.$ticket['gpsLong'];?>);">VIEW</button>
                                    </span>  
                                    <label class="container-chkbox">
                                      <input type="checkbox" name="assign[]" value="<?php echo $ticket['intTicketId']?>">
                                      <span class="checkmark1"></span>
                                    </label>
                                    <label class="container-chkbox">
                                      <input type="checkbox" name="notification[]" onclick="flipNotify(<?php echo $ticket['intTicketId']?>)" value="<?php echo $ticket['intTicketId']?>"<?php if ($ticket['bitMobileDisplay'] == '1'){echo "checked";}?>>
                                      <span class="checkmark2"></span>
                                    </label>
                                    
                                    <label class="container-chkbox">
                                      <input type="checkbox" name="urgent[]" onclick="flipUrgent(<?php echo $ticket['intTicketId']?>)" value="<?php echo $ticket['intTicketId']?>"<?php if ($ticket['bitUrgent'] == '1'){echo "checked";}?>>
                                      <span class="checkmark3"></span>
                                    </label>
                               </li>
                              
                           </ul>
                               

                       </div>
                       
                    </div>
                </dt>
           <?php } ?> 
        </dl>
                    <br/>
           