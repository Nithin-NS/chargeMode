<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Admin Component</div>

                    <div class="card-body">
                        Message from {{ comment }} Component
                    </div>
                    <div class="card-body">
                        {{ data }}
                        <div>Title = {{ data.title }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            comment: "Admin",
            data: ""
        };
    },
    mounted() {
        console.log("Admin Component  mounted.");
        this.listen();
        // cp_id: this.cp_id;
    },
    methods: {
        listen() {
            Echo.channel("bootnotification").listen("BootNotification", e => {
                this.data = e.data;
                // this.cp_id = e.cp_id;
                console.log(e.data.payload.chargePointModel);
                //console.log(e.data.payload.chargeBoxSerialNumber);
                this.checking();
            });
        },
        checking() {
            var title = this.data.title;
            
            switch (title) {
                case "BootNotificationRequest":
                    console.log("BootNotification from " + this.data.payload.chargePointModel);
                    this.BootNotificationResponse();
                    break;
                case "Authorize":
                    console.log("AuthenticateRequest");
                    this.AuthenticateResponse();
                    break;
                case "StartTransactionRequest":
                    console.log('StartTransaction');
                    this.StartTransactionResponse();
                    break;
                case "MeterValuesRequest":
                    console.log('MeterValues');
                    this.MeterValues();
                    break;
                case "HeartBeatRequest":
                    console.log('HeartBeat');
                    this.HeartBeat();
                    break;
                case "StopTransactionRequest":
                    console.log('StopTransaction');
                    this.StopTransaction();
                    break;
                default:
                    console.log("Not Working");
            }
        },
        BootNotificationResponse() {
            axios
                .post("/sendBootNotificationResponce", {
                    chargePointModel: this.data.payload.chargePointModel,
                })
                .then(
                    function(response) {
                        // console.log(response);
                        if(response.data == 'ok'){
                            console.log('OK');
                        }
                    }.bind(this)
                );
        },
        AuthenticateResponse() {
            axios
                .post("/sendAuthenticateResponse", {
                    idTag : this.data.payload.idTag,
                    // cp_id : this.data.cp_id,
                })
                .then(
                    function(response) {
                        //   this.connectors = response.data;
                    }.bind(this)
                );
            console.log('Authenticatedddddd');
        },
        StartTransactionResponse() {
            axios
                .post("/sendTransactionResponse", {
                    status: "Rejected",
                    currenTime: "10.25",
                    interval: "2"
                })
                .then(
                    function(response) {
                        //   this.connectors = response.data;
                    }.bind(this)
                );
        },
        MeterValues() {
            axios
                .post("/sendMeterValues", {
                    status: "Rejected",
                    currenTime: "10.25",
                    interval: "2"
                })
                .then(
                    function(response) {
                        //   this.connectors = response.data;
                    }.bind(this)
                );
        },
        HeartBeat() {
            axios
                .post("/sendHeartBeatRequest", {
                    status: "Rejected",
                    currenTime: "10.25",
                    interval: "2"
                })
                .then(
                    function(response) {
                        //   this.connectors = response.data;
                    }.bind(this)
                );
        },
        StopTransaction() {
            axios
                .post("/sendStopTransaction", {
                    status: "Rejected",
                    currenTime: "10.25",
                    interval: "2"
                })
                .then(
                    function(response) {
                        //   this.connectors = response.data;
                    }.bind(this)
                );
        }
    }
};
</script>
