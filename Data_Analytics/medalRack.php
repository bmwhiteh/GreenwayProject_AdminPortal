<!DOCTYPE html>

<html>
<head>
    <title>Medal Rack</title>
        <link rel="stylesheet" type="text/css" href=<?php echo $_COOKIE['colorCssLink'];?>>
        <link rel="stylesheet" type="text/css" href="/css/medalRack.css"/>
        <link rel="shortcut icon" href="../Dashboard_Pages/favicon.png" type="image/x-icon">
        
        <script src="https://code.jquery.com/jquery-1.11.0.min.js" /></script>
        <script src = "../js/changeColorScheme.js"></script>

</head>

<body class="genericBody">
    <?php include "../Dashboard_Pages/navBar.php"; ?>
<!-- 1st row verticaly centered text in the square columns -->
<div class="contentBox">
    <div id="box">
        <div style="padding-top:1%;">
        <img src="../images/medal.png" style="width:3%; height: 3%;"/>
        <h1 style="display: inline;">MEDAL RACK</h1>
        <img src="../images/medal.png" style="width:3%; height: 3%;"/>
       </div>
    <div class="square">
    <div class="content">
        <div class="table">
            <div class="table-cell">
                <img id="badge" class="rs" src="./badges/badgeFanaticColor.png"/>
            </div>
            <div class="overlay">
                <div class="badgeName"><h2>Trail Fanatic</h2></div>
                <div class="badgeDescription">Description: Visit the trail every day of the week!</div>
                <div class="badgeEarned">Number Earned: <?php include "./Medals/getCountTrailFanatic.php"?></div> 
            </div>
        </div>
    </div>
    
    </div>
    <div class="square">
    <div class="content">
        <div class="table">
            <div class="table-cell">
                <img id="badge" class="rs" src="./badges/badgeFeelBurnColor.png"/>
            </div>
            <div class="overlay">
                <div class="badgeName"><h2>Feel the Burn</h2></div>
                <div class="badgeDescription">Description: Burn 500 calories in one activity!</div>
                <div class="badgeEarned">Number Earned: <?php include "./Medals/getCountFeelBurn.php"?></div> 
            </div>
        </div>
    </div>
    
    </div>
    
    <div class="square">
    <div class="content">
        <div class="table">
            <div class="table-cell">
                <img id="badge" class="rs" src="./badges/badgeWheelsColor.png"/>
            </div>
            <div class="overlay">
                <div class="badgeName"><h2>Wheels of Steel</h2></div>
                <div class="badgeDescription">Description: Cycle for 3 hours!</div>
                <div class="badgeEarned">Number Earned: <?php include "./Medals/getCountWheelsSteel.php"?></div> 
            </div>
        </div>
    </div>
    
    </div>
    <div class="square">
    <div class="content">
        <div class="table">
            <div class="table-cell">
                <img id="badge" class="rs" src="./badges/badgeLongHaulColor.png"/>
            </div>
            <div class="overlay">
                <div class="badgeName"><h2>The Long Haul</h2></div>
                <div class="badgeDescription">Description: Cycle for more than 25 miles!</div>
                <div class="badgeEarned">Number Earned: <?php include "./Medals/getCountLongHaul.php"?></div> 
            </div>
        </div>
    </div>
    
    </div>
    <div class="square">
    <div class="content">
        <div class="table">
            <div class="table-cell">
                <img id="badge" class="rs" src="./badges/badgeNomadColor.png"/>
            </div>
            <div class="overlay">
                <div class="badgeName"><h2>Trail Nomad</h2></div>
                <div class="badgeDescription">Description: Walk for over 2 miles!</div>
                <div class="badgeEarned">Number Earned: <?php include "./Medals/getCountNomad.php"?></div> 
            </div>
        </div>
    </div>
    
    </div>
    <div class="square">
    <div class="content">
        <div class="table">
            <div class="table-cell">
                <img id="badge" class="rs" src="./badges/badgeNeighborColor.png"/>
            </div>
            <div class="overlay">
                <div class="badgeName"><h2>Neighborhood Watch</h2></div>
                <div class="badgeDescription">Description: Submit 3 problem tickets!</div>
                <div class="badgeEarned">Number Earned: <?php include "./Medals/getCountNeighborhoodWatch.php"?></div> 
            </div>
        </div>
    </div>
    
    </div>
    <div class="square">
    <div class="content">
        <div class="table">
            <div class="table-cell">
                <img id="badge" class="rs" src="./badges/badgeRosesColor.png"/>
            </div>
            <div class="overlay">
                <div class="badgeName"><h2>Stop & Smell the Roses</h2></div>
                <div class="badgeDescription">Description: Walk for over 2 hours!</div>
                <div class="badgeEarned">Number Earned: <?php include "./Medals/getCountStopSmellRoses.php"?></div> 
            </div>
        </div>
    </div>
    
    </div>
    <div class="square">
    <div class="content">
        <div class="table">
            <div class="table-cell">
               <img id="badge" class="rs" src="./badges/badgeWayfinderColor.png"/>
            </div>
            <div class="overlay">
                <div class="badgeName"><h2>Wayfinder</h2></div>
                <div class="badgeDescription">Description: Log 100 activities!</div>
                <div class="badgeEarned">Number Earned: <?php include "./Medals/getCountWayfinder.php"?></div> 
            </div>
        </div>
    </div>
    
    </div>
    <div class="square">
    <div class="content">
        <div class="table">
            <div class="table-cell">
                <img id="badge" class="rs" src="./badges/badgeLimitColor.png"/>
            </div>
            <div class="overlay">
                <div class="badgeName"><h2>Push It to the Limit</h2></div>
                <div class="badgeDescription">Description: Run faster than 7 mph!</div>
                <div class="badgeEarned">Number Earned: <?php include "./Medals/getCountPushIt.php"?></div> 
            </div>
        </div>
    </div>
    
    </div>
    <div class="square">
    <div class="content">
        <div class="table">
            <div class="table-cell">
                <img id="badge" class="rs" src="./badges/badgeStartStrongColor.png"/>
            </div>
            <div class="overlay">
                <div class="badgeName"><h2>Startin' Strong</h2></div>
                <div class="badgeDescription">Description: Go for your first run!</div>
                <div class="badgeEarned">Number Earned: <?php include "./Medals/getCountStartingStrong.php"?></div> 
            </div>
        </div>
    </div>
    
    </div>
    <div class="square">
    <div class="content">
        <div class="table">
            <div class="table-cell">
                <img id="badge" class="rs" src="./badges/badgeBurningColor.png"/>
            </div>
            <div class="overlay">
                <div class="badgeName"><h2>Burning Rubber</h2></div>
                <div class="badgeDescription">Description: Cycle over 25 mph!</div>
                <div class="badgeEarned">Number Earned: <?php include "./Medals/getCountBurningRubber.php"?></div> 
            </div>
        </div>
    </div>
    
    </div>
    </div>
    
</div>

</body>
</html>