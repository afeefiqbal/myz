@extends('Admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-user-shield"></i> Manage Specification</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Specification</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
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
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Heading Form</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <form role="form" id="formWizard" action="{{ url('admin/product/specification/information/store') }}" class="form--wizard" enctype="multipart/form-data" method="post">
                                    {{csrf_field()}}
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="title">Title*</label>
                                                <input type="text" class="form-control required" id="title" name="title"
                                                       placeholder="Title" value="{{@$product->specification_title}}">
                                                <div class="help-block with-errors" id="title_error"></div>
                                                @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Image*</label>
                                                <div class="file-loading">
                                                   <input id="image" name="image" type="file" accept="image/png, image/jpg, image/jpeg">
                                                </div>
                                                <span class="caption_note">Note: Image dimension must be 738 x 472 PX and Size must be
                                                    lessthan 512KB</span>
                                                @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label> Image Attribute</label>
                                                <input type="text" class="form-control placeholder-cls" id="image_attribute"
                                                       name="image_attribute" placeholder="Alt='Banner Attribute'"
                                                       value="{{@$product->specification_image_attribute}}">
                                                @error('image_attribute')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="description">Description*</label>
                                                <textarea class="form-control required tinyeditor" id="description" name="description"
                                                          placeholder="Description">{{@$product->specification_description}}</textarea>
                                                <div class="help-block with-errors" id="description_error"></div>
                                                @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <input type="hidden" name="product_id" value="{{ $product_id }}">
                                        <input type="submit" id="btn_save" name="btn_save" value="Submit" class="btn btn-primary pull-left">
                                        <button type="reset" class="btn btn-default">Cancel</button>
                                        <img class="animation__shake loadingImg" src="{{asset('backend/dist/img/loading.gif')}}"
                                             style="display:none;">
                                    </div>
                                </form>
                            </div>
                            <div class="card card-success card-outline">
                            <div class="card-header">
                                <a href="{{url(Helper::sitePrefix().'product/specification/create/'.$product_id)}}"
                                   class="btn btn-success pull-right">Add Specification <i
                                        class="fa fa-plus-circle pull-right mt-1 ml-2"></i></a>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover dataTable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Specification</th>
                                        <th>Sort Order</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th class="not-sortable">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $i=1@endphp@foreach($productSpecificationHeads as $specification)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $specification->title }}</td>
                                            <td>
                                                <input type="text" name="sort_order"
                                                       id="sort_order_{{$loop->iteration}}"
                                                       data-table="ProductSpecificationHead"
                                                       data-url="/sort-order-with-field" data-field="product_id"
                                                       data-field-value="{{ $specification->product_id }}"
                                                       data-id="{{ $specification->id }}" class="common_sort_order"
                                                       style="width:25%" value="{{ $specification->sort_order }}">
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" class="status_check"
                                                           {{($specification->status=="Active")?'checked':''}} title="ProductSpecificationHead"
                                                           ref="{{ $specification->id}}">
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td>{{ date("d-M-Y", strtotime($specification->created_at))  }}</td>
                                            <td class="text-right py-0 align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{url(Helper::sitePrefix().'product/specification/edit/'.$specification->id)}}"
                                                       class="btn btn-success mr-2 tooltips" title="Edit Category"><i
                                                            class="fas fa-edit"></i></a>
                                                    <a href="#" class="btn btn-danger mr-2 delete_entry tooltips"
                                                       data-url="product/specification/delete"
                                                       data-id="{{$specification->id}}"
                                                       title="Delete Specification Heads"><i
                                                            class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        @php $i++@endphp
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#image").fileinput({
                'theme': 'explorer-fas',
                validateInitialCount: true,
                overwriteInitial: false,
                autoReplace: true,
                layoutTemplates: {actionDelete: ''},
                removeLabel: "Remove",
                initialPreviewAsData: true,
                dropZoneEnabled: false,
                required: true,
                allowedFileTypes: ['image'],
                minImageWidth: 738,
                minImageHeight: 472,
                maxImageWidth: 738,
                maxImageHeight: 472,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($product) && $product->specification_image!=NULL)
                initialPreview: ["{{asset($product->specification_image)}}",],
                initialPreviewConfig: [{
                    caption: "{{last(explode('/',$product->specification_image))}}",
                    width: "120px"
                }]
                @endif
            });
        });
    </script>
@endsection
