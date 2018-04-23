<?php 
    /*
    *   Author: Bailey Whitehill
    *   Description: This will provide all of the ticket information in a popup rather than 
                    requiring the user to navigate to a different screen
    *
    */

        include("../MySQL_Connections/config.php");
         

    $id = $_POST['event_id'];
    
    //Find all the ticket info given the ticketid
    $sqlGetTicket = "SELECT * FROM `CalendarEvents` WHERE `intEventId` = '".$id."'";
    $resultGetTicket = $conn->query($sqlGetTicket);
    $row = $resultGetTicket->fetch_array(MYSQLI_ASSOC);
    
    
    $date = new DateTime($row['dtStartDate'], new DateTimeZone('UTC'));
    $date->setTimezone(new DateTimeZone('EST'));
    
    $dtStartDate = $date->format('Y-m-d h:i:s a');

    $date = new DateTime($row['dtEndDate'], new DateTimeZone('UTC'));
    $date->setTimezone(new DateTimeZone('EST'));
    
    $dtEndDate = $date->format('Y-m-d h:i:s a');




?>

    <!-- Modal content -->
    <div id="myNotificationView" class="modal-content" style="margin-top:10%;width:50%;">
        
        
        <span id="closeNotification" class="close" onClick="closeTicket('myNotificationView');">&times;</span>
        
        
        <h1 class="modal-title" style="margin-top:0px; vertical-align:middle; text-align: center;" id="MapTicketId">Event Id #: <?php echo $id?></h1>
        
            
        <div class="modal-body">
        
       
            <table  >
                
                <tbody>

                <tr>
                    <th style="width:30%;text-align:right;">Title:</th>
                    <td>&nbsp;</td>
                    <td style="width:50%">
                        <?php echo $row['strEventTitle']; ?>
                    </td>
                    
                </tr>
                
                <tr>
                    <th style="text-align:right;">Start Date: </th>
                    <td>&nbsp;</td>
                    <td>
                        <?php echo $dtStartDate; ?>
                    </td>
                   
                </tr>
        
        
                <tr>
                    <th style="text-align:right;">End Date: </th>
                    <td>&nbsp;</td>
                    <td>
                        <?php echo $dtEndDate; ?>
                    </td>
                    
                </tr>
                
                <!--Message-->
                <tr>
                    <th style="text-align:right;">Description: </th>
                    <td>&nbsp;</td>
                    <td>
                        <?php echo $row['strEventDescription'] ?>
                    </td>
                    
                </tr>
                
                
                </tbody>
            </table>
    
        </div>
    
    </div>