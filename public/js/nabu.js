// JavaScript Document

UserDashboard.init({});
User.init({});

//DEBUT
User.getUserId();


var url=window.location.href;

if(url.lastIndexOf("dashboard")>0){
	//timeAgo
	jQuery.timeago.settings.strings = {
   // environ ~= about, it's optional
   prefixAgo: "il y a",
   prefixFromNow: "d'ici",
   seconds: "moins d'une minute",
   minute: "environ une minute",
   minutes: "environ %d minutes",
   hour: "environ une heure",
   hours: "environ %d heures",
   day: "environ un jour",
   days: "environ %d jours",
   month: "environ un mois",
   months: "environ %d mois",
   year: "un an",
   years: "%d ans"
};
	//DASH
	UserDashboard.getNewPosts(1);
	UserDashboard.getSuggestArticles();
	User.getMonthCount();
	
	//UPDATE
	var intervalle=6000;
	
	setInterval(function(){
		if(finishNew==true)
			UserDashboard.getNewPosts(0);
		}, intervalle);
		
		}
else{
	User.getStateFollow();
	User.getCatPostsUser();
		}

	//Profile
User.getUserData();

User.getUserBadges();




//ACTIONS

	//SCROLL INFINI
$(window).scroll(function(){
	//console.log($(document).scrollTop()+" "+$(document).scr+" "+$(window).scrollTop());
	if($(window).scrollTop()>=(0.6*$(window).height())){
	//if(($(window).scrollTop()+$(document).scrollHeight)>=(0.9*$(window).height())){
		//alert($(window).scrollTop())
		if(finish==true)
			UserDashboard.getOldPosts();
		//console.log("scroll!!");
		//finish=false;
		
	
	}
	
});

	//suggestions
$('#suggest_articles_button').on('click',function(e){
	e.preventDefault();
	
	UserDashboard.getSuggestArticles();

})

$('#suggest_follows_button').on('click',function(e){
	e.preventDefault();
	//console.log("ok");
	
	UserDashboard.getSuggestFollow();

})

$('#follow_button').on('click',function(e){
	e.preventDefault();
	
	User.follow();

})

	//search
$('input[name="name"]').on('keyup',function(e){
	if($(this).val()=="")
		$('.users-result').hide();
	else
		$('.users-result').show();
		
	var $parent=$(this).parent('form');
	//console.log($parent.serialize());
	UserDashboard.searchUser($parent);
})


	//post
$('#post_article').submit(function () {
				UserDashboard.post();
                $('#url').val('').focus(); // Vide la zone de Chat et remet le focus dessus
				$('#desc').val('').focus();
                return false; // Permet de bloquer l'envoi "classique" du formulaire
});

	//GRAPH
$("#post_cat_user").on("change", function() {
   // var $form = $("#graphForm");
   User.getGraphProfile($("#post_cat_user").val());

});

/*------INTERFACE ------*/

$('input[name="post_url"]').on('focus',function(){
	$('#form-extended').fadeIn(400);
});
$('input[name="post_url"]').on('blur',function(){
	if( !$(this).val() ) {
		$('#form-extended').fadeOut(400);
	}
});
$('input[name="name"]').focusout(function() {
      $('.users-result').hide(200);
 });
 $('input[name="name"]').focus(function() {
    $('.users-result').show(200);
});
// follow lists
$('#sidebar #stats-followers, .followers .close').on('click',function(e){
	e.preventDefault();
	//$('#sidebar .content:nth-child(2)').toggle(200);
	if($('.following').is(':visible')){$('.following').hide()}
	$('.followers').fadeToggle(200);
});
$('#sidebar #stats-following, .following .close').on('click',function(e){
	e.preventDefault();
	//$('#sidebar .content:nth-child(2)').toggle(200);
	if($('.followers').is(':visible')){$('.followers').hide()}
	$('.following').fadeToggle(200);
});
