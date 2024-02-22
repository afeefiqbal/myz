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
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'/dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'product')}}">Product</a>
                            </li>
                            <li class="breadcrumb-item"><a
                                    href="{{url(Helper::sitePrefix().'product/offer/'.$product->id)}}">{{$product->title}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{$title}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
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
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form role="form" id="offerFormWizard" class="form--wizard" enctype="multipart/form-data" method="post">
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
                                <div class="form-group col-md-12">
                                    <label> Title*</label>
                                    <input type="text" name="title" id="title" placeholder="Title"
                                           class="form-control required" autocomplete="off"
                                           value="{{ isset($offer)?$offer->title:'' }}">
                                    <div class="help-block with-errors" id="title_error"></div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="form-row">
                                        <table class="table table-active">
                                            <thead>
                                                <th>Size *</th>
                                                <th> Price *</th>
                                         
                                            </thead>
                                           @php
                                               $productPrice = \App\Models\ProductPrice::where('product_id',$product->id)->get();
                                               $sizeID = $productPrice->pluck('size_id')->toArray();
                                                 $sizes = \App\Models\Size::whereIn('id',$sizeID)->orderBy('sort_order')->get();
                                           @endphp
                                            @if (!isset($offer))
                                                <tbody>
                                                    @foreach ($sizes as $size)
                                                    <tr>
                                                        <td>
                                                            {{$size->title}}
                                                        </td>
                                                        @php
                                                        $oPrice = \App\Models\ProductPrice::where('size_id',$size->id)->where('product_id',$product->id)->first();
                                                    @endphp
                                              
                                                        <td>
                                                            <input type="number" name="price[{{$size->id}}]" id="price"   class="form-control price-offer " max="{{$oPrice->price}}" data-actual_price = "{{$oPrice->price}}">
                                                            <input type="hidden" name="product_price" id="product_price" class="size-price" value="{{$oPrice->price}}">
                                                        </td>
                                                    
                                                    </tr>
                                                    @endforeach
                                                    <div class="help-block with-errors" id="price_error"></div>
                                                </tbody>
                                            @else
                                            <tbody>
                                                @php
                                               $productPrice =DB::table('product_offer_size')->where('offer_id',$offer->id)->get();
                                               $sizeID = $productPrice->pluck('size_id')->toArray();
                                                 $sizes = \App\Models\Size::whereIn('id',$sizeID)->orderBy('sort_order')->get();
                                                @endphp
                                                @foreach ($sizes as $size)
                                                <tr>
                                                    <td>
                                                        {{$size->title}}
                                                    </td>
                                                    <td>
                                                        @php
                                                           $oPrice = \App\Models\ProductPrice::where('size_id',$size->id)->where('product_id',$product->id)->first();
                                                            $offerPrice = DB::table('product_offer_size')->where('offer_id',$offer->id)->where('size_id',$size->id)->first();
                                                        @endphp
                                                       
                                                        <input type="number" name="price[{{$size->id}}]" id="price" class="form-control price-offer" data-actual_price = "{{$offerPrice->price}}" value="{{isset($offerPrice)?$offerPrice->price:''}}" max="{{$oPrice->price}}">
                                                        <input type="hidden" name="product_price" id="product_price" class="size-price" value="{{$oPrice->price}}">
                                                    </td>
                                                  
                                                </tr>
                                                @endforeach
                                                <div class="help-block with-errors" id="price_error"></div>
                                            </tbody>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Sale Condition</label>
                                    <textarea name="sale_condition" id="sale_condition" placeholder="Sale Condition"
                                              class="form-control"
                                              autocomplete="off">{{ isset($offer)?$offer->sale_condition:'' }}</textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Start Date*</label>
                                    <input type="date" max="2999-12-31" name="start_date" id="start_date" min="{{date('Y-m-d')}}"
                                           placeholder="Start Date"
                                           class="form-control required" autocomplete="off"
                                           value="{{ isset($offer)?$offer->start_date:'' }}">
                                    <div class="help-block with-errors" id="start_date_error"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label> End Date*</label>
                                    <input type="date" max="2999-12-31" name="end_date" id="end_date" min="{{date('Y-m-d')}}"
                                           placeholder="Start Date"
                                           class="form-control required" autocomplete="off"
                                           value="{{ isset($offer)?$offer->end_date:'' }}">
                                    <div class="help-block with-errors" id="end_date_error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="submit" name="btn_save" value="Submit"
                                   class="btn btn-primary pull-left submitBtn">
                            <input type="hidden" name="id" id="id" value="{{ isset($offer)?$offer->id:'0' }}">
                            <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                            <button type="reset" class="btn btn-default">Cancel</button>
                            <img class="animation__shake loadingImg" src="{{url('backend/dist/img/loading.gif')}}"
                                 style="display:none;">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
