<?php include "../Dashboard_Pages/navBar.php"; ?>

<!DOCTYPE html>

<html>
<head>
    <title>Push Notifications</title>
    <link rel="stylesheet" href="./customBootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/css/pushNotifications.css"/>
    
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="./customBootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../Push_Notifications/DataTables/datatables.js"></script>
    <link rel="stylesheet" type="text/css" href="../Push_Notifications/DataTables/datatables.css"/>
    <script>
        $(document).ready(function() {
            $('table.display').DataTable({
                "order": [[ 0, "desc" ]]
            });
        } );
    </script>
</head>

<body class="genericBody">
    
<div class="contentBox">
    <div class="leftSide">
        <!--<h2>Quick Stats</h2>-->
        <div class="topBox">
            <h3># of Weather Alerts This Week</h3>
            <h1><?php include "numWeatherAlertsSentWeekly.php"?></h1>
            <div class="absolute">
                <img src="../images/weatherAlerts3.png" style="margin-right:30%;"></img>
            </div>
        </div>
        
        <div class="midBox">
            <h3># of Alerts Scheduled This Week</h3>
            <h1><?php include "numScheduledAlertsSentWeekly.php"?></h1>
            <div class="absolute">
                <img src="../images/overtime.png" style="margin-right:30%;"></img>
            </div>
        </div>
        
        <div class="bottomBox">
            <h3># of Users Receiving Alerts</h3>
            <h1><?php include "numUsersReceivingNotifications.php"?></h1>
            <div class="absolute">
                <img src="../images/alert.png" style="margin-right:30%;"></img>
            </div>
        </div>
    </div>
    <div class="recentNotifications">
        <div class="sendNotification">
        <h2>Recent Notifications Sent</h2>
        <button id="myBtn" type="button" >Send New Notification</button>
        </div>
        <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3 class="modal-title">Send New Push Notification</h3>
                <div class="modal-body">
                <form action="./schedulePushNotification.php" method="post" id="addUserForm" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="content">Message</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                       id="content" name="message" placeholder="Message..."/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="dtSend" >Send Date</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control"
                                       id="dtSend" name="dtSend"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="dtSend" >Send Time</label>
                            <div class="col-sm-10">
                                <input type="time" class="form-control"
                                       id="timeSend" name="timeSend"/>
                            </div>
                        </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="strNotificationType">Type</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="strNotificationType" name="strNotificationType">
                                        <option value="Local Event">Local Event</option>
                                        <option value="Trail Closure">Trail Closure</option>
                                    </select>
                                </div>
                            </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Submit</button>
                        </div>
                    </div>

                </form>
                </div>
            </div>

        </div>

        <script>
            // Get the modal
            var modal = document.getElementById('myModal');

            // Get the button that opens the modal
            var btn = document.getElementById("myBtn");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks the button, open the modal
            btn.onclick = function() {
                modal.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>


        <table id="notifications" class="display" cellspacing="0">
            <thead id="header">
                <tr>
                    <th>Alert Id</th>
                    <th>Date Sent</th>
                    <th>Alert Type</th>
                    <th>Alert Message</th>
                </tr>
            </thead>
            <tfoot id="footer">
                <tr>
                    <th>Alert Id</th>
                    <th>Date Sent</th>
                    <th>Alert Type</th>
                    <th>Alert Message</th>
                </tr>
            </tfoot>
            <tbody>
                <?php include "recentNotifications.php"?>
            </tbody>
        </table>
    </div>

</div>


</body>
</html>