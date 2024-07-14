@extends('Admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-user-shield"></i> Home </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{url(Helper::sitePrefix().Helper::loggedUserType().'dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Home </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
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
                <form role="form" id="formWizard" action="{{route('banner.store')}}" class="form--wizard" enctype="multipart/form-data" method="post">
                    {{csrf_field()}}
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Home </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Home Side first banner*</label>
                                    <div class="file-loading">
                                         <input id="side_first_banner" name="side_first_banner" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image size must be 375 X 586</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Home  Image Attribute *</label>
                                    <input type="text" class="form-control placeholder-cls" id="side_first_banner_attribute"
                                           name="side_first_banner_attribute" placeholder="Alt='Banner  Attribute'"
                                           value="{{ isset($index)?$index->side_first_banner_attribute:'' }}" maxlength="230">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Home Side first banner URL *</label>
                                    <input type="text" class="form-control " id="side_first_banner_url" name="side_first_banner_url"
                                           value="{{ isset($index)?$index->side_first_banner_url:'' }}" maxlength="230">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Home Side Second Banner*</label>
                                    <div class="file-loading">
                                         <input id="side_second_banner" name="side_second_banner" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image size must be 313 X 209</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Home  Image Attribute *</label>
                                    <input type="text" class="form-control placeholder-cls" id="side_second_banner_attribute"
                                           name="side_second_banner_attribute" placeholder="Alt=' Banner Attribute'"
                                           value="{{ isset($index)?$index->side_second_banner_attribute:'' }}" maxlength="230">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Home Side second banner url *</label>
                                    <input type="text" class="form-control " id="side_second_banner_url" name="side_second_banner_url"
                                           value="{{ isset($index)?$index->side_second_banner_url:'' }}" maxlength="230">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Home  Category first banner*</label>
                                    <div class="file-loading">
                                         <input id="category_first_banner" name="category_first_banner" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image size must be 790 X 286</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Home  Image Attribute *</label>
                                    <input type="text" class="form-control placeholder-cls" id="category_first_banner_attribute"
                                           name="category_first_banner_attribute" placeholder="Alt='banner Attribute'"
                                           value="{{ isset($index)?$index->category_first_banner_attribute:'' }}" maxlength="230">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Home  Category first banner url *</label>
                                    <input type="text" class="form-control " id="category_first_banner_url" name="category_first_banner_url"
                                           value="{{ isset($index)?$index->category_first_banner_url:'' }}" maxlength="230">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Home Category second banner *</label>
                                    <div class="file-loading">
                                         <input id="category_second_banner" name="category_second_banner" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image size must be 383 X 286</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Home  Image Attribute *</label>
                                    <input type="text" class="form-control placeholder-cls" id="category_second_banner_attribute"
                                           name="category_second_banner_attribute" placeholder="Alt='image  Attribute'"
                                           value="{{ isset($index)?$index->category_second_banner_attribute:'' }}" maxlength="230">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Home Category second banner url *</label>
                                    <input type="text" class="form-control " id="category_second_banner_url" name="category_second_banner_url"
                                           value="{{ isset($index)?$index->category_second_banner_url:'' }}" maxlength="230">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Product  banner *</label>
                                    <div class="file-loading">
                                         <input id="product_banner" name="product_banner" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image size must be 1380 X 531</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Product  banner Text *</label>
                                    <input type="text" class="form-control " id="product_banner_text" name="product_banner_text"
                                           value="{{ isset($banner)?$banner->product_banner_text:'' }}" maxlength="230">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Product  banner url *</label>
                                    <input type="text" class="form-control " id="product_banner_url" name="product_banner_url"
                                           value="{{ isset($banner)?$banner->product_banner_url:'' }}" maxlength="230">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>First bottom image *</label>
                                    <div class="file-loading">
                                         <input id="about_first_bottom_image" name="about_first_bottom_image" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image size must be 39 X 39</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>First bottom image text *</label>
                                    <input type="text" class="form-control " id="about_first_bottom_image_text" name="about_first_bottom_image_text"
                                           value="{{ isset($banner)?$banner->about_first_bottom_image_text:'' }}" maxlength="230">
                                </div>
                            </div>  
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Second bottom image *</label>
                                    <div class="file-loading">
                                         <input id="about_second_bottom_image" name="about_second_bottom_image" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image size must be 39 X 39</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Second bottom image text *</label>
                                    <input type="text" class="form-control " id="about_second_bottom_image_text" name="about_second_bottom_image_text"
                                           value="{{ isset($banner)?$banner->about_second_bottom_image_text:'' }}" maxlength="230">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Third bottom image *</label>
                                    <div class="file-loading">
                                         <input id="about_third_bottom_image" name="about_third_bottom_image" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image size must be 39 X 39</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Third bottom image text *</label>
                                    <input type="text" class="form-control " id="about_third_bottom_image_text" name="about_third_bottom_image_text"
                                           value="{{ isset($banner)?$banner->about_third_bottom_image_text:'' }}" maxlength="230">
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <input type="hidden" name="id" id="id" value="{{isset($index)?$index->id:'0'}}">
                            <input type="submit" name="btn_save" value="Submit"
                                   class="btn btn-primary pull-left submitBtn">

                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#side_first_banner").fileinput({
                'theme': 'explorer-fas',
                validateInitialCount: true,
                overwriteInitial: false,
                autoReplace: true,
                layoutTemplates: {actionDelete: ''},
                removeLabel: "Remove",
                initialPreviewAsData: true,
                dropZoneEnabled: false,
                required: false,
                allowedFileTypes: ['image'],
                // minImageWidth: 375,
                // minImageHeight: 586,
                // maxImageWidth: 375,
                // maxImageHeight: 586,
                // maxFileSize: 512,
                showRemove: true,
                @if(isset($index) && $index->side_first_banner!=NULL)
                initialPreview: [
                    "{{asset($index->side_first_banner)}}",
                ],
                initialPreviewConfig: [
                    {caption: "{!! ($index->side_first_banner!=NULL)?:'';!!}", width: "120px"}
                ]
                @endif
            });
            $("#side_second_banner").fileinput({
                'theme': 'explorer-fas',
                validateInitialCount: true,
                overwriteInitial: false,
                autoReplace: true,
                layoutTemplates: {actionDelete: ''},
                removeLabel: "Remove",
                initialPreviewAsData: true,
                dropZoneEnabled: false,
                required: false,
                allowedFileTypes: ['image'],
                // minImageWidth: 313,
                // minImageHeight: 209,
                // maxImageWidth: 313,
                // maxImageHeight: 209,
                // maxFileSize: 512,
                showRemove: true,
                @if(isset($index) && $index->side_second_banner!=NULL)
                initialPreview: [
                    "{{asset($index->side_second_banner)}}",
                ],
                initialPreviewConfig: [
                    {caption: "{!! ($index->side_second_banner!=NULL)?:'';!!}", width: "120px"}
                ]
                @endif
            });
            $("#category_first_banner").fileinput({
                'theme': 'explorer-fas',
                validateInitialCount: true,
                overwriteInitial: false,
                autoReplace: true,
                layoutTemplates: {actionDelete: ''},
                removeLabel: "Remove",
                initialPreviewAsData: true,
                dropZoneEnabled: false,
                required: false,
                allowedFileTypes: ['image'],
                // minImageWidth: 790,
                // minImageHeight: 287,
                // maxImageWidth: 790,
                // maxImageHeight: 287,
                // maxFileSize: 512,
                showRemove: true,
                @if(isset($index) && $index->category_first_banner!=NULL)
                initialPreview: [
                    "{{asset($index->category_first_banner)}}",
                ],
                initialPreviewConfig: [
                    {caption: "{!! ($index->category_first_banner!=NULL)?:'';!!}", width: "120px"}
                ]
                @endif
            });
            $("#category_second_banner").fileinput({
                'theme': 'explorer-fas',
                validateInitialCount: true,
                overwriteInitial: false,
                autoReplace: true,
                layoutTemplates: {actionDelete: ''},
                removeLabel: "Remove",
                initialPreviewAsData: true,
                dropZoneEnabled: false,
                required: false,
                allowedFileTypes: ['image'],
                // minImageWidth: 790,
                // minImageHeight: 287,
                // maxImageWidth: 790,
                // maxImageHeight: 287,
                // maxFileSize: 512,
                showRemove: true,
                @if(isset($index) && $index->category_second_banner!=NULL)
                initialPreview: [
                    "{{asset($index->category_second_banner)}}",
                ],
                initialPreviewConfig: [
                    {caption: "{!! ($index->category_second_banner!=NULL)?:'';!!}", width: "120px"}
                ]
                @endif
            });
            $("#product_banner").fileinput({
                'theme': 'explorer-fas',
                validateInitialCount: true,
                overwriteInitial: false,
                autoReplace: true,
                layoutTemplates: {actionDelete: ''},
                removeLabel: "Remove",
                initialPreviewAsData: true,
                dropZoneEnabled: false,
                required: false,
                allowedFileTypes: ['image'],
                minImageWidth: 1380,
                minImageHeight: 531,
                maxImageWidth: 1380,
                maxImageHeight: 531,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($banner) && $banner->product_banner!=NULL)
                initialPreview: [
                    "{{asset($banner->product_banner)}}",
                ],
                initialPreviewConfig: [
                    {caption: "{!! ($banner->product_banner!=NULL)?:'';!!}", width: "120px"}
                ]
                @endif
            });
            $("#about_first_bottom_image").fileinput({
                'theme': 'explorer-fas',
                validateInitialCount: true,
                overwriteInitial: false,
                autoReplace: true,
                layoutTemplates: {actionDelete: ''},
                removeLabel: "Remove",
                initialPreviewAsData: true,
                dropZoneEnabled: false,
                required: false,
                allowedFileTypes: ['image'],
                minImageWidth: 39,
                minImageHeight: 39,
                maxImageWidth: 39,
                maxImageHeight: 39,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($banner) && $banner->about_first_bottom_image!=NULL)
                initialPreview: [
                    "{{asset($banner->about_first_bottom_image)}}",
                ],
                initialPreviewConfig: [
                    {caption: "{!! ($banner->about_first_bottom_image!=NULL)?:'';!!}", width: "120px"}
                ]
                @endif
            });
            $("#about_second_bottom_image").fileinput({
                'theme': 'explorer-fas',
                validateInitialCount: true,
                overwriteInitial: false,
                autoReplace: true,
                layoutTemplates: {actionDelete: ''},
                removeLabel: "Remove",
                initialPreviewAsData: true,
                dropZoneEnabled: false,
                required: false,
                allowedFileTypes: ['image'],
                minImageWidth: 39,
                minImageHeight: 39,
                maxImageWidth: 39,
                maxImageHeight: 39,
                maxFileSize: 39,
                showRemove: true,
                @if(isset($banner) && $banner->about_second_bottom_image!=NULL)
                initialPreview: [
                    "{{asset($banner->about_second_bottom_image)}}",
                ],
                initialPreviewConfig: [
                    {caption: "{!! ($banner->about_second_bottom_image!=NULL)?:'';!!}", width: "120px"}
                ]
                @endif
            });
            $("#about_third_bottom_image").fileinput({
                'theme': 'explorer-fas',
                validateInitialCount: true,
                overwriteInitial: false,
                autoReplace: true,
                layoutTemplates: {actionDelete: ''},
                removeLabel: "Remove",
                initialPreviewAsData: true,
                dropZoneEnabled: false,
                required: false,
                allowedFileTypes: ['image'],
                minImageWidth: 39,
                minImageHeight: 39,
                maxImageWidth: 39,
                maxImageHeight: 39,
                maxFileSize: 39,
                showRemove: true,
                @if(isset($banner) && $banner->about_third_bottom_image!=NULL)
                initialPreview: [
                    "{{asset($banner->about_third_bottom_image)}}",
                ],
                initialPreviewConfig: [
                    {caption: "{!! ($banner->about_third_bottom_image!=NULL)?:'';!!}", width: "120px"}
                ]
                @endif
            });

        });
    </script>
@endsection 
