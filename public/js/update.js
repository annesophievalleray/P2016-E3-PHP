$("#updateProfile").on('submit',function(e){
	e.preventDefault();
	var files=$('#avatar')[0].files[0];
	var form=$(this).serialize();
	var datas = new FormData();
	datas.append('file',files);
	datas.append('form',form);
 	$.ajax({url:"updateProfile/",type:'POST',data:datas,processData:false,contentType:false})
	.success(function(){
	console.log('succes envoi'); 
});