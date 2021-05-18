@extends('layouts.app')
@section('title', 'Chargepoint')

@section('header')
    <h1 class="page-title">New Chargepoints</h1>

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
        <form method="POST" action="{{ route('savechargepoint') }}">
            <!-- <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>"> -->
            @csrf
            <div class="row form-group">
                <div class="col-2">
                    <label class="col-form-label">Name</label>
                </div>
                <div class="col-8">
                    <input type="text" name="CP_Name" class="form-control" style="width:100%" required>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-2">
                    <label class="col-form-label">State</label>
                </div>
                <div class="col-8">
                    <input type="text" name="CP_State" class="form-control" style="width:100%" required>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-2">
                    <label class="col-form-label">District</label>
                </div>
                <div class="col-8">
                    <input type="text" name="CP_District" class="form-control" style="width:100%" required>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-2">
                    <label class="col-form-label">Location</label>
                </div>
                <div class="col-8">
                    <input type="number" step="0.01" name="CP_Loc" class="form-control" style="width:100%" required>
                </div>
            </div>
            <!-- <div class="row form-group">
                <div class="col-2">
                    <label class="col-form-label">Connector Type</label>
                </div>
                <div class="col-8">
                    <select name="CP_Connector_Type" class="form-control" style="width:100%" required>
                        @if(count($connector)>0)
                            <option> select</option>
                            @foreach($connector as $con)
                            <option value="{{ $con['id']}}">{{ $con['Type']}}</option>
                            @endforeach
                        @else
                            <option>Connector not found</option>
                        @endif
                    </select> 
                </div>
            </div> -->
            <div class="row form-group">
                <div class="col-2">
                    <label class="col-form-label">ChargeBox Serial Number</label>
                </div>
                <div class="col-8">
                    <input type="text" name="CB_Serial_No" class="form-control" style="width:100%" required>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-2">
                    <label class="col-form-label">ChargePoint Serial Number</label>
                </div>
                <div class="col-8">
                    <input type="text" name="CP_Serial_No" class="form-control" style="width:100%" required>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-2">
                    <label class="col-form-label">Firmware Version</label>
                </div>
                <div class="col-8">
                    <input type="text" name="CP_Firmware_Ver" class="form-control" style="width:100%" required>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-2">
                    <label class="col-form-label">Meter Serial Number</label>
                </div>
                <div class="col-8">
                    <input type="text" name="CP_Meter_Serial_No" class="form-control" style="width:100%" required>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-2">
                    <label class="col-form-label">Meter Type</label>
                </div>
                <div class="col-8">
                    <input type="text" name="CP_Meter_Type" class="form-control" style="width:100%" required>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-2">
                    <label class="col-form-label">Phone Number</label>
                </div>
                <div class="col-8">
                <input type="tel" name="Station_Phone"  pattern="[6-9]{1}[0-9]{9}"  class="form-control" style="width:100%" required>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-2">
                    <label class="col-form-label">Email</label>
                </div>
                <div class="col-8">
                    <input type="email" name="Station_Email" class="form-control"  pattern=".+@gmail.com" style="width:100%" required>
                </div>
            </div>
            <div class="row form-group">
                <label class="col-2 col-form-label" for="status">Charging Pins </label>
                <div class="col-8 ">
                    <div  class="form-group row">
                        <div class="col">
                            <select   name="charging_pin_id[]"
                    class="charging-pin-dropdown form-control{{ $errors->has('charging_pin_id') ? ' is-invalid' : '' }}">

                                <option value="">-</option>
                                @foreach($connector as $con)
                                    <option value="{{ $con->id }}">{{ $con->Type  }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('charging_pin_id'))
                                <span class="invalid-feedback" role="alert">{{ $errors->first('charging_pin_id') }}</span>
                            @endif
                        </div>
                        <div class="col" style="flex-grow: 0;flex-shrink: 1; align-self: center">
                            <div class="checkbox-custom checkbox-inline checkbox-primary checkbox-lg float-left">
                                <input id="pin_status" name="pin_status[]" type="checkbox" value="1" @if(old('pin_status', true)) checked @endif
                                            class="{{ $errors->has('status') ? ' is-invalid' : '' }}" >
                                <label for="pin_status"></label>
                                <input type="hidden" name="pin_status_value[]" value="1">
                            </div>
                            @if ($errors->has('pin_status'))
                                <span class="invalid-feedback" role="alert">{{ $errors->first('pin_status') }}</span>
                            @endif
                        </div>
                        <div class="col-md-1" style="flex-grow: 0;flex-shrink: 1; align-self: center">
                            {{--<a href="#">X</a>--}}
                        </div>
                    </div>
                    <!-- <div class="col-8"> -->
                    <div class="charging-pins-container">
                    </div>
                    <a id="add-charging-pin" class="pt-10" href="#">Add Charging Pin</a>
                    <!-- </div> -->
                </div>
            </div>
            <div class="row form-group">
                <div class="col-2"></div>
                <div class="col-8">
                    <input type="submit" name="submit" class="btn btn-primary" value="submit">
                </div>
            </div>
        </form>
    </div>
