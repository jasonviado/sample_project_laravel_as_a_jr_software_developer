/**
 * Created by jason.viado on 4/3/17.
 */

var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);



io.on('connection', function (socket){
    socket.on('join room',function(room) {
        console.log('client join on Room: '+ room);
        socket.join(room);
    });
    socket.on('load find friends', function(room){
        console.log('User Friends Home:'+ room);
        io.to(room).emit('load friends');
    });
    socket.on('load the post',function(room){
        console.log('Load User Posts Home:'+ room);
        io.to(room).emit('load post');
    });
    socket.on('load friend message',function(room,my){
        console.log('Load User Messages:'+ room);
        io.to(room).emit('load messages',my);
    });
    socket.on('load my message',function(my,room){
        console.log('Load My Messages:'+ room);
        io.to(room).emit('load messages',my);
    });
    socket.on('load group',function(room){
        console.log('Load My Group:'+ room);
        io.to(room).emit('load group chat');
    });
    socket.on('load group message',function(item,data){
        console.log('id:'+ item +'group'+data);
        io.to(item).emit('load group chat receive',data,item);
    });



});

http.listen(5858, function(){
    console.log('Listening on Port 5858')
});

