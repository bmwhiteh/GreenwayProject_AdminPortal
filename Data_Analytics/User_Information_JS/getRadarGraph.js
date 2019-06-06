function getRadarGraph(){
    	
    	//initialize the data variable
		var data = {
			"action": "radar"
		};
		
		var usersFemale = [0,0,0,0,0,0,0,0,0,0,0,0];
		var usersMale =   [0,0,0,0,0,0,0,0,0,0,0,0];
		var unspecified =  [0,0,0,0,0,0,0,0,0,0,0,0]; 
		
		
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
				var ticketsArray = JSON.parse(data["json"]);
				
				//locate all results of the ticket type
				for(var i = 0; i < ticketsArray.length; i++){

					var ticketSlice = ticketsArray[i]["ticketType"];
					var ticket = ticketSlice.split(",");
				
					var countUsers  = parseFloat(ticket[0]);
					var strGender = ticket[1];
					var dtMonth = parseFloat(ticket[2]);
					
					
					//console.log("month:"+dtMonth + " open:"+countOpen + " close:"+countClosed);
					//place the count of each month in the bucket corresponding to the month
					
					if(strGender == 'F'){
						usersFemale[dtMonth-1] = countUsers;
					}else if(strGender == 'M'){
						usersMale[dtMonth-1] = countUsers;
					}else{
						unspecified[dtMonth-1] = countUsers;
					}
				}	
				//console.log(usersFemale);
				//console.log(usersMale);

				
				
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
			
			
			

				var radar_dataPreferences = {
					labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
					datasets: [{
	    					label: "Female Users",
	    					backgroundColor: colorArray[0] ,
							borderColor: colorArray[0],
	    					data: usersFemale
						},
						{
							label: "Male Users",
							backgroundColor: colorArray[1] ,
							borderColor: colorArray[1],
							data: usersMale
						}
						,
						{
							label: "Unspecified",
							backgroundColor: colorArray[2] ,
							borderColor: colorArray[2],
							data: unspecified
						}
	    				]
				};
	
	
				//console.log(openTicketsPerMonth);

                var radar_optionPreferences = {
                 
				    scale: {
				        // Hides the scale
				        display: true
				    }

					
            	};
                


				var ctx = document.getElementById("myRadarGraph");
				var myRadarGraph = new Chart(ctx, {
				    type: 'radar',
				    data: radar_dataPreferences,
				    options: radar_optionPreferences
				});
			}
			,
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
				alert("Error: " + errorThrown); 
			}  
		}); 
    	
    	
       
    }
    
