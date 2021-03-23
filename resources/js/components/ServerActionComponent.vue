
<template>
	<div class="row">
		<div class="col-6">
            <h5>Actions</h5>
            <br>
            <label>IdTag</label>
            <input id="IdTag" type="text" class="form-control" name="IdTag" v-model="IdTag" required autocomplete="Id Tag" autofocus>
            <br>
            <button v-on:click="RemotestartCharging" class="btn btn-primary" style="width: 220px;" id="start">Start Charging</button>
            <br><br>
            <input type="hidden" id="transaction_id" value="0">
            <button v-on:click="RemotestopCharging" class="btn btn-primary" style="width: 220px;" id="stop" disabled>Stop Charging</button>
        </div>
        <div class="col-6">
            <span style="text-align: center;">
                <h5 style="font-weight: bold;">Payload</h5>
            </span>
            <ul style="height:170px; overflow-x:scroll;border: 2px solid #6c757d;
      border-radius: 5px;">
                <div class='col-12' v-for="(payload, index) in payloads" :key="index">
                            <div id= "request" class="req">
                                <b>{{payload.type}}</b>
                                <label>{{payload.data}}</label>
                            </div>
                         </div>
            </ul>
        </div>
	</div>
</template>

<script>
export default {
        data() {
            return {
                payloads:[],
                msgId: ' ',
                req:'',
                res:'',
                flag:0 ,
                status:'',
                users:'',
                IdTag:''
            }
        },
        mounted() {
            console.log('mounted');
        },
        created() {
            Echo.join('chat')
                .listen('StartTransaction',(event)=>{
                    this.payloads.push(event.payload);
                    console.log("hhh");
                })
        },
        methods :{
            RemotestartCharging() {
                this.payloads.length=0;
                if(this.IdTag == "")
                {
                     alert("Please enter a valid Tag ID");
                }
                else 
                {
                    var msgId = Math.floor(100000 + Math.random() * 900000);
                    axios.post('remoteStartCharging', {MessageTypeId:"2",UniqueId:msgId, Action:"RemoteStartTransacion",data:{connectorId: "11111", idTag: "567890"}})
                    .then((response) => {
                        document.getElementById("start").disabled=true;
                        document.getElementById("stop").disabled=false;
                        var req = '{MessageTypeId:"2",UniqueId:msgId, Action:"RemoteStartTransacion",data:{connectorId: "11111", idTag: "567890"}}';
                        axios.get('download_remotestartreq').then(response => {
                            var remotestart_request = response.data;
                        })
                        var res_data = response.data; 
                    
                        var transactionId = res_data.data.transactionId;
                        console.log(res_data.data.transactionId);
                        document.getElementById("transaction_id").value= transactionId;
                        this.payloads.push ({
                            type: 'RemoteStartTransacion request',
                            data:req
                        });
                        axios.get('download_remotestartres').then(response => {
                            var remotestart_response = response.data;
                        })
                    })
                }
            },
            RemotestopCharging() {
                var msgId = Math.floor(100000 + Math.random() * 900000);
                var transactionId = document.getElementById("transaction_id").value;
                console.log(transactionId);
                axios.post('remoteStopCharging', {MessageTypeId:"2",UniqueId:msgId, Action:"RemoteStopTransacion",data:{transactionId: transactionId}})
                .then((response) => {
                    document.getElementById("start").disabled=false;
                    document.getElementById("stop").disabled=true;
                    var req = '{MessageTypeId:"2",UniqueId:msgId, Action:"RemoteStopTransacion",data:{transactionId: transactionId}}';
                    axios.get('download_remotestopreq').then(response => {
                      var remotestop_request = response.data;
                    })
                    this.payloads.push ({
                        type: 'RemoteStopTransacion request',
                        data:req
                    });
                    axios.get('download_remotestopres').then(response => {
                      var remotestop_response = response.data;
                    })
                })
            }
        }
    }
</script>