var app = require('express')(),
    server = require('http').createServer(app),
    io = require('socket.io').listen(server),
    ent = require('ent'), // Permet de bloquer les caractères HTML (sécurité équivalente à htmlentities en PHP)
    fs = require('fs'),
	mysql = require('mysql');

// Chargement de la page index.html
//app.get('/', function (req, res) {
  //res.sendfile(__dirname + '/index.html');
//});


var db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    database: 'nabu'
})


db.connect(function(err){
    if (err) console.log(err)
})

io.sockets.on('connection', function (socket, url) {

	//console.log(publication);
    // Dès qu'on nous donne un pseudo, on le stocke en variable de session et on informe les autres personnes
   socket.on('pseudo', function(login) {
        login = ent.encode(login);
        socket.set('login', login);
        socket.broadcast.emit('pseudo', login);
    });

    // Dès qu'on reçoit un message, on récupère le pseudo de son auteur et on le transmet aux autres personnes
    socket.on('url', function (url) {
        socket.get('login', function (error, login) {
            url = ent.encode(url);
			console.log(login);
            socket.broadcast.emit('url', {url: url, login: login});
			db.query("INSERT INTO feed (author_feed, url_feed) VALUES('"+login+"', '"+url+"')");
        });
    }); 
});

server.listen(8080);
