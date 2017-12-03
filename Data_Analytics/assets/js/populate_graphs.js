type = ['','info','success','warning','danger'];


demo = {
    initPickColor: function(){
        $('.pick-class-label').click(function(){
            var new_class = $(this).attr('new-class');
            var old_class = $('#display-buttons').attr('data-class');
            var display_div = $('#display-buttons');
            if(display_div.length) {
            var display_buttons = display_div.find('.btn');
            display_buttons.removeClass(old_class);
            display_buttons.addClass(new_class);
            display_div.attr('data-class', new_class);
            }
        });
    },

    checkScrollForTransparentNavbar: debounce(function() {
            $navbar = $('.navbar[color-on-scroll]');
            scroll_distance = $navbar.attr('color-on-scroll') || 500;

            if($(document).scrollTop() > scroll_distance ) {
                if(transparent) {
                    transparent = false;
                    $('.navbar[color-on-scroll]').removeClass('navbar-transparent');
                    $('.navbar[color-on-scroll]').addClass('navbar-default');
                }
            } else {
                if( !transparent ) {
                    transparent = true;
                    $('.navbar[color-on-scroll]').addClass('navbar-transparent');
                    $('.navbar[color-on-scroll]').removeClass('navbar-default');
                }
            }
    }, 17),

    initDocChartist: function(){
        var dataSales = {
          labels: ['9:00AM', '12:00AM', '3:00PM', '6:00PM', '9:00PM', '12:00PM', '3:00AM', '6:00AM'],
          series: [
             [287, 385, 490, 492, 554, 586, 698, 695, 752, 788, 846, 944],
            [67, 152, 143, 240, 287, 335, 435, 437, 539, 542, 544, 647],
            [23, 113, 67, 108, 190, 239, 307, 308, 439, 410, 410, 509]
          ]
        };

        var optionsSales = {
          lineSmooth: false,
          low: 0,
          high: 800,
          showArea: true,
          height: "245px",
          axisX: {
            showGrid: false,
          },
          lineSmooth: Chartist.Interpolation.simple({
            divisor: 3
          }),
          showLine: false,
          showPoint: false,
        };

        var responsiveSales = [
          ['screen and (max-width: 640px)', {
            axisX: {
              labelInterpolationFnc: function (value) {
                return value[0];
              }
            }
          }]
        ];

        Chartist.Line('#chartHours', dataSales, optionsSales, responsiveSales);


        var data = {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          series: [
            [542, 443, 320, 780, 553, 453, 326, 434, 568, 610, 756, 895],
            [412, 243, 280, 580, 453, 353, 300, 364, 368, 410, 636, 695]
          ]
        };

        var options = {
            seriesBarDistance: 10,
            axisX: {
                showGrid: false
            },
            height: "245px"
        };

        var responsiveOptions = [
          ['screen and (max-width: 640px)', {
            seriesBarDistance: 5,
            axisX: {
              labelInterpolationFnc: function (value) {
                return value[0];
              }
            }
          }]
        ];

        Chartist.Bar('#chartActivity', data, options, responsiveOptions);

        var dataPreferences = {
            series: [
                [25, 30, 20, 25]
            ]
        };

        var optionsPreferences = {
            donut: true,
            donutWidth: 40,
            startAngle: 0,
            total: 100,
            showLabel: false,
            axisX: {
                showGrid: false
            }
        };

        Chartist.Pie('#chartPreferences', dataPreferences, optionsPreferences);

        Chartist.Pie('#chartPreferences', {
          labels: ['62%','32%','6%'],
          series: [62, 30, 8]
        });
    },

    initChartist: function(){

        /*
        *   Multi-Line Colored Chart
        */

        var dataSales = {
          labels: ['9:00AM', '12:00AM', '3:00PM', '6:00PM', '9:00PM', '12:00PM', '3:00AM', '6:00AM'],
          series: [
             [287, 385, 490, 492, 554, 586, 698, 695, 752, 788, 846, 944],
            [67, 152, 143, 240, 287, 335, 435, 437, 539, 542, 544, 647],
            [23, 113, 67, 108, 190, 239, 307, 308, 439, 410, 410, 509]
          ]
        };

        var optionsSales = {
          lineSmooth: false,
          low: 0,
          high: 800,
          showArea: true,
          height: "245px",
          axisX: {
            showGrid: false,
          },
          lineSmooth: Chartist.Interpolation.simple({
            divisor: 3
          }),
          showLine: false,
          showPoint: false,
        };

        var responsiveSales = [
          ['screen and (max-width: 640px)', {
            axisX: {
              labelInterpolationFnc: function (value) {
                return value[0];
              }
            }
          }]
        ];

        Chartist.Line('#chartHours', dataSales, optionsSales, responsiveSales);


        /*
        *   Create a Double Bar Bar Chart
        */
        var data = {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          series: [
            [542, 443, 320, 780, 553, 453, 326, 434, 568, 610, 756, 895],
            [412, 243, 280, 580, 453, 353, 300, 364, 368, 410, 636, 695]
          ]
        };

        var options = {
            seriesBarDistance: 10,
            axisX: {
                showGrid: false
            },
            height: "245px"
        };

        var responsiveOptions = [
          ['screen and (max-width: 640px)', {
            seriesBarDistance: 5,
            axisX: {
              labelInterpolationFnc: function (value) {
                return value[0];
              }
            }
          }]
        ];

        Chartist.Bar('#chartActivity', data, options, responsiveOptions);


        /*
        * Create a Pie Chart
        */

        //initialize the data variable
        var data = {
         "action": "pie_chart"
        };
        //serialize the data as a JSON pack and include the other parameters of the form
        data = $(this).serialize() + "&" + $.param(data);
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
                var pieCountList = [];
                var pieTypeList = [];
                var i = 0;
                var total = 0;
                //go through the array to get the name & counts
                for(i = 0; i < ticketsArray.length; i++){
                  
                    var ticketSlice = ticketsArray[i]["ticketType"];
                    var ticket = ticketSlice.split(",");
                    var typeName = ticket[0];
                    console.log(ticketSlice);
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
                  console.log(total);
                  piePercentageList.push(value) ;
                  
                  pieLabelList.push(String(Math.round(value)) + "%");
                  
                }

                
               console.log(total);
              var dataPreferences = {
                  labels: pieLabelList,
                  series: piePercentageList
              };
      
              var optionsPreferences = {
                  donut: false,
                  donutWidth: 40,
                  startAngle: 0,
                  total: 100,
                  showLabel: true,
                  labelOffset: 70,
                  labelDirection: 'explode'
                  
              };
              
              Chartist.Pie('#chartPreferences', dataPreferences, optionsPreferences); //make a Pie Chart with selected options from above
              
              
              var labelsForGraph ='';
              for(var k= 0; k<pieTypeList.length; k++){
                labelsForGraph = labelsForGraph +  '<i class="fa fa-circle text-color' + k +'"></i>' + pieTypeList[k];
              }
              console.log("labels:" + labelsForGraph);
              document.getElementById("PieChartLabels").innerHTML = labelsForGraph;  
              
            }
            ,
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                alert("Error: " + errorThrown); 
            }   
        });


        

    }

    /*
    initGoogleMaps: function(){
        var myLatlng = new google.maps.LatLng(40.748817, -73.985428);
        var mapOptions = {
          zoom: 13,
          center: myLatlng,
          scrollwheel: false, //we disable de scroll over the map, it is a really annoing when you scroll through page
          styles: [{"featureType":"water","stylers":[{"saturation":43},{"lightness":-11},{"hue":"#0088ff"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"hue":"#ff0000"},{"saturation":-100},{"lightness":99}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#808080"},{"lightness":54}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ece2d9"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#ccdca1"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#767676"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#b8cb93"}]},{"featureType":"poi.park","stylers":[{"visibility":"on"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"simplified"}]}]

        }
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);

        var marker = new google.maps.Marker({
            position: myLatlng,
            title:"Hello World!"
        });

        // To add the marker to the map, call setMap();
        marker.setMap(map);
    },
    */
	/*showNotification: function(from, align){
    	color = Math.floor((Math.random() * 4) + 1);

    	$.notify({
        	icon: "pe-7s-gift",
        	message: "Welcome to <b>Light Bootstrap Dashboard</b> - a beautiful freebie for every web developer."

        },{
            type: type[color],
            timer: 4000,
            placement: {
                from: from,
                align: align
            }
        });
	}*/


}
