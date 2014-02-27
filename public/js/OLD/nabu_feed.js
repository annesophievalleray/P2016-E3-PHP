// JavaScript Document
login="lol";
id="";
				$.ajax({
					url:"user/getUserData",
					method:"get",

				})
				.success(function(data){
					dataUser=JSON.parse(data);
					console.log(dataUser);
					login=dataUser.user_login;
					id=parseInt(dataUser.user_id);
					
					//socket.emit('pseudo', login);
					//socket.emit('id_user', id);

			
				})
            // Connexion à socket.io
            //var socket = io.connect('http://localhost:8080');
			
var messenger={
  init : function(){
    this.socket = io.connect('http://localhost:8080');
		this.socket.emit('connect',{user:id});
		this.socket.emit('connect',{user:3});
		this.listen();
  },
	listen :function(){
		this.socket.on('connected',function(datas){
			console.log('connected id:'+datas); 
  	});
		this.socket.on('url',function(datas){
			console.log(datas); 
			insereMessage(datas.url,datas.from,datas.desc,datas.login);
		});
	},
	sendMessage : function(datas){  
		this.socket.emit('url',datas);
		
	},
	post:function(){
		console.log($('#post_article').serialize());
				$.ajax({
					url:"dashboard/user/post",
					type:"post",
					data:$('#post_article').serialize()
				})
				.success(function(data){
					alert(data);

			
				})
		
	}
}
messenger.init();



            // On demande le pseudo, on l'envoie au serveur et on l'affiche dans le titre
            /*var pseudo = prompt('Quel est votre pseudo ?');
            socket.emit('nouveau_client', pseudo);
            document.title = pseudo + ' - ' + document.title;*/
			

            // Quand on reçoit un message, on l'insère dans la page
            /*socket.on('url', function(data) {
				console.log(data);
                insereMessage(data.url,data.login);
				
            })*/

            // Quand un nouveau client se connecte, on affiche l'information
            /*socket.on('nouveau_client', function(pseudo) {
                $('#zone_chat').prepend('<p><em>' + pseudo + ' a rejoint le Chat !</em></p>');
            })*/

            // Lorsqu'on envoie le formulaire, on transmet le message et on l'affiche sur la page
            $('#post_article').submit(function () {
				messenger.post();
                var url = $('#url').val();
				 var desc = $('#desc').val();
                //socket.emit('url', url); // Transmet le message aux autres
                insereMessage(url,id); // Affiche le message aussi sur notre page
                $('#url').val('').focus(); // Vide la zone de Chat et remet le focus dessus
				$('#desc').val('').focus();
				messenger.sendMessage({from:id,to:3,url:url,desc:desc,login:login});
				//messenger.sendMessage({from:3,to:id,url:url});
				
                return false; // Permet de bloquer l'envoi "classique" du formulaire
            });
            
            // Ajoute un message dans la page
            function insereMessage(url,id_from,desc,login) {
				//apercu='<a href="http://'+message+'"><img src="//www.apercite.fr/api/apercite/120x90/yes/http://'+message+'" alt="Miniature par Apercite.fr" width="120" height="90" /></a>';
				
				//apercu='<div class="post-feed"><p><a href="http://'+url+'"><img src="public/img/PP_2.png" alt="">'+login+'</a><br /><img src="//www.apercite.fr/api/apercite/120x90/yes/http://'+url+'" alt="Miniature par Apercite.fr" width="120" height="90" /></p></div>';
				//if(!id_from)
					//id_from=id;
			if(url.indexOf("youtube.com")>=0 && url.indexOf("watch")>=0){
				data=url.indexOf("=")+1;	
				video=url.substr(data);	
				url_aff='<iframe width="95%" height="55%" src="//www.youtube.com/embed/'+video+'" frameborder="0" allowfullscreen></iframe>';
				
				//console.log(video);
			}
			else
				url_aff=url;
			
				
				apercu='<div class="post-feed clearfix"><div class="tag"></div><p><a href="'+url+'"><img src="public/img/PP_large.png" class="avatar-50" alt="">'+id_from+''+login+'</a>date<br/>'+desc+'</br><a href="'+url+'" class="post-link">'+url_aff+'</a></p></div>';
				
                $('#zone_post').prepend(apercu);
            }