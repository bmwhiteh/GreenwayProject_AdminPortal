<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data Analytics</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
   
	<link rel="icon" type="image/png" href="assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <!---<link rel="stylesheet" type="text/css" href="./css/styles.css"/>--->
    <link rel="stylesheet" type="text/css" href="/Data_Analytics/data_analytics.css"/>
    <link rel="shortcut icon" href="../Dashboard_Pages/favicon.png" type="image/x-icon">
    <script src="../js/jquery-3.2.1.min.js"></script>
    
	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin  -->  
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
-->
    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>

	<!-- Using Chartist for Graphs
	<script src="assets/js/populate_graphs.js"></script> 
-->
    <script src="../Data_Analytics/UsingD3/node_modules/chart.js/dist/Chart.js"></script>
    <script src="Tracked_Activities_JS/getPieChart.js"></script> 
	<script src="Tracked_Activities_JS/getBarChart.js"></script> 
    <script src="Tracked_Activities_JS/getRadarGraph.js"></script> 
    
    <script src="Tracked_Activities_JS/getLineGraph.js"></script>

	<script type="text/javascript">
    	function getTheGraphs(){

        	getPieChart();
        	getActivityTypes();
        	

            getRadarGraph();
            getBarGraph();

    	};
	</script>
    
    
    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project    
    <link href="assets/css/demo.css" rel="stylesheet" /> -->


    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    <style>
        


        ul { list-style-type: none; }

        a {            text-decoration: none;
        }

       


        .tile {
            height:300px;
            width:300px;
            
        }
        
         .col-md-6 {
            width: 47% !important;
        }
        
        .col-md-5, .col-md-7 {
            width:95% !important;
        }
        

    </style>
</head>
<body onLoad="getTheGraphs();"  class="genericBody">
<?php require_once("../Login_System/verifyAuth.php"); ?>
<?php include "../Dashboard_Pages/navBar.php"; ?>
    
<div class="contentBox" style="height:100%">

<?php date_default_timezone_set('EST');?>

<div class="wrapper">
    

    <div class="main-panel">
        

            <div class="container-fluid" style="background-color:grey; padding: 20px;">
                <div class="row">
                    <div class="col-md-6">
                        <!---This is the Pie Chart--->
                        <div class="card">

                            <div class="header">
                                <h4 class="title">Activity Distribution</h4>
                                <p class="category">All Activities Divided by Type</p>
                            </div>
                            <div class="content" style="height: 100%">
                                <!---<div id="chartPreferences" class="ct-chart ct-perfect-fourth" ></div>--->
                                <canvas id="myPieChart"></canvas>
                                <div class="footer">
                                    <!---<div class="legend" >
                                        <div id="PieChartLabels"></div>
                                        This populates using the labels from the javascript
                                    </div>--->
                                    <hr>
                                    <!---Needs to be the last time this data was pulled--->
                                    <div class="stats">
                                        <i class="fa fa-clock-o"></i> Updated: <?php echo date("F j, Y, g:i a");?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!---Radar Chart--->
                        <div class="card ">
                            <div class="header">
                                <h4 class="title">Activities per Month</h4>
                                <p class="category">Monthly Distribution</p>
                            </div>
                            <div class="content">
                               <canvas id="myRadarGraph"></canvas>
                                 <div class="footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> Updated: <?php echo date("F j, Y, g:i a");?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="row">
                    <div class="col-md-5">
                        
                        <!---This is the Stacked Line Graph--->
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Total Distance By Month</h4>
                                <p class="category">Number of Miles Tracked Per Month</p>
                            </div>
                            <div class="content">
                                 <canvas id="myBarGraph"></canvas>
                                 <div class="footer">
                                   <div id="showMessage"></div>
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> Updated: <?php echo date("F j, Y, g:i a");?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   <div class="col-md-7">
                        
                        <!---This is the Stacked Line Graph--->
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Total Distance By Month</h4>
                                <p class="category">Number of Miles Tracked Per Month</p>
                            </div>
                            <div class="content">
                                 <canvas id="myLineGraph"></canvas>
                                 <div class="footer">
                                   <div id="showMessage"></div>
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> Updated: <?php echo date("F j, Y, g:i a");?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>



    </div>
</div>



    


    
</div>

</body>


</html>
