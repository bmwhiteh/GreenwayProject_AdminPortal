<!DOCTYPE html>
<html>
<head>
    <title>Ticket Info</title>
    <style>
        .contentBox{
            background-color: #8c8c8c;
            margin: 0px 100px 50px 100px;
            padding:10px;
        }

        h1 {
            color: #000;
            font-size: 24px;
            font-weight: 400;
            text-align: center;
            margin-top: 20px;
        }

        .contentTable {
            border: 1px solid black;
            border-radius:20px;
            background-color:white;
            margin:auto;
            text-align: left;
            font-size: 20px;
            padding: 10px;
        }

        td, th {            vertical-align: top;
        }
        body {
            background-color: #1B371A ;

        }
        input{
            width:30%;
        }

    </style>
    
</head>

<body>

<?php include "../Dashboard_Pages/navBar.php"; ?>

<div class="contentBox">
    <h1 style="margin-top:0px; color: white; vertical-aligh:middle; text-align: center;">Ticket Id #: <?php echo $_GET['ticketid']?></h1>
    
    
    <?php 
        include("../MySQL_Connections/config.php");
        
          $id = $_GET['ticketid'];
        //try to query ticketId from open tickets
        $sql = "SELECT * FROM `maintenancetickets` WHERE `intTicketId` = ".$_GET['ticketid'];
        $result = $conn->query($sql) or die("open ticket fail");
        
        $row = $result->fetch_array(MYSQLI_ASSOC);
        
         $sqlNotes = "SELECT *\n"
                . "from ticketnotes\n"
                . "left join employees on employees.intEmployeeId = ticketnotes.intEmployeeId\n"
                . "WHERE `intTicketId` = '".$id."' \n"
                . "ORDER BY `noteId` desc";
                
        $resultNotes = $conn->query($sqlNotes) or die("Notes Query Failed"); 
        
        if($row['dtClosed']==''){
            $status = "open";
        }else{
            $status = "closed";
        }
    
        if($_GET['page'] == 'table'){
            $url = "ticket_table_table.php?tickets=".$status;
            
        }else if ($_GET['page'] == 'list'){
            $url = "ticket_table_list.php?tickets=".$status;
        } else{
            $url = "ticket_table_cards.php?tickets=".$status;
        }
        
    ?>
    <h3  style="margin-bottom: 30px; vertical-align:middle; text-align: center; margin:auto;"><a href="<?php echo $url; ?>" style="text-decoration:none;color:green;">Return to View</a></h3>
        <table class="contentTable">
            <tr>
                <th>Title:</th>
                <td style="max-width:200px;"><?php echo $row['strTitle'] ?></td>
                <td style="width:20px;">&nbsp;</td>
                <th>Submitted By: </th>
                <td><?php
                $sql = "SELECT `strFirstName`, `strLastName` FROM users WHERE intUserId =".$row['intUserId'];
                $tempConn = $conn->query($sql) or die($sql."\nQuery fail".$_GET['ticketid']);
                $temp = $tempConn->fetch_array(MYSQLI_ASSOC);
                echo $temp['strFirstName']." ".$temp['strLastName']
                ?></td>
            </tr>
            <tr>
                <th>Ticket Type: </th>
                <td><?php echo $row['intTypeId'] ?></td>
                <td style="width:20px;">&nbsp;</td>
                <th>Date Submitted: </th>
                <td><?php echo $row['dtSubmitted'] ?></td>
            </tr>
    
            <tr>
                <th>Description: </th>
                <td><?php echo $row['strDescription'] ?></td>
                <td style="width:20px;">&nbsp;</td>
                <th>Assigned Employee: </th>
                <td><?php 
                $sql = "SELECT `strFirstName`, `strLastName` FROM employees WHERE intEmployeeId =".$row['intEmployeeAssigned'];
                $tempConn = $conn->query($sql) or die($sql."\nQuery fail".$_GET['ticketid']);
                $temp = $tempConn->fetch_array(MYSQLI_ASSOC);
                echo $temp['strFirstName']." ".$temp['strLastName'] ?></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
                <td style="width:20px;">&nbsp;</td>
                <th>Urgent: </th>
                <td><?php
                if($temp['bitUrgent'] == 0){
                    echo "No";
                }
                else{
                    echo "Yes";
                }
                ?></td>
            </tr>
            <tr>
                <th colspan="2">Image:</th>
                <td style="width:20px;">&nbsp;</td>
                <th colspan="2">Location: </th>
                
            </tr>
            <tr>
                <td colspan="2" style="width:47%;min-height:800px;text-align:center;"><?php if($row['strImageFilePath'] != ''){ ?><img src="<?php echo $row['strImageFilePath'];?>" style="max-width:100%;margin:auto;" alt="Ticket Image Not Found"><?php }else{ ?>No Image to Display<?php } ?></td>
                <td style="width:6%;">&nbsp;</td>
                <td id="map" colspan="2" style="width:47%;">
                    <script>
                        var map;
        
                        function getMarkerMap(){
                            var map = new google.maps.Map(document.getElementById('map'), {
                            zoom: 10,
                            center: {lat: 41.1178412, lng: -85.1082758}
                        });

                        <?php
                            include("../MySQL_Connections/config.php");
                    
                            $sql = "SELECT `intTicketId`,`gpsLat`,`gpsLong` FROM `maintenancetickets`WHERE `intTicketId` = ".$_GET['ticketid'];
                            $result = $conn->query($sql) or die("Query fail");
                        ?>
                
                        var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(<?php echo $row['gpsLat']?>, <?php echo $row['gpsLong']?>),
                            map: map,
                            icon: '../images/markerLogo.png',
                            animation: google.maps.Animation.DROP,
                            title: 'Ticket ID #<?php echo $row['intTicketId']?>',
                            url: "https://virdian-admin-portal-whitbm06.c9users.io/Ticket_System_v2/ticket_info_single.php?ticketid=" + <?php echo $row['intTicketId']?>
                        });
                        
                        google.maps.event.addListener(marker, 'click', function() {
                            window.location.href = this.url;
                        });
        }
    </script><script async defer
                        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVZ9qSBrT-dnmrBaxkX2PzWbfmxv6xZgM&libraries=visualization&callback=getMarkerMap">
                    </script>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td >
                     <span style="border:2px solid red; background-color:red; font-weight:bold;padding:5px;">
                             <?php if(($_GET['tickets'] == "open")|| $row['dtClosed'] ==''){?>
                                    <a href="action_close_ticket.php?ticketid=<?php echo $_GET['ticketid']?>" style="text-decoration:none; color:white; font-weight:bold;">CLOSE</a>
                            <?php }else{?>
                                <a href="action_reopen_ticket.php?ticketid=<?php echo $_GET['ticketid']?>" style="text-decoration:none; color:white; font-weight:bold;">REOPEN</a>
                            <?php }?>
                        </span>
                </td>
                <td colspan="3">&nbsp;</td>
               
            </tr>
            
            <tr>
                <td colspan="5" height="100px;">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5">
                    <h2>Ticket Notes</h2>
                    <table>
                        <tr>
                            <th>Date</th>
                            <th>Employee</th>
                            <th colspan="3" ><span style="margin-left: 10px;">Comment</span></th>
                            
                        </tr>
                        <tr>
                            <form method="post" action="action_add_note.php">
                                    <input type="hidden" name="intTicketId" value="<?php echo $id?>">
                                    <input type="hidden" name="strEmployeeUsername" value="<?php echo $_COOKIE['user']?>">
                                    <input type="hidden" name="date" value="<?php echo date("Y-m-d")?>">

                                    <td><?php echo date("Y-m-d") ?></td>
                                    <td><?php echo $_COOKIE['user'];?></td>
                                    <td colspan="3"><span style="margin-left: 10px;"><textarea name="comment" cols="100" rows="2" style="overflow:hidden;" required></textarea>
                                    <button type="submit" name="addNote" style="width:80px; height:30px; vertical-align:top;">Add Note</button></span></td>
                                </form>
                        </tr>
                        <?php    while($notes = $resultNotes->fetch_array(MYSQLI_ASSOC)){ ?>
                            <tr>
                                <td><?php echo $notes['dateAdded']?></td>
                                <td><?php echo $notes['strUsername']?></td>
                                <td colspan="2" ><?php echo $notes['comment']?></td>
                                <td>
                                    <?php 
                                         $sqlSecurityLevel = "SELECT intSecurityLevel\n"
                                                . "from employees\n"
                                                . "WHERE `strUsername` = '".$_COOKIE['user']."' \n"
                                                . "LIMIT 1";
                                                
                                        $resultSecurityLevel = $conn->query($sqlSecurityLevel) or die("Find Security Level Query Failed"); 
                                        
                                        while($currentUserSecurity = $resultSecurityLevel->fetch_array(MYSQLI_ASSOC)){

                                        if (
                                            ($notes['strUsername'] == $_COOKIE['user'])
                                            || ($currentUserSecurity['intSecurityLevel'] == '1' || $currentUserSecurity['intSecurityLevel'] == '2')
                                        ) {?>
                                            <a href="action_delete_note.php?noteId=<?php echo $notes['noteId']?>&ticketid=<?php echo $_GET['ticketid']?>">Remove</a>
                                        <?php }}?>
                                     </td>
                            </tr>
                        <?php } ?>
                    </table>
                </td>
            </tr>
        </table>
    
    </div>
    
    
    </div>
    
</body>
</html>

