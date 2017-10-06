<!DOCTYPE html>

<html>
<head>
    <title>Push Notifications</title>
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
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            text-align: left;
            padding: 8px;
        }
        tr:hover{
            background-color: #77be74;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
        tr:nth-child(odd){
            background-color: #aaaaaa;
        }
    </style>

</head>

<body>

<?php include "navBar.html"; ?>
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
        <button type="button" >Send New Notification</button>
        </div>
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