<!DOCTYPE html>

<html>
<head>
    <title>Home</title>
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
        }
        /* Create three equal columns that floats next to each other */
        .column {
            float: left;
            width: 31.6%;
            padding: 10px;
            height: 500px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Style the footer */
        .footer {
            background-color: #f1f1f1;
            padding: 10px;
            text-align: center;
        }

        /* Responsive layout - makes the three columns stack on top of each other instead of next to each other */
        @media (max-width: 600px) {
            .column {
                width: 100%;
            }
        }

        .quick_stats_box{
            border: 2px solid red;
            border-radius: 5px;
            text-align:left;
            padding: 20px;
        }

        input[type=text], input[type=date], select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type=submit] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        form {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
        }
    </style>

</head>

<body>

<?php include "navBar.html"; ?>
<div class="contentBox">

    <div class="row">


        <div class="column" style="background-color:#aaa;">
            <!---Display Quick Stats of the push notifications---->
            <h2>Quick Stats for Push Notifications</h2>
            <table >
                <tr>
                    <th>Sent Today</th>
                    <th>&nbsp;</th>
                    <td class="quick_stats_box">Query Result</td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                </tr>
                <tr>
                    <th>Users Signed Up</th>
                    <th>&nbsp;</th>
                    <td class="quick_stats_box">Query Result</td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                </tr>
                <tr>
                    <th>Total Sent</th>
                    <th>&nbsp;</th>
                    <td class="quick_stats_box">Query Result</td>
                </tr>

            </table>
        </div>

        <div class="column" style="background-color:#bbb;">
            <!---Display the 20 most recent push notifications distributed--->
            <h2>Most Recent Push Notifications Sent</h2>
            <table>
                <tr>
                    <th>Column 1</th>
                    <th>Column 2</th>
                    <th>Column 3</th>
                    <th>Column 4</th>
                </tr>

                <!---Will need a php loop through query here--->
                <tr>
                    <td>Data 1</td>
                    <td>Data 2</td>
                    <td>Data 3</td>
                    <td>Data 4</td>
                </tr>
            </table>
        </div>


        <div class="column" style="background-color:#ccc;">
            <h2>Send New Push Notification</h2>
            <form action="/sendPushNotification.php">
                <label for="content">Message</label>
                <input type="text" id="content" name="content" placeholder="Message..">




                <label for="dtSend">Send Date</label>
                <input type="date" id="dtSend" name="dtSend">

                <label for="strNotificationType">Type</label>
                <select id="strNotificationType" name="strNotificationType">
                    <option value="event">Local Event</option>
                    <option value="closure">Trail Closure</option>
                </select>

                <input type="submit" value="Submit">
            </form>
        </div>
    </div>

</div>
<div class="footer">
    <p>Footer</p>
</div>

</body>
</html>

<script>
    function EnterZip(){
        $document.getElementById("ShowZipCode").style.display="block";
    }
</script>