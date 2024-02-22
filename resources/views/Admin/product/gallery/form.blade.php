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
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'product')}}">Products</a>
                            </li>
                            <li class="breadcrumb-item"><a
                                    href="{{url(Helper::sitePrefix().'product/gallery/'.$product_id)}}">Gallery</a></li>
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
                            <h3 class="card-title">Gallery Form</h3>
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
                                <div class="form-group col-md-6" hidden>
                                    <label> Media Type *</label>
                                    <select name="media_type" id="media_type" class="form-control select2">
                                        @foreach(["Image", "Video"] AS $media_type)
                                            <option value="{{ $media_type }}"
                                                {{ old("media_type", @$product_gallery->media_type) == $media_type ? "selected" : "" }}>{{ $media_type }}</option>
                                        @endforeach
                                    </select>
                                    @error('media_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6 video-div"
                                     style="display:{{(@$product_gallery->media_type=='Video')?'block':'none'}}">
                                    <label> Video URL</label>
                                    <input type="text" class="form-control" id="video_url" name="video_url"
                                           placeholder="Video URL"
                                           value="{{ isset($product_gallery)?$product_gallery->video_url:'' }}">
                                    <div class="help-block with-errors" id="video_url_error"></div>
                                    @error('video_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label> Image*</label>
                                        <div class="file-loading">
                                            @isset($product_gallery)
                                                <input type="file" name="image[]" id="image" accept="image/png, image/jpg, image/jpeg" multiple>
                                            @else
                                                <input type="file" name="image[]" id="image" accept="image/png, image/jpg, image/jpeg" multiple>
                                            @endisset
                                        </div>
                                        
                                        @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label> Image Attribute *</label>
                                        <input type="text" class="form-control required placeholder-cls"
                                               id="image_attribute" name="image_attribute"
                                               placeholder="Alt='Banner Attribute'"
                                               value="{{ isset($product_gallery)?$product_gallery->image_attribute:'' }}">
                                        <div class="help-block with-errors" id="image_attribute_error"></div>
                                        @error('image_attribute')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                        </div>
                        <div class="card-footer">
                            <input type="submit" name="btn_save" value="Submit"
                                   class="btn btn-primary pull-left submitBtn">
                            <input type="hidden" name="product_id" id="product_id" value="{{$product_id}}">
                            <button type="reset" class="btn btn-default">Cancel</button>
                            <img class="animation__shake loadingImg" src="{{url('backend/dist/img/loading.gif')}}"
                                 style="display:none;">
                        </div>
                    </div>
                </form>
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
            initialPreviewShowDelete: false,
            initialPreviewAsData: true,
            dropZoneEnabled: false,
            required: true,
            allowedFileTypes: ['image'],

            maxFileSize: 512,
            showRemove: true,
            @if(isset($product) && $product->thumbnail_image!=NULL)
                initialPreview: ["{{asset($product->thumbnail_image)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($product->thumbnail_image!=NULL)?last(explode('/',$product->thumbnail_image)):''}}",
                    width: "120px",
                    key: "{{'Product/thumbnail_image/'.$product->id.'/thumbnail_image_webp' }}",
                }],
                @endif
            });
        });
    </script>
@endsection