</div>

{{--Template for charging pins--}}
    <div  class="form-group row charging-pin-template hidden-xs-up charging-pins-array">
        <div class="col">
            <select   name="charging_pin_id[]"
                    class="charging-pin-dropdown form-control{{ $errors->has('charging_pin_id') ? ' is-invalid' : '' }}">
                    <option value="">-</option>
                @foreach($connector as $con)
                    <option value="{{ $con->id }}">{{ $con->Type  }}</option>
                @endforeach
            </select>
            @if ($errors->has('charging_pin_id'))
                <span class="invalid-feedback" role="alert">{{ $errors->first('charging_pin_id') }}</span>
            @endif
        </div>
        <div class="col" style="flex-grow: 0;flex-shrink: 1; align-self: center">
            <div class="checkbox-custom checkbox-inline checkbox-primary checkbox-lg float-left">
                <input id="pin_status" name="pin_status[]" type="checkbox" value="1" @if(old('pin_status', true)) checked @endif
                class="{{ $errors->has('pin_status') ? ' is-invalid' : '' }} pin-status" >
                <label for="pin_status"></label>
                <input type="hidden" name="pin_status_value[]" value="1">
            </div>
            @if ($errors->has('pin_status'))
                <span class="invalid-feedback" role="alert">{{ $errors->first('pin_status') }}</span>
            @endif
        </div>
        <div class="col-md-1" style="flex-grow: 0;flex-shrink: 1; align-self: center">
            <a class="btn btn-pure btn-default icon wb-trash btn-close" href="#"></a>
        </div>
    </div>

    {{--Template for charging pins Ends--}}


@endsection

@push('scripts')
<script>
    $(function() {
        'use strict';

        $('#form-station-create').validate({
            rules: {
                name: {
                    required: true
                },
                phone: {
                    require_from_group: [1, ".phone-group"]
                },
                mobile: {
                    require_from_group: [1, ".phone-group"]
                },
                email: {
                    required: true,
                    email: true
                },
                street1: {
                    required: true
                },
                street2: {
                    required: true
                },
                city: {
                    required: true
                },
                state: {
                    required: true
                },
                country: {
                    required: true
                },
                zip: {
                    required: true
                },
                latitude: {
                    required: true
                },
                longitude: {
                    required: true
                },
                device_id: {
                    required: true
                },
                device_uuid: {
                    required: true
                },
                image:{
                    extension: "jpeg,png,jpg"
                },
                "relay_switch_number[]": "required",
                "charging_pin_id[]":"required"
            }
        });

        $('#btn-reset').click(function() {
            $('#role').val("").trigger('change');
            $('#form-station-create').resetForm();
        });

        $('#add-charging-pin').click(function(event) {
            event.preventDefault();
            var template=$('.charging-pin-template').clone();
            template.removeClass('charging-pin-template');
            template.removeClass('hidden-xs-up');

            template.appendTo('.charging-pins-container');
            template.find('.charging-pin-dropdown').select2();
        });

        $('.charging-pins-container').on('click', '.btn-close', function(event) {
            event.preventDefault();
            $(this).closest('.form-group').remove();
        });

        $("input[name='pin_status[]']").on('change', function() {
            if($(this).is(':checked')) {
                $(this).nextAll('input').first().val(1);
            } else {
                $(this).nextAll('input').first().val(0);
            }
        });

        $('.charging-pins-container').on('click', '.pin-status', function() {
            if($(this).is(':checked')) {
                $(this).nextAll('input').first().val(1);
            } else {
                $(this).nextAll('input').first().val(0);
            }
        });

        let chargingPinsArray;

        $('#blackbox').on('change', function() {
            if ($(this).prop('checked')) {
                chargingPinsArray = $('.charging-pins-array').detach();
            } else {
                $('.charging-pins-container').append(chargingPinsArray);
            }
        });

    });
</script>
@endpush