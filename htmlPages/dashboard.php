<!DOCTYPE html>

<html>
<head>
    <title>Home</title>
    <style>
        body{
            width: 100%;
            margin: auto;
            margin: 0 auto;
            background-color: rgb(208,240,192);
        }

        .container {
            padding: 16px;
            vertical-align: middle;
            width:35%;
            margin-top:20%;
            margin-left:30%;
            background-color: rgba(211, 211, 211,0.8) ;
        }

        .header{
            background-color: rgba(211,211,211,0.8);
            width:100%;
            top:0;
            position:fixed;
        }

        .twitter{
            margin-left:68%;
            margin-top:2%;
        }

    </style>

</head>

<body>
<div class="header">
    <div class="picLogo">
        <h1>CoFW Trail Network Admin Portal</h1>
    </div>
</div>
<div class="menu">
    <?php include "navBar.html"; ?>
</div>

<div class="twitter">
    <a class="twitter-timeline" data-width="400" data-height="400" href="https://twitter.com/FortWayneTrails">Tweets by @FortWayneTrails</a>
    <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
</div>
</body>
</html>