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
{{--                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'about')}}">About</a>--}}
{{--                            </li>--}}
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
                <form role="form" id="aboutFormWizard" class="form--wizard" enctype="multipart/form-data" method="post">
                    {{csrf_field()}}
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">About Form</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Title*</label>
                                    <input type="text" name="title" id="title" placeholder="Title"
                                           class="form-control required" autocomplete="off"
                                           value="{{ old('title', isset($about)?$about->title:'') }}">
                                    <div class="help-block with-errors" id="title_error"></div>
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                               <div class="form-group col-md-6">
                                   <label> Sub Title</label>
                                   <input type="text" name="subtitle" id="subtitle" placeholder="Sub Title"
                                          class="form-control " autocomplete="off"
                                          value="{{ isset($about)?$about->subtitle:'' }}">
                                   <div class="help-block with-errors" id="subtitle_error"></div>
                                   @error('subtitle')
                                   <div class="invalid-feedback">{{ $message }}</div>
                                   @enderror
                               </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label> Description*</label>
                                    <textarea name="description" id="description"
                                              class="form-control required tinyeditor" placeholder="Description"
                                    >{{ old('description', isset($about)?$about->description:'') }}</textarea>
                                    <div class="help-block with-errors" id="description_error"></div>
                                    @error('description')
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
                                    <span class="caption_note">Note: Image dimension must be  1125 x 750 and Size must be
                                        less than 512 KB</span>
                                    @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Image Attribute</label>
                                    <input type="text" class="form-control placeholder-cls" id="image_attribute"
                                           name="image_attribute" placeholder="Alt='Image Attribute'"
                                           value="{{ isset($about)?$about->image_attribute:'' }}">
                                    @error('image_attribute')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>
                            <div class="form-row">

                                <div class="form-group col-md-6">
                                    <label>Second Image*</label>
                                    <div class="file-loading">
                                       <input id="banner_image" name="banner_image" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image dimension must be  500 x 750 and Size must be
                                        less than 512 KB</span>
                                    @error('banner_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Banner Image Attribute</label>
                                    <input type="text" class="form-control placeholder-cls" id="banner_image_attribute"
                                           name="banner_image_attribute" placeholder="Alt='Banner Image Attribute'"
                                           value="{{ isset($about)?$about->banner_image_attribute:'' }}">
                                    @error('banner_image_attribute')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>First Div*</label>
                                    <textarea name="first_div" id="first_div"   placeholder="first_div"  class="form-control tinyeditor" autocomplete="off">
                                        {{ old('first_div', !empty($about)?$about->first_div:'') }}</textarea>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Second Div*</label>
                                    <textarea id="second_div"   name="second_div"  class="form-control tinyeditor" autocomplete="off">
                                        {{ old('second_div', !empty($about)?$about->second_div:'') }}</textarea>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Third Div*</label>
                                    <textarea name="third_div" id="thid_div"   placeholder="thōid_div"  class="form-control tinyeditor" autocomplete="off">
                                        {{ old('third_div', !empty($about)?$about->third_div:'') }}</textarea>
                                </div>
                            </div>
                            <div class="form-row">
                            
                                <div class="form-group col-md-4">
                                    <label> First Div Title </label>
                                    <input type="text" class="form-control placeholder-cls" id="first_div_title"
                                           name="first_div_title" placeholder=""
                                           value="{{ isset($about)?$about->first_div_title:'' }}">
                                    @error('first_div_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>First Div Icon*</label>
                                    <div class="file-loading">
                                       <input id="first_div_image" name="first_div_image" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image dimension must be  233 x 230 and Size must be  less than 512 KB</span>
                                    @error('first_div_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label> First Div Value </label>
                                    <input type="text" class="form-control placeholder-cls" id="first_div_count"
                                           name="first_div_count" placeholder=""
                                           value="{{ isset($about)?$about->first_div_count:'' }}">
                                    @error('first_div_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label> Second Div Title </label>
                                    <input type="text" class="form-control placeholder-cls" id="second_div_title"
                                           name="second_div_title" placeholder=""
                                           value="{{ isset($about)?$about->second_div_title:'' }}">
                                    @error('second_div_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Second Div Icon*</label>
                                    <div class="file-loading">
                                       <input id="second_div_image" name="second_div_image" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image dimension must be  299 x 230 and Size must be  less than 512 KB</span>
                                    @error('second_div_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Second Div Value </label>
                                    <input type="text" class="form-control placeholder-cls" id="second_div_count"
                                           name="second_div_count" placeholder=""
                                           value="{{ isset($about)?$about->second_div_count:'' }}">
                                    @error('second_div_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label> Third Div Title </label>
                                    <input type="text" class="form-control placeholder-cls" id="third_div_title"
                                           name="third_div_title" placeholder=""
                                           value="{{ isset($about)?$about->third_div_title:'' }}">
                                    @error('third_div_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Third Div Icon*</label>
                                    <div class="file-loading">
                                       <input id="third_div_image" name="third_div_image" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image dimension must be  236 x 230 and Size must be  less than 512 KB</span>
                                    @error('third_div_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Third Div Value </label>
                                    <input type="text" class="form-control placeholder-cls" id="third_div_count"
                                           name="third_div_count" placeholder=""
                                           value="{{ isset($about)?$about->third_div_count:'' }}">
                                    @error('third_div_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
            $("#image",).fileinput({
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
                minImageWidth: 1125,
                minImageHeight: 750,
                maxImageWidth: 1125,
                maxImageHeight: 750,
                showRemove: true,
                @if(isset($about) && $about->image!=NULL)
                initialPreview: ["{{asset($about->image)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($about->image!=NULL)?last(explode('/',$about->image)):''}}",
                    width: "120px"
                }]
                @endif
            });
            $("#banner_image",).fileinput({
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
                minImageHeight: 750,
                maxImageWidth: 500,
                maxImageHeight: 750,
                showRemove: true,
                @if(isset($about) && $about->banner_image!=NULL)
                initialPreview: ["{{asset($about->banner_image)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($about->banner_image!=NULL)?last(explode('/',$about->banner_image)):''}}",
                    width: "120px"
                }]
                @endif
            });
            $("#first_div_image",).fileinput({
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
                minImageWidth: 233,
                minImageHeight: 230,
                maxImageWidth: 233,
                maxImageHeight: 230,
                showRemove: true,
                @if(isset($about) && $about->first_div_image!=NULL)
                initialPreview: ["{{asset($about->first_div_image)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($about->first_div_image!=NULL)?last(explode('/',$about->first_div_image)):''}}",
                    width: "120px"
                }]
                @endif
            });
            $("#second_div_image",).fileinput({
                'theme': 'explorer-fas',
                validateInitialCount: true,
                overwriteInitial: false,
                autoReplace: true,
                layoutTemplates: {actionDelete: ''},
                removeLabel: "Remove",
                initialPreviewAsData: true,
                dropZoneEnabled: false,
                required: false ,
                allowedFileTypes: ['image'],
                minImageWidth: 299,
                minImageHeight: 230,
                maxImageWidth: 299,
                maxImageHeight: 230,
                showRemove: true,
                @if(isset($about) && $about->second_div_image!=NULL)
                initialPreview: ["{{asset($about->second_div_image)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($about->second_div_image!=NULL)?last(explode('/',$about->second_div_image)):''}}",
                    width: "120px"
                }]
                @endif
            });
            $("#third_div_image",).fileinput({
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
                minImageWidth: 236,
                minImageHeight: 230,
                maxImageWidth: 236,
                maxImageHeight: 230,
                showRemove: true,
                @if(isset($about) && $about->third_div_image!=NULL)
                initialPreview: ["{{asset($about->third_div_image)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($about->third_div_image!=NULL)?last(explode('/',$about->third_div_image)):''}}",
                    width: "120px"
                }]
                @endif
            });
        });
    </script>
@endsection
