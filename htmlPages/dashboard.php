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
        .leftSide{
            -webkit-flex: 1;
            -ms-flex: 1;
            flex: 1;
            margin: 3% 1.5% 3% 3%
        }
        .heatMap{
            -webkit-flex: 2;
            -ms-flex: 2;
            flex: 2;
            margin: 3% 1.5% 3% 1.5%;
        }

        .twitter{
            -webkit-flex: 1;
            -ms-flex: 1;
            flex: 1;
            margin: 3% 3% 3% 1.5%
        }
        .topBox{
            height: 30%;
            background-color: #448b41;
        }

        .midBox{
            height: 30%;
            margin-top: 5%;
            background-color: #55ad52;
        }

        .bottomBox{
            height: 30%;
            margin-top: 5%;
            background-color: #77be74;
        }

    </style>

</head>

<body>

    <?php include "navBar.html"; ?>
<div class="contentBox">
    <div class="leftSide">
        <div class="topBox"> Number of Current People on the Trail</div>
        <div class="midBox"> Number of Open Tickets </div>
        <div class="bottomBox"> Number of Tickets closed in the last 7 days</div>
    </div>
    <div class="heatMap">
        <img src="../images/Temporary Picture.jpg" width="100%" height="253px"/>
    </div>
    <div class="twitter">
        <a class="twitter-timeline" data-width="400" data-height="400" href="https://twitter.com/FortWayneTrails">Tweets by @FortWayneTrails</a>
        <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
</div>

</body>
</html>