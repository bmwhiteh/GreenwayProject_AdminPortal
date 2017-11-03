<!DOCTYPE html>


<html>
<head>
    <title>Home</title>
    <style>
        body{
            width: 100%;
            background-color: #1B371A ;
        }

        .contentBox{
            background-color: #8c8c8c;
            margin: 0px 100px 50px 100px;
        }
        div.dataTables_wrapper {
            margin-bottom: 3em;
        }
    </style>
    <script src="../js/jquery-3.2.1.min.js"></script>

   <link rel="stylesheet" type="text/css" href="DataTables/datatables.css"/>

    <script type="text/javascript" src="DataTables/datatables.js"></script>
    <script>
        $(document).ready(function() {
            $('table.display').DataTable();
        } );
    </script>
</head>

<body>

<?php include "../Dashboard_Pages/navBar.html"; ?>
<div class="contentBox">

    <h1 style="margin-bottom: 30px; margin-top:0px; color: white; vertical-aligh:middle; text-align: center;">Viridian Ticket System</h1>

    <div style="width:80%;margin:auto;">
    <table id="" class="display" cellspacing="0" width="80%"  style="margin-top: 20px;padding:5px;">
        <thead>
        <tr style="background-color: #448b41">
            <th>Ticket Id</th>
            <th>Title</th>
            <th>Type</th>
            <th>Created On</th>
            <th>View</th>
        </tr>
        </thead>
        <tfoot>
        <tr style="background-color: #448b41">
            <th>Ticket Id</th>
            <th>Title</th>
            <th>Type</th>
            <th>Created On</th>
            <th>View</th>
        </tr>
        </tfoot>
        <tbody>
        <tr>
            <td>1</td>
            <td>The cherry tree is blocking the path</td>
            <td>6</td>
            <td>8-1-2017</td>
            <td><a href="ticketInfo.php?ticketid=1">View Ticket</a></td>
        </tr>
        <tr>
            <td>2</td>
            <td>A huge tree fell</td>
            <td>3</td>
            <td>8-2-2017</td>
            <td><a href="ticketInfo.php?ticketid=2">View Ticket</a></td>
        </tr>
        <tr>
            <td>3</td>
            <td>Same person all week</td>
            <td>8</td>
            <td>8-4-2017</td>
            <td><a href="ticketInfo.php?ticketid=3">View Ticket</a></td>
        </tr>
        <tr>
            <td>4</td>
            <td>Somebody spraypainted a bench</td>
            <td>7</td>
            <td>8-6-2017</td>
            <td><a href="ticketInfo.php?ticketid=4">View Ticket</a></td>
        </tr>
        <tr>
            <td>5</td>
            <td>Cut the bushes back!</td>
            <td>6</td>
            <td>8-7-2017</td>
            <td><a href="ticketInfo.php?ticketid=5">View Ticket</a></td>
        </tr>
        <tr>
            <td>6</td>
            <td>Grafitti under the bridge</td>
            <td>7</td>
            <td>8-8-2017</td>
            <td><a href="ticketInfo.php?ticketid=6">View Ticket</a></td>
        </tr>
        <tr>
            <td>7</td>
            <td>There is litter everywhere</td>
            <td>5</td>
            <td>8-20-2017</td>
            <td><a href="ticketInfo.php?ticketid=7">View Ticket</a></td>
        </tr>
        <tr>
            <td>8</td>
            <td>Tree blocking path</td>
            <td>3</td>
            <td>8-21-2017</td>
            <td><a href="ticketInfo.php?ticketid=8">View Ticket</a></td>
        </tr>
        <tr>
            <td>9</td>
            <td>Group of Guys loitering</td>
            <td>8</td>
            <td>8-23-2017</td>
            <td><a href="ticketInfo.php?ticketid=9">View Ticket</a></td>
        </tr>
        </tbody>
    </table>
    
    
    <table cellspacing="0" width="80%"  style="margin-top: 20px;padding:5px;">
            <thead style="background-color: #448b41">
                <tr>
                    <th>Date Sent</th>
                    <th>Number Sent</th>
                    <th>Alert Message</th>
                </tr>
            </thead>
            <tfoot style="background-color: #448b41">
                <tr>
                    <th>Date Sent</th>
                    <th>Number Sent</th>
                    <th>Alert Message</th>
                </tr>
            </tfoot>
            <tbody>
                 <?php include "getTickets.php" ?>
            </tbody>

        </div>
</div>

</body>
</html>

<script>

</script>