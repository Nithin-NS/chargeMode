@extends('layouts.app')
@section('title', 'Transaction')

@section('header')
    <h1 class="page-title">Transactions</h1>
@endsection
@section('content')
@csrf
<div class="card">
<table class="table table-bordered">
 <thead class="thead-dark">
    <tr>
        <th>ID</th>
        <th>Connector ID</th>
        <th>ChargingPoint ID</th>
        <th>ChargingStation ID</th>
        <th>User ID</th>
        <th>Reservation ID</th>
        <th>Transaction Date and Time</th>
        <th>Initial Meter Value</th>
        <th>Final Meter Value</th>
        <th colspan="2">Actions</th>
    </tr>
 </thead>
    @foreach($data as $key => $value)
    <tr>
        <td>{{$value->id}}</td>
        <td>{{ $value->Connector_ID }}</td>
        <td>{{ $value->CP_ID }}</td>
        <td>{{ $value->CS_ID }}</td>
        <td>{{ $value->User_ID }}</td>
        <td>{{ $value->Reservation_ID}}</td>
        <td>{{ $value->Trans_DateTime}}</td>
        <td>{{ $value->Trans_Meter_Start}}</td>
        <td>{{ $value->Trans_Meter_Stop}}</td>
        <td class="text-center"><a href="/transactions/edit/{{ $value->id }}" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
        <td class="text-center"><a href="#" data-toggle="modal" data-target="#deleteModal_{{ $value->id }}"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
        
        <!-- Modal -->
        <div class="modal fade" id="deleteModal_{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="deleteModalLabel">Delete Transaction {{ $value->id }}</h4>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
                </div>
                <div class="modal-body">
                    <span class="">Are you sure you want to delete this Transaction</span>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <a href="/transactions/delete/{{ $value->id }}" class="btn btn-danger">Delete</a>
                </div>
            </div>
            </div>
        </div>

    </tr>
    @endforeach
</table>
</div>

<div class='row'>
    <div class="col-10">
        {{-- {{ $data->links() }} --}}
        {{$data->links("pagination::bootstrap-4")}}
    </div>
    <div class="col-2 text-right">
        <a class="btn btn-outline-primary" href="/addtransaction">
            <i class="icon fa-plus" aria-hidden="true"></i>
            <span class="text hidden-sm-down">Add New Transaction</span>
        </a>
    </div>
</div>
{{-- <script src="{{ asset('/js/msc-script.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function(){
        var deleteconf = document.querySelector("#delete");
        deleteconf.addEventListener("click", function() {
          mscConfirm("Delete", "Are you sure you want to delete this post?", function(){
            mscAlert("Post deleted");
          });
        });
    });
    // mscConfirm("Delete", "Are you sure you want to delete this post?", function(){
    //     alert("Post deleted");
    // });
</script> --}}
@endsection