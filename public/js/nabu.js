UserDashboard.init({		
});

User.init({
		
});

//DEBUT

User.getUserId();
User.getStateFollow();
	//Dash
UserDashboard.getSuggestArticles();

	//Profile
User.getUserData();
User.getUserBadges();

//UPDATE
var intervalle=6000;

setInterval(function(){
	UserDashboard.getNewPosts();
	}, intervalle);



//ACTIONS
	//suggestions
$('#suggest_articles_button').on('click',function(e){
	e.preventDefault();
	
	UserDashboard.getSuggestArticles();

})

$('#suggest_follows_button').on('click',function(e){
	e.preventDefault();
	
	UserDashboard.getSuggestFollow();

})

$('#follow_button').on('click',function(e){
	e.preventDefault();
	
	User.follow();

})

	//search
$('input[name="name"]').on('keyup',function(e){
	var $parent=$(this).parent('form');
	//console.log($parent.serialize());
	UserDashboard.searchUser($parent);
	// $('input[name="name"]').focusout(function() {
	//     $('.users-result').hide();
	// });
})


	//post
$('#post_article').submit(function () {
				UserDashboard.post();
                $('#url').val('').focus(); // Vide la zone de Chat et remet le focus dessus
				$('#desc').val('').focus();
                return false; // Permet de bloquer l'envoi "classique" du formulaire
});




/*------INTERFACE ---*/

$('input[name="post_url"]').on('focus',function(){
	$('#form-extended').fadeIn(400);
});
$('input[name="post_url"]').on('blur',function(){
	if( !$(this).val() ) {
		$('#form-extended').fadeOut(400);
	}
});


/*------GRAPH DASHBOARD ---*/
$(window).load(function() {
      Pizza.init();
});