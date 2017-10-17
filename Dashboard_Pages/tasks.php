<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasks</title>
    <link rel="stylesheet" type="text/css" href="/GreenwayProject_AdminPortal/css/styles.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="/GreenwayProject_AdminPortal/js/tasks.js"></script>
</head>
<body class="genericBody">
<?php include "navBar.html"; ?>
<div class="contentBox">

    <div class="tabs">
        <button id="showScheduledTasks">Scheduled</button>
        <button id="showCompletedTassks">Completed</button>
    </div>
    <div id="taskTableWrapper">
        <table id="completedTaskTable">
        <tr class="tableHeader" >
            <th style="width:25%">User</th>
            <th style="width:50%">Task</th>
            <th style="width:25%">Date</th>
        </tr>
            <tr class="task">
                <td>Admin</td>
                <td>Completed ticket</td>
                <td>Date</td>
            </tr>
            <tr class="task">
                <td>User</td>
                <td>Submitted ticket</td>
                <td>Date</td>
            </tr>
            <tr class="task">
                <td>User</td>
                <td>Submitted ticket</td>
                <td>Date</td>
            </tr>
            <tr class="task">
                <td>User</td>
                <td>Submitted ticket</td>
                <td>Date</td>
            </tr>
            <tr class="task">
                <td>User</td>
                <td>Submitted ticket</td>
                <td>Date</td>
            </tr>
        </table>

        <table id="scheduledTaskTable">
            <tr class="tableHeader">
                <th style="width:20%">User</th>
                <th>Task</th>
                <th>Date</th>
            </tr>
            <tr class="task">
            <td>Auto</td>
            <td>Generate weekly report</td>
            <td>15 Oct 2017 00:00</td>
            </tr>
            <tr class="task">
                <td>Auto</td>
                <td>Generate monthly report</td>
                <td>31 Oct 2017 00:00</td>
            </tr>
            <tr class="task">
                <td>Auto</td>
                <td>Generate quarterly report</td>
                <td>31 Dec 2017 00:00</td>
            </tr>
        </table>
    </div>
</div>

</body>
</html>