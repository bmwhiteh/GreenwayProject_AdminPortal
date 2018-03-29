function getActivityTypes(){
	
	//Initialize the ticket types array
	var types = [];

	//initialize the data variable
	var data = {
		"action": "activity_types"
	};
	
	//serialize the data as a JSON pack and include the other parameters of the form
	data = $(this).serialize() + "&" + $.param(data);
	
	//perform the ajax action to go run the php with the sql query in it
	$.ajax({
		type: "POST",
		//input data type is a json message
		dataType: "json",
		url: "./Tracked_Activities_JS/get_graph_data.php", //Relative or absolute path to filterUserActivity.php file
		data: data,
		//if the ajax successfully returns, this is what should be displayed and be what needs to change for your points
		success: function(data) {
			//get the JSON results
			var activityJSON = JSON.parse(data["json"]);

			//for each result, grab the ticket type and throw it in the array
			for(var i = 0; i < activityJSON.length; i++){

				var activityType = activityJSON[i]["ActivityTypes"];
				
				//put the ticket type in the array to use later
				types[i] = activityType;
				
			}
			//console.log(types);
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
		url: "./Tracked_Activities_JS/get_graph_data.php", //Relative or absolute path to filterUserActivity.php file
		data: data,
		success: function(data) {
			//get the JSON
			var activityJSON = JSON.parse(data["json"]);
			
					var name = "colorArray=";
          var colors = "";
          var decodedCookie = decodeURIComponent(document.cookie);
          var ca = decodedCookie.split(';');
          for(var i = 0; i <ca.length; i++) {
              var c = ca[i];
              while (c.charAt(0) == ' ') {
                  c = c.substring(1);
              }
              if (c.indexOf(name) == 0) {
                  colors =  c.substring(name.length, c.length);
              }
          }
          var colorArray = colors.split(",");
			
			
			
			//create arrays for the colors that will be used for the lines (Background & Border Colors)
			var bgColorList = colorArray;
			var bdColorList = colorArray;
			//get the dataset for each ticket type
			for (var j=0; j<types.length; j++){
				
				//Counts for the ticket type are zero and changed if found in the query
				var counts = [0,0,0,0,0,0,0];


				//locate all results of the ticket type
				for(var i = 0; i < activityJSON.length; i++){

					var ticketSlice = activityJSON[i]["ActivityPerWeekday"];
					var ticket = ticketSlice.split(",");
					var typeName = ticket[1];
					
					//if the ticket type found matches what we are looking for, continue
					if (typeName == types[j]){

						var typeCount = parseFloat(ticket[0]);
						var typeDay = parseFloat(ticket[2]);
						
						//place the count of each month in the bucket corresponding to the month
						counts[typeDay] = typeCount;
						

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
		
				//console.log(lines);
			//Add the datasets into the Data part of the graph
			var dataPreferences_Lines = {
				labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"], //
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