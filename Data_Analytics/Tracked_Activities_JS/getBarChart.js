
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
		url: "./Tracked_Activities_JS/get_graph_data.php", //Relative or absolute path to filterUserActivity.php file
		data: data,
		//if the ajax successfully returns, this is what should be displayed and be what needs to change for your points
		success: function(data) {

			//get the JSON
			var resultsArray = JSON.parse(data["json"]);
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
			var counts = [];
			var labels = [];
			//get the dataset for each ticket type
			for (var j=0; j<resultsArray.length; j++){
				

				var resultItem = resultsArray[j]["DistancePerMonth"];
				var result = resultItem.split(",");
				//console.log(resultItem);
				var totalDistance = result[0];
				var month = result[1];
				
				var monthList = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec")

			    var d = new Date();
			    var year = d.getFullYear();
			    var first = "00";
			    
			    if(month.toString().length <2){
			    	month = "0"+month;
			    }
			    
			    var monthAsDate = new Date(year,month, first);
			    
			    var monthAsString = monthList[monthAsDate.getMonth()];
				
				counts[j] = totalDistance;
				labels[j] = monthAsString;
				
				
			
				
			}			

		//console.log(counts);
		//console.log(labels);
		
		
		
		var bar_dataPreferences = {
    		labels: labels, //
    		datasets: [
	        {
	        	label: "Total Distance Per Month",
	        	backgroundColor: bgColorList[0],
	        	data: counts
	        }],
	        xAxisID: "Month",
	        yAxisID: "Total Distance (Miles)"
	        
    	};

    	//console.log(bar_dataPreferences);
    
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