<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data Analytics</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
       <link rel="stylesheet" type="text/css" href="/Data_Analytics/data_analytics.css"/>

	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<link rel="shortcut icon" href="../Dashboard_Pages/favicon.ico" type="image/x-icon">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/chartist.min.js"></script><!--  Charts Plugin -->
	<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script> <!--Light Bootstrap JS-->

	<!-- Chart JS Implementation Files -->
    <script src="../Data_Analytics/UsingD3/node_modules/chart.js/dist/Chart.js"></script>
    <script src="./Maintenance_JS/getPieChart.js"></script> 
	<script src="./Maintenance_JS/getLineGraph.js"></script> 
    <script src="./Maintenance_JS/getBarChart.js"></script> 
    <script src="./Maintenance_JS/getTicketList.js"></script>

    <script type="text/javascript">
        function getTheGraphs(){
        
            getPieChart(); //Pie Chart of Ticket Type Distribution
            getTicketTypes(); //Line Graphs of Ticket Counts per Ticket Type
            getBarChart(); //Bar Chart Showing Open vs. Closed Tickets per Month
            getTicketList(); //List Open Tickets that are Assigned to Current Employee
        
        };
    </script>
    
    
    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications  --> 
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS   --> 
    <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>

    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    
    
</head>

<!--Load the Graphs as the page Loads-->
<body onLoad="getTheGraphs();" class="genericBody">
    <?php require_once("../Login_System/verifyAuth.php"); ?>
    <!--Include the Navigation Bar-->
    <?php include "../Dashboard_Pages/navBar.php"; ?>
    
    
    
    <div class="contentBox">
    
        <!--Set the Time zone to EST for the time calculations-->
        <?php date_default_timezone_set('EST');?>
        

        
            <div class="main-panel">
                
        
                <div class="container-fluid" style="background-color:grey; padding: 20px; ">
                    
                    <!--First Row of Graphs-->
                    <div class="row">
                        
                        <!--Each Graph is embedded in a "Card" (col-md-6 is the size of the card)-->
                        <div class="col-md-5">
                            
                            <div class="card">
                                
                                <div class="header">
                                    <h4 class="title">Ticket Distribution</h4>
                                    <p class="category">All Existing Tickets by Ticket Type</p>
                                </div>
                                
                                <div class="content" style="height: 100%">
                                    
                                    <!--Canvas Element holds the Pie Chart-->
                                    <canvas id="myPieChart"></canvas>
                                    
                                    <!--The graphs are updated on page load so this will change to current time of page load-->
                                    <div class="footer">
                                        <hr>
                                        <div class="stats">
                                            <i class="fa fa-clock-o"></i> Updated: <?php echo date("F j, Y, g:i a");?>
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                                
                                
                            </div>
                            
                            
                        </div>
                        
                        <!--This is a Bar Graph comparing Open to Closed Tickets-->
                        <div class="col-md-6">
                            
                            <div class="card ">
                                
                                <div class="header">
                                    <h4 class="title">Open vs. Closed Tickets</h4>
                                    <p class="category">Monthly Distribution</p>
                                </div>
                                
                                <div class="content">
                                   
                                    <!--Canvas element contains the Bar Chart-->
                                    <canvas id="myBarChart"></canvas>
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
    
    
                    <!--Second Row, Third total Chart-->        
                    <div class="row">
                        
                        <div class="col-md-7">
                            
                            <div class="card">
                                
                                <div class="header">
                                    <h4 class="title">Ticket Types By Month</h4>
                                    <p class="category">Tickets submitted for each category per month</p>
                                </div>
                                
                                <div class="content">
                                     
									<!--Canvas contains a Multi-Line Graph showing Ticket Type Counts-->
									<canvas id="myLineGraph"></canvas>
									<div class="footer">
										<hr>
										<div class="stats">
											<i class="fa fa-history"></i> Updated: <?php echo date("F j, Y, g:i a");?>
										</div>
									</div>
                                    
                                    
                                </div>


                            </div>


                        </div>
                        
                        <!--Fourth Card is a list of Open Tickets assigned to the Employee-->
                        <div class="col-md-3">
                            
                            <div class="card ">
                                
                                <div class="header">
                                    <h4 class="title">My Assigned Tickets</h4>
                                    <p class="category">From Ticket System</p>
                                </div>
                                
                                <div class="content">
                                    <div class="table-full-width">
                                        
                                        <!--Javascript adds rows of content to this table-->
                                        <table class="table">
                                            <tbody id="employeeTicketList"></tbody>
                                        </table>
                                        
                                        
                                    </div>
    
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


                </div>


			</div>


		

            
    </div>

</body>


</html>
