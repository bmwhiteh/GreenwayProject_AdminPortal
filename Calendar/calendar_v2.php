!DOCTYPE html>
	<html>
	<head>
		<title>Calendar V2</title>
		<link rel="stylesheet" href="bootstrap-calendar-master/components/bootstrap3/css/bootstrap.min.css">
		<link rel="stylesheet" href="bootstrap-calendar-master/css/calendar.css">
		<link rel="shortcut icon" href="../Dashboard_Pages/favicon.ico" type="image/x-icon">
		  <style>
            .contentBox{
                background-color: #8c8c8c;
                margin: 0px 100px 50px 100px;
            }
        </style>
	</head>
	<body style="background-color: #1B371A;">
    <?php include "../Dashboard_Pages/navBar.php"; ?>

    <div class="contentBox">

		<div id="calendar"></div>

		<script type="text/javascript" src="../../js/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="bootstrap-calendar-master/components/underscore/underscore-min.js"></script>
		<script type="text/javascript" src="bootstrap-calendar-master/js/calendar.js"></script>
		<script type="text/javascript">
			var calendar = $("#calendar").calendar(
				{
					tmpl_path: "bootstrap-calendar-master/tmpls/",
					events_source: function () { return []; }
				});			
		</script>
	</div>
	</body>
	</html>