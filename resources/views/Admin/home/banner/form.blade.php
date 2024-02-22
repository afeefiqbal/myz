@extends('Admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-user-shield"></i> {{$title}} </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'home/banner')}}">Slider List</a></li>
                            <li class="breadcrumb-item active">{{$title}} </li>
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
                <form role="form" id="formWizard" class="form--wizard" enctype="multipart/form-data"method="post">
                    {{csrf_field()}}
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Slider Form</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
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
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="title">Title *</label>
                                    <input type="text" name="title" id="title" placeholder="Title" class="form-control required" autocomplete="off" value="{{ isset($banner)?$banner->title:'' }}" maxlength="230">
                                    <div class="help-block with-errors" id="title_error"></div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="title">Sub Title *</label>
                                    <input type="text" name="sub_title" id="sub_title" placeholder="Sub Title" class="form-control required" autocomplete="off" value="{{ isset($banner)?$banner->subtitle:'' }}" maxlength="230">
                                    <div class="help-block with-errors" id="sub_title_error"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="title">Description</label>
                                    <textarea name="description" id="description" placeholder="Description" class="form-control tinyeditor" autocomplete="off"> {{ old('description', !empty($banner)?$banner->description:'') }}</textarea>
                                    <div class="help-block with-errors" id="description_error"></div>
                                </div>
                            </div>
                            <div class="form-row" id="slider-div">
                                <div class="form-group col-md-6">
                                    <label>Image</label>
                                    <div class="file-loading">
                                         <input id="image" name="image" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: uploaded images have a maximum size of <strong> 618x650</strong> pixels and can't be over 300KB</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="image_meta_tag">Image Attribute</label>
                                    <input type="text" name="image_attribute" id="image_attribute" placeholder="Image Alternate Text" class="form-control placeholder-cls required" required autocomplete="off" value="{{ isset($banner)?$banner->image_attribute:'' }}" maxlength="230">
                                </div>

                            </div>
                            <div class="form-row" id="slider-div">
                                <div class="form-group col-md-6">
                                    <label for="title">Button Text</label>
                                    <input type="text" name="button_text" id="button_text" placeholder="Button Text" class="form-control" autocomplete="off" value="{{ isset($banner)?$banner->button_text:'' }}" maxlength="230">
                                    <div class="help-block with-errors" id="title_error"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="title">Button Url</label>
                                    <input type="text" name="url" id="url" placeholder="Button Url" class="form-control" autocomplete="off" value="{{ isset($banner)?$banner->url:'' }}" maxlength="230">
                                    <div class="help-block with-errors" id="url_error"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input type="submit" class="btn btn-primary form_submit_btn submitBtn" value="Submit">
                                    <input type="reset" class="btn btn-default" value="Reset">
                                    <img class="animation__shake loadingImg" src="{{url('backend/dist/img/loading.gif')}}" style="display:none;">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <script type="text/javascript">
    //if button text have value add required attribute to url
    $('#button_text').on('keyup',function(){
        if($(this).val()!=''){
            $('#url').addClass('required');
        }else{
            $('#url').removeClass('required');
        }
    });
        $(document).ready(function(){
            $("#image").fileinput({
                'theme': 'explorer-fas',
                validateInitialCount: true,
                overwriteInitial: false,
                autoReplace: true,
               
                
                initialPreviewAsData: true,
                dropZoneEnabled: false,
                required: false,
                allowedFileTypes: ['image'],
                minImageWidth: 618,
                minImageHeight: 650,
                maxImageWidth: 618,
                maxImageHeight: 650,
                maxFileSize: 300,
                showRemove: true,
                @if(isset($banner) && $banner->desktop_image!=NULL)
                initialPreview: ["{{asset($banner->desktop_image)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($banner->desktop_image!=NULL)?$banner->title:''}}",
                    width: "120px",
                    key: "{{'HomeBanner/desktop_image/'.$banner->id.'/desktop_image_webp' }}",
                }]
                @endif
            });

        });
    </script>
@endsection
