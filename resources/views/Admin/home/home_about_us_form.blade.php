@extends('Admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-user-shield"></i> Home About Us</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{url(Helper::sitePrefix().Helper::loggedUserType().'dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Home About-us</li>
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
                <form role="form" id="formWizard" class="form--wizard" enctype="multipart/form-data" method="post">
                    {{csrf_field()}}
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Home About-us Form</h3>
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
                                           value="{{ old('title', isset($about)?$about->title:'') }} " maxlength="230">
                                    <div class="help-block with-errors" id="title_error"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="description">Description*</label>
                                    <textarea class="form-control tinyeditor required reset" id="description"
                                              name="description">
                                    {!! old('description', isset($about)?$about->description:'') !!}</textarea>
                                    <div class="help-block with-errors" id="description_error"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Image*</label>
                                    <div class="file-loading">
                                         <input id="image" name="image" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image size must be 830 X 780</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Image Attribute *</label>
                                    <input type="text" class="form-control placeholder-cls" id="image_attribute"
                                           name="image_attribute" placeholder="Alt='Home Image Attribute'"
                                           value="{{ isset($about)?$about->image_meta_tag:'' }}" maxlength="230">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Button Text*</label>
                                    <input type="text" name="button_text" id="button_text" placeholder="Button Text"
                                           class="form-control required" autocomplete="off"
                                           value="{{ old('button_text', isset($about)?$about->button_text:'') }}"
                                           maxlength="230">
                                    <div class="help-block with-errors" id="button_text_error"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Button URL*</label>
                                    <input type="text" name="button_url" id="button_url" placeholder="Button URL"
                                           class="form-control required" autocomplete="off"
                                           value="{{ old('button_url', isset($about)?$about->button_url:'') }}"
                                           maxlength="230">
                                    <div class="help-block with-errors" id="button_url_error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="hidden" name="id" id="id" value="{{isset($about)?$about->id:'0'}}">
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
                minImageWidth: 830,
                minImageHeight: 780,
                maxImageWidth: 830,
                maxImageHeight: 780,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($about) && $about->image!=NULL)
                initialPreview: [
                    "{{asset($about->image)}}",
                ],
                initialPreviewConfig: [
                    {caption: "{!! ($about->image!=NULL)?$about->title:'';!!}", width: "120px"}
                ]
                @endif
            });


        });
    </script>
@endsection
