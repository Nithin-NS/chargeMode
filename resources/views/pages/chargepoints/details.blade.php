@extends('layouts.app')
@section('title', 'Chargepoint')

@section('header')
    <h1 class="page-title"> ChargePoint Details</h1>

@endsection
@section('content')  
<div class="card">
    <!-- <div class="card-header">
        <h4>ChargePoint Info</h4>
    </div> -->
    <div class="card-body">
        <div class="hed" style="padding: 2px;">
            <h3>ChargePoint Info</h3>
        </div>
        <table class="table table-hover dataTable table-striped w-full">
            <tr>
                <th>Name </th>
                <td>: {{$data->CP_Name}}</td>
                <th style="border-left:1px solid #e4eaec;;">District & State</th>
                <td>: {{$data->CP_District}}, {{$data->CP_District}}</td>
            </tr>
            <tr>
                <th>Contact Number </th>
                <td>: {{$data->Station_Phone}}</td>
                <th style="border-left:1px solid #e4eaec;;">Email</th>
                <td>: {{$data->Station_Email}}</td>
            </tr>
            <tr><th colspan="4" style="padding-left: 360px;">Technical Info</th></tr>
            <tr>
                <th>ChargeBox Serial Number </th>
                <td>: {{$data->CB_Serial_No}}</td>
                <th style="border-left:1px solid #e4eaec;;">ChargePoint Serial Number</th>
                <td>: {{$data->CP_Serial_No}}</td>
            </tr>
            <tr>
                <th>Firmware Version </th>
                <td>: {{$data->CP_Firmware_Ver}}</td>
                <th style="border-left:1px solid #e4eaec;;">Meter Serial Number</th>
                <td>: {{$data->CP_Meter_Serial_No}}</td>
            </tr>
            <tr>
                <th>Meter Type </th>
                <td>: {{$data->CP_Meter_Type}}</td>
                <th style="border-left:1px solid #e4eaec;;">Meter Serial Number</th>
                <td>: {{$data->CP_Meter_Serial_No}}</td>
            </tr>
        </table>
        
    </div>
</div>
<div class="row">
    <div class="col-6">
        @if($connector)
        <div class="card">
            <div class="card-body">
                <h4>Connectors</h4>
                <table class="table table-hover dataTable table-striped w-full">
                    <tr>
                        <th>Sl No</th>
                        <th>Connector</th>
                        <th>Status</th>
                    </tr>
                    <?php $i=1; ?>
                    
                    <tr>
                        <td>{{ $i++}}</td>
                        <td>{{ $connector['Type'] }}</td>
                        @if($connector['status'] == '1')
                        <td> <span class="badge badge-success">Active</span></td>
                        @else 
                        <td><span class="badge badge-danger">Inactive</span></td>
                        @endif
                    </tr>
                    
                    {{-- @foreach ($con->chargepoints as $chargepoint)
                            <p>{{ $chargepoint->CP_Name }}</p>
                        @endforeach --}}
                </table>
            </div>
        </div>
        @endif
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h4>Location</h4>
                <div id="googleMap" style="width:100%;height:400px;overflow:hidden;"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function myMap() {
var mapProp= {
  center:new google.maps.LatLng(51.508742,-0.120850),
  zoom:5,
};
var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY&callback=myMap"></script>

@endpush