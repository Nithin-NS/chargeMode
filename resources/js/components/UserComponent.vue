<template>
    <div>
        <!-- search user -->
        <div class="row mb-20">
            <div class="col-8">
                <div class="input-group">
                    <input
                        type="search"
                        name="search"
                        class="form-control rounded"
                        placeholder="Search"
                        aria-label="Search"
                        aria-describedby="search-addon"
                    />
                    <button type="submit" class="btn btn-outline-primary">
                        search
                    </button>
                </div>
            </div>
            <div class="col-4 text-right">
                <a class="btn btn-outline-primary" href="/admin/addcustomer">
                    <i class="icon fa-plus" aria-hidden="true"></i>
                    <span class="text hidden-sm-down">Add New User</span>
                </a>
            </div>
        </div>

        <div class="card">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Sl No</th>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Pin Code</th>
                        <th>State</th>
                        <th>District</th>
                        <th>Status</th>
                        <th>Remote</th>
                        <th colspan="2">Actions</th>
                    </tr>
                </thead>

                <tr v-for="user in users" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.user_id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.mobile }}</td>
                    <td>{{ user.address }}</td>
                    <td>{{ user.pin }}</td>
                    <td>{{ user.state }}</td>
                    <td>{{ user.district }}</td>
                    <td>{{ user.status }}</td>
                    <td>
                        <span
                            v-if="user.status == 1"
                            class="badge badge-success"
                            >Active</span
                        >
                        <span v-else class="badge badge-danger">Deactive</span>
                    </td>
                    <td class="text-center">
                        <button
                            :id="'remoteStart_' + user.id"
                            class="btn btn-sm btn-success"
                            data-toggle="modal"
                            :data-target="'#transactionModal_' + user.id"
                            data-backdrop="static"
                            data-keyboard="false"
                        >
                            Start Transaction
                        </button>

                        <!-- Modal -->
                        <div
                            class="modal fade"
                            :id="'transactionModal_' + user.id"
                            tabindex="-1"
                            role="dialog"
                            aria-labelledby="deleteModalLabel"
                            aria-hidden="true"
                        >
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div
                                        class="modal-header justify-content-center"
                                    >
                                        <h4
                                            class="modal-title"
                                            id="deleteModalLabel"
                                        >
                                            Start Remote Transaction
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div
                                            id="error_msg"
                                            v-show="elementVisible"
                                            class="alert alert-danger col-md-8 offset-2"
                                            role="alert"
                                        >
                                            {{ error_msg }}
                                        </div>
                                        <div
                                            class="form-row justify-content-center"
                                        >
                                            <div class="form-group col-md-4">
                                                <label
                                                    for="select_cp"
                                                    class="col-form-label text-md-right"
                                                    >Charge point</label
                                                >
                                                <select
                                                    required
                                                    v-model="select_cp"
                                                    class="form-control"
                                                    id="select_cp"
                                                    @change="getConnectors()"
                                                >
                                                    <option
                                                        value="0"
                                                        disabled
                                                        selected
                                                        >Select Charging
                                                        Point...</option
                                                    >
                                                    <option
                                                        v-bind:value="
                                                            chargepoint.CP_ID
                                                        "
                                                        v-for="chargepoint in chargepoints"
                                                        :key="chargepoint.CP_ID"
                                                        >{{
                                                            chargepoint.CP_Name
                                                        }}</option
                                                    >
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label
                                                    for="select_connector"
                                                    class="col-form-label text-md-right"
                                                    >Connector</label
                                                >
                                                <select
                                                    required
                                                    v-model="select_connector"
                                                    class="form-control"
                                                    id="select_connector"
                                                >
                                                    <option
                                                        value="0"
                                                        disabled
                                                        selected
                                                        >Select
                                                        Connector...</option
                                                    >
                                                    <option
                                                        :value="connector.id"
                                                        :key="connector.id"
                                                        v-for="connector in connectors"
                                                        >{{
                                                            connector.Type
                                                        }}</option
                                                    >
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="col-md-8 offset-2">
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline-secondary"
                                                data-dismiss="modal"
                                            >
                                                Close
                                            </button>
                                            <button
                                                type="submit"
                                                value="Submit"
                                                id="remoteStart"
                                                @click.prevent="
                                                    remoteStart(user.id)
                                                "
                                                class="btn btn-success btn-sm"
                                            >
                                                Start Transaction
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button
                            style="display:none;"
                            :id="'remoteStop_' + user.id"
                            class="btn btn-sm btn-danger remoteStop"
                            @click.prevent="remoteStop(user.id)"
                        >
                            Stop Transaction
                        </button>
                    </td>
                    <td class="text-center">
                        <a :href="'/customer/edit/' + user.id"
                            ><i
                                class="fa fa-pencil-square-o"
                                aria-hidden="true"
                            ></i
                        ></a>
                    </td>
                    <td class="text-center">
                        <a href="#"
                            ><i class="fa fa-trash" aria-hidden="true"></i
                        ></a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script type="application/javascript">
