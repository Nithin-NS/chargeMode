const WebSocket = require('ws');

const wss = new WebSocket.Server({ port: 8082 });

wss.on("connection", ws => {

    console.log('New Client Conncted..');

    ws.on("message", data => {
        // var msg = data;
        var msg = JSON.parse(data);

        // console.log(msg.)

        switch (msg.title) {

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
              
            default:
                var text = "No value found";
                break;
        }
        // console.log(`Client has send us: (${data})`);
        // ws.send(msg);
    });

    //Function to Handle BootnotificationRequests from Charging Point
    function BootNotification(msg){
        // console.log(msg);
        var data = msg;
        var cbserialno = data.payload.chargeBoxSerialNumber;
        var cpserialno = data.payload.chargePointSerialNumber;
        var cp_id = data.payload.chargePointVendor;
        var uniqid = data.UniqueId;
        var connector = data.payload.connector;
        var cpstatus = "0";

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



        var queryString = "SELECT * FROM chargepoint WHERE CP_ID = ? AND CB_Serial_No= ? AND CP_Serial_No= ?;"
        var filter = [cp_id, cbserialno, cpserialno];

        con.query(queryString, filter, function(err, results) {
            // console.log(results.length);
            var querystr = "SELECT * FROM cp_connector WHERE cp_id=? AND connector_type=? AND status=?;"
            var filter1 = [cp_id, connector, cpstatus] ;
            
            con.query(querystr, filter1, function(err, results1){
                // console.log(results1.length);
                
                //Wrong Credancials
                if(results.length === 0 && results1.length === 0){
                    console.log('Rejected');
                    var metadata = { 
                        MessageTypeId:"3",
                        UniqueId: uniqid,
                        title:"BootNotificationResponse",
                        payload:{
                            status:"Rejected",
                            currenTime:datetime,
                            interval:"2"
                        }
                    };
                    // Sending responce with status Rejected
                    ws.send(JSON.stringify(metadata));
                }

                //Valid Credentials
                else {
                console.log('Accepted');
                var queryString = "UPDATE cp_connector SET status = '1' WHERE cp_id = ? AND connector_type = ? AND status = ?;"
                var filter = [cp_id,connector,cpstatus];
                con.query(queryString, filter, function(err, results) {
                    console.log('Updated');
                });

                var metadata = { 
                    MessageTypeId:"3",
                    UniqueId: uniqid,
                    title:"BootNotificationResponse",
                    payload:{
                        status:"Accepted",
                        currenTime:datetime,
                        interval:"2"
                    }
                };
                // var metadata = [ 
                //     "3",
                //     uniqid,
                //     "BootNotificationResponse",
                //     {
                //         status:"Accepted",
                //         currenTime:datetime,
                //         interval:"2"
                //     }
                // ];
                //Sending responce with status accepted
                ws.send(JSON.stringify(metadata));
                }
            });
        });
    }//End of BootNotification

    //Authenticate Function
    function authentication(msg){
        console.log('Inside Auth');
        var data = msg;
        var idTag = data.payload.idTag;
        var chargepoint = data.payload.chargepoint;
        var connector = data.payload.connector;
        
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
                var metadata = {
                    MessageTypeId:"3",
                    Uniqueid:"456378",
                    title:"AuthenticateResponse",
                    payload:{
                        expiryDate:"2021-3-8T3.00PM",
                        parentIdTag:"170443",
                        status:"Invalid"
                    }
                };
                //Sending Responce with status Invalid
                console.log(JSON.stringify(metadata));
                ws.send(JSON.stringify(metadata));
            }
            //Valid User
            else{
                var metadata = {
                    MessageTypeId:"3",
                    Uniqueid:"456378",
                    title:"AuthenticateResponse",
                    payload:{
                        expiryDate:"2021-3-8T3.00PM",
                        parentIdTag:"170443",
                        status:"Accepted"
                    }
                };
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
        var chargepoint = data.payload.chargepoint;
        var connectorid = data.payload.connectorId;
        var idTag = data.payload.idTag;
        var meterStart = data.payload.meterStart;
        var reservationId = data.payload.reservationId;

        var mysql = require('mysql');
        var con = mysql.createConnection({
            host: "localhost",
            user: "root",
            password: "",
            database: "chargemode_websockets"
        });
        var sql = 'SELECT * FROM connectortype WHERE id = ' + mysql.escape(connectorid);
        con.query(sql, function (err, result) {
            if (err) throw err;
            
            //Invalid
            if(result.length === 0){
                console.log('Invalid')
                var metadata = {
                    MessageTypeId:"3",
                    UniqueId:"678534",
                    title:"StartTransactionResponse",
                    IdTagInfo:{
                        expiryDate:"2021-3-8T3.00PM",
                        parentIdTag:"170443",
                        status:"Invalid"
                    },
                    transactionId:"2468" 
                };
                ws.send(JSON.stringify(metadata));
            }
            else{
                console.log('Accepted')
                var metadata = {
                    MessageTypeId:"3",
                    UniqueId:"678534",
                    title:"StartTransactionResponse",
                    IdTagInfo:{
                        expiryDate:"2021-3-8T3.00PM",
                        parentIdTag:"170443",
                        status:"Accepted"
                    },
                    transactionId:"2468"
                };
                ws.send(JSON.stringify(metadata));
            }
        });

    }//End of Start Transaction Function

    //MeterValues
    function MeterValues(msg){
        var data = msg;
        var chargepoint = data.payload.chargepoint;
        var connectorId = data.payload.connectorId;

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

        if(connectorId == "1"){
            con.connect(function(err) {
                //Insert a record in the "transcations" table:
                var sql = "INSERT INTO transactions (Connector_ID,CP_ID,CS_ID,User_ID,Reservation_ID,Trans_DateTime,Trans_Meter_Start,Trans_Meter_Stop) VALUES ('"+connectorId+"','"+chargepoint+"','3459','170443','235265','"+datetime+"','45','53')";
                con.query(sql, function (err, result) {
                    if (err) throw err;
                    console.log("transactiondata inserted");
                });
            });

            con.connect(function(err) {
                //Insert a record in the "metervalue" table:
                var sql = "INSERT INTO meter_values (Connector_ID,CP_ID,Date,Reservation_ID,Meter_Values) VALUES ('"+connectorId+"','"+chargepoint+"','"+datetime+"','235265','53')";
                con.query(sql, function (err, result) {
                    if (err) throw err;
                    console.log("metervalue record inserted");
                });
            });

            var metadata = {
                MessagetypeId:"3",
                UniqueId:"342337",
                title:"MeterValuesResponse",
                payload:{
                    status: 'success'
                }
            };
            ws.send(JSON.stringify(metadata));
        }
        else{
            con.connect(function(err) {
                //Insert a record in the "transcations" table:
                var sql = "INSERT INTO transactions (Connector_ID,CP_ID,CS_ID,User_ID,Reservation_ID,Trans_DateTime,Trans_Meter_Start,Trans_Meter_Stop) VALUES ('"+connectorId+"','"+chargepoint+"','3459','170443','235265','"+datetime+"','45','53')";
                con.query(sql, function (err, result) {
                    if (err) throw err;
                    console.log("transactiondata inserted");
                });
            });

            con.connect(function(err) {
                //Insert a record in the "metervalue" table:
                var sql = "INSERT INTO meter_values (Connector_ID,CP_ID,Date,Reservation_ID,Meter_Values) VALUES ('"+connectorId+"','"+chargepoint+"','"+datetime+"','235265','53')";
                con.query(sql, function (err, result) {
                    if (err) throw err;
                    console.log("metervalue record inserted");
                });
            });
            var metadata = {
                MessagetypeId:"3",
                UniqueId:"342337",
                title:"MeterValuesResponse",
                payload:{
                    status: 'success'
                }
            };
            ws.send(JSON.stringify(metadata));
        }

    }//End of metervalues

    //hearBeat
    function HeartBeat(msg){
        var metadata =  {
            MessagetypeId:"3",
            UniqueId:"334741",
            title:"HeartBeatResponse",
            payload:{
                currentTime: '02-04-21' 
            }
        };
        ws.send(JSON.stringify(metadata));
    }
    
    //Stop Transaction
    function StopTransaction(msg){
        var metadata = {
            MessageTypeId:"3",
            UniqueId:"678534",
            title:"StopTransactionResponse",
            IdTagInfo:{
                expiryDate:"2021-3-8T3.00PM",
                parentIdTag:"170443",
                status:"Accepted"
            },
            transactionId:"2468"
        };
        ws.send(JSON.stringify(metadata));
    }//End of Stop Transaction

    ws.on("close", () => {
        console.log('Client Has Disconnected..');
    });
});