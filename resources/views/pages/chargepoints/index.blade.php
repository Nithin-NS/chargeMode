@extends('layouts.app')
@section('title', 'Chargepoint')

@section('header')
    <h1 class="page-title">Chargepoints</h1>
    {{-- <div class="page-header-actions">
        
    </div> --}}
@endsection
@section('content')
@csrf
<form method="get" action="{{ url('/searchchargepoint') }}" role="search">
    <div class="row mb-20">
        <div class="col-8">
            <div class="input-group">
                <input type="search" name="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                  aria-describedby="search-addon" />
                <button type="submit" class="btn btn-outline-primary">search</button>
            </div>
        </div>
        <div class="col-4 text-right">
            <a class="btn btn-outline-primary" href="{{ route('addchargepoint') }}">
                <i class="icon fa-plus" aria-hidden="true"></i>
                <span class="text hidden-sm-down">Add Chargepoint</span>
            </a>
        </div>
    </div>
</form> 

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Sl No</th>
                        <th>CP Name</th>
                        <th>CP State</th>
                        <th>CP District</th>
                        <th>CP Location</th>
                        <th>Station Phone</th>
                        <th>Station Email</th>
                        <th colspan="3">Actions</th>
                    </tr>
                </thead>
                @foreach($data as $key => $value)
                <tr>
                    {{-- <td>{{$key+1}}</td> --}}
                    <td>{{$value->CP_ID}}</td>
                    <td>{{ $value->CP_Name}}</td>
                    <td>{{ $value->CP_State}}</td>
                    <td>{{$value->CP_District}}</td>
                    <td>{{$value->CP_Loc}}</td>
                    <td>{{$value->Station_Phone}}</td>
                    <td>{{$value->Station_Email}}</td>
                    <td class="text-center"><a href="/chargepoint/details/{{ $value->CP_ID }}" data-toggle="tooltip" title="View" data-toggle="tooltip" title="View"><i class="fa fa-eye" aria-hidden="true" ></i></td>
                    <td class="text-center"><a href="/chargepoint/edit/{{ $value->CP_ID }}" data-toggle="tooltip" title="Edit" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                    <td class="text-center"><a href="#" data-toggle="modal" data-target="#deleteModal_{{ $value->CP_ID }}"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="deleteModal_{{ $value->CP_ID }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title" id="deleteModalLabel">Delete ChargePoint {{ $value->CP_Name }}</h4>
                            {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button> --}}
                            </div>
                            <div class="modal-body">
                                <span class="">Are you sure you want to delete this ChargePoint</span>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                <a href="/chargepoint/delete/{{ $value->CP_ID }}" class="btn btn-danger">Delete</a>
                            </div>
                        </div>
                        </div>
                    </div>

                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
