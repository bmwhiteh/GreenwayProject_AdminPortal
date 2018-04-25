<?php 
    /*
    *   Author: Bailey Whitehill
    *   Description: This will provide all of the ticket information in a popup rather than 
                    requiring the user to navigate to a different screen
    *
    */

        include("../MySQL_Connections/config.php");
         

    $id = $_POST['notificationid'];
    
    //Find all the ticket info given the ticketid
    $sqlGetTicket = "SELECT * FROM `pushnotifications` WHERE `intNotificationId` = '".$id."'";
    $resultGetTicket = $conn->query($sqlGetTicket);
    $row = $resultGetTicket->fetch_array(MYSQLI_ASSOC);
    
    





?>

    <!-- Modal content -->
    <div id="myNotificationView" class="modal-content">
        
        
        <span id="closeNotification" class="close" onClick="closeTicket('myNotificationView');">&times;</span>
        
        
        <h1 class="modal-title" id="MapTicketId">Notification Id #: <?php echo $id?></h1>
        
            
        <div class="modal-body">
        
       
            <table  >
                
                <tbody>
                <!--Notification Type-->
                <tr>
                    <th class="calendar_view_30">Type:</th>
                    <td>&nbsp;</td>
                    <td class="calendar_view_50">
                        <?php echo $row['strNotificationType']; ?>
                    </td>
                    
                </tr>
                
                <!--Date Sent-->
                <tr>
                    <th class="calendar_right">Date Sent: </th>
                                        <td>&nbsp;</td>

                    <td>
                        <?php echo $row['dtSentToUsers']; ?>
                    </td>
                   
                </tr>
        
        
                <!--Time Sent-->
                <tr>
                    <th class="calendar_right">Time Sent: </th>                    <td>&nbsp;</td>

                    <td>
                        <?php echo $row['strDateTime'] ?>
                    </td>
                    
                </tr>
                
                <!--Message-->
                <tr>
                    <th class="calendar_right">Message: </th>                    <td>&nbsp;</td>

                    <td>
                        <?php echo $row['strJSONMessage'] ?>
                    </td>
                    
                </tr>
                
                
                </tbody>
            </table>
    
        </div>
    
    </div>