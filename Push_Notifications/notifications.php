<?php include "../Dashboard_Pages/navBar.html"; ?>

<!DOCTYPE html>

<html>
<head>
    <title>Push Notifications</title>
    <link rel="stylesheet" href="/GreenwayProject_AdminPortal/Push_Notifications/customBootstrap/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/GreenwayProject_AdminPortal/Push_Notifications/customBootstrap/js/bootstrap.min.js"></script>
    <style>
        body{
            width: 100%;
            overflow: hidden;
            background-color: #1B371A ;
        }

        .contentBox{
            background-color: #8c8c8c;
            margin: 0px 100px 50px 100px;
            display: -webkit-flex;
            display: flex;
            height: 470px;
        }
        .sendNotification{
            display:flex;
        }
        .topBox{
            height: 28%;
            background-color: #448b41;
        }

        .midBox{
            height: 28%;
            margin-top: 5%;
            background-color: #55ad52;
        }

        .bottomBox{
            height: 28%;
            margin-top: 5%;
            background-color: #77be74;
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
        table {
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            text-align: left;
            padding: 8px;
        }
        tr:hover td{
            background-color: #77be74;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
        tr:nth-child(odd){
            background-color: #aaaaaa;
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

</head>

<body>



<div class="contentBox">
    <div class="leftSide">
        <h2>Quick Stats</h2>
        <div class="topBox"> Sent Today</div>
        <div class="midBox"> Users Signed Up</div>
        <div class="bottomBox">Total Sent</div>
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
                <form action="/sendPushNotification.php" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="content">Message</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                       id="content" placeholder="Message..."/>
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
                                        <option value="event">Local Event</option>
                                        <option value="closure">Trail Closure</option>
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
        <table>
            <tr>
                <th>Date Sent</th>
                <th>Number Sent</th>
                <th>Alert Message</th>
            </tr>
            <tr>
                <td>10/05/2017</td>
                <td>10</td>
                <td>Test push notification message</td>
            </tr>
            <tr>
                <td>10/05/2017</td>
                <td>10</td>
                <td>Test push notification message</td>
            </tr>
            <tr>
                <td>10/05/2017</td>
                <td>10</td>
                <td>Test push notification message</td>
            </tr>
            <tr>
                <td>10/05/2017</td>
                <td>10</td>
                <td>Test push notification message</td>
            </tr>
            <tr>
                <td>10/05/2017</td>
                <td>10</td>
                <td>Test push notification message</td>
            </tr>
            <tr>
                <td>10/05/2017</td>
                <td>10</td>
                <td>Test push notification message Test push notification messageTest push notification messageTest push notification message</td>
            </tr>
        </table>
    </div>

</div>


</body>
</html>