function changeCSS() {
    // oldlink = document.getElementsByTagName("link").item(0);

 /*   var newlink = document.createElement("link");
    newlink.setAttribute("rel", "stylesheet");
    newlink.setAttribute("type", "text/css");*/
    
    //initialize the data variable, you can use this to select specific name in your sql statement
   var data = {
		"action": "getSpecificCSSColor"
	};
	
	//serialize the data as a JSON pack and include the other parameters of the form
	data = $(this).serialize() + "&" + $.param(data);
    
    $.ajax({
      url: '../Color_Switch/getCssLink.php',
      datatype: 'text',
      data: data,
      success: function(data) {
          //var link = data;
        //newlink.setAttribute("href", link);
      }
    });

   // document.getElementsByTagName("head").item(0).appendChild(newlink);
}

function changeBanner(){
   var oldImg = document.getElementsByTagName("img").item(0);

    var newImg = document.createElement("img");
    newImg.setAttribute("src", "../images/CarmineBanner.png");
    newImg.setAttribute("width", "100%");
    newImg.setAttribute("height", "150px");

    document.getElementsByClassName("logo").item(0).replaceChild(newImg, oldImg); 
}