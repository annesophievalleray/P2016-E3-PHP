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

$('input[name="name"]').on('keyup',function(e){
	var $parent=$(this).parent('form');
	//console.log($parent.serialize());
	$.ajax({
		url:$parent.attr('action'),
		method:$parent.attr('method'),
		data:$parent.serialize()
	})
	.success(function(data){
		$('.users-result').html(data);
		console.log(data);
	})
})