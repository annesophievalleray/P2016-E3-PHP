/*$('#form_signIn').submit(function(e){
	//e.preventDefault();
	$.ajax({
		url:"user/connexion",
		method:"post",
	})
	.success(function(data){
		console.log("OKKKKKK");
	})
});*/
/*$('#form_signIn').submit(function(e){
	e.preventDefault();
	//var $parent=$(this).parent('form');
	//POST /user/connexion = App_controller->signIn
	$.ajax({
		url:$(this).attr('action'),
		method:$(this).attr('method'),
		data:$(this).serialize()
	})
	.success(function(data){
		console.log(data);
		if(data==-1)
			$('.erreur').html("erreur d'authentification");
		else
			window.location="user/"+data;

	})*/
	
		/*console.log($(this).attr('action'));
		console.log($(this).attr('method'));
		console.log($(this).serialize());*/
//})



/*$('.users').on('click','a',function(e){
	e.preventDefault();
	$.ajax({
		url:$(this).attr('href')
	})
	.success(function(data){
		$('section + section').html(data);
	})
});*/

$.ajax({
		url:"user/badges",
		method:"get",
	})
	.success(function(data){
		$('#display-badges').append(data);
		//console.log(data);
	})

$.ajax({
					url:"user/getUserData",
					method:"get",

				})
				.success(function(data){
					dataUser=JSON.parse(data);
					//console.log(dataUser);
					
					nb_fle=dataUser.nb_followers;
					nb_fli=dataUser.nb_following;
					nb_posts=dataUser.nb_posts;
					console.log(nb_posts);
					
					$('#nb_followers').html(nb_fle);
					$('#nb_following').html(nb_fli);
					$('#nb_posts').html(nb_posts);
								
});

$('input[name="name"]').on('keyup',function(e){
	var $parent=$(this).parent('form');
	//console.log($parent.serialize());
	$.ajax({
		url:$parent.attr('action'),
		method:$parent.attr('method'),
		data:$parent.serialize()
	})
	.success(function(data){
		$('.users-result').show();
		$('.users-result').html(data);
		console.log(data);
	});
	$('input[name="name"]').focusout(function() {
	    $('.users-result').hide();
	  });
});


$('input[name="url"]').on('focus',function(){
	$('#form-extended').fadeIn(400);
});
$('input[name="url"]').on('blur',function(){
	if( !$(this).val() ) {
		$('#form-extended').fadeOut(400);
	}
});


/*------GRAPH DASHBOARD ---*/
$(window).load(function() {
      Pizza.init();
});