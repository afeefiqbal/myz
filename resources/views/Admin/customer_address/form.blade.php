@extends('Admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-user-shield"></i> {{$title}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a
                                    href="{{url(Helper::sitePrefix().'customer/address/'.$customer_id)}}">Customer
                                    Address</a></li>
                            <li class="breadcrumb-item active">{{$title}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <form role="form" id="formWizard" class="form--wizard" enctype="multipart/form-data" method="post">
                    {{csrf_field()}}
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Customer Address Form</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    {{ session('success') }}
                                </div>
                            @elseif(session('error'))
                                <div class="alert alert-danger" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="form-row">
                                <div class="col-md-6">
                                    <label> First Name*</label>
                                    <input type="text" class="form-control required" id="first_name" name="first_name"
                                           placeholder="First Name"
                                           value="{{ old('first_name', @$address->first_name) }}">
                                    <div class="help-block with-errors" id="first_name_error"></div>
                                    @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label> Last Name*</label>
                                    <input type="text" class="form-control required" id="last_name" name="last_name"
                                           placeholder="Last Name" value="{{ old('last_name', @$address->last_name) }}">
                                    <div class="help-block with-errors" id="last_name_error"></div>
                                    @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label> Address*</label>
                                    <textarea class="form-control required" name="address"
                                              id="address">{{ old('address', @$address->address) }}</textarea>
                                    <div class="help-block with-errors" id="address_error"></div>
                                    @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Phone Number*</label>
                                    <input type="number" class="form-control required" id="phone"
                                           name="phone" placeholder="Phone Number"
                                           value="{{ old('phone', @$address->phone) }}">
                                    <div class="help-block with-errors" id="phone_error"></div>
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label> Email*</label>
                                        <input type="email" name="email" id="email" placeholder="Email"
                                               class="form-control required" autocomplete="off"
                                               value="{{ old('email', @$address->email) }}">
                                    <div class="help-block with-errors" id="email_error"></div>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Country*</label>
                                    <select name="country" id="country" class="form-control">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ (old('country',@$address->state->country->id)==$country->id)?'selected':'' }}
                                            >{{$country->title}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="country_error"></div>
                                    @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> State*</label>
                                    @if(isset($address))
                                        <select name="state" id="state" class="form-control required">
                                            <option value="">Select State</option>
                                            @foreach($states as $state)
                                                <option value="{{ $state->id }}"
                                                    {{ (old('state',@$address->state_id)==$state->id)?'selected':'' }}
                                                >{{$state->title}}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors" id="state_error"></div>
                                    @else
                                        <select name="state" id="state" class="form-control required">
                                            <option value="">Select State</option>
                                        </select>
                                        <div class="help-block with-errors" id="state_error"></div>
                                    @endif
                                    @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Zipcode*</label>
                                    <input type="number" class="form-control required" id="zipcode"
                                           name="zipcode" placeholder="Zipcode"
                                           value="{{ old('zipcode', @$address->zipcode) }}">
                                    <div class="help-block with-errors" id="zipcode_error"></div>
                                    @error('zipcode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="submit" name="btn_save" value="Submit"
                                   class="btn btn-primary pull-left submitBtn">
                            <input type="hidden" name="id" id="id" value="{{ isset($address)?$address->id:'0' }}">
                            <input type="hidden" name="customer_id" id="customer_id" value="{{ $customer_id }}">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
