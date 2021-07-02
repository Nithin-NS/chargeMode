// var Userdb = require('../model/model');
const express = require('express');

const app = express();

// const WebSocket = require('ws');

const http = require('http');

exports.remotestop = (res) => {
    // const server = http.createServer(app);

    // const wss = new WebSocket.Server({ port: 8082 });

    // wss.on("connection", ws => {
    //     // ws.on("message", data => {});

    //     // ws.on("close", () => {
    //     //     console.log('Client Has Disconnected..');
    //     // });  
    // });
    res.send('From Remotestart');
        function remotestop(res){
            // res.send('From Remotestop');
            var metadata = [
                2,
                '12365987',
                {
                    idTag: '125',
                    transactionId: '1000',
                    timestamp: '12.12'
                }
            ];
            
            ws.send(JSON.stringify(metadata));
        }
        console.log('Inside RemoteStop Controller');  
}