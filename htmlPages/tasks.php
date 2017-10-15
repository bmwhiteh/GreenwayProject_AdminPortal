<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasks</title>
    <link rel="stylesheet" type="text/css" href="/GreenwayProject_AdminPortal/css/styles.css"/>
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
        <tr class="tableHeader">
            <th>User</th>
            <th>Task</th>
            <th>Date</th>
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
                <th>User</th>
                <th>Task</th>
                <th>Date</th>
            </tr>
            <tr class="task">
                <td>Admin</td>
                <td>Generate weekly report</td>
                <td>15 Oct 2017 00:00</td>
            </tr>
        </table>
    </div>
</div>

</body>
</html>