
function getBarGraph(){	
	
	var data = {
	"action": "bar_graph"
	};

	//serialize the data as a JSON pack and include the other parameters of the form
	data = $(this).serialize() + "&" + $.param(data);
	
	//perform the ajax action to go run the php with the sql query in it
	$.ajax({
		type: "POST",
		//input data type is a json message
		dataType: "json",
		url: "./User_Information_JS/get_graph_data.php", //Relative or absolute path to filterUserActivity.php file
		data: data,
		//if the ajax successfully returns, this is what should be displayed and be what needs to change for your points
		success: function(data) {

			//get the JSON
			var resultsArray = JSON.parse(data["json"]);
			//console.log(resultsArray);
			var bgColorList = ["rgba(64, 186, 64, 1)", "rgba(59, 171, 59, 1)","rgba(54, 156, 54, 1)","rgba(49, 142, 49, 1)","rgba(44, 127, 44, 1)","rgba(39, 113, 39, 1)","rgba(34, 98,  34, 1)","rgba(29, 83, 29, 1)","rgba(24, 69, 24, 1)"];
			var bdColorList = ["rgba(64, 186, 64, 0.5)", "rgba(59, 171, 59, 0.5)","rgba(54, 156, 54, 0.5)","rgba(49, 142, 49, 0.5)","rgba(44, 127, 44, 0.5)","rgba(39, 113, 39, 0.5)","rgba(34, 98,  34, 0.5)","rgba(29, 83, 29, 0.5)","rgba(24, 69, 24, 0.5)"];
			
			var counts = [];
			var labels = [];
			//get the dataset for each ticket type
			for (var j=0; j<resultsArray.length; j++){
				

				var resultItem = resultsArray[j]["zipList"];
				var result = resultItem.split(",");
				//console.log(ticket);
				var zipCode = result[0];
				var zipCount = parseFloat(result[1]);
				counts[j] = zipCount;
				labels[j] = zipCode;
				
				
			
				
			}			

		console.log(counts);
		console.log(labels);
		
		
		
		var bar_dataPreferences = {
    		labels: labels, //
    		datasets: [
	        {
	        	label: "Users per Zip Code",
	        	backgroundColor: "rgba(49, 142, 49, 1)",
	        	data: counts
	        }],
	        xAxisID: "# of Users",
	        yAxisID: "Registered Zip Codes"
	        
    	};

    	console.log(bar_dataPreferences);
    
    	// Notice the scaleLabel at the same level as Ticks
    	var bar_options = {
    		scales: {
		        xAxes: [{
		            gridLines: {
		                offsetGridLines: true
		            }
		        }],
		        yAxes: [{
		            ticks: {
		                beginAtZero: true
		            }
		        }]
    
		    }  
    	};
    	
    	// Chart declaration:
    	var canvas = document.getElementById("myBarGraph");
    	var ctx = canvas.getContext('2d');
		var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: bar_dataPreferences,
            
            options: bar_options
        });
		}
		,
		error: function(XMLHttpRequest, textStatus, errorThrown) { 
			alert("Error: " + errorThrown); 
		}  
	});

	

}