const WebSocket = require('ws');

const remotejs = require('./remote.js');

var fs = require('fs');

const path = require('path');

const express = require('express');

const app = express();

const http = require('http');

const port = 8000;

app.use(express.urlencoded({ extended: true }));

const server = http.createServer(app);

// app.post('/remoteStart', (req, res)=>{
//     calling.aFunction();
//     res.send('A message!');
// });

// remotejs.remote();

const dir = './public/device_messages';

try {
        if (!fs.existsSync(dir)){
            fs.mkdir(path.join(__dirname, dir), (err) => {
                if (err) {
                    return console.error(err);
                }
                console.log('Directory created successfully!');
            });
        }
        else{
            console.log('Directory Exists!');
        }
    } 
catch (err) {
            console.error(err);
    }

const wss = new WebSocket.Server({ port: 8082 });

wss.on("connection", ws => {

    console.log('New Client Conncted..');

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

        var date = new Date();
        var fullDate = date.getDate()+'-'+(date.getMonth()+1)+'-'+date.getFullYear();
        var time = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
        var datetime = fullDate+' '+time;

        //setting the path
        const path = './public/device_messages/messages.json'

        //Convert it from an object to a string with JSON.stringify
        var json = JSON.stringify(msg);

        //Check the file exist or not create it, and use fs to write the file to disk
        try {
            if (fs.existsSync(path)) {
                //file exist
                console.log("File exists.");
                fs.readFile(path, 'utf8', function readFileCallback(err, data){
                    if (err){
                        console.log(err);
                    } else {
                    // obj = JSON.parse(data); //now it an object
                    // obj.table.push(msg); //add some data
                    json = JSON.stringify(msg); //convert it back to json
                    // json = msg; //convert it back to json
                    fs.appendFileSync(path, json, 'utf8', function(err){
                        console.log(err);
                    }); // write it back 
                }});
            } else {
                //file not exist
                console.log("File does not exist.");
                fs.writeFile(path, json, 'utf8', function(err){
                    if (err) {
                        return console.log(err);
                    }
                    console.log('Json file generated succesfully.');
                });
            }
          } catch(err) {
            console.error(err)
        }
        //end of json file save section

        var mysql = require('mysql');
        var con = mysql.createConnection({
            host: "localhost",
            user: "root",
            password: "",
            database: "chargemode_websockets"
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
                            currenTime: datetime,
                            interval: "15",
                            status: 'Rejected',
                        }
                    ];
                    console.log(metadata);

                    //setting the path
                    const path = './public/device_messages/messages.json'

                    //Convert it from an object to a string with JSON.stringify
                    var json = JSON.stringify(metadata);

                    //Check the file exist or not create it, and use fs to write the file to disk
                    try {
                        if (fs.existsSync(path)) {
                            //file exist
                            console.log("File exists.");
                            fs.readFile(path, 'utf8', function readFileCallback(err, data){
                                if (err){
                                    console.log(err);
                                } else {
                                // obj = JSON.parse(data); //now it an object
                                // obj.table.push(msg); //add some data
                                json = JSON.stringify(metadata); //convert it back to json
                                // json = msg; //convert it back to json
                                fs.appendFileSync(path, json, 'utf8', function(err){
                                    console.log(err);
                                }); // write it back 
                            }});
                        } else {
                            //file not exist
                            console.log("File does not exist.");
                            fs.writeFile(path, json, 'utf8', function(err){
                                if (err) {
                                    return console.log(err);
                                }
                                console.log('Json file generated succesfully.');
                            });
                        }
                      } catch(err) {
                        console.error(err)
                    }
                    //end of json file save section

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
                            currenTime: datetime,
                            interval: "15",
                            status: 'Accepted'
                        }
                    ];
                    console.log(metadata);

                    //setting the path
                    const path = './public/device_messages/messages.json'

                    //Convert it from an object to a string with JSON.stringify
                    var json = JSON.stringify(metadata);

                    //Check the file exist or not create it, and use fs to write the file to disk
                    try {
                        if (fs.existsSync(path)) {
                            //file exist
                            console.log("File exists.");
                            fs.readFile(path, 'utf8', function readFileCallback(err, data){
                                if (err){
                                    console.log(err);
                                } else {
                                // obj = JSON.parse(data); //now it an object
                                // obj.table.push(msg); //add some data
                                json = JSON.stringify(msg); //convert it back to json
                                // json = msg; //convert it back to json
                                fs.appendFileSync(path, json, 'utf8', function(err){
                                    console.log(err);
                                }); // write it back 
                            }});
                        } else {
                            //file not exist
                            console.log("File does not exist.");
                            fs.writeFile(path, json, 'utf8', function(err){
                                if (err) {
                                    return console.log(err);
                                }
                                console.log('Json file generated succesfully.');
                            });
                        }
                    } catch(err) {
                        console.error(err)
                    }
                    //end of json file save section

                    ws.send(JSON.stringify(metadata));
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
        
        console.log(idTag + ' | ' + chargepoint + ' | ' + connector);

        var mysql = require('mysql');
        var con = mysql.createConnection({
            host: "localhost",
            user: "root",
            password: "",
            database: "chargemode_websockets"
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

        var date = new Date();
        var fullDate = date.getDate()+'-'+(date.getMonth()+1)+'-'+date.getFullYear();
        var time = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
        var datetime1 = fullDate+' '+time;

        // console.log(datetime);
 
        var mysql = require('mysql');
        var con = mysql.createConnection({
            host: "localhost",
            user: "root",
            password: "",
            database: "chargemode_websockets"
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
                ws.send(JSON.stringify(metadata));
            }
            else{
                console.log('Accepted')
                
                var sql = "INSERT INTO transactions (Connector_ID,CP_ID,CS_ID,User_ID,Reservation_ID,Trans_DateTime,Trans_Meter_Start) VALUES ('"+connectorid+"','"+chargepoint+"','3459','170443','235265','"+datetime1+"','45')";
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

        var date = new Date();
        var fullDate = date.getDate()+'-'+(date.getMonth()+1)+'-'+date.getFullYear();
        var time = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
        var datetime = fullDate+' '+time;

        //Insert a record in the "metervalue" table:
        var sql = "INSERT INTO meter_values (Connector_ID,CP_ID,Date,Reservation_ID,Meter_Values) VALUES ('"+connectorId+"','"+chargepoint+"','"+datetime+"','235265','53')";
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
        ws.send(JSON.stringify(metadata));
    }//End of metervalues

    //hearBeat
    function HeartBeat(msg){
        var data = msg;
        var uniqid = data[1];

        var metadata =  [
            3,
            uniqid,
            "HeartBeatResponse",
            {
                currentTime: '02-04-21' 
            }
        ];
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

        var date = new Date();
        var fullDate = date.getDate()+'-'+(date.getMonth()+1)+'-'+date.getFullYear();
        var time = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
        var datetime = fullDate+' '+time;
 
        var mysql = require('mysql');
        var con = mysql.createConnection({
            host: "localhost",
            user: "root",
            password: "",
            database: "chargemode_websockets"
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