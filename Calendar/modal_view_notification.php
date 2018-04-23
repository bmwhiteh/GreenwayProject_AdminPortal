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
    <div id="myNotificationView" class="modal-content" style="margin-top:10%;">
        
        
        <span id="closeNotification" class="close" onClick="closeTicket('myNotificationView');">&times;</span>
        
        
        <h1 class="modal-title" style="margin-top:0px; vertical-align:middle; text-align: center;" id="MapTicketId">Notification Id #: <?php echo $id?></h1>
        
            
        <div class="modal-body">
        
       
            <table  >
                
                <tbody>
                <!--Notification Type-->
                <tr>
                    <th style="width:30%;text-align:right;">Type:</th>
                    <td>&nbsp;</td>
                    <td style="width:50%">
                        <?php echo $row['strNotificationType']; ?>
                    </td>
                    
                </tr>
                
                <!--Date Sent-->
                <tr>
                    <th style="text-align:right;">Date Sent: </th>
                                        <td>&nbsp;</td>

                    <td>
                        <?php echo $row['dtSentToUsers']; ?>
                    </td>
                   
                </tr>
        
        
                <!--Time Sent-->
                <tr>
                    <th style="text-align:right;">Time Sent: </th>                    <td>&nbsp;</td>

                    <td>
                        <?php echo $row['strDateTime'] ?>
                    </td>
                    
                </tr>
                
                <!--Message-->
                <tr>
                    <th style="text-align:right;">Message: </th>                    <td>&nbsp;</td>

                    <td>
                        <?php echo $row['strJSONMessage'] ?>
                    </td>
                    
                </tr>
                
                
                </tbody>
            </table>
    
        </div>
    
    </div>