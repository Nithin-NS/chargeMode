<template>
    <span>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body row">
                        <div class="form-group col-2">
                            <div class="input-group">
                                <label class="col-form-label text-md-right"
                                    >Charge point</label
                                >
                                <select
                                    v-model="select_cp"
                                    class="custom-select"
                                    id="cp_select"
                                    @change="getConnectors()"
                                >
                                    <option value="0" disabled selected
                                        >Select Charging Point...</option
                                    >
                                    <option
                                        v-bind:value="chargePoint.CP_ID"
                                        :key="chargePoint.CP_ID"
                                        v-for="chargePoint in chargePoints"
                                        >{{ chargePoint.CP_Name }}</option
                                    >
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-2">
                            <div class="input-group">
                                <label class="col-form-label text-md-right"
                                    >Connector</label
                                >
                                <select
                                    v-model="select_connector"
                                    class="custom-select"
                                    id="connector_select"
                                >
                                    <option value="0" disabled selected
                                        >Select Connector...</option
                                    >
                                    <option
                                        :value="connector.id"
                                        :key="connector.id"
                                        v-for="connector in connectors"
                                        >{{ connector.Type }}</option
                                    >
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-3">
                            <div class="input-group">
                                <label class="col-form-label text-md-right"
                                    >CB Serial No</label
                                >
                                <input
                                    v-model="select_cb_serial"
                                    class="form-control"
                                    name="cbserial_no"
                                />
                            </div>
                            <span></span>
                        </div>
                        <div class="form-group col-3">
                            <div class="input-group">
                                <label class="col-form-label text-md-right"
                                    >CP Serial No</label
                                >
                                <input
                                    v-model="select_cp_serial"
                                    id="cpserial_no"
                                    type="text"
                                    class="form-control"
                                    name="cpserial_no"
                                />
                            </div>
                        </div>
                        <div class="col-1">
                            <button v-bind:disabled="btnDisable"
                                class="btn btn-primary btn-lg"
                                id="boot"
                                @click.prevent="bootnotification()"
                            >
                                Boot
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <label
                                for="IdTag"
                                class="col-1 col-form-label text-md-right"
                                >ID Tag</label
                            >

                            <div class="col-3">
                                <input
                                    id="IdTag"
                                    type="text"
                                    class="form-control"
                                    name="IdTag"
                                    required
                                    autocomplete="Id Tag"
                                    autofocus
                                    v-model="id_Tag"
                                />
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-primary" id="auth" v-bind:disabled="authbtn" @click.prevent="authenticate()">
                                    Authenticate
                                </button>
                            </div>
                            <div class="col-3">
                                <button
                                    class="btn btn-primary"
                                    id="start"
                                    disabled
                                >
                                    Start Charging
                                </button>
                                <button
                                    class="btn btn-primary"
                                    id="stop"
                                    disabled
                                >
                                    Stop Charging
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="input-group">
                                <label>User ID</label>
                                <input
                                    id="userid"
                                    type="text"
                                    class="form-control"
                                    name="TagID"
                                    disabled="disabled"
                                />
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <div class="input-group">
                               <label>Tag ID</label>
                                <input id="tagid" type="text" class="form-control" name="TagID" disabled="disabled">
                              </div>
                        </div>-->
                        <!--<div class="form-group">
                            <div class="input-group">
                               <label>Status</label>
                                <input id="status" type="text" class="form-control" name="TagID"  disabled="disabled">
                              </div>
                        </div>-->
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="input-group">
                                <label>Tag ID</label>
                                <input
                                    id="tagid"
                                    type="text"
                                    class="form-control"
                                    name="TagID"
                                    disabled="disabled"
                                />
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <div class="input-group">
                               <label>Vehicle name</label>
                                <input id="vehicle" type="text" class="form-control" name="TagID"  disabled="disabled">
                              </div>
                        </div>-->
                        <!--<div class="form-group">
                            <div class="input-group">
                               <label>Charging PIN ID</label>
                                <input id="chargepin" type="text" class="form-control" name="TagID"  disabled="disabled">
                              </div>
                        </div>-->
                        <!--<div class="form-group">
                            <div class="input-group">
                               <label>Battery</label>
                                <input id="battery" type="text" class="form-control" name="TagID"  disabled="disabled">
                              </div>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <strong>Payload </strong>
                    </div>
                    <div class="card-body">
                        <ul style="height: 170px; overflow-y: scroll">
                            <div class="row">
                                <div class="col-12">
                                    <div id="request" class="req" style="margin-bottum:10px">
                                        {{ data }}
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <strong>Log </strong>
                        <button
                            type="submit"
                            class="btn btn-primary"
                            style="align-content: right"
                        >
                            Clear
                        </button>
                    </div>

                    <div class="card-body">
                        <ul style="height: 90px; overflow-y: scroll">
                            <li></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>

@section('scripts')
<script>
//import func from 'vue-editor-bridge';
    export default {
        data: function(){
            return {
                chargePoints : [],
                select_cp: '',
                key : '',
                connectors: [],
                select_connector: '',
                select_cb_serial: '',
                select_cp_serial: '',
                data : [],
                btnDisable: false,
                authbtn: true,
                id_Tag: '',
            }
        },
        mounted() {
            // this.getChargepoints();
            this.listen();
        },
        methods: {
            listen(){
                Echo.channel('bootnotificationresponce')
                    .listen('BootNotificationResponse', (e)=>{
                         
                        this.data = JSON.parse(e.data);
                        console.log(this.data.payload.status); 
                        if(this.data.payload.status == 'Accepted'){
                           this.btnDisable = true;
                           this.authbtn = false;
                        }
                        else{
                        
                        }
                    })
            },
            getChargepoints: function(){
                axios.get('/getChargepoints')
                    .then(function (response) {
                      this.chargePoints = response.data;
                    //   console.log(response.data);
                    }.bind(this));

            },
            getConnectors: function() {
                axios.get('/getConnectors',{
                      params: {
                        cp_id: this.select_cp
                      }
                      }).then(function(response){
                          this.connectors = response.data;
                        }.bind(this));
            },
            bootnotification: function() {
                axios.post('/getBootNotification',{
                        connector: this.select_connector,
                        cp_id: this.select_cp,
                        chargePointSerialNumber: this.select_cp_serial,
                        chargeBoxSerialNumber: this.select_cb_serial,
                      }).then(function(response){
                        //   this.connectors = response.data;
                        }.bind(this));
            },
            authenticate: function() {
                axios.post('/authenticate',{
                        id_tag: this.id_Tag,
                        cp_id: this.select_cp,
                      }).then(function(response){
                        //   this.connectors = response.data;
                        }.bind(this));
            }
        },
        created: function(){
          this.getChargepoints();
        }
    }
</script>
@endsection
