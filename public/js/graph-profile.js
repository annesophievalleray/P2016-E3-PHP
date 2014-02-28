var data = {
			labels : ["Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"],
			datasets : [
				{
					fillColor : "transparent",
					strokeColor : "#f8a20f",
					pointColor : "#f8a20f",
					pointStrokeColor : "#fff",
					data : [35,29,40,51,36,55,40]
				}
			]
			
		}

		

		var options = {
						
			//Boolean - If we show the scale above the chart data			
			scaleOverlay : false,
			
			//Boolean - If we want to override with a hard coded scale
			scaleOverride : false,
			
			//** Required if scaleOverride is true **
			//Number - The number of steps in a hard coded scale
			scaleSteps : null,
			//Number - The value jump in the hard coded scale
			scaleStepWidth : null,
			//Number - The scale starting value
			scaleStartValue : null,

			//String - Colour of the scale line	
			scaleLineColor : "rgba(0,0,0,.1)",
			
			//Number - Pixel width of the scale line	
			scaleLineWidth : 1,

			//Boolean - Whether to show labels on the scale	
			scaleShowLabels : true,
			
			//Interpolated JS string - can access value
			scaleLabel : "<%=value%>",
			
			//String - Scale label font declaration for the scale label
			scaleFontFamily : "'Arial'",
			
			//Number - Scale label font size in pixels	
			scaleFontSize : 12,
			
			//String - Scale label font weight style	
			scaleFontStyle : "normal",
			
			//String - Scale label font colour	
			scaleFontColor : "#666",	
			
			///Boolean - Whether grid lines are shown across the chart
			scaleShowGridLines : true,
			
			//String - Colour of the grid lines
			scaleGridLineColor : "rgba(0,0,0,.05)",
			
			//Number - Width of the grid lines
			scaleGridLineWidth : 1,	
			
			//Boolean - Whether the line is curved between points
			bezierCurve : false,
			
			//Boolean - Whether to show a dot for each point
			pointDot : true,
			
			//Number - Radius of each point dot in pixels
			pointDotRadius : 8,
			
			//Number - Pixel width of point dot stroke
			pointDotStrokeWidth : 3,
			
			//Boolean - Whether to show a stroke for datasets
			datasetStroke : true,
			
			//Number - Pixel width of dataset stroke
			datasetStrokeWidth : 4,
			
			//Boolean - Whether to fill the dataset with a colour
			datasetFill : true,
			
			//Boolean - Whether to animate the chart
			animation : true,

			//Number - Number of animation steps
			animationSteps : 60,
			
			//String - Animation easing effect
			animationEasing : "easeOutQuart",

			//Function - Fires when the animation is complete
			onAnimationComplete : null
			
		}

		//var myLine = new Chart(document.getElementById("canvas-graph").getContext("2d")).Line(lineChartData);
		var c = $('#canvas-graph'); //document.getElementById("canvas-graph");
		var ctx = document.getElementById("canvas-graph").getContext("2d");
		var container = $(c).parent();

		//Run function when browser resizes
		$(window).resize( respondCanvas() );

		function respondCanvas(){ 
		    c.attr('width', $(container).width() ); //max width
		    //c.attr('height', $(container).height() ); //max height

		}

		//Initial call 
		respondCanvas();

		var myLine = new Chart(ctx).Line(data,options);




		