export default {
    data: function() {
        return {
            users: [],
            chargepoints: [],
            connectors: [],
            select_cp: "",
            select_connector: "",
            con_id: "",
            idTag: "",
            error_msg: "",
            elementVisible: false,
            ws: null
            // url: "ws://65.2.153.255:8082/"
        };
    },
    created() {
        this.getUserDetails();
        this.findChargePoints();
        // this.ws = new WebSocket(this.url);

        // this.ws.addEventListener("open", () => {
        //     console.log("We are connected!..");
        //     this.ws.addEventListener("message", e => {});
        // });
    },
    mounted() {},
    methods: {
        getUserDetails: function() {
            axios.get("/getUserDetails").then(
                function(response) {
                    this.users = response.data;
                    // console.log(response.data);
                }.bind(this)
            );
        },
        findChargePoints: function() {
            axios.get("/findChargePoints").then(
                function(response) {
                    this.chargepoints = response.data;
                    // console.log(response.data);
                }.bind(this)
            );
        },
        getConnectors: function() {
            axios
                .get("/findConnectors", {
                    params: {
                        cp_id: this.select_cp
                    }
                })
                .then(
                    function(response) {
                        this.connectors = response.data;
                        // console.log(response.data);
                    }.bind(this)
                );
        },

        remoteStart: function(id) {
            // if (this.select_connector == "" || this.select_cp == "") {
            if (this.select_cp == "") {
                // console.log("enter values");
                this.error_msg = "Enter Value";
                this.elementVisible = true;
                setTimeout(function() {
                    // Closing the alert
                    $("#error_msg").alert("close");
                }, 3000);
            } else {
                var id = id;
                axios
                    .get("http://localhost:8000/api/remoteStart/" + id, {
                        con_id: this.select_connector,
                        cp_id: this.select_cp
                    })
                    .then(
                        function(res) {
                            if (res.status == 200) {
                                console.log(
                                    "Ok!, server status code is",
                                    res.status
                                );
                                document.getElementById(
                                    "remoteStart_" + id
                                ).style.display = "none";
                                document.getElementById(
                                    "remoteStop_" + id
                                ).style.display = "inline-block";
                                $("#transactionModal_" + id).modal("hide");
                                $(".modal-backdrop").remove();
                            } else {
                                console.log("server status error", res.status);
                            }
                        }.bind(this)
                    )
                    .catch(error => {
                        console.log(error.response);
                    });
            }
        },

        remoteStop: function(id) {
            var id = id;
            console.log(id);
            axios
                .get("http://localhost:8000/api/remoteStop/" + id, {
                    con_id: this.select_connector,
                    cp_id: this.select_cp
                })
                .then(
                    function(res) {
                        if (res.status == 200) {
                            console.log(
                                "Ok!, server status code is",
                                res.status
                            );
                            document.getElementById(
                                "remoteStart_" + id
                            ).style.display = "inline-block";
                            document.getElementById(
                                "remoteStop_" + id
                            ).style.display = "none";
                        } else {
                            console.log("server status error", res.status);
                        }
                    }.bind(this)
                )
                .catch(error => {
                    console.log(error.response);
                });
        }
    }
};
</script>
