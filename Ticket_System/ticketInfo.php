<!DOCTYPE html>
<html>
<head>
    <title>Ticket Info</title>
    <style>
        .contentBox{
            background-color: #8c8c8c;
            margin: 0px 100px 50px 100px;
            padding:10px;
        }

        h1 {
            color: #000;
            font-size: 24px;
            font-weight: 400;
            text-align: center;
            margin-top: 20px;
        }

        table{
            border: 1px solid black;
            border-radius:20px;
            background-color:white;
            height:100%;
            margin:auto;
            text-align: left;
            font-size: 20px;
        }

        td, th {            vertical-align: top;
        }
        body {
            background-color: #1B371A ;

        }
        input{
            width:30%;
        }

    </style>
</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: bmwhi
 * Date: 10/13/2017
 * Time: 9:51 PM
 */
?>

<?php include "../Dashboard_Pages/navBar.html"; ?>
<div class="contentBox">
    <h1 style="margin-bottom: 30px; margin-top:0px; color: white; vertical-aligh:middle; text-align: center;">Ticket Id #: 15</h1>
    <table>
        <tr>
            <th>Title: </th>
            <td>There is flooding along the path</td>
            <td style="width:20px;">&nbsp;</td>
            <th>Submitted By: </th>
            <td>Jeffrey McDog</td>
        </tr>
        <tr>
            <th>Ticket Type: </th>
            <td>1 (High Water)</td>
            <td style="width:20px;">&nbsp;</td>
            <th>Date Submitted: </th>
            <td>08-30-2017 12:00:14</td>
        </tr>

        <tr>
            <th>Description: </th>
            <td>Watch this area to make sure it stays safe</td>
            <td style="width:20px;">&nbsp;</td>
            <th>Assigned Employee: </th>
            <td>John Dow</td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="button">Close Ticket</button> &nbsp; &nbsp;
                <button type="button">Add Note</button>
            </td>
            <td style="width:20px;">&nbsp;</td>
            <th>Urgent: </th>
            <td>No</td>
        </tr>
        <tr>
            <th>Image:</th>
            <td><img src="../images/loginBackground.jpg" width="400px" height="400px" alt="Ticket #15"></td>
            <td style="width:20px;">&nbsp;</td>
            <th>Location: </th>
            <td><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12023.14950213453!2d-85.1077816!3d41.1173345!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x64b8eb5cd29a3f47!2sIndiana+University+%E2%80%93+Purdue+University+Fort+Wayne+(IPFW)!5e0!3m2!1sen!2sus!4v1505530004250" style="border:0; width:400px; height:400px;" allowfullscreen></iframe></td>
        </tr>
    </table>
</div>

</body>
</html>

