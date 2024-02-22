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
                                <a href="{{url(Helper::sitePrefix().'product/product-type')}}">{{$title}}</a></li>
                            <li class="breadcrumb-item active">{{$key}}</li>
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
                            <h3 class="card-title">Product type form</h3>
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
                                    <label> Title*</label>
                                    <input type="text" name="title" id="title" placeholder="Title" readonly
                                           class="form-control required" autocomplete="off"
                                           value="{{ @$product_type->title }}">
                                    <div class="help-block with-errors" id="title_error"></div>
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Image*</label>
                                    <div class="file-loading">
                                       <input id="image" name="image" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image size must be 80 x 80px</span>
                                    @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Image Attribute</label>
                                    <input type="text" class="form-control placeholder-cls" id="image_attribute"
                                           name="image_attribute" placeholder="Alt='Image Attribute'"
                                           value="{{ isset($product_type)?$product_type->image_attribute:'' }}">
                                    @error('image_attribute')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Alternate Image</label>
                                    <div class="file-loading">
                                        <input id="alternate_image" name="alternate_image" type="file"  accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image size must be 1200 x 1200 px</span>
                                    @error('alternate_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label> Alternate Image Attribute</label>
                                <input type="text" class="form-control placeholder-cls" id="alternate_image_attribute"
                                       name="alternate_image_attribute" placeholder="Alt='Image Attribute'"
                                       value="{{ isset($product_type)?$product_type->alternate_image_attribute:'' }}">
                                @error('alternate_image_attribute')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                        <div class="card-footer">
                            <input type="submit" name="btn_save" value="Submit"
                                   class="btn btn-primary pull-left submitBtn">
                            <button type="reset" class="btn btn-default">Cancel</button>
                            <img class="animation__shake loadingImg" src="{{asset('backend/dist/img/loading.gif')}}"
                                 style="display:none;">
                        </div>
                    </div>
                </form>
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
                 initialPreviewShowDelete: false,
                dropZoneEnabled: false,
                required: false,
                allowedFileTypes: ['image'],
                minImageWidth: 80,
                minImageHeight: 80,
                maxImageWidth: 80,
                maxImageHeight: 80,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($product_type) && $product_type->image!=NULL)
                initialPreview: ["{{asset($product_type->image)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($product_type->image!=NULL)?last(explode('/',$product_type->image)):''}}",
                    width: "120px"
                }]
                @endif
            });

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            // $("#alternate_image").fileinput({
            //     'theme': 'explorer-fas',
            //     validateInitialCount: true,
            //     overwriteInitial: false,
            //     autoReplace: true,
            //     layoutTemplates: {actionDelete: ''},
            //     removeLabel: "Remove",
            //     initialPreviewAsData: true,
            //     dropZoneEnabled: false,
            //     required: false,
            //     allowedFileTypes: ['image'],
              
            //     minImageWidth: 1200,
            //     minImageHeight: 1200,
            //     maxImageWidth: 1200,
            //     maxImageHeight: 1200,
            //     maxFileSize: 512,
            //     showRemove: true,
            //     @if(isset($product_type) && $product_type->alternate_image!=NULL)
            //     initialPreview: ["{{asset($product_type->alternate_image)}}",],
            //     initialPreviewConfig: [{
            //         caption: "{{ ($product_type->alternate_image!=NULL)?last(explode('/',$product_type->alternate_image)):''}}",
            //         width: "120px"
            //     }]
            //     @endif
            // });
            
            $("#alternate_image").fileinput({
            'theme': 'explorer-fas',
            validateInitialCount: true,
            overwriteInitial: false,
            autoReplace: true,
            initialPreviewShowDelete: false,
            initialPreviewAsData: true,
            dropZoneEnabled: false,
            required: false,
            allowedFileTypes: ['image'],
            showRemove: true,
            minImageWidth: 1200,
                minImageHeight: 1200,
                maxImageWidth: 1200,
                maxImageHeight: 1200,
            maxFileSize: 512,
            @if(isset($product_type) && $product_type->alternate_image!=NULL)
                initialPreview: ["{{asset($product_type->alternate_image)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($product_type->alternate_image!=NULL)?last(explode('/',$product_type->alternate_image)):''}}",
                    width: "120px",
                    key: "{{'ProductType/alternate_image/'.$product_type->id.'/alternate_image_webp' }}",
                }],
                @endif
        })

        });
    </script>
@endsection
