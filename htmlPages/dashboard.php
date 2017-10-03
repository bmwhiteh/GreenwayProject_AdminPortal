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
            background-color: #aaaaaa;
            margin: 0px 100px 50px 100px;
            display: -webkit-flex;
            display: flex;
        }
        .leftSide{
            -webkit-flex: 1;
            -ms-flex: 1;
            flex: 1;
        }
        .heatMap{
            -webkit-flex: 2;
            -ms-flex: 2;
            flex: 2;
            margin: 3% 1.5% 3% 3%;
        }

        .twitter{
            -webkit-flex: 1;
            -ms-flex: 1;
            flex: 1;
            margin: 3% 3% 3% 1.5%
        }

    </style>

</head>

<body>

    <?php include "navBar.html"; ?>
<div class="contentBox">
    <div class="leftSide">
        <div class="topBox" style="background-color: #bbb"> <p>TOP</p>       </div>
        <div class="midBox" style="background-color: #bbb"><p>MID</p></div>
        <div class="bottomBox" style="background-color: #bbb"><p>BOTTOM</p></div>
    </div>
    <div class="heatMap">
        <img src="../images/Temporary Picture.jpg" width="100%" height="250px"/>
    </div>
    <div class="twitter">
        <a class="twitter-timeline" data-width="400" data-height="400" href="https://twitter.com/FortWayneTrails">Tweets by @FortWayneTrails</a>
        <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
</div>

</body>
</html>