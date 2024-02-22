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
                            <li class="breadcrumb-item">
                                <a href="{{url(Helper::sitePrefix().'country/shipping-charge')}}">Shipping Charge</a>
                            </li>
                            <li class="breadcrumb-item active">New Shipping Charge</li>
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
                            <h3 class="card-title">Shipping Charge Form</h3>
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
                                <div class="form-group col-md-6">
                                    <label> Country*</label>
                                    <select name="country" id="country" class="form-control required">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ (old('country',@$shipping->state->country->id)==$country->id)?'selected':'' }}
                                            >{{$country->title}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="country_error"></div>

                                    @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> State*</label>
                                    @if(isset($shipping))
                                        <select name="state" id="state" class="form-control required">
                                            <option value=" ">Select State</option>
                                            @foreach($states as $state)
                                                <option value="{{ $state->id }}"
                                                    {{ (old('state',@$shipping->state_id)==$state->id)?'selected':'' }}
                                                >{{$state->title}}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <select name="state" id="state" class="form-control required">
                                            <option value=" ">Select State</option>
                                        </select>
                                    @endif
                                    <div class="help-block with-errors" id="state_error"></div>

                                    @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Shipping Type</label>
                                    <select name="type" id="type" class="form-control required">
                                        <option value="free" {{ (@$shipping->type=='free')?'selected':'' }}>Free
                                            Shipping
                                        </option>
                                        <option value="flat" {{ (@$shipping->type=='flat')?'selected':'' }}>Flat Rate
                                        </option>
                                    </select>
                                    @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6 free"
                                     style="display: {{ (@$shipping->type=='flat')?'none':'block' }}">
                                    <label> Free Shipping Type</label>
                                    <select name="free_shipping_type" id="free_shipping_type" class="form-control ">
                                        <option value="na" {{ (@$shipping->free_shipping_type=='na')?'selected':'' }}>
                                            NA
                                        </option>
                                        <option value="min" {{ (@$shipping->free_shipping_type=='min')?'selected':'' }}>
                                            Min Amount
                                        </option>
                                    </select>
                                    @error('free_shipping_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6 min"
                                     style="display: {{ (@$shipping->free_shipping_type=='min' && $shipping->type=='free')?'block':'none' }}">
                                    <label> Minimum Amount</label>
                                    <input type="number" class="form-control" name="min_amount" id="min_amount"
                                           placeholder="Minimum Amount" step=".01"
                                           value="{{isset($shipping)?$shipping->min_amount:''}}">
                                    @error('min_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6 min"
                                     style="display: {{ (@$shipping->free_shipping_type=='min' && $shipping->type=='free')?'block':'none' }}">
                                    <label> Fixed Price Min</label>
                                    <input type="number" class="form-control" name="fixed_price_min"
                                           id="fixed_price_min"
                                           placeholder="Fixed Price" step=".01"
                                           value="{{isset($shipping)?$shipping->fixed_price:''}}">
                                    @error('fixed_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6 flat"
                                     style="display: {{ (@$shipping->type=='flat')?'block':'none' }}">
                                    <label> Fixed Price</label>
                                    <input type="number" class="form-control" name="fixed_price" id="fixed_price"
                                           placeholder="Fixed Price" step=".01"
                                           value="{{ isset($shipping)?$shipping->fixed_price:'' }}">
                                    @error('fixed_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="submit" name="btn_save" value="Submit"
                                   class="btn btn-primary pull-left submitBtn">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
