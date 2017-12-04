var types = {
	initChartJS: function(){
		

	}
	
}
	
var line = {	createLineGraph: function(){
		/*
		* Create a Line Graph for Tickets By Month
		*/  
		/*
		* Get an Array of the Ticket Types
		*/
		var types = [];

		//initialize the data variable
		var data = {
			"action": "get_ticket_types"
		};
		
		//serialize the data as a JSON pack and include the other parameters of the form
		data = $(this).serialize() + "&" + $.param(data);
		
		
		//perform the ajax action to go run the php with the sql query in it
		var getTypesAjaxResult = $.ajax({
			type: "POST",
			//input data type is a json message
			dataType: "json",
			url: "./get_graph_data.php", //Relative or absolute path to filterUserActivity.php file
			data: data,
			//if the ajax successfully returns, this is what should be displayed and be what needs to change for your points
			success: function(data) {

				//get the JSON
				var ticketsArray = JSON.parse(data["json"]);
	
	
				for(var i = 0; i < ticketsArray.length; i++){
	
					var ticketType = ticketsArray[i]["ticketType"];
					//put the ticket type in the array to parse later
					types[i] = ticketType;
				}


			}
			,
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
				alert("Error: " + errorThrown); 
			}  
		});
		var data = {
		"action": "line_graph"
		};

		//serialize the data as a JSON pack and include the other parameters of the form
		data = $(this).serialize() + "&" + $.param(data);
		
		var things = [];
		
		//perform the ajax action to go run the php with the sql query in it
		$.ajax({
			type: "POST",
			//input data type is a json message
			dataType: "json",
			url: "./get_graph_data.php", //Relative or absolute path to filterUserActivity.php file
			data: data,
			//if the ajax successfully returns, this is what should be displayed and be what needs to change for your points
			success: function(data) {

				//get the JSON
				var ticketsArray = JSON.parse(data["json"]);
				var bgColorList = ["rgba(64, 186, 64, 1)", "rgba(59, 171, 59, 1)","rgba(54, 156, 54, 1)","rgba(49, 142, 49, 1)","rgba(44, 127, 44, 1)","rgba(39, 113, 39, 1)","rgba(34, 98,  34, 1)","rgba(29, 83, 29, 1)","rgba(24, 69, 24, 1)"];
				var bdColorList = ["rgba(64, 186, 64, 0.5)", "rgba(59, 171, 59, 0.5)","rgba(54, 156, 54, 0.5)","rgba(49, 142, 49, 0.5)","rgba(44, 127, 44, 0.5)","rgba(39, 113, 39, 0.5)","rgba(34, 98,  34, 0.5)","rgba(29, 83, 29, 0.5)","rgba(24, 69, 24, 0.5)"];

				//get the dataset for each ticket type
				for (var j=0; j<types.length; j++){
					var counts = [];


					//locate all results of the ticket type
					for(var i = 0; i < ticketsArray.length; i++){

						var ticketSlice = ticketsArray[i]["ticketType"];
						var ticket = ticketSlice.split(",");
						//console.log(ticket);
						//if the ticket type found matches what we are looking for, continue
						if (ticket[0] == types[j]){

							var typeName = ticket[0];
							var typeCount = parseFloat(ticket[1]);
							var typeMonth = parseFloat(ticket[2]);
							//console.log("name:"+typeName + " count:"+typeCount + " month:"+typeMonth);
							//place the count of each month in the bucket corresponding to the month
							if (typeCount === undefined){
								counts[typeMonth] = 0;
							}else{
								counts[typeMonth] = typeCount;
							}
							

						}
					}
					//console.log(counts);
					//create the dataset var and place in array
					var bgColor = bgColorList[j];
					var bdColor = bdColorList[j];
					var TicketData = {
						label: types[j] ,
						fill: false,
						lineTension: 0.1,
						backgroundColor: bgColor ,
						borderColor: bdColor, // The main line color
						borderCapStyle: 'square',
						borderDash: [], // try [5, 15] for instance
						borderDashOffset: 0.0,
						borderJoinStyle: 'miter',
						pointBorderColor: bgColor,
						pointBackgroundColor: bdColor,
						pointBorderWidth: 1,
						pointHoverRadius: 8,
						pointHoverBackgroundColor: "yellow",
						pointHoverBorderColor: "brown",
						pointHoverBorderWidth: 2,
						pointRadius: 4,
						pointHitRadius: 10,
						// notice the gap in the data and the spanGaps: true

						data: counts,
						spanGaps: true,
					};




					things[j] = TicketData;
				}
			}
			,
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
				alert("Error: " + errorThrown); 
			}  
		});

		




		// Global Options:
       
       
        
		var dataThings = {
			labels: ["Sep", "Oct", "Nov", "Dec"], //"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", 
			datasets: things
		};

		console.log(dataThings);

		// Notice the scaleLabel at the same level as Ticks
		var options = {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:true
					},
					scaleLabel: {
						display: true,
						labelString: 'Count',
						fontSize: 20 
					}
				}]            
			}  
		};

		// Chart declaration:
		var canvas = document.getElementById("myLineGraph");
		var ctx = canvas.getContext('2d');
		var myLieGraph = new Chart(ctx,{
			type: 'line',
			data: dataThings,
			options: options
		});

	}
}

