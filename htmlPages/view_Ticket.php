<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tickets</title>
    <link rel="stylesheet" type="text/css" href="/GreenwayProject_AdminPortal/css/styles.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="/GreenwayProject_AdminPortal/js/ticketView.js"></script>
</head>
<body class="genericBody">
<?php include "navBar.html"; ?>

<div class="contentBox">




    <table id="createTicketModal">
        <tr>
            <td><label>Description: </label></td>
            <td><input type="text" name="description"></td>
            <td><label>Category: </label><select>
                    <option value="branch">Tree Branch</option>
                    <option value="pothole">Pot hole</option>
                    <option value="trashcan">Trash full</option>
                    <option value="litter">litter</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><label>Comments: </label></td>
            <td><textarea name="comment"></textarea></td>
            <td><labeL>Severity:</labeL></td>
            <td><select>
                    <option value="severe">Severe</option>
                    <option value="mild">Mild</option>
                </select>
            </td>
            <td><button type="button">Submit Ticket</button></td>
        </tr>
    </table>
    <table class="ticketModal" style="text-align:center;" width="100%">

        <tr class="ticket">
            <td>ID#</td>
            <td>There is a tree that has fallen on the path</td>
            <td>Tree Branch</td>
            <td>
                <div class="severe">SEVERE</div>
            </td>
        </tr>
        <tr class="ticket">
            <td class="active">
                <div>ACTIVE</div>
            </td>
            <td>Comments</td>
            <td class="map" colspan="2">
                <iframe
                        frameborder="0" style="border:0"
                        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDlMzRTCnLXQFtVWBaQgp5BOQY9sZxGW04&q=IPFW">
                </iframe>
            </td>

        </tr>
        <tr class="ticket">
            <td>Icons</td>
            <td>
                <button type="button" class="closeModalButton">Close</button>
            </td>
            <td>Submission date</td>
            <td>submission author</td>
        </tr>
    </table>

    <table class="ticketModal" style="text-align:center;" width="100%">

        <tr class="ticket">
            <td>ID#</td>
            <td>There is a pothole</td>
            <td>Tree Branch</td>
            <td>
                <div class="severe">SEVERE</div>
            </td>
        </tr>
        <tr class="ticket">
            <td class="active">
                <div>ACTIVE</div>
            </td>
            <td>Comments</td>
            <td class="map" colspan="2">
                <iframe
                        frameborder="0" style="border:0"
                        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDlMzRTCnLXQFtVWBaQgp5BOQY9sZxGW04&q=IPFW">
                </iframe>
            </td>

        </tr>
        <tr class="ticket">
            <td>Icons</td>
            <td>
                <button type="button" class="closeModalButton">Close</button>
            </td>
            <td>Submission date</td>
            <td>submission author</td>
        </tr>
    </table>

    <div class="ticketPreviewWrapper">
        <div>
            <button id="createTicketButton" type="button">Create Ticket</button>
        </div>


        <div class="ticketPreview">
            <table>
                <tr>
                    <td class="active">Active</td>
                    <td class="previewDescription">There is a tree that has fallen on the path</td>
                    <td style="text-align: right">
                        <div class="severe">SEVERE</div>
                    </td>
                    <td >
                        <button type="button" class="view">View</button>
                    </td>
                </tr>
            </table>
        </div>
        <br>

        <div class="ticketPreview">
            <table>
                <tr>
                    <td class="active">Active</td>
                    <td class="previewDescription">There is a pothole</td>
                    <td style="text-align: right">
                        <div class="severe">SEVERE</div>
                    </td>
                    <td >
                        <button type="button" class="view">View</button>
                    </td>
                </tr>
            </table>
        </div>
        </div>


    </div>
</div>


</body>
</html>