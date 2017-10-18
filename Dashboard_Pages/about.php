<!DOCTYPE html>
<html>

<head>
    <!--The title of the login page -->
    <title>About</title>
    <style>
        body{
            width: 100%;
            overflow: hidden;
            background-color: #1B371A ;
        }

        .contentBox{
            background-color: #8c8c8c;
            margin: 0px 100px 10px 100px;
            display: -webkit-flex;
            display: flex;
            height:470px;
        }
        .viridianTeam{
            height: 30%;
            background-color: #448b41;
        }

        .teamTwo{
            height: 30%;
            margin-top: 2%;
            background-color: #55ad52;
        }

        .teamThree{
            height: 30%;
            margin-top: 2%;
            background-color: #77be74;
        }
        .teamBoxes{
            -webkit-flex: 1;
            -ms-flex: 1;
            flex: 1;
            margin: 1% 1.5% 3% 3%
        }
    </style>

</head>

<body>

<?php include "../Dashboard_Pages/navBar.html"; ?>
<div class="contentBox">
    <div class="teamBoxes">
        <div class="viridianTeam">
            <h2><u>Viridian</u></h2>
            <p>Insert Info on Viridian Team here.</p>
        </div>
        <div class="teamTwo">
            <h2><u>Team Two</u></h2>
            <p>Insert Info on Team Two here.</p>
        </div>
        <div class="teamThree">
            <h2><u>Team Three</u></h2>
            <p>Insert Info on Team Three here.</p>
        </div>
    </div>
</div>

</body>
</html>