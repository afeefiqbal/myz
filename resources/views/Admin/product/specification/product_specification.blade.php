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
                                    href="{{url(Helper::sitePrefix().'product/list')}}">Product</a></li>
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
                <form role="form" id="formWizard" class="form--wizard" enctype="multipart/form-data" method="post">
                    {{csrf_field()}}
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Specification Head Form</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="first_title_en">Title*</label>
                                    <input type="text" name="title" id="title"
                                           placeholder="Title"
                                           class="form-control required" autocomplete="off"
                                           value="{{ @$specificationHead->title }}"
                                           maxlength="230">
                                    <div class="help-block with-errors" id="title_error"></div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="description">Description*</label>
                                    <textarea class="form-control required tinyeditor" id="description"
                                              name="description"
                                              placeholder="Description">{{@$specificationHead->description}}</textarea>
                                    <div class="help-block with-errors" id="description_error"></div>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Product Specification Form</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div>
                        </div>
                        <div class="card-body">
                            @if(isset($productSpecification) && $productSpecification->isNotEmpty())
                                @php $i=1 @endphp
                                @foreach($productSpecification as $specification)
                                    <div class="form-row" id="append_result_{{$i}}">
                                        <div class="form-group col-md-4">
                                            <label for="inputPassword4">Title*</label>
                                            <input type="text" class="form-control required" name="extra_title[]"
                                                   id="extra_title_{{$i}}" placeholder="Title"
                                                   value="{{ $specification->title }}" maxlength="230">
                                            <div class="help-block with-errors" id="extra_title_{{$i}}_error"></div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputPassword4">Value*</label>
                                            <input type="text" class="form-control required" name="extra_value[]"
                                                   id="extra_value_{{$i}}" placeholder="Value"
                                                   value="{{ $specification->value }}" maxlength="230">
                                            <div class="help-block with-errors" id="extra_value_{{$i}}_error"></div>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <label for="sort_order_{{$i}}">Sort Order</label>
                                            <input type="number" class="form-control" name="sort_order[]"
                                                   id="sort_order_{{$i}}" value="{{ $specification->sort_order?? $i }}">
                                        </div>
                                        <div class="form-group col-md-2" style="margin-top: 10px">
                                            @if($loop->last)
                                                <a href="javascript:void(0);"
                                                   class="btn btn-success mt-4 add_specification_row btn-sm add_{{$i}}"
                                                   id="{{$i}}"><i class="fa fa-plus fa-lg"></i></a>
                                            @endif
                                            <a href="javascript:void(0);"
                                               class="btn btn-danger mt-4 remove_specification_row btn-sm" id="{{$i}}"
                                               ref="{{ $specification->id }}"><i class="fa fa-times fa-lg"></i></a>
                                            <input type="hidden" name="detail_id[]" id="detail_id_{{$i}}"
                                                   value="{{ $specification->id }}">
                                        </div>
                                    </div>
                                    <hr>
                                    @php $i++@endphp
                                @endforeach
                            @else
                                <div class="form-row" id="append_result_1">
                                    <div class="form-group col-md-4">
                                        <label for="inputPassword4">Title*</label>
                                        <input type="text" class="form-control required" name="extra_title[]"
                                               id="extra_title_1" placeholder="Title ">
                                        <div class="help-block with-errors" id="extra_title_1_error"></div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputPassword4">Value*</label>
                                        <input type="text" class="form-control required" name="extra_value[]"
                                               id="extra_value_1" placeholder="Value" maxlength="230">
                                        <div class="help-block with-errors" id="extra_value_1_error"></div>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="sort_order_1">Sort Order</label>
                                        <input type="number" class="form-control" name="sort_order[]"
                                               id="sort_order_1" value="1">
                                    </div>
                                    <div class="form-group col-md-1" style="margin-top: 10px">
                                        <a href="javascript:void(0);"
                                           class="btn btn-success mt-4 add_specification_row btn-sm add_1" id="1"><i
                                                class="fa fa-plus fa-lg"></i></a>
                                        <input type="hidden" name="detail_id[]" id="detail_id_1" value="0">
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer">
                            <input type="submit" name="btn_save" value="Submit"
                                   class="btn btn-primary pull-left submitBtn">
                            <input type="hidden" name="product_id" id="product_id" value="{{$product_id}}">
                            <input type="hidden" name="id" id="id"
                                   value="{{isset($specificationHead)?$specificationHead->id:'0'}}">
                            <img class="animation__shake loadingImg" src="{{url('backend/dist/img/loading.gif')}}"
                                 style="display:none;">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <style>

        hr {
            border-top: 2px solid #17a2b8;
        }
    </style>
@endsection
