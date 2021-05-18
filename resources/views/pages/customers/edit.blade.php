@extends('layouts.app')
@section('title', 'users')

@section('header')
    <h1 class="page-title">Edit User Details</h1>

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
<form method="POST" action="/customer/update/{{ $data->id}}">
<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
{{-- <div class="row">
        <div class="col-2">
            Type 
        </div>
        <div class="col-8">
           <input type=radio name="User_Type" required="required" value="1" {{ $data->User_Type == '1' ? 'checked' : ''}}>1(EV User)
           <input type=radio name="User_Type"  required="required" value="2" {{ $data->User_Type == '2' ? 'checked' : ''}}>2(Fleet User)
        </div>
    </div><br> --}}
    <div class="row">
        <div class="col-2">
            Name 
        </div>
        <div class="col-8">
            <input type="string" name="User_Name" style="width:100%" value="{{ $data->name}}"  required>
        </div>
    </div><br>
    <div class="row">
        <div class="col-2">
          Mobile Number 
        </div>
        <div class="col-8">
            <input type="tel" name="User_Mobile" pattern="[6-9]{1}[0-9]{9}"  style="width:100%" value="{{ $data->mobile}}"  required>
        </div>
    </div><br>
    <div class="row">
        <div class="col-2">
            Email
        </div>
        <div class="col-8">
            <input type="text" name="User_Email" style="width:100%" value="{{ $data->email}}"  required>
        </div>
    </div><br>
    {{-- <div class="row">
        <div class="col-2">
            Password
        </div>
        <div class="col-8">
            <input type="password" name="User_Password" style="width:100%" value="{{$data->password}}"  required>
        </div>
    </div><br> --}}
    <div class="row">
        <div class="col-2">
           Address For Contact
        </div>
        <div class="col-8">
           <textarea name="User_Address"style="width:100%"  required>{{ $data->address}}</textarea>
        </div>
    </div><br>
    <div class="row">
        <div class="col-2">
            Pincode
        </div>
        <div class="col-8">
            <input type="text" name="User_Pin" style="width:100%" value="{{ $data->pin}}"  required>
        </div>
    </div><br>
    <div class="row">
        <div class="col-2">
            State
        </div>
        <div class="col-8">
            <input type="text" name="User_State" style="width:100%" value="{{ $data->state}}"  required>
        </div>
    </div><br>
    <div class="row">
        <div class="col-2">
        District
        </div>
        <div class="col-8">
            <input type="text" name="User_District" style="width:100%" value="{{ $data->district}}"  required>
        </div>
    </div><br>
    <div class="row">
  <div class="col-2"></div>
  <div class="col-8">
    <input type="submit" name="submit" class="btn btn-primary" value="Update">
  </div>
  </div>
</form>
@endsection

