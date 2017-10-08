<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tickets</title>
    <link rel="stylesheet" type="text/css" href="/GreenwayProject_AdminPortal/css/styles.css"/>
    <script type="text/javascript" src="/GreenwayProject_AdminPortal/js/ticketView.js"></script>
</head>
<body class="genericBody">
<?php include "navBar.html"; ?>

<div class="contentBox">


    <table class="ticketModal" style="text-align:center;" width="100%">

        <tr class="ticket">
            <td>ID#</td>
            <td>There is a tree that has fallen on the path</td>
            <td>Tree Branch</td>
            <td ><div class="severe">SEVERE</div></td>
        </tr>
        <tr class="ticket">
            <td class="active"><div>ACTIVE</div></td>
            <td>Comments</td>
            <td class="map" colspan="2" ><iframe
                        frameborder="0" style="border:0"
                        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDlMzRTCnLXQFtVWBaQgp5BOQY9sZxGW04
    &q=IPFW">
                </iframe></td>

        </tr >

        <tr class="ticket">
            <td>Icons</td>
            <td></td>
            <td>Submission date</td>
            <td>submission author</td>
        </tr>
    </table>


    <div class="ticketPreview">
        <table >
            <tr>
                <td class="active">Active</td>
                <td>There is a tree that has fallen on the path</td>
                <td><div class="severe">SEVERE</div></td>
                <td><button type="button" id="view" onclick="showModal(0);">View</button></td>
            </tr>
        </table>
    </div>
</div>


</body>
</html>