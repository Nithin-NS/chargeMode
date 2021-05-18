
@extends('layouts.app')
@section('title', 'Connector')

@section('header')
    <h1 class="page-title">New Connectors</h1>

@endsection
@section('content')
@csrf
@if(session()->has('message'))
<div class="col-lg-10">
    <div role="alert" class="alert alert-success alert-dismissible">
        <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
        <strong>Success! </strong>{{ Session::get('message') }}
    </div>
</div>
<div class="clearfix"></div>
@endif
<!-- Main content -->
          
@if($errors->any())
    <div class="col-xs-12">  
        <div role="alert" class="alert alert-danger alert-dismissible" style="margin-top: 25px;">
            <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
            <strong>Whoops!</strong> There were some problems with your input.
            <br/>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
<div class="panel">
  <div class="panel-body">
    <form method="POST" action="{{route('saveconnector')}}" role="form" enctype="multipart/form-data" >
      <!-- <input type = "hidden" name = "_token" value = "{{ csrf_token()}}"> -->
      @csrf
      <div class="row form-group">
        <div class="col-2">
          <label class="col-form-label">Connector Type</label>
        </div>
        <div class="col-8">
          <input type="text" name="Type"class="form-control" style="width:100%" required>
        </div>
      </div>
      <div class="row form-group">
          <div class="col-2">
             <label class="col-form-label">Remarks</label>
          </div>
          <div class="col-8"> 
            <textarea name="Remarks" style="width:100%" class="form-control" required></textarea>
          </div>
      </div>
      <div class="row form-group">
          <div class="col-2">
            
          </div>
          <div class="col-8">
            <input type="submit" name="submit" class="btn btn-primary" value="submit">
          </div>
      </div>
    </form>
  </div>
</div>
@endsection

