<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        console.log("Component mounted.");
    }
};
</script>

<form method="get" action="{{ url('/searchuser') }}" role="search">
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
                <a
                    class="btn btn-outline-primary"
                    href="{{ route('addcustomer') }}"
                >
                    <i class="icon fa-plus" aria-hidden="true"></i>
                    <span class="text hidden-sm-down">Add New User</span>
                </a>
            </div>
        </div>
    </form>

<div class="card">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Sl No</th>
                    <th>User ID</th>
                    <th>Name of User</th>
                    <th>Mobile No</th>
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
            @foreach($data as $key => $value)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $value->user_id }}</td>
                <td>{{ $value->name}}</td>
                <td>{{ $value->mobile}}</td>
                <td>{{ $value->email}}</td>
                <td>{{ $value->address}}</td>
                <td>{{ $value->pin}}</td>
                <td>{{ $value->state}}</td>
                <td>{{ $value->district}}</td>
                @if ($value->status == 1)
                <td><span class="badge badge-success">Active</span></td>
                @else
                <td><span class="badge badge-secondary">Deactive</span></td>
                @endif
                <td class="text-center">
                    <button
                        type="button"
                        class="btn btn-success btn-sm"
                        data-toggle="modal"
                        data-target="#remoteStartModal_{{ $value->id }}"
                        data-backdrop="static"
                        data-keyboard="false"
                    >
                        Start Transaction
                    </button>

                    <!-- Modal -->
                    <div
                        class="modal fade"
                        id="remoteStartModal_{{ $value->id }}"
                        tabindex="-1"
                        role="dialog"
                        aria-labelledby="deleteModalLabel"
                        aria-hidden="true"
                    >
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4
                                        class="modal-title"
                                        id="deleteModalLabel"
                                    >
                                        Select Charge Point
                                    </h4>
                                    {{--
                                    <button
                                        type="button"
                                        class="close"
                                        data-dismiss="modal"
                                        aria-label="Close"
                                    >
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    --}}
                                </div>
                                <div class="modal-body">
                                    {{-- select chargepoints --}}
                                    <div class="form-group col-6">
                                        <label
                                            class="text-right col-form-label"
                                            for="cp_select"
                                            >Charge point</label
                                        >
                                        <select
                                            class="form-control"
                                            id="cp_select"
                                            Onchange="getConnectors()"
                                        >
                                            <option value="0" disabled selected
                                                >Select Charging
                                                Point...</option
                                            >
                                            @foreach($chargepoints as
                                            $chargepoint)
                                            <option
                                                value="{{ $chargepoint['CP_ID'] }}"
                                                >{{
                                                    $chargepoint["CP_Name"]
                                                }}</option
                                            >
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- select connectors --}}
                                    <div class="form-group col-6">
                                        <label
                                            class="col-form-label text-md-right"
                                            for="connector_select"
                                            >Connector</label
                                        >
                                        <select
                                            class="custom-select"
                                            id="connector_select"
                                        >
                                            <option value="0" disabled selected
                                                >Select Connector...</option
                                            >
                                            {{-- @foreach($connectors as $connector) --}}
                                            {{--
                                            <option
                                                v-for="connector in connectors"
                                                >{{ connector.Type }}</option
                                            >
                                            --}}
                                            {{-- @endforeach --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary"
                                        data-dismiss="modal"
                                    >
                                        Close
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-success btn-sm"
                                        Onclick="remoteStart({{ $value->id }})"
                                    >
                                        Start Transaction
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="btn btn-danger btn-sm"
                        Onclick="remoteStop({{ $value->id }})"
                    >
                        Stop Transaction
                    </button>
                </td>
                <td class="text-center">
                    <a href="/customer/edit/{{ $value->id }}"
                        ><i class="fa fa-pencil-square-o" aria-hidden="true"></i
                    ></a>
                </td>
                <td class="text-center">
                    <a
                        href="#"
                        data-toggle="modal"
                        data-target="#deleteModal_{{ $value->id }}"
                        ><i class="fa fa-trash" aria-hidden="true"></i
                    ></a>
                </td>

                <!-- Modal -->
                <div
                    class="modal fade"
                    id="deleteModal_{{ $value->id }}"
                    tabindex="-1"
                    role="dialog"
                    aria-labelledby="deleteModalLabel"
                    aria-hidden="true"
                >
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="deleteModalLabel">
                                    Delete User {{ $value->name }}
                                </h4>
                                {{--
                                <button
                                    type="button"
                                    class="close"
                                    data-dismiss="modal"
                                    aria-label="Close"
                                >
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                --}}
                            </div>
                            <div class="modal-body">
                                <span class=""
                                    >Are you sure you want to delete this
                                    User</span
                                >
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary"
                                    data-dismiss="modal"
                                >
                                    Close
                                </button>
                                <a
                                    href="/customer/delete/{{ $value->id }}"
                                    class="btn btn-danger"
                                    >Delete</a
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </tr>
            @endforeach
        </table>
    </div>

function getConnectors() { // cp_id =
document.getElementById('cp_select').value; // console.log(cp_id); axios
.get("/findConnectors", { params: { cp_id:
document.getElementById("cp_select").value } }) .then( function(response) {
const connectors = response.data; console.log(connectors); return connectors;
}.bind(this) ); } function remoteStart(id) { // var id = id; // console.log(id);
axios .post("/remoteStart/" + id + "", {}) .then( function(response) { if
(response.data) { console.log(response.data); //
this.ws.send(JSON.stringify(response.data)); } else { console.log("No Data"); }
}.bind(this) ) .catch(error => { console.log(error.response); }); } function
remoteStop(id) { axios .post("/remoteStop/" + id + "", {}) .then(
function(response) { if (response.data) { console.log(response.data); //
this.ws.send(JSON.stringify(response.data)); } else { console.log("No Data"); }
}.bind(this) ) .catch(error => { console.log(error.response); }); }
