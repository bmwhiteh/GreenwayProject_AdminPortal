<?php 
    /*
    *   Author: Bailey Whitehill
    *   Description: This will provide all of the ticket information in a popup rather than 
                    requiring the user to navigate to a different screen
    *
    */

        include("../MySQL_Connections/config.php");
         

    $id = $_POST['ticketid'];
    
    //Find all the ticket info given the ticketid
    $sqlGetTicket = "SELECT * FROM `maintenancetickets` LEFT JOIN `tickettypes` ON tickettypes.intTypeid = maintenancetickets.inttypeid WHERE `intTicketId` = '".$id."'";
    $resultGetTicket = $conn->query($sqlGetTicket);
    $row = $resultGetTicket->fetch_array(MYSQLI_ASSOC);
    
    

    //Find all of the ticket notes given the ticketid
    $sqlNotes = "SELECT *\n"
            . "from ticketnotes\n"
            . "left join employees on employees.intEmployeeId = ticketnotes.intEmployeeId\n"
            . "WHERE `intTicketId` = '".$id."' \n"
            . "ORDER BY `noteId` desc";
    $resultNotes = $conn->query($sqlNotes) or die("Notes Query Failed"); 
    
    //Get the name of the user that submitted it
    $sqlUser = "SELECT `strFirstName`, `strLastName` FROM users WHERE intUserId =".$row['intUserId'];
    $resultUser = $conn->query($sqlUser) or die($sql."\nQuery fail".$id);
    $User = $resultUser->fetch_array(MYSQLI_ASSOC);
    
    //Get the name of the employee assigned to the ticket
    $EmployeeName = "Not Assigned";
    if($row['intEmployeeAssigned']!=''){
        $sqlEmployeeName = "SELECT `strFirstName`, `strLastName` FROM employees WHERE intEmployeeId =".$row['intEmployeeAssigned'];
        $resultEmployeeName = $conn->query($sqlEmployeeName);
        $EmployeeNameResult = $resultEmployeeName->fetch_array(MYSQLI_ASSOC);
        $EmployeeName = $EmployeeNameResult['strFirstName'] . " " . $EmployeeNameResult[strLastName];
    }
    
    //get the security level of the current user to determine if they can delete ticket notes
    $sqlSecurityLevel = "SELECT intSecurityLevel\n"
            . "from employees\n"
            . "WHERE `strUsername` = '".$_COOKIE['user']."' \n"
            . "LIMIT 1";
            
    $resultSecurityLevel = $conn->query($sqlSecurityLevel) or die("Find Security Level Query Failed"); 
                
    	$ticket = $row['intTicketId'];

                                            
    if($row['dtClosed'] == ''){ 
		$submit = "0px"; 
		$closed = '';	
		$reopen_close = '<a href="action_close_ticket.php?ticketid='.$ticket.'" class="ticketView"  style="padding:10px;">CLOSE</a>';
	

	}else{ 
	    $submit =  "20px";
		$closed = $row['dtClosed'];

	
	    $reopen_close = '<a href="action_reopen_ticket.php?ticketid='.$ticket.'" class="ticketView">REOPEN</a>';


	}
	
	
	if($row['bitUrgent']=='1'){
	    $switch = '0';
	    $words = "NON-";
	}else{
	    $switch = '1';
	    $words = "";
	}
	$urgentBtn = '<a href="action_set_urgent.php?ticketid='.$ticket.'&urgent='.$switch.'" class="btn-close-reopen" style="padding:10px; background-color:red; border-color:red;">CHANGE TO '.$words.'URGENT</a>';
    
    $sqlRangers = "SELECT strFirstName, strLastName, intEmployeeId\n"
                        . "from employees\n";
                        
    $resultRangers = $conn->query($sqlRangers) or die("Query Rangers fail");
                    
