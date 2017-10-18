<!DOCTYPE html>
<html>
<head>
    <title>Profile Page</title>
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
        #usersInfo{
            text-align:center;
            float:left;
            width:50%;
        }
        #wrapper{
            border: 1px solid black;
            border-radius:20px;
            background-color:white;
            height:100%;
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
<h1 style="margin-bottom: 30px; margin-top:0px; color: white; vertical-aligh:middle; text-align: center;">User Profile</h1>

<div class="contentBox">
    <div id="wrapper">
        <div  id="usersInfo">
            <p>Name: John Dow</p>
            <p>Security Level: Ranger</p>
            <p>Email: johndoe@ranger.com</p>
            <button type="button">Change Password</button><br>
            <button type="button">Request Permissions</button>

        </div>
        <div  id="permission">
            <p>Permissions:</p>
            <p>Create New Tickets?: Yes</p>
            <p>Close Tickets?: Yes</p>
            <p>Manage Users?: No</p>
            <p>Send Notifications? No</p>
        </div>
    </div>
</div>

</body>
</html>

