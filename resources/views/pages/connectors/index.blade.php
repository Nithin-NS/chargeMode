@extends('layouts.app')
@section('title', 'Connector')

@section('header')
    <h1 class="page-title">Connectors</h1>
    {{-- <div class="page-header-actions">
        
    </div> --}}
@endsection
@section('content')
@csrf
<form method="get" action="{{ url('/searchconnector') }}" role="search">
    <div class="row mb-20">
        <div class="col-8">
            <div class="input-group">
                <input type="search" name="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                  aria-describedby="search-addon" />
                <button type="submit" class="btn btn-outline-primary">search</button>
            </div>
        </div>
        <div class="col-4 text-right">
            <a class="btn btn-outline-primary" href="{{ route('createconnector') }}">
                <i class="icon fa-plus" aria-hidden="true"></i>
                <span class="text hidden-sm-down">Add Connector</span>
            </a>
        </div>
    </div>
</form>

<div class="card">
    <table class="table table-bordered">
     <thead class="thead-dark">
        <tr>
            <th>Sl No</th>
            <th>Types</th>
            <th>Remarks</th>
            <th colspan="2">Actions</th>
        </tr>
     </thead>
        @foreach($data as $key => $value)
        <tr>
            {{-- <td>{{$key+1}}</td> --}}
            <td>{{$value->id}}</td>
            <td>{{ $value->Type }}</td>
            <td>{{ $value->Remarks }}</td>
            <td class="text-center"><a href="connector/edit/{{ $value->id }}" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
            <td class="text-center"><a href="#" data-toggle="modal" data-target="#deleteModal_{{ $value->id }}"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
        
            <!-- Modal -->
            <div class="modal fade" id="deleteModal_{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title" id="deleteModalLabel">Delete Connector {{ $value->id }}</h4>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                    </div>
                    <div class="modal-body">
                        <span class="">Are you sure you want to delete this Connector!</span>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <a href="/connector/delete/{{ $value->id }}" class="btn btn-danger">Delete</a>
                    </div>
                </div>
                </div>
            </div>
        
        </tr>
        @endforeach
    </table>
</div>
@endsection