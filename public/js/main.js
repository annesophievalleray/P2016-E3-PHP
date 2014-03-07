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
	$(window).scroll(function() {
		EasyPeasyParallax();
	});
	
	$(document).keydown(function(){
		$("#different_passwords").fadeOut();
		$("#erreur").fadeOut();
		})
	
	
	$("#send").click(function(e){
	//e.preventDefault();
	valid = true;
	/*if($("#password").val() == "" || $("#password_verif").val() == ""){
		$("#erreur").fadeIn();
		valid = false;
	}*/
	
	if($("#password").val() != $("#password_verif").val() ){
		$("#different_passwords").fadeIn();
		valid = false;
		
	}
	$.ajax({
					url:"user/signup",
					type:"POST"

				})
				.success(function(data){
					dataErreur=JSON.parse(data);
					if(dataErreur.erreur==-1){
						$("#erreur").fadeIn();
						valid = false;
						}
					if(dataErreur.erreur==-2){
						$("#different_passwords").fadeIn();
						valid = false;
						}
				})
	
	return valid;
});

$('#form_auth').submit(function () {
				$.ajax({
					url:"user/signin",
					type:"POST"

				})
				.success(function(data){
					dataErreur=JSON.parse(data);
					if(dataErreur.erreur==1){
						$('#erreur_auth').fadeIn();
					}

						
				})
                
});
	
	