var pie = {	createPieChart: function(){

		/*
		* Create a Pie Chart for Total Tickets
		*/

		//initialize the data variable
		var dataPie = {
			"action": "pie_chart"
		};
		
		//serialize the data as a JSON pack and include the other parameters of the form
		dataPie = $(this).serialize() + "&" + $.param(dataPie);
		
		//perform the ajax action to go run the php with the sql query in it
		$.ajax({
			type: "POST",
			//input data type is a json message
			dataType: "json",
			url: "./get_graph_data.php", //Relative or absolute path to filterUserActivity.php file
			data: dataPie,
			//if the ajax successfully returns, this is what should be displayed and be what needs to change for your points
			success: function(dataPie) {

				//get the JSON
				var ticketsArray = JSON.parse(dataPie["json"]);
				var pieCountList = [];
				var pieTypeList = [];
				var i = 0;
				var total = 0;
				//go through the array to get the name & counts
				for(i = 0; i < ticketsArray.length; i++){

					var ticketSlice = ticketsArray[i]["ticketType"];
					var ticket = ticketSlice.split(",");
					var typeName = ticket[0];
					var typeCount = parseFloat(ticket[1]);

					total += typeCount;

					pieCountList.push(typeCount);
					pieTypeList.push(typeName);

				}

				var piePercentageList = [];
				var pieLabelList = [];

				for(var j= 0; j<pieCountList.length; j++){
					var count = pieCountList[j];
					//add the percentages into an array
					var value = ((count / total)*100).toFixed(1);
					piePercentageList.push(value) ;

					pieLabelList.push(String(Math.round(value)) + "%");

				}



				var dataPreferences = {
					labels: pieTypeList,
					datasets: [{
					label: 'Ticket Distribution', 
					data: piePercentageList,
					backgroundColor: [
					'rgba(64, 186, 64, 1)',
					'rgba(59, 171, 59, 1)',
					'rgba(54, 156, 54, 1)',
					'rgba(49, 142, 49, 1)',
					'rgba(44, 127, 44, 1)',
					'rgba(39, 113, 39, 1)',
					'rgba(34, 98,  34, 1)',
					'rgba(29, 83, 29, 1)',
					'rgba(24, 69, 24, 1)'
					],
					borderColor: [
					'rgba(232, 232, 232, 1)',
					'rgba(232, 232, 232, 1)',
					'rgba(232, 232, 232, 1)',
					'rgba(232, 232, 232, 1)',
					'rgba(232, 232, 232, 1)',
					'rgba(232, 232, 232, 1)',
					'rgba(232, 232, 232, 1)',
					'rgba(232, 232, 232, 1)',
					'rgba(232, 232, 232, 1)',
					],
					borderWidth: 1
					}]
				};


				var pie_ctx = document.getElementById("myPieChart");
				var myPieChart = new Chart(pie_ctx,{
					type: 'pie',
					data: dataPreferences
				});
			}
			,
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
				alert("Error: " + errorThrown); 
			}  
		}); 
	}
}