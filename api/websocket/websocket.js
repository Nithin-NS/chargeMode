const http = require('http');

const express = require('express');

const WebSocket = require('ws');

const app = express();

const server = http.createServer(app);

const port = 8082;

const wss = new WebSocket.Server({ 
    port: port,
    clientTracking: true
});

module.exports = wss;