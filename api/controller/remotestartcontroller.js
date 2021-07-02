// var Userdb = require('../model/model');
var wss = require('../websocket/websocket');

const express = require('express');

const http = require('http');

const app = express();

var moment = require('moment');

// const format = "MM/DD/YYYY-hh:mm:ss A";
// 1970-01-01T00:00:05Z
const format = "YYYY-MM-DDThh:mm:ssA";

const port = 8082;

const WebSocket = require('ws');

exports.remotestart = (res) => {
    var uniqid = '1';
    var cpname = 'CP01';

    var date = moment().utcOffset("+05:30").format(format);
    console.log(date);
   
    var metadata = [
        2,
        uniqid,
        'RemoteStartTransaction',
            {
                connectorId: 1,
                idTag: '8481',
            }
        ];

    // var metadata2 = [
    //     2,
    //     '12',
    //     'Reset',
    //         {
    //             type: "Hard",
    //         }
    //     ];

        var metadata3 = [
            2,
            "11",
            "ChangeConfiguration",
            {
                key:"DisplayText",
                value:"welcome.."
            }
            // {
            //     "configurationKey": [
            //         {
            //             key:"DisplayText",
            //             value:"welcome.."
            //         }   
            //         // {
            //         //     'key':"AuthorizeRemoteTxRequests",
            //         //     'value':"True"
            //         // }   
            //     ]
            // } 
            // {
            //     key:"StopTransactionOnInvalidId",
            //     value:"False"
            // },
            // {
            //     "key":"MaxEnergyOnInvalidId",
            //     "value":"10"
            // }    
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

        // broadcasting to all connected WebSocket clients, including itself.
        wss.clients.forEach(function each(client) {
            if (client.readyState === WebSocket.OPEN) {
              client.send(JSON.stringify(metadata));    
            }
        });

        // const ws = new WebSocket('ws://65.2.153.255:8082');

        // ws.on('open', function open() {
        //     ws.send(JSON.stringify(metadata));
        // });

        //save the sending message to database
        var sql = "INSERT INTO device_messages (uid,date,station,type,message) VALUES ('"+uniqid+"','"+date+"','"+cpname+"','Out','"+JSON.stringify(metadata,null, 2)+"')";
            con.query(sql, function (err, result) {
                if (err) throw err;
            console.log("Remote Start Request Inserted");
        });

        //sending responce to frontend
        res.send('Remotestart Send Successful');
        console.log('Inside RemoteStart Controller');
}