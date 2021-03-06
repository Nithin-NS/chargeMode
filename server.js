const WebSocket = require('ws');

var remotestartcontroller = require('./api/controller/remotestartcontroller');
var remotestopcontroller = require('./api/controller/remotestopcontroller');
var wss = require('./api/websocket/websocket');

const cors = require('cors');

var fs = require('fs');

const path = require('path');

const express = require('express');

const app = express();

const http = require('http');

var moment = require('moment');

const format = "MM/DD/YYYY hh:mm:ss A";

const port1 = process.env.PORT || 8000;

app.use(express.urlencoded({ extended: true }));

//setting options for cors
var corsOptions = {
    origin: 'http://127.0.0.1:8000',
    optionsSuccessStatus: 200 // For legacy browser support
}
app.use(cors(corsOptions));

// function to handle remotestart
// function remotestart(res){
//     res.send('From Remotestart');
// }

//API for Remotestart and remotestop
app.get('/api/remotestart/:id', cors(), (req, res) => {
    //Call Function inside server
    // remotestart(res);

    //call function on controller.js
    remotestartcontroller.remotestart(res);
})

app.get('/api/remotestop/:id', cors(), (req, res) => {
    //Call Function inside server
    // remotestart(res);

    //call function on controller.js
    remotestopcontroller.remotestop(res);
})

app.listen(port1, () => console.log(`Listening on ${port1}`))

// const server = http.createServer(app);

// const wss = new WebSocket.Server({ port: 8082 });