?>

    <!-- Modal content -->
    <div id="myTicketView" class="modal-content">
        
        
        <span id="closeTicket" class="close" onClick="closeTicket('myTicketView');">&times;</span>
        
        
        <h1 class="modal-title" style="margin-top:0px; vertical-aligh:middle; text-align: center;" id="MapTicketId">Ticket Id #: <?php echo $id?></h1>
        
            
        <div class="modal-body">
        
       
            <table style=" text-align:left;" >
                
                <tbody>
                <!--Ticket Title & Submitted By-->
                <tr>
                    <th style="width:15%">Title:</th>
                    <td style="width:15%">
                        <?php echo $row['strTitle']; ?>
                    </td>
                    <td style="width:10%;">&nbsp;</td>
                    <th style="width:15%">Submitted By: </th>
                    <td style="width:15%">
                        <?php echo $User['strFirstName']." ".$User['strLastName']; ?>
                    </td>
                </tr>
                
                <!--Ticket Type and Date Submitted-->
                <tr>
                    <th>Ticket Type: </th>
                    <td>
                        <?php echo $row['intTypeId'] . " - " . $row['strTicketType'] ?>
                    </td>
                    <td style="width:20px;">&nbsp;</td>
                    <th>Date Submitted: </th>
                    <td>
                        <?php echo $row['dtSubmitted'] ?>
                    </td>
                </tr>
        
        
                <!--Description and Assigned Employee-->
                <tr>
                    <th>Description: </th>
                    <td>
                        <?php echo $row['strDescription'] ?>
                    </td>
                    <td style="width:20px;">&nbsp;</td>
                    <th>Assigned Employee: </th>
                    <td>
                        <form>
                            <select name="assignedEmployee" id="assignedEmployee" onChange="ReassignTicket(<?php echo $row['intTicketId'];?>);">
                                <?php 
                                if ($row['intEmployeeAssigned']!=''){
                                    echo "<option value='".$row['intEmployeeAssigned']."'>".$EmployeeName."</option>";
                                }else{
                                    echo "<option value='%'>Select Employee</option>";
                                }
                                while($ranger = $resultRangers->fetch_array(MYSQLI_ASSOC)){ 
                                    echo "<option value='". $ranger['intEmployeeId']."'>" .$ranger['strFirstName']." ".$ranger['strLastName']."</option>";
                                }
                                ?>
                            </select>
                        </form>
                    </td>
                </tr>
                
                <!--Urgent Flag-->
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td style="width:20px;">&nbsp;</td>
                    <th>Urgent: </th>
                    <td>
                        <?php
                            if($row['bitUrgent'] == 0){
                                echo "No";
                            }
                            else{
                                echo "Yes";
                            }
                        ?>
                    </td>
                </tr>
                
                <!--Image and Map Headers-->
                <tr>
                    <th colspan="2">Image:</th>
                    <td style="width:20px;">&nbsp;</td>
                    <th colspan="2">Location: </th>
                    
                </tr>
                
                <!--Image and Map-->
                <tr>
                    <td colspan="2" style="text-align:center;width:70%;margin-left:15%;">
                            <?php 
                            $filename = "../Ticket_System_v2/Images_ticketSize/".$row['strImageFilePath'];
                            if(!file_exists($filename)){
                                $filename = "/Ticket_System_v2/Images_ticketSize/no-image-available.png";
                            }
                        ?>
                            <img src="<?php echo $filename;?>" style="margin:auto;width:80%;" alt="Ticket Image NOT Found">
                    </td>
                    <td style="width:30px;">&nbsp;</td>
                    
                    <td colspan="2" style="width:30%;">
                        
                        <div id="mapBucket" class="mapBucket"></div>

                
                        
                    </td>
                    
                </tr>
                
                <!---Allow the User to Close or Reopen a Closed Ticket--->
                <tr>
                    <td colspan="2" style="padding:15px;">
                        <div style="display:inline-block;">
                        <ul>
                            <li>
                                <?php echo $reopen_close;?>
                            </li>
                            <li>&nbsp;</li>
                            <li><?php echo $urgentBtn;?></li>
                        </ul>
                        
                        
                        </div>
                        
                    </td>
                    <td colspan="3">&nbsp;</td>
                   
                </tr>
                
                <tr>
                    <td colspan="5" height="100px;">&nbsp;</td>
                </tr>
                
                <!---Ticket Notes--->
                <tr>
                    <td colspan="5">
                        <h2>Ticket Notes</h2>
                        
                        <table>
                            
                            <!--Table Headers-->
                            <tr>
                                <th>Date</th>
                                <th>Employee</th>
                                <th colspan="3" ><span style="margin-left: 10px;">Comment</span></th>
                                
                            </tr>
                            
                            <!--All Employees can Add New Notes-->
                            <tr>
                                <form method="post" action="action_add_note.php">
                                
                                    <input type="hidden" id="intTicketId" name="intTicketId" value="<?php echo $id?>">
                                    <input type="hidden" id="strEmployeeUsername" name="strEmployeeUsername" value="<?php echo $_COOKIE['user']?>">
                                    <input type="hidden" id="date" name="date" value="<?php echo date("Y-m-d")?>">
                                    
                                    <!---Today's Date--->
                                    <td>
                                        <?php echo date("Y-m-d") ?>
                                    </td>
                                    
                                    <!---Current User--->
                                    <td>
                                        <?php echo $_COOKIE['user'];?>
                                    </td>
                                    
                                    <!---Comment Box--->
                                    <td colspan="3">
                                        
                                        <span style="margin-left: 10px;">
                                            
                                            <textarea name="comment" style="width:80%;" rows="2" style="overflow:hidden;" id="strComment" required></textarea>
                                        
                                            <button type="button" name="addNote" style="width:80px; height:30px; vertical-align:top;" onClick="AddNotesTicket(<?php echo $id;?>);">Add Note</button>
                                       
                                        </span>
                                        
                                    </td>
                                
                                </form>
                            
                            </tr>
                            
                            <!--Display Previously Added Notes-->
                            <?php       
                                while($notes = $resultNotes->fetch_array(MYSQLI_ASSOC)){ ?>
                                
                                    <tr>
                                        
                                        <!---Date it was added--->
                                        <td>
                                            <?php echo $notes['dateAdded']?>
                                        </td>
                                        
                                        <!---Employee who created it--->
                                        <td>
                                            <?php if ($notes['intEmployeeId'] == ''){ echo 'Deleted User.';} else {echo $notes['strUsername'];}?>
                                        </td>
                                        
                                        <!---Comment--->
                                        <td colspan="2" ><?php echo $notes['comment']?></td>
                                        
                                        <!--If the employee has a security level of 1 or 2, they can delete notes-->
                                        <td>
                                            <?php 
                                                while($currentUserSecurity = $resultSecurityLevel->fetch_array(MYSQLI_ASSOC)){
        
                                                    if (($notes['strUsername'] == $_COOKIE['user']) || ($currentUserSecurity['intSecurityLevel'] == '1' || $currentUserSecurity['intSecurityLevel'] == '2')) {
                                            ?>
                                                        <a href="action_delete_note.php?noteId=<?php echo $notes['noteId']?>&ticketid=<?php echo $id?>">Remove</a>
                                            <?php 
                                                    }
                                                }
                                            ?>
                                            
                                        </td>
                                    </tr>
                            <?php
                                } 
                            ?>
                        </table>
                        
                    </td>
                    
                </tr>
                </tbody>
            </table>
    
        </div>
    
    </div>


        
       
    