function getTicketTypes(){
	
	//Initialize the ticket types array
	var types = [];

	//initialize the data variable
	var data = {
		"action": "get_ticket_types"
	};
	
	//serialize the data as a JSON pack and include the other parameters of the form
	data = $(this).serialize() + "&" + $.param(data);
	
	//perform the ajax action to go run the php with the sql query in it
	$.ajax({
		type: "POST",
		//input data type is a json message
		dataType: "json",
		url: "./Maintenance_JS/get_graph_data.php", //Relative or absolute path to filterUserActivity.php file
		data: data,
		//if the ajax successfully returns, this is what should be displayed and be what needs to change for your points
		success: function(data) {

			//get the JSON results
			var ticketsArray = JSON.parse(data["json"]);

			//for each result, grab the ticket type and throw it in the array
			for(var i = 0; i < ticketsArray.length; i++){

				var ticketType = ticketsArray[i]["ticketType"];
				
				//put the ticket type in the array to use later
				types[i] = ticketType;
				
			}
			
			//call the function that will create the graph based on the ticket types
			getLineGraph(types);

		}
		,
		error: function(XMLHttpRequest, textStatus, errorThrown) { 
			alert("Error: " + errorThrown); 
		}  
		
	});
	return false;
}	


function getLineGraph(types){	
	
	var data = {
	"action": "line_graph"
	};

	//serialize the data as a JSON pack and include the other parameters of the form
	data = $(this).serialize() + "&" + $.param(data);
	
	var lines = [];
	
	//create the individual lines for the line graph
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "./Maintenance_JS/get_graph_data.php", //Relative or absolute path to filterUserActivity.php file
		data: data,
		success: function(data) {

			//get the JSON
			var ticketsArray = JSON.parse(data["json"]);
			
			//create arrays for the colors that will be used for the lines (Background & Border Colors)
			var bgColorList = ["rgba(64, 186, 64, 1)", "rgba(59, 171, 59, 1)","rgba(54, 156, 54, 1)","rgba(49, 142, 49, 1)","rgba(44, 127, 44, 1)","rgba(39, 113, 39, 1)","rgba(34, 98,  34, 1)","rgba(29, 83, 29, 1)","rgba(24, 69, 24, 1)"];
			var bdColorList = ["rgba(64, 186, 64, 0.5)", "rgba(59, 171, 59, 0.5)","rgba(54, 156, 54, 0.5)","rgba(49, 142, 49, 0.5)","rgba(44, 127, 44, 0.5)","rgba(39, 113, 39, 0.5)","rgba(34, 98,  34, 0.5)","rgba(29, 83, 29, 0.5)","rgba(24, 69, 24, 0.5)"];

			//get the dataset for each ticket type
			for (var j=0; j<types.length; j++){
				
				//Counts for the ticket type are zero and changed if found in the query
				var counts = [0,0,0,0,0,0,0,0,0,0,0,0];


				//locate all results of the ticket type
				for(var i = 0; i < ticketsArray.length; i++){

					var ticketSlice = ticketsArray[i]["ticketType"];
					var ticket = ticketSlice.split(",");
					var typeName = ticket[0];
					
					//if the ticket type found matches what we are looking for, continue
					if (typeName == types[j]){

						var typeCount = parseFloat(ticket[1]);
						var typeMonth = parseFloat(ticket[2]);
						
						//place the count of each month in the bucket corresponding to the month
						counts[typeMonth-1] = typeCount;
						

					}
					
				
				}
				
				
				
				//Get the colors for this ticket type
				var bgColor = bgColorList[j];
				var bdColor = bdColorList[j];
				
				//Set the Dataset properties for this line
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
					pointHoverBackgroundColor: bgColor,
					pointHoverBorderColor: bdColor,
					pointHoverBorderWidth: 2,
					pointRadius: 4,
					pointHitRadius: 2,
					// notice the gap in the data and the spanGaps: true

					data: counts,
					spanGaps: true,
				};



				//add the ticket data into the lines array
				lines[j] = TicketData;
				
				
			}
		
			//Add the datasets into the Data part of the graph
			var dataPreferences_Lines = {
				labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"], //
				datasets: lines
			};

			//Options for the Line graph
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
    	
			//Create the Line Graph and assign it to the proper canvas element
			var canvas = document.getElementById("myLineGraph");
			var ctx = canvas.getContext('2d');
			new Chart(ctx,{
				type: 'line',
				data: dataPreferences_Lines,
				options: options
			});
			
		 
		}
		,
		error: function(XMLHttpRequest, textStatus, errorThrown) { 
			alert("Error: " + errorThrown); 
		}  
		
		
	});
	

}