wss.on("connection", function connection(ws, req) {

    console.log('New Client Conncted..');

    const ip = req.socket.remoteAddress;

    console.log(ip);

    ws.on("message", data => {
        // var msg = data;

        var msg = JSON.parse(data);

        var title = msg[2];

        console.log(msg)

        switch (title) {

            case "BootNotification":
                    console.log('boot');
                    BootNotification(msg);
                break;

            case "Authorize":
                console.log('authentication');
                authentication(msg);
                break;

            case "StartTransactionRequest":
                console.log('StartTransaction');
                StartTransaction(msg);
                break;
              
            case "MeterValuesRequest":
                console.log('MeterValues');
                MeterValues(msg);
                break;
              
            case "HeartBeatRequest":
                console.log('HeartBeat');
                HeartBeat(msg);
                break;

            case "StopTransactionRequest":
                console.log('StopTransaction');
                StopTransaction(msg);
                break;

            case "RemoteStartRequest":
                // console.log('RemoteStartRequest');
                RemoteStartRequest(msg);
                break;
              
            default:
                var text = "No value found";
                break;
        }
        // console.log(`Client has send us: (${data})`);
        // ws.send(msg);
    });

    //Function to Handle BootnotificationRequests from Charging Point
    function BootNotification(msg){
        console.log(msg);
        var data = msg;
        var cbserialno = data[3].chargeBoxSerialNumber;
        var cpserialno = data[3].chargePointSerialNumber;
        var cp_name = data[3].chargePointModel;
        var uniqid = data[1];
        var cpstatus = "0";

        var date = moment().format(format); 

        var mysql = require('mysql');
        var con = mysql.createConnection({
            host: "localhost",
            user: "root",
            password: "",
            database: "chargemode_websockets"
        });

        var sql = "INSERT INTO device_messages (uid,date,station,type,message) VALUES ('"+uniqid+"','"+date+"','"+cp_name+"','in','"+JSON.stringify(data,null, 2)+"')";
            con.query(sql, function (err, result) {
                if (err) throw err;
            console.log("Bootnotification Request Inserted");
        });

        var queryString = "SELECT * FROM chargepoints WHERE CP_Name = ?;"
        var filter = [cp_name];

        con.query(queryString, filter, function(err, results) {
                if(results.length === 0){
                    console.log('Rejected');
                    var metadata = [
                        3,
                        uniqid,
                        'BootNotificationResponse',
                        {
                            currenTime: date,
                            interval: "15",
                            status: 'Rejected',
                        }
                    ];
                    console.log(metadata);

                    var sql = "INSERT INTO device_messages (uid,date,station,type,message) VALUES ('"+uniqid+"','"+date+"','"+cp_name+"','out','"+JSON.stringify(metadata,null, 2)+"')";
                    con.query(sql, function (err, result) {
                        if (err) throw err;
                            console.log("Bootnotification Responce(Rejected) Inserted");
                    });

                    // Sending responce with status Rejected
                    ws.send(JSON.stringify(metadata));
                }

                //Valid Credentials
                else {
                    console.log('Accepted');
                    var metadata = [
                        3,
                        uniqid,
                        'BootNotificationResponse',
                        {
                            currenTime: date,
                            interval: "15",
                            status: 'Accepted'
                        }
                    ];
                    console.log(metadata);

                    var sql = "INSERT INTO device_messages (uid,date,station,type,message) VALUES ('"+uniqid+"','"+date+"','"+cp_name+"','out','"+JSON.stringify(metadata,null, 2)+"')";
                    con.query(sql, function (err, result) {
                        if (err) throw err;
                            console.log("Bootnotification Responce(Accepted) Inseted..");
                    });

                    ws.send(JSON.stringify(metadata));
                    console.log("Bootnotification has been send");
                }
        });
    }//End of BootNotification

    //Authenticate Function
    function authentication(msg){
        console.log('Inside Auth');
        // console.log(msg);
        var data = msg;
        var idTag = data[3].idTag;
        var chargepoint = data[3].chargepoint;
        var connector = data[3].connector;
        var uniqid = data[1];

        var date = moment().format(format); 

        var mysql = require('mysql');
        var con = mysql.createConnection({
            host: "localhost",
            user: "root",
            password: "",
            database: "chargemode_websockets"
        });

        var sql = "INSERT INTO device_messages (uid,date,station,type,message) VALUES ('"+uniqid+"','"+date+"','"+chargepoint+"','in','"+JSON.stringify(data,null, 2)+"')";
            con.query(sql, function (err, result) {
                if (err) throw err;
            console.log("Authentication Request Inserted..");
        });

        var sql = 'SELECT * FROM users WHERE user_id = ' + mysql.escape(idTag);
        con.query(sql, function (err, result) {
            if (err) throw err;

            //Invalid User
            if(result.length === 0 ){
                var metadata = [
                    3,
                    uniqid,
                    "AuthenticateResponse",
                    {
                        expiryDate:"2021-3-8T3.00PM",
                        parentIdTag:"170443",
                        status:"Invalid"
                    }
                ];

                var sql = "INSERT INTO device_messages (uid,date,station,type,message) VALUES ('"+uniqid+"','"+date+"','"+chargepoint+"','out','"+JSON.stringify(metadata,null, 2)+"')";
                    con.query(sql, function (err, result) {
                        if (err) throw err;
                    console.log("Authentication responce(Invalid) Inserted..");
                });

                //Sending Responce with status Invalid
                console.log(JSON.stringify(metadata));
                ws.send(JSON.stringify(metadata));
            }
            //Valid User
            else{
                var metadata = [
                    3,
                    uniqid,
                    "AuthenticateResponse",
                    {
                        expiryDate:"2021-3-8T3.00PM",
                        parentIdTag:"170443",
                        status:"Accepted"
                    }
                ];

                var sql = "INSERT INTO device_messages (uid,date,station,type,message) VALUES ('"+uniqid+"','"+date+"','"+chargepoint+"','out','"+JSON.stringify(metadata,null, 2)+"')";
                    con.query(sql, function (err, result) {
                        if (err) throw err;
                    console.log("Authentication responce(Accepted) Inserted..");
                });

                //Sending Responce with Status Accepted
                console.log(JSON.stringify(metadata));
                ws.send(JSON.stringify(metadata));
            }
        });
    }//End of Authenticate Function

    //Start Transaction Function
    function StartTransaction(msg){
        console.log('Inside StartTransaction');

        var data = msg;
        var chargepoint = data[3].chargepoint;
        var connectorid = data[3].connectorId;
        var idTag = data[3].idTag;
        var meterStart = data[3].meterStart;
        var reservationId = data[3].reservationId;
        var uniqid = data[1];

        var date = moment().format(format);
 
        var mysql = require('mysql');
        var con = mysql.createConnection({
            host: "localhost",
            user: "root",
            password: "",
            database: "chargemode_websockets"
        });

        var sql = "INSERT INTO device_messages (uid,date,station,type,message) VALUES ('"+uniqid+"','"+date+"','"+chargepoint+"','in','"+JSON.stringify(data,null, 2)+"')";
            con.query(sql, function (err, result) {
                if (err) throw err;
            console.log("StartTransaction Request Inserted..");
        });

        var sql = 'SELECT * FROM connectors WHERE id = ' + mysql.escape(connectorid);
        con.query(sql, function (err, result) {
            if (err) throw err;
            
            //Invalid
            if(result.length === 0){
                console.log('Invalid')
                var metadata = [
                    3,
                    uniqid,
                    "StartTransactionResponse",
                    {
                        expiryDate:"2021-3-8T3.00PM",
                        parentIdTag:"170443",
                        status:"Invalid"
                    },
                    transactionId="2468"
                ];

                var sql = "INSERT INTO device_messages (uid,date,station,type,message) VALUES ('"+uniqid+"','"+date+"','"+chargepoint+"','out','"+JSON.stringify(metadata,null, 2)+"')";
                    con.query(sql, function (err, result) {
                        if (err) throw err;
                    console.log("StartTransaction Responce(Invalid) Inserted..");
                });
                ws.send(JSON.stringify(metadata));
            }
            else{
                console.log('Accepted')
                
                var sql = "INSERT INTO transactions (Connector_ID,CP_ID,CS_ID,User_ID,Reservation_ID,Trans_DateTime,Trans_Meter_Start) VALUES ('"+connectorid+"','"+chargepoint+"','3459','170443','235265','"+date+"','45')";
                con.query(sql, function (err, result) {
                    if (err) throw err;
                    console.log("transactiondata inserted");
                });

                var metadata = [
                    3,
                    uniqid,
                    "StartTransactionResponse",
                    {
                        expiryDate:"2021-3-8T3.00PM",
                        parentIdTag:"170443",
                        status:"Accepted"
                    },
                    transactionId="2468"
                ];
                var sql = "INSERT INTO device_messages (uid,date,station,type,message) VALUES ('"+uniqid+"','"+date+"','"+chargepoint+"','out','"+JSON.stringify(metadata,null, 2)+"')";
                    con.query(sql, function (err, result) {
                        if (err) throw err;
                    console.log("StartTransaction Responce(Accepted) Inserted..");
                });
                ws.send(JSON.stringify(metadata));
            }
        });

    }//End of Start Transaction Function

    //MeterValues
    function MeterValues(msg){
        var data = msg;
        var chargepoint = data[3].chargepoint;
        var connectorId = data[3].connectorId;
        var uniqid = data[1];

        var mysql = require('mysql');
        var con = mysql.createConnection({
            host: "localhost",
            user: "root",
            password: "",
            database: "chargemode_websockets"
        });

        var date = moment().format(format);

        var sql = "INSERT INTO device_messages (uid,date,station,type,message) VALUES ('"+uniqid+"','"+date+"','"+chargepoint+"','in','"+JSON.stringify(data,null, 2)+"')";
            con.query(sql, function (err, result) {
                if (err) throw err;
            console.log("MeterValues Request Inserted..");
        });

        //Insert a record in the "metervalue" table:
        var sql = "INSERT INTO meter_values (Connector_ID,CP_ID,Date,Reservation_ID,Meter_Values) VALUES ('"+connectorId+"','"+chargepoint+"','"+date+"','235265','53')";
        con.query(sql, function (err, result) {
            if (err) throw err;
            console.log("metervalue record inserted");
        });

        var metadata = [
            3,
            uniqid,
            "MeterValuesResponse",
            {
                status: 'success'
            }
        ];

        var sql = "INSERT INTO device_messages (uid,date,station,type,message) VALUES ('"+uniqid+"','"+date+"','"+chargepoint+"','out','"+JSON.stringify(metadata,null, 2)+"')";
            con.query(sql, function (err, result) {
                if (err) throw err;
            console.log("MeterValues Responce Inserted..");
        });
        ws.send(JSON.stringify(metadata));
    }//End of metervalues

    //hearBeat
    function HeartBeat(msg){
        var data = msg;
        var uniqid = data[1];
        var chargepoint = 'unknown';

        var date = moment().format(format);

        var mysql = require('mysql');
        var con = mysql.createConnection({
            host: "localhost",
            user: "root",
            password: "",
            database: "chargemode_websockets"
        });

        var sql = "INSERT INTO device_messages (uid,date,station,type,message) VALUES ('"+uniqid+"','"+date+"','"+chargepoint+"','in','"+JSON.stringify(data,null, 2)+"')";
            con.query(sql, function (err, result) {
                if (err) throw err;
            console.log("HeartBeat Request Inserted..");
        });

        var metadata =  [
            3,
            uniqid,
            "HeartBeatResponse",
            {
                currentTime: '02-04-21' 
            }
        ];

        var sql = "INSERT INTO device_messages (uid,date,station,type,message) VALUES ('"+uniqid+"','"+date+"','"+chargepoint+"','out','"+JSON.stringify(metadata,null, 2)+"')";
            con.query(sql, function (err, result) {
                if (err) throw err;
            console.log("HeartBeat Request Inserted..");
        });
        ws.send(JSON.stringify(metadata));
    }
    
    //Stop Transaction
    function StopTransaction(msg){

        var data = msg;
        var chargepoint = data[3].chargepoint;
        var connectorId = data[3].connectorId;
        var idTag = data[3].idTag;
        //var meterStart = data.payload.meterStart;
        // var reservationId = data.payload.reservationId;
        var meterStop = data[3].meterStop;
        var uniqid = data[1];

        var date = moment().format(format);
 
        var mysql = require('mysql');
        var con = mysql.createConnection({
            host: "localhost",
            user: "root",
            password: "",
            database: "chargemode_websockets"
        });

        var sql = "INSERT INTO device_messages (uid,date,station,type,message) VALUES ('"+uniqid+"','"+date+"','"+chargepoint+"','in','"+JSON.stringify(data,null, 2)+"')";
            con.query(sql, function (err, result) {
                if (err) throw err;
            console.log("StopTransaction Request Inserted..");
        });

        var sql = 'UPDATE transactions SET Trans_Meter_Stop = ? WHERE Connector_ID = ? AND CP_ID = ?';
        
        con.query(sql,[meterStop, connectorId, chargepoint], function(err,rows,fields) { 
            console.log('Transactions Updated');
        });

        var metadata = [
            3,
            uniqid,
            "StopTransactionResponse",
            {
                expiryDate:"2021-3-8T3.00PM",
                parentIdTag:"170443",
                status:"Accepted"
            },
            2468,
        ];
        var sql = "INSERT INTO device_messages (uid,date,station,type,message) VALUES ('"+uniqid+"','"+date+"','"+chargepoint+"','out','"+JSON.stringify(data,null, 2)+"')";
            con.query(sql, function (err, result) {
                if (err) throw err;
            console.log("StopTransaction Request Inserted..");
        });
        ws.send(JSON.stringify(metadata));
        // ws.terminate();
    }//End of Stop Transaction

    //remote start transaction
    function RemoteStartRequest(msg){
        var data = msg;
        // console.log(data);
        // var uniqid = data[1];

        // var metadata =  [
        //     3,
        //     uniqid,
        //     "HeartBeatResponse",
        //     {
        //         currentTime: '02-04-21' 
        //     }
        // ];
        ws.send(JSON.stringify(data));
    }

    ws.on("close", () => {
        console.log('Client Has Disconnected..');
    });
});