var Hapi = require('hapi');

var server = new Hapi.Server();
var fs = require('fs');

var tls = {
  key: fs.readFileSync('/etc/letsencrypt/live/account.skytax.ca/privkey.pem'),
  cert: fs.readFileSync('/etc/letsencrypt/live/account.skytax.ca/cert.pem')
};

server.connection({ port: 3000, tls: tls });
server.route({
    method: 'GET',
    path: '/',
    handler: function (request, reply) {
        reply('Hello, world!');
    }
});

server.route({
    method: 'GET',
    path: '/{name}',
    handler: function (request, reply) {
        reply('Hello, ' + encodeURIComponent(request.params.name) + '!');
    }
});


var mysqlConfiguration = {};
var connection = {};
var Files = {};

var exec = require('child_process').exec,
    util = require('util')
    fs = require('fs'),
    readline = require('readline');

var rd = readline.createInterface({
    input: fs.createReadStream('./.env'),
    output: process.stdout,
    terminal: false
});

rd.on('line', function(line) {
  var getLine = line.split("=");

      if(getLine[0] == "DB_HOST")
        mysqlConfiguration.hostname = getLine[1];

      if(getLine[0] == "DB_DATABASE")
        mysqlConfiguration.database = getLine[1];

      if(getLine[0] == "DB_USERNAME")
        mysqlConfiguration.username = getLine[1];

      if(getLine[0] == "DB_PASSWORD")
        mysqlConfiguration.password = getLine[1];

      if(mysqlConfiguration.password){
        mysqlCoonection(mysqlConfiguration);
        return true;
      }

});

function mysqlCoonection(mysqlConfiguration){
  var mysql      = require('mysql');
   connection = mysql.createConnection({
    host     : mysqlConfiguration.hostname,
    user     : mysqlConfiguration.username,
    password : mysqlConfiguration.password,
    database : mysqlConfiguration.database
  });
  connection.connect();
}

var io = require('socket.io')(server.listener);

var sockets = [];
io.on('connection', function (socket) {
  //on user online
  socket.on('online',function(user){
    sockets[user.id] = socket;
  });

  // on user disconnect
  socket.on('userdisconnect', function(data) {
    var online = sockets.indexOf(data.id);
      sockets.splice(online, 1);
    var chat = sockets.indexOf(data.receiver+'_'+data.id);
      sockets.splice(chat, 1);
  });

  //on one to one chat setup
  socket.on('setup',function(data){
    sockets[data.id+'_'+data.receiver] = socket;
  });

  //on chat
  socket.on('chat', function (data) {
      data.type = 'single';
      messageSend(data);
  });


  var messageSend = function(data){
    var status = 'sent';
    if(sockets[data.receiver+'_'+data.id]){
      data.datetime = "now";
      status = 'read';
      sockets[data.receiver+'_'+data.id].emit('receiver',data);
    }
    else if(sockets[data.receiver]){
      sockets[data.receiver].emit('message',data);
      status = 'received';
    }
    else{
      //console.log("sockets lists", sockets);
    }

    var message = {sender_id: data.id, message:data.message, receiver_id : data.receiver, status:status};
    connection.query('INSERT INTO messages SET ?', message, function(err, result) {
        if (err) throw err;

      });
  }

});

server.start(function(err){
    if (err) {
        throw err;
    }
    console.log('Server running at: 3000');
  });
