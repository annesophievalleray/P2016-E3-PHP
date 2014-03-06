function EasyPeasyParallax() {
	scrollPos = $(this).scrollTop();
	$('#banner').css({
		'background-position' : '50% ' + (-scrollPos/4)+"px"
	});
	$('#bannertext').css({
		'margin-top': (scrollPos/4)+"px",
		'opacity': 1-(scrollPos/250)
	});
}
$(document).ready(function(){
	$(window).scroll(function() {
		EasyPeasyParallax();
	});
	
	$("#send").click(function(e){
	e.preventDefault();
	valid = true;
	if($("#password").val() == "" || $("#password_verif").val() == ""){
		$("#erreur").fadeIn();
		valid = false;
	}
	
	if($("#password").val() != $("#password_verif").val() ){
		$("#different_passwords").fadeIn();
		valid = false;
		
	}
	
	return valid;
});
	
	
});

