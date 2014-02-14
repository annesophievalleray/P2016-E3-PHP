// JavaScript Document
login="lol";
				$.ajax({
					url:"user/getLogin",
					method:"get",

				})
				.success(function(data){
					console.log(data);
					login=data;
					
					socket.emit('pseudo', login);

			
				})
            // Connexion à socket.io
            var socket = io.connect('http://localhost:8080');

            // On demande le pseudo, on l'envoie au serveur et on l'affiche dans le titre
            /*var pseudo = prompt('Quel est votre pseudo ?');
            socket.emit('nouveau_client', pseudo);
            document.title = pseudo + ' - ' + document.title;*/
			

            // Quand on reçoit un message, on l'insère dans la page
            socket.on('url', function(data) {
                insereMessage(data.url);
            })

            // Quand un nouveau client se connecte, on affiche l'information
            /*socket.on('nouveau_client', function(pseudo) {
                $('#zone_chat').prepend('<p><em>' + pseudo + ' a rejoint le Chat !</em></p>');
            })*/

            // Lorsqu'on envoie le formulaire, on transmet le message et on l'affiche sur la page
            $('#post_feed').submit(function () {
                var url = $('#url').val();
                socket.emit('url', url); // Transmet le message aux autres
                insereMessage(url); // Affiche le message aussi sur notre page
                $('#url').val('').focus(); // Vide la zone de Chat et remet le focus dessus
                return false; // Permet de bloquer l'envoi "classique" du formulaire
            });
            
            // Ajoute un message dans la page
            function insereMessage(url) {
				//apercu='<a href="http://'+message+'"><img src="//www.apercite.fr/api/apercite/120x90/yes/http://'+message+'" alt="Miniature par Apercite.fr" width="120" height="90" /></a>';
				
				apercu='<div class="post-feed"><p><a href="http://'+url+'"><img src="public/img/PP_2.png" alt="">'+login+'</a><br /><img src="//www.apercite.fr/api/apercite/120x90/yes/http://'+url+'" alt="Miniature par Apercite.fr" width="120" height="90" /></p></div>';
				
                $('#zone_chat').prepend(apercu);
            }