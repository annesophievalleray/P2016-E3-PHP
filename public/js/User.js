var User = {
    defaults: {
		userId:0,
		SESSIONid:$('#user').data('id'),
        divBadges: '#display_badges',
		divNbFollowers: '#nb_followers',
		divNbFollowing: '#nb_following',
		divNbPosts: '#nb_posts',
		divFollowers:'',
		divFollowing:'',
        boutonAmitieDone: function () {},

    },

    init: function (options) {
        this.params = $.extend(this.defaults, options);
    },
	
	getUserId:function(){
		var url=window.location.href;
		console.log(url);
		var id;
		
		if(url.lastIndexOf("dashboard")>0){
			id=User.params.SESSIONid;
		}
		else{
			var pos = url.lastIndexOf("/");
			id=url.substr(pos+1);
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
					console.log(dataFollow);
					if(dataFollow.state==1)
						$('#follow_button').html("Ne plus suivre");
				})
	},
	
	getUserData:function(){
		
		$.ajax({
					url:"user/getUserData/"+User.params.userId,
					method:"get",

				})
				.success(function(data){
					dataUser=JSON.parse(data);
					//console.log(dataUser);
					
					nb_fle=dataUser.nb_followers;
					nb_fli=dataUser.nb_following;
					nb_posts=dataUser.nb_posts;
					//console.log(nb_posts);
					User.params.SESSIONid=dataUser.user_id;
					$(User.params.divNbFollowers).html(nb_fle);
					$(User.params.divNbFollowing).html(nb_fli);
					$(User.params.divNbPosts).html(nb_posts);
								
		});
		
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
		
				console.log(badges);
			})
		
	},
	
	getUserObjectives:function(){
		allObjectives=$(User.params.divObjectives).data('allobjectives');
		
		$.ajax({
				url:"user/objectives/"+User.params.userId,
				method:"get",
				data:"all="+allObjectives
			})
			.success(function(objectives){
				$(User.params.divObjectives).html(objectives);
			})
	},
	
	follow:function(){
		$.ajax({
				url:$('#follow_button').attr('href'),
				method:"get",
			})
			.success(function(badges){
				//badgesUser=JSON.parse(badges);
			if($('#follow_button').html()!="Suivre")
				$('#follow_button').html("Suivre");
			else
				$('#follow_button').html("Ne plus suivre");
				//alert("demandé!");
		
				//console.log(badges);
			})
		
		
		},
	

	
	
	
}