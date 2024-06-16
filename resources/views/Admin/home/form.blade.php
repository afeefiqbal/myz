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
                <form role="form" id="formWizard" action="{{route('home.store')}}" class="form--wizard" enctype="multipart/form-data" method="post">
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
                                    <label> Main Banner*</label>
                                    <div class="file-loading">
                                         <input id="main_banner" name="main_banner" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image size must be 1155 X 770</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Image Attribute *</label>
                                    <input type="text" class="form-control placeholder-cls" id="main_banner_attribute"
                                           name="main_banner_attribute" placeholder="Alt='Main Banner  Attribute'"
                                           value="{{ isset($index)?$index->main_banner_attribute:'' }}" maxlength="230">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Banner URL *</label>
                                    <input type="text" class="form-control " id="main_banner_url" name="main_banner_url"
                                           value="{{ isset($index)?$index->main_banner_url:'' }}" maxlength="230">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label> Left Side First Banner*</label>
                                    <div class="file-loading">
                                         <input id="left_side_banner" name="left_side_banner" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image size must be 415 X 320</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Image Attribute *</label>
                                    <input type="text" class="form-control placeholder-cls" id="left_banner_attribute"
                                           name="left_banner_attribute" placeholder="Alt=' Banner Attribute'"
                                           value="{{ isset($index)?$index->left_banner_attribute:'' }}" maxlength="230">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Left Side First Banner URL *</label>
                                    <input type="text" class="form-control " id="left_side_banner_url" name="left_side_banner_url"
                                           value="{{ isset($index)?$index->left_side_banner_url:'' }}" maxlength="230">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label> Left Side Second Banner*</label>
                                    <div class="file-loading">
                                         <input id="left_second_banner" name="left_second_banner" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image size must be 500 X 300</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Image Attribute *</label>
                                    <input type="text" class="form-control placeholder-cls" id="left_second_banner_attribute"
                                           name="left_second_banner_attribute" placeholder="Alt='banner Attribute'"
                                           value="{{ isset($index)?$index->left_second_banner_attribute:'' }}" maxlength="230">
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Left Side Second Banner URL *</label>
                                    <input type="text" class="form-control " id="left_second_banner_url" name="left_second_banner_url"
                                           value="{{ isset($index)?$index->left_second_banner_url:'' }}" maxlength="230">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label> Bottom First Image *</label>
                                    <div class="file-loading">
                                         <input id="bottom_first_image" name="bottom_first_image" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image size must be 347 X 231</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Bottom First Image Attribute *</label>
                                    <input type="text" class="form-control placeholder-cls" id="bottom_first_image_attribute"
                                           name="bottom_first_image_attribute" placeholder="Alt='image  Attribute'"
                                           value="{{ isset($index)?$index->bottom_first_image_attribute:'' }}" maxlength="230">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Bottom First Image URL *</label>
                                    <input type="text" class="form-control " id="bottom_first_image_url" name="bottom_first_image_url"
                                           value="{{ isset($index)?$index->bottom_first_image_url:'' }}" maxlength="230">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label> Bottom Second Image*</label>
                                    <div class="file-loading">
                                         <input id="bottom_second_image" name="bottom_second_image" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image size must be 347 X 231</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Image Attribute *</label>
                                    <input type="text" class="form-control placeholder-cls" id="bottom_second_image_attribute"
                                           name="bottom_second_image_attribute" placeholder="Alt='Image  Attribute'"
                                           value="{{ isset($index)?$index->bottom_second_image_attribute:'' }}" maxlength="230">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Bottom Second Image URL *</label>
                                    <input type="text" class="form-control " id="bottom_second_image_url" name="bottom_second_image_url"
                                           value="{{ isset($index)?$index->bottom_second_image_url:'' }}" maxlength="230">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label> Bottom Third Image*</label>
                                    <div class="file-loading">
                                         <input id="bottom_third_image" name="bottom_third_image" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image size must be 347 X 231</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Image Attribute *</label>
                                    <input type="text" class="form-control placeholder-cls" id="bottom_third_image_attribute"
                                           name="bottom_third_image_attribute" placeholder="Alt='image Attribute'"
                                           value="{{ isset($index)?$index->bottom_third_image_attribute:'' }}" maxlength="230">
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Bottom Third Image URL *</label>
                                    <input type="text" class="form-control " id="bottom_third_image_url" name="bottom_third_image_url"
                                           value="{{ isset($index)?$index->bottom_third_image_url:'' }}" maxlength="230">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label> Bottom Fourth Banner*</label>
                                    <div class="file-loading">
                                         <input id="bottom_fourth_image" name="bottom_fourth_image" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image size must be 347 X 231</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Image Attribute *</label>
                                    <input type="text" class="form-control placeholder-cls" id="bottom_fourth_image_attribute"
                                           name="bottom_fourth_image_attribute" placeholder="Alt='Image  Attribute'"
                                           value="{{ isset($index)?$index->bottom_fourth_image_attribute:'' }}" maxlength="230">
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Bottom Fourth Image URL *</label>
                                    <input type="text" class="form-control " id="bottom_fourth_image_url" name="bottom_fourth_image_url"
                                           value="{{ isset($index)?$index->bottom_fourth_image_url:'' }}" maxlength="230">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label> Deal Banner*</label>
                                    <div class="file-loading">
                                         <input id="deal_image" name="deal_image" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image size must be 500 X 300</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Image Attribute *</label>
                                    <input type="text" class="form-control placeholder-cls" id="deal_image"
                                           name="deal_image" placeholder="Alt='Image  Attribute'"
                                           value="{{ isset($index)?$index->deal_image:'' }}" maxlength="230">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Deal Banner URL *</label>
                                    <input type="url" class="form-control " id="deal_image_url" name="deal_image_url"
                                           value="{{ isset($index)?$index->deal_image_url:'' }}" maxlength="230">
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
            $("#main_banner").fileinput({
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
                minImageWidth: 1155,
                minImageHeight: 770,
                maxImageWidth: 1155,
                maxImageHeight: 770,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($index) && $index->main_banner!=NULL)
                initialPreview: [
                    "{{asset($index->main_banner)}}",
                ],
                initialPreviewConfig: [
                    {caption: "{!! ($index->main_banner!=NULL)?:'';!!}", width: "120px"}
                ]
                @endif
            });
            $("#left_side_banner").fileinput({
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
                minImageWidth: 415,
                minImageHeight: 320,
                maxImageWidth: 415,
                maxImageHeight: 320,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($index) && $index->left_side_banner!=NULL)
                initialPreview: [
                    "{{asset($index->left_side_banner)}}",
                ],
                initialPreviewConfig: [
                    {caption: "{!! ($index->left_side_banner!=NULL)?:'';!!}", width: "120px"}
                ]
                @endif
            });
            $("#left_second_banner").fileinput({
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
                minImageWidth: 500,
                minImageHeight: 300,
                maxImageWidth: 500,
                maxImageHeight: 300,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($index) && $index->left_second_banner!=NULL)
                initialPreview: [
                    "{{asset($index->left_second_banner)}}",
                ],
                initialPreviewConfig: [
                    {caption: "{!! ($index->left_second_banner!=NULL)?:'';!!}", width: "120px"}
                ]
                @endif
            });
            $("#bottom_first_image").fileinput({
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
                minImageWidth: 347,
                minImageHeight: 231,
                maxImageWidth: 347,
                maxImageHeight: 231,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($index) && $index->bottom_first_image!=NULL)
                initialPreview: [
                    "{{asset($index->bottom_first_image)}}",
                ],
                initialPreviewConfig: [
                    {caption: "{!! ($index->bottom_first_image!=NULL)?:'';!!}", width: "120px"}
                ]
                @endif
            });
            $("#bottom_second_image").fileinput({
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
                minImageWidth: 347,
                minImageHeight: 231,
                maxImageWidth: 347,
                maxImageHeight: 231,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($index) && $index->bottom_second_image!=NULL)
                initialPreview: [
                    "{{asset($index->bottom_second_image)}}",
                ],
                initialPreviewConfig: [
                    {caption: "{!! ($index->bottom_second_image!=NULL)?:'';!!}", width: "120px"}
                ]
                @endif
            });
            $("#bottom_third_image").fileinput({
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
                minImageWidth: 347,
                minImageHeight: 231,
                maxImageWidth: 347,
                maxImageHeight: 231,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($index) && $index->bottom_third_image!=NULL)
                initialPreview: [
                    "{{asset($index->bottom_third_image)}}",
                ],
                initialPreviewConfig: [ 
                    {caption: "{!! ($index->bottom_third_image!=NULL)?:'';!!}", width: "120px"}
                ]
                @endif
            });
            $("#bottom_fourth_image").fileinput({
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
                minImageWidth: 347,
                minImageHeight: 231,
                maxImageWidth: 347,
                maxImageHeight: 231,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($index) && $index->bottom_fourth_image!=NULL)
                initialPreview: [
                    "{{asset($index->bottom_fourth_image)}}",
                ],
                initialPreviewConfig: [
                    {caption: "{!! ($index->bottom_fourth_image!=NULL)?:'';!!}", width: "120px"}
                ]
                @endif
            });
            $("#deal_image").fileinput({
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
                minImageWidth: 500,
                minImageHeight: 300,
                maxImageWidth: 500,
                maxImageHeight: 300,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($index) && $index->deal_image!=NULL)
                initialPreview: [
                    "{{asset($index->deal_image)}}",
                ],
                initialPreviewConfig: [
                    {caption: "{!! ($index->deal_image!=NULL)?:'';!!}", width: "120px"}
                ]
                @endif
            });
        });
    </script>
@endsection
