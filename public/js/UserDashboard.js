var finish=true;
var finishNew=true;

var UserDashboard = {
    defaults: {
        divFormPost: '#post_article',
		divResultRecherche:'.users-result',
		divSuggestArticles:'#suggest_articles',
		divSuggestFollow:'#suggest_follow',
		divPosts:'#zone_post',
		recentId:0,
		oldId:0,
		messNoResult:"<li class='no-results'>Pas de résultats</li>"

    },

    init: function (options) {
        this.params = $.extend(this.defaults, options);
    },
	
	formatPost:function(dataPosts,i){
		
		var format="<div class='post-feed clearfix' data-postid='"+dataPosts[i].post_id+"'><div class='tag'></div> <p><a href='user/"+dataPosts[i].post_user_id+"' class='name'><img src='public/img/PP_large.png' class='avatar-50 avatar-feed' alt=''>"+dataPosts[i].login+"</a> - "+$.timeago(dataPosts[i].post_date)+"<br>"+dataPosts[i].post_desc+"<a href='"+dataPosts[i].post_url+"' class='post-link'>"+dataPosts[i].post_url+"</a></p></div>";
		
		return format;
		  
	},
	
	getNewPosts:function(start){
		//var recentId=0;
		finishNew=false;
		var limit=1;
		
		if(start==0){
			UserDashboard.params.recentId=$("div.post-feed:first").data('postid');
			limit=0;
		}
		//console.log(UserDashboard.params.recentId);
		
				$.ajax({
					url:"dashboard/getNewPosts",
					type:"get",
					data:"recentId="+UserDashboard.params.recentId+"&limit="+limit
				})
				.success(function(data){
					//console.log(data);
					var dataPosts=JSON.parse(data);
					var nbPosts=dataPosts.length;
					if(nbPosts!=0){
						
						//if(start==1)
								//UserDashboard.params.oldId=dataPosts[nbPosts-1].post_id;
								
						//UserDashboard.params.recentId=dataPosts[0].post_id;
						//console.log("oldId1:"+UserDashboard.params.oldId);
								
						for(i=(nbPosts-1);i>=0;i--){
							$(UserDashboard.params.divPosts).prepend(UserDashboard.formatPost(dataPosts,i));

								//$(UserDashboard.params.divPosts).append(UserDashboard.formatPost(dataPosts,i));

						}
					}
					finishNew=true;
				})
		
		
		
	},
	
	getOldPosts:function(){
		finish=false;
		UserDashboard.params.oldId=$("div.post-feed:last").data('postid');
		//console.log("oldId"+UserDashboard.params.oldId);
		
				$.ajax({
					url:"dashboard/getOldPosts",
					type:"get",
					data:"oldId="+UserDashboard.params.oldId
				})
				.success(function(data){
					//console.log("data"+data);
					var dataPosts=JSON.parse(data);
					var nbPosts=dataPosts.length;
						
					if(nbPosts!=0&& !finish){
						//UserDashboard.params.oldId=dataPosts[nbPosts-1].post_id;
						
						for(i=0;i<nbPosts;i++){
							$(UserDashboard.params.divPosts).append(UserDashboard.formatPost(dataPosts,i));
						}
						
					}
					
					finish=true;

				})
			},
	
	post:function(){
		//console.log($('#post_article').serialize());
				$.ajax({
					url:"dashboard/user/post",
					type:"post",
					data:$(UserDashboard.params.divFormPost).serialize()
				})
				.success(function(data){
					dataBdg=JSON.parse(data);
					
					if(data && url.lastIndexOf("dashboard")<0)
						$('#new-post').html("page bookée !");
					
					if(dataBdg.state==1)
						alert("Nouveau badges :"+dataBdg.bdg_name+" car "+dataBdg.bdg_desc);
						//alert("Count :"+dataBdg.bdg_array);
						
					UserDashboard.getNewPosts(0);
					User.getUserData();
					//alert("Posté!");
				})
		
	},
	
	getSuggestArticles:function(){
		
		$.ajax({
			url:"dashboard/getSuggestArticles",
			method:"get",
		})
		.success(function(data){
			$(UserDashboard.params.divSuggestArticles).html(data);
			//console.log(data);
		})
		
		
	},
	
	getSuggestFollow:function(){
		//console.log('OK');
		$.ajax({
			url:"dashboard/getSuggestFollow",
			type:"get",
		})
		.success(function(data){
			$(UserDashboard.params.divSuggestFollow).html(data);
			//console.log(data);
		})
		
		
	},
	
	searchUser:function($parent){
		//var $parent=$(this).parent('form');
		//console.log($parent.serialize());
		$.ajax({
			url:$parent.attr('action'),
			type:$parent.attr('method'),
			data:$parent.serialize()
		})
		.success(function(data){
			if(data.length==0)
				data=UserDashboard.params.messNoResult;
			$(UserDashboard.params.divResultRecherche).html(data);
			//console.log(data);
		})	
		
		
	}
	
	
	
}