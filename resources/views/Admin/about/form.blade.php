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
                                <div class="form-group col-md-6">
                                    <label> Description*</label>
                                    <textarea name="description" id="description"
                                              class="form-control required tinyeditor" placeholder="Description"
                                    >{{ old('description', isset($about)?$about->description:'') }}</textarea>
                                    <div class="help-block with-errors" id="description_error"></div>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- <div class="form-row"> --}}
                                    <div class="form-group col-md-6">
                                        <label> Alternative Description</label>
                                        <textarea name="alternative_description" id="alternative_description"
                                                  class="form-control  tinyeditor" placeholder="Description"
                                        >{{ old('alternative_description', isset($about)?$about->alternative_description:'') }}</textarea>
                                        <div class="help-block with-errors" id="altenative_description_error"></div>
                                        @error('alternative_description')
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
                                    <span class="caption_note">Note: Image dimension must be  650 x 680 and Size must be
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
                                    <label>Banner Image*</label>
                                    <div class="file-loading">
                                       <input id="banner_image" name="banner_image" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image dimension must be  1920 x 600 and Size must be
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
                            {{-- <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Story Title</label>
                                    <input type="text" name="story_title" id="story_title" placeholder="Story Title"
                                           class="form-control " autocomplete="off"
                                           value="{{ old('story_title', isset($about)?$about->story_title:'') }}">
                                    <div class="help-block with-errors" id="title_error"></div>
                                    @error('story_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                            {{-- <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Story Description</label>
                                    <textarea name="story_description" id="story_description"
                                              class="form-control tinyeditor" placeholder="Story Description"
                                    >{{ old('story_description', isset($about)?$about->story_description:'') }}</textarea>
                                    @error('story_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
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
                minImageWidth: 650,
                minImageHeight: 680,
                maxImageWidth: 650,
                maxImageHeight: 680,
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
                minImageWidth: 1920,
                minImageHeight: 600,
                maxImageWidth: 1920,
                maxImageHeight: 600,
                showRemove: true,
                @if(isset($about) && $about->banner_image!=NULL)
                initialPreview: ["{{asset($about->banner_image)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($about->banner_image!=NULL)?last(explode('/',$about->banner_image)):''}}",
                    width: "120px"
                }]
                @endif
            });
        });
    </script>
@endsection
