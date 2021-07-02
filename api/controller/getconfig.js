// var Userdb = require('../model/model');
var wss = require('../websocket/websocket');

const express = require('express');

const http = require('http');

const app = express();

var moment = require('moment');

const format = "MM/DD/YYYY hh:mm:ss A";

const port = 8082;

const WebSocket = require('ws');

exports.getConfig = (res) => {
    var uniqid = '100';
    var cpname = 'CP01'
    var date = moment().utcOffset('-0400').format(format);

    var metadata = [
        2,
        uniqid,
        'GetConfiguration',
            {
                
            }
        ];

        var mysql = require('mysql');
        var con = mysql.createConnection({
            host: "localhost",
            user: "ubuntu",
            password: "admin@123",
            database: "chargemode_websockets"
        });
        // var con = mysql.createConnection({
        //     host: "localhost",
        //     user: "root",
        //     password: "",
        //     database: "chargemode_websockets"
        // });

        //broadcasting to all connected WebSocket clients, including itself.
        wss.clients.forEach(function each(client) {
            if (client.readyState === WebSocket.OPEN) {
              client.send(JSON.stringify(metadata));
            }
        });

        //save the sending message to database
        var sql = "INSERT INTO device_messages (uid,date,station,type,message) VALUES ('"+uniqid+"','"+date+"','"+cpname+"','Out','"+JSON.stringify(metadata,null, 2)+"')";
            con.query(sql, function (err, result) {
                if (err) throw err;
            console.log("Get Config Send Successfully");
        });

        //sending responce to frontend
        res.send('Remotestart Send Successful');
        console.log('Inside RemoteStart Controller');
}