// JavaScript Document
login="lol";
				$.ajax({
					url:"user/getUserData",
					method:"get",

				})
				.success(function(data){
					dataUser=JSON.parse(data);
					console.log(dataUser);
					login=dataUser.user_login;
					id=dataUser.user_id;
					nb_fle=dataUser.nb_followers;
					nb_fli=dataUser.nb_following;
					
					$('#nb_followe').html(nb_fle);
					$('#nb_followi').html(nb_fli);
					
					socket.emit('pseudo', login);
					socket.emit('id_user', id);

			
				})
            // Connexion à socket.io
            var socket = io.connect('http://localhost:8080');

            // On demande le pseudo, on l'envoie au serveur et on l'affiche dans le titre
            /*var pseudo = prompt('Quel est votre pseudo ?');
            socket.emit('nouveau_client', pseudo);
            document.title = pseudo + ' - ' + document.title;*/
			

            // Quand on reçoit un message, on l'insère dans la page
            socket.on('url', function(data) {
                insereMessage(data.url,data.login);
            })

            // Quand un nouveau client se connecte, on affiche l'information
            /*socket.on('nouveau_client', function(pseudo) {
                $('#zone_chat').prepend('<p><em>' + pseudo + ' a rejoint le Chat !</em></p>');
            })*/

            // Lorsqu'on envoie le formulaire, on transmet le message et on l'affiche sur la page
            $('#post_article').submit(function () {
                var url = $('#url').val();
                socket.emit('url', url); // Transmet le message aux autres
                insereMessage(url); // Affiche le message aussi sur notre page
                $('#url').val('').focus(); // Vide la zone de Chat et remet le focus dessus
                return false; // Permet de bloquer l'envoi "classique" du formulaire
            });
            
            // Ajoute un message dans la page
            function insereMessage(url,login) {
				//apercu='<a href="http://'+message+'"><img src="//www.apercite.fr/api/apercite/120x90/yes/http://'+message+'" alt="Miniature par Apercite.fr" width="120" height="90" /></a>';
				
				//apercu='<div class="post-feed"><p><a href="http://'+url+'"><img src="public/img/PP_2.png" alt="">'+login+'</a><br /><img src="//www.apercite.fr/api/apercite/120x90/yes/http://'+url+'" alt="Miniature par Apercite.fr" width="120" height="90" /></p></div>';
				
				apercu='<div class="post-feed clearfix"><div class="tag"></div><p><a href="'+url+'"><img src="public/img/PP_large.png" class="avatar-50" alt="">'+login+'</a>date<br/>description</br><a href="'+url+'" class="post-link">"'+url+'"</a></p></div>';
				
                $('#zone_post').prepend(apercu);
            }