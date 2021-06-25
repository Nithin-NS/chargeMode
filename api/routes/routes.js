const express = require('express');
const route = express.Router();

const controller = require('../controller/controller');

//API
route.post('/ocpp/remotestart', controller.remotestart);
route.post('/ocpp/remotestop', controller.remotestop);
// route.get('/api/users', controller.find);
// route.put('/api/users/:id', controller.update);
// route.delete('/api/delete/:id', controller.delete);

module.exports = route;