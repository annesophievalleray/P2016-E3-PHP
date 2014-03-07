var User = {
    defaults: {
		userId:0,
		SESSIONid:$('#user').data('id'),
        divBadges: '#display_badges',
		divNbFollowers: '#nb_followers',
		divNbFollowing: '#nb_following',
		divNbPosts: '#nb_posts',
		divNbBadges: '#nb_badges',
		divCount: '#count',
		divCatPostsUser:'#post_cat_user',
		divFollowers:'',
		divFollowing:'',
		buttonFollow:'#follow_button',
		weekStats:[],
        boutonAmitieDone: function () {},

    },

    init: function (options) {
        this.params = $.extend(this.defaults, options);
    },
	
	getUserId:function(){
		var url=window.location.href;
		//console.log(url);
		var id;
		
		if(url.lastIndexOf("dashboard")>0 ||url.lastIndexOf("iframe")>0){
			id=User.params.SESSIONid;
		}
		else{
			var pos = url.lastIndexOf("/");
			id=parseInt(url.substr(pos+1));
		}
		
		User.params.userId=id;
		
	},
	
	getStateFollow:function(){
		$.ajax({
					url:"user/getStateFollow/"+User.params.userId,
					method:"get",

				})
				.success(function(data){
					dataFollow=JSON.parse(data);
					//console.log(dataFollow);
					
					if(dataFollow.state==1){
						//console.log($(User.params.buttonFollow).data("state"));
						$(User.params.buttonFollow).html("Ne plus suivre");
						$(User.params.buttonFollow).toggleClass('profile-follow-button');
						$(User.params.buttonFollow).toggleClass('profile-unfollow-button');	
					}
				})
	},
	
	getUserData:function(){
		
		$.ajax({
					url:"user/getUserData/"+User.params.userId,
					method:"get",

				})
				.success(function(data){
					//console.log(data);
					dataUser=JSON.parse(data);
					
					
					nb_fle=dataUser.nb_followers;
					nb_fli=dataUser.nb_following;
					nb_posts=dataUser.nb_posts;
					nb_badges=dataUser.nb_badges;
					//console.log(nb_posts);
					User.params.SESSIONid=dataUser.user_id;
					$(User.params.divNbFollowers).html(nb_fle);
					$(User.params.divNbFollowing).html(nb_fli);
					$(User.params.divNbPosts).html(nb_posts);
					$(User.params.divNbBadges).html(nb_badges);
					
								
		});
		
	},
	
	getMonthCount:function(){
		///user/getCount/@id
		$.ajax({
				url:"user/getCount/"+User.params.userId,
				method:"get",
				data:"countPostsUser=1"
			})
			.success(function(count){
				//badgesUser=JSON.parse(badges);
				
				$(User.params.divCount).html(count);
		
				//console.log(count);
			})
	},
	getGraphProfile:function(cat){
		///user/getCount/@id
		$.ajax({
				url:"user/graphProfile/"+User.params.userId,
				data: "categorie="+cat,
				method:"post",
			})
			.success(function(stats){
				User.params.weekStats=JSON.parse(stats);
				//console.log(weekStats);
				User.graph(User.params.weekStats);
				
			})
	},
	
	
	getCatPostsUser:function(){
		///user/getCount/@id
		$.ajax({
				url:"user/getCatPostsUser/"+User.params.userId,
				method:"get",
			})
			.success(function(cat){
				//badgesUser=JSON.parse(badges);
				
				$(User.params.divCatPostsUser).append(cat);
				var cat1=$(User.params.divCatPostsUser+":first-child").val();
				
				User.getGraphProfile(cat1);
			})
	},
	
	getUserBadges:function(){
		allBadges=$(User.params.divBadges).data('allbadges');
		//console.log(allBadges);
		$.ajax({
				url:"user/badges/"+User.params.userId,
				method:"get",
				data:"all="+allBadges
			})
			.success(function(badges){
				//badgesUser=JSON.parse(badges);
				
				$(User.params.divBadges).html(badges);
		
				//console.log(badges);
			})
		
	},
	
	follow:function(){
		
		var state;
		if($(User.params.buttonFollow).html()!="Suivre")
			state=0;
		else
			state=1;
		
		$.ajax({
				url:$(User.params.buttonFollow).attr('href')+state,
				method:"get",
			})
			.success(function(badges){
				//badgesUser=JSON.parse(badges);
			if(!$(User.params.buttonFollow).hasClass('profile-follow-button')){
				$(User.params.buttonFollow).html("Suivre");
			}
			else{
				$(User.params.buttonFollow).html("Ne plus suivre");
				//alert("demandé!");
			}
				$(User.params.buttonFollow).toggleClass('profile-follow-button');
				$(User.params.buttonFollow).toggleClass('profile-unfollow-button');
				
				User.getUserData();
				//console.log(badges);
			})
			
			
		
		
		},
	
	graph :function(stats){
	
		//console.log(stats);
		var data = {
			labels : ["Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"],
			datasets : [
				{
					fillColor : "transparent",
					strokeColor : "#f8a20f",
					pointColor : "#f8a20f",
					pointStrokeColor : "#fff",
					data : [stats[0],stats[1],stats[2],stats[3],stats[4],stats[5],stats[6]]
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
		
		}
		
	
	

	
	
	
}