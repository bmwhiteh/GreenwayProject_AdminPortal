<?php include "../Dashboard_Pages/navBar.php"; ?>

<!DOCTYPE html>

<html>
<head>
    <title>Push Notifications</title>
    <link rel="stylesheet" href="./customBootstrap/css/bootstrap.css">
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="./customBootstrap/js/bootstrap.min.js"></script>
    <style>
        body{
            width: 100%;
            
            background-color: #1B371A ;
        }

        .contentBox{
            background-color: #8c8c8c;
            margin: 0px 100px 50px 100px;
            display: -webkit-flex;
            display: flex;
            color:black;

        }
        .sendNotification{
            display:flex;
        }
        .topBox{
            height: 22%;
            background-color: #448b41;
            text-align: center;
        }

        .midBox{
            height: 22%;
            margin-top: 5%;
            background-color: #55ad52;
            text-align: center;
        }

        .bottomBox{
            height: 22%;
            margin-top: 5%;
            background-color: #77be74;
            text-align: center;
        }
        .leftSide{
            width: 15%;
            margin: 1% 1.5% 3% 3%;
            display:block;
        }
        .recentNotifications{
            -webkit-flex: 2;
            -ms-flex: 2;
            flex: 2;
            margin: 1% 1.5% 3% 1.5%;
        }
        button{
            height: 10%;
            margin-left:55%;
            margin-top:4%;
            padding: 1px 5px;
        }

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 15%; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
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

<body>



<div class="contentBox">
    <div class="leftSide">
        <h2>Quick Stats</h2>
        <div class="topBox">
            <h3>Sent Today</h3>
            <h1><?php include "numNotificationsSentToday.php"?></h1>
        </div>
        
        <div class="midBox">
            <h3>Users Signed Up</h3>
            <h1><?php include "numUsersReceivingNotifications.php"?></h1>
        </div>
        
        <div class="bottomBox">
            <h3>Sent This Week</h3>
            <h1><?php include "numNotificationsSentWeekly.php"?></h1>
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
                <form action="./sendPushNotification.php" method="get" class="form-horizontal" role="form">
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
                                <label class="col-sm-2 control-label" for="strNotificationType">Type</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="strNotificationType" name="strNotificationType">
                                        <option value="local event">Local Event</option>
                                        <option value="trail closure">Trail Closure</option>
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


        <table id="" class="display" cellspacing="0" width="80%" style="margin-top: 20px; padding:5px;">
            <thead style="background-color: #448b41">
                <tr>
                    <th>Alert Id</th>
                    <th>Date Sent</th>
                    <th>Number Sent</th>
                    <th>Alert Message</th>
                </tr>
            </thead>
            <tfoot style="background-color: #448b41">
                <tr>
                    <th>Alert Id</th>
                    <th>Date Sent</th>
                    <th>Number Sent</th>
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