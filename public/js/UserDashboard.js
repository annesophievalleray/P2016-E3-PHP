var UserDashboard = {
    defaults: {
        divFormPost: '#post_article',
		divResultRecherche:'.users-result',
		divSuggestArticles:'#suggest_articles',

    },

    init: function (options) {
        this.params = $.extend(this.defaults, options);
    },
	
	getNewPosts:function(){
		
		var recentId=$("section#zone_post :first-child").data('postid');
		//console.log(recentId);
		
				$.ajax({
					url:"dashboard/getNewPosts",
					type:"get",
					data:"recentId="+recentId
				})
				.success(function(data){
					console.log(data);
					if(data!=0)
						$('#zone_post').prepend(data);
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
					UserDashboard.getNewPosts();
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
		
	},
	
	searchUser:function($parent){
		//var $parent=$(this).parent('form');
		//console.log($parent.serialize());
		$.ajax({
			url:$parent.attr('action'),
			method:$parent.attr('method'),
			data:$parent.serialize()
		})
		.success(function(data){
			//$('.users-result').show();
			$(UserDashboard.params.divResultRecherche).html(data);
			console.log(data);
		})	
		
		
	}
	
	
	
}