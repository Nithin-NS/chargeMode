var app =require('express')();
const http = require('http').createServer(app);
var io = require('socket.io')(http);
var port = 6001;
// var socket = io();

// app.get('/', (req, res) => {
//     res.send('<h1>Hello world</h1>');
//   });

http.listen(port, '127.0.0.1', function() {
    console.log('Listening to port 6001');
})

app.get('/', (req, res) => {
    res.sendFile(__dirname + "resources/views/client/client.blade.php");
})

io.on('message', (msg) => {
    io.broadcast.emit('message', msg)
})

