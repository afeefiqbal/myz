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
                        <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'product')}}">Product</a></li>
                        <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'product/offer/'.$product->id)}}">{{$product->title}}</a></li>
                        <li class="breadcrumb-item active">{{$title}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success" user_type="alert">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger" user_type="alert">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session('error') }}
                </div>
            @endif
            <form role="form" id="formWizard" class="form--wizard" enctype="multipart/form-data" method="post">
                {{csrf_field()}}
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Offer Form</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                         </div>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label> Title*</label>
                                <input type="text" name="title" id="title" placeholder="Title" class="form-control required" autocomplete="off" value="{{ isset($offer)?$offer->title:old('title')}}">
                                <div class="help-block with-errors" id="title_error"></div>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Price*</label>
                               
                                <input type="number" name="price" id="price" placeholder="Price" class="form-control required" autocomplete="off"  step=".01" min="0" value="{{ isset($offer)?$offer->price:old('price') }}" >
                                <div class="help-block with-errors" id="price_error"></div>
                                @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                            <div class="form-group col-md-4">
                                <label> Sale Condition</label>
                                <textarea name="sale_condition" id="sale_condition" placeholder="Sale Condition" class="form-control" autocomplete="off">{{ isset($offer)?$offer->sale_condition:old('sale_condition')}}</textarea>
                                @error('sale_condition')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label> Offer Type*</label>
                                <select class="form-control" name="offer_type" id="offer_type">
                                    <option value="Decrease" {{(@$offer->offer_inc_desc=='Decrease')?'selected':''}} @if (old('offer_type') == "Decrease") {{ 'selected' }} @endif>Decrease</option>
                                    <option value="Increase" {{(@$offer->offer_inc_desc=='Increase')?'selected':''}}  @if (old('offer_type') == "Increase") {{ 'selected' }} @endif>Increase</option>
                                </select>
                                <div class="help-block with-errors" id="offer_type_error"></div>
                                @error('offer_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label> Start Date*</label>
                                <input type="date" name="start_date" id="start_date" placeholder="Start Date" class="form-control required" min="{{date('Y-m-d')}}" autocomplete="off" value="{{ isset($offer)?$offer->start_date:old('start_date') }}">
                                <div class="help-block with-errors" id="start_date_error"></div>
                                @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label> End Date*</label>
                                <input type="date" name="end_date" id="end_date" placeholder="Start Date" class="form-control required"min="{{date('Y-m-d')}}"  autocomplete="off" value="{{ isset($offer)?$offer->end_date:old('end_date') }}">
                                <div class="help-block with-errors" id="end_date_error"></div>
                                @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="submit" name="btn_save" value="Submit" class="btn btn-primary pull-left submitBtn">
                        <input type="hidden" name="id" id="id" value="{{ isset($offer)?$offer->id:'0' }}">
                        <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="product_price" id="product_id" value="{{ $product->price }}">

                        <button type="reset" class="btn btn-default">Cancel</button>
                        <img class="animation__shake loadingImg" src="{{url('backend/dist/img/loading.gif')}}" style="display:none;">
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
