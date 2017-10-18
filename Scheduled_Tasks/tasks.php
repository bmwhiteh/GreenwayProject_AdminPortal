<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasks</title>
    <style>
        body{
            width: 100%;
            background-color: #1B371A ;
        }

        .contentBox{
            background-color: #8c8c8c;
            margin: 0px 100px 50px 100px;
        }

    </style>
    <script src="../js/jquery-3.2.1.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../Ticket_System/DataTables/datatables.css"/>
    <script type="text/javascript" src="../../GreenwayProject_AdminPortal/js/tasks.js"></script>

    <script type="text/javascript" src="../Ticket_System/DataTables/datatables.js"></script>

    <script>
        $(document).ready(function() {
            $('table.display').DataTable();
        } );
    </script>
</head>
<body>
<?php include "../Dashboard_Pages/navBar.html"; ?>
<div class="contentBox">

    <div class="tabs">
        <button id="showScheduledTasks">Scheduled</button>
        <button id="showCompletedTasks">Completed</button>
    </div>

        <div id="completedTaskTable" style="width:80%;margin:auto;">
            <table id="" class="display" cellspacing="0" width="80%"  style="margin-top: 20px;padding:5px;">
                <thead style="background-color: #448b41">
                    <tr>
                        <th>User</th>
                        <th>Task</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tfoot style="background-color: #448b41">
                    <tr>
                        <th>User</th>
                        <th>Task</th>
                        <th>Date</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td>Admin</td>
                        <td>Completed ticket</td>
                        <td>Date</td>
                    </tr>
                    <tr>
                        <td>User</td>
                        <td>Submitted ticket</td>
                        <td>Date</td>
                    </tr>
                    <tr>
                        <td>User</td>
                        <td>Submitted ticket</td>
                        <td>Date</td>
                    </tr>
                    <tr>
                        <td>User</td>
                        <td>Submitted ticket</td>
                        <td>Date</td>
                    </tr>
                    <tr>
                        <td>User</td>
                        <td>Submitted ticket</td>
                        <td>Date</td>
                    </tr>
                </tbody>

            </table>
        </div>

        <div id="scheduledTaskTable" style="width:80%;margin:auto;">
            <table id="" class="display" cellspacing="0" width="80%"  style="margin-top: 20px;padding:5px;">
                <thead style="background-color: #448b41">
                    <tr>
                        <th>User</th>
                        <th>Task</th>
                        <th>Date</th>
                    </tr>
                </thead>


                <tfoot style="background-color: #448b41">
                    <tr>
                        <th>User</th>
                        <th>Task</th>
                        <th>Date</th>
                    </tr>
                </tfoot>

                <tbody>
                    <tr>
                        <td>Auto</td>
                        <td>Generate weekly report</td>
                        <td>15 Oct 2017 00:00</td>
                    </tr>
                    <tr>
                        <td>Auto</td>
                        <td>Generate monthly report</td>
                        <td>31 Oct 2017 00:00</td>
                    </tr>
                    <tr>
                        <td>Auto</td>
                        <td>Generate quarterly report</td>
                        <td>31 Dec 2017 00:00</td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
</div>

</body>
</html>