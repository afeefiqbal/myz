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
                            <li class="breadcrumb-item">
                                <a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{url(Helper::sitePrefix().'blog')}}">Blog</a></li>
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
                            <h3 class="card-title">Basic Information</h3>
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
                                    <input type="text" name="title" id="title" placeholder="Title"
                                           class="form-control for_canonical_url required" autocomplete="off"
                                           value="{{ isset($blog)?$blog->title:old('title') }}">
                                    <div class="help-block with-errors" id="title_error"></div>
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Short URL*</label>
                                    <input type="text" name="short_url" id="short_url" placeholder="Short URL"
                                           class="form-control required" autocomplete="off"
                                           value="{{ isset($blog)?$blog->short_url:old('short_url') }}">
                                    <div class="help-block with-errors" id="short_url_error"></div>
                                    @error('short_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Author*</label>
                                    <input type="text" name="author" id="author" placeholder="Author"
                                           class="form-control required" autocomplete="off"
                                           value="{{ isset($blog)?$blog->author:old('author') }}">
                                    <div class="help-block with-errors" id="author_error"></div>
                                    @error('author')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Posted Date*</label>
                                    <input type="date" max="2999-12-31" @if(@$blog) @else min="{{date('Y-m-d')}}" @endif name="posted_date" id="posted_date"
                                           placeholder=""
                                           class="form-control required" autocomplete="off"
                                           value="{{ isset($blog)?$blog->posted_date:old('posted_date') }}">
                                    <div class="help-block with-errors" id="posted_date_error"></div>
                                    @error('posted_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="description">Description*</label>
                                    <textarea class="form-control tinyeditor required reset" id="description"
                                              name="description">{!! isset($blog)?$blog->description:old('description')  !!}</textarea>
                                    <div class="help-block with-errors" id="description_error"></div>
                                </div>
                            </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Image*</label>
                                        <div class="file-loading">
                                           <input id="image" name="image" type="file" accept="image/png, image/jpg, image/jpeg">
                                        </div>
                                        <span class="caption_note">Note: Image dimension must be 1162 x 505 PX and Size must be less than 512 KB</span>
                                        @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label> Image Attribute</label>
                                        <input type="text" class="form-control placeholder-cls" id="image_attribute"
                                               name="image_attribute" placeholder="Alt='Banner Attribute'"
                                               value="{{ isset($blog)?$blog->image_attribute:old('image_attribute') }}">
                                        @error('image_attribute')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label> Video Thumbnail Image</label>
                                        <div class="file-loading">
                                            <input id="video_thumbnail" name="video_thumbnail" type="file"
                                            accept="image/png, image/jpg, image/jpeg">
                                        </div>
                                        <span class="caption_note">Note: Image dimension must be 1032 x 448 PX and Size must be less than 512 KB</span>
                                        @error('video_thumbnail')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label> Video Thumbnail Attribute</label>
                                        <input type="text" class="form-control placeholder-cls"
                                               id="video_thumbnail_attribute"
                                               name="video_thumbnail_attribute"
                                               placeholder="Alt='Video Thumbnail Attribute'"
                                               value="{{ isset($blog)?$blog->video_thumbnail_image_attribute:old('video_thumbnail_attribute') }}">
                                        @error('video_thumbnail')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                            <div class="form-row">

                                <div class="form-group col-md-6">
                                    <label> Video URL</label>
                                    <input type="text" name="video_url" id="video_url" placeholder="Video URL"
                                           class="form-control" autocomplete="off" value="{{ isset($blog)?$blog->video_url:old('video_url') }}">
                                </div>
                              

                            </div>
                                <div class="form-row">

                                <div class="form-group col-md-12">
                                    <label for="description">Alternate Description</label>
                                    <textarea class="form-control tinyeditor reset" id="alternate_description"
                                              name="alternate_description">{!! isset($blog)?$blog->alternate_description:old('alternate_description') !!}</textarea>
                                </div>
                            </div>


{{--                                                        <div class="form-row">--}}
                                {{--                                                            <div class="form-group col-md-4">--}}
                                {{--                                                                <label> Banner Title</label>--}}
                                {{--                                                                <input type="text" name="banner_title" id="banner_title"--}}
                                {{--                                                                       placeholder="Banner Title"--}}
                                {{--                                                                       class="form-control" autocomplete="off"--}}
                                {{--                                                                       value="{{ isset($blog)?$blog->banner_title:'' }}">--}}
                                {{--                                                                <div class="help-block with-errors" id="banner_title_error"></div>--}}
                                {{--                                                                @error('banner_title')--}}
                                {{--                                                                <div class="invalid-feedback">{{ $message }}</div>--}}
                                {{--                                                                @enderror--}}
                                {{--                                                            </div>--}}
                                {{--                                                            <div class="form-group col-md-4">--}}
                                {{--                                                                <label> Banner Sub Title</label>--}}
                                {{--                                                                <input type="text" name="banner_sub_title" id="banner_sub_title"--}}
                                {{--                                                                       placeholder="Banner Sub Title"--}}
                                {{--                                                                       class="form-control" autocomplete="off"--}}
                                {{--                                                                       value="{{ isset($blog)?$blog->banner_sub_title:'' }}">--}}
                                {{--                                                                <div class="help-block with-errors" id="banner_sub_title_error"></div>--}}
                                {{--                                                                @error('banner_sub_title')--}}
                                {{--                                                                <div class="invalid-feedback">{{ $message }}</div>--}}
                                {{--                                                                @enderror--}}
                                {{--                                                            </div>--}}
                                {{--                                                            <div class="form-group col-md-4">--}}
                                {{--                                                                <label> Banner Attribute</label>--}}
                                {{--                                                                <input type="text" class="form-control placeholder-cls" id="banner_attribute"--}}
                                {{--                                                                       name="banner_attribute" placeholder="Alt='Banner Attribute'"--}}
                                {{--                                                                       value="{{ isset($blog)?$blog->banner_attribute:'' }}">--}}
                                {{--                                                                @error('banner_attribute')--}}
                                {{--                                                                <div class="invalid-feedback">{{ $message }}</div>--}}
                                {{--                                                                @enderror--}}
                                {{--                                                            </div>--}}
                                {{--                                                        </div>--}}
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label> Desktop Banner</label>
                                                                <div class="file-loading">
                                                                    <input id="desktop_banner" name="desktop_banner" type="file" accept="image/png, image/jpg, image/jpeg">
                                                                </div>
                                                                <span class="caption_note">Note: Image size should be minimum of 1920 x 340</span>
                                                                @error('desktop_banner')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label> Banner Attribute</label>
                                                                <input type="text" class="form-control placeholder-cls" id="banner_attribute"
                                                                       name="banner_attribute" placeholder="Alt='Banner Attribute'"
                                                                       value="{{ isset($blog)?$blog->banner_attribute:old('banner_attribute')}}">
                                                                @error('banner_attribute')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
{{--                                                            <div class="form-group col-md-6">--}}
{{--                                                                <label> Mobile Banner</label>--}}
{{--                                                                <div class="file-loading">--}}
{{--                                                                    <input id="mobile_banner" name="mobile_banner" type="file" accept="image/*">--}}
{{--                                                                </div>--}}
{{--                                                                <span class="caption_note">Note: Image size should be minimum of 960 x 450</span>--}}
{{--                                                                @error('mobile_banner')--}}
{{--                                                                <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                                                                @enderror--}}
{{--                                                            </div>--}}
                                                        </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Meta Title</label>
                                    <textarea class="form-control" id="meta_title" name="meta_title"
                                              placeholder="Meta Title">{{ isset($blog)?$blog->meta_title:old('meta_title') }}</textarea>
                                    @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Meta Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description"
                                              placeholder="Meta Description">{{ isset($blog)?$blog->meta_description:old('meta_description') }}</textarea>
                                    @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Meta Keyword</label>
                                    <textarea class="form-control" id="meta_keyword" name="meta_keyword"
                                              placeholder="Meta Keyword">{{ isset($blog)?$blog->meta_keyword:old('meta_keyword') }}</textarea>
                                    @error('meta_keyword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Other Meta Tag</label>
                                    <textarea class="form-control" id="other_meta_tag" name="other_meta_tag"
                                              placeholder="Other Meta Tag">{{ isset($blog)?$blog->other_meta_tag:old('other_meta_tag') }}</textarea>
                                    @error('other_meta_tag')
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
                minImageWidth: 1162,
                minImageHeight: 505,
                maxImageWidth: 1162,
                maxImageHeight: 505,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($blog) && $blog->image!=NULL)
                initialPreview: ["{{asset($blog->image)}}",],
                initialPreviewConfig: [{
                    caption: "{{last(explode('/',$blog->image))}}",
                    width: "120px"
                }]
                @endif
            });

            $("#video_thumbnail").fileinput({
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
                minImageWidth: 1032,
                minImageHeight: 448,
                maxImageWidth: 1032,
                maxImageHeight: 448,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($blog) && $blog->video_thumbnail_image!=NULL)
                initialPreview: ["{{asset($blog->video_thumbnail_image)}}",],
                initialPreviewConfig: [{
                    caption: "{{ last(explode('/',$blog->video_thumbnail_image))}}",
                    width: "120px"
                }]
                @endif
            });

            $("#desktop_banner").fileinput({
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
                minImageWidth: 1920,
                minImageHeight: 340,
                maxImageWidth: 1920,
                maxImageHeight: 340,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($blog) && $blog->desktop_banner!=NULL)
                initialPreview: ["{{asset($blog->desktop_banner)}}",],
                initialPreviewConfig: [{
                    caption: "{{last(explode('/',$blog->desktop_banner))}}",
                    width: "120px"
                }]
                @endif
            });


            $("#mobile_banner").fileinput({
                'theme': 'explorer-fas',
                validateInitialCount: true,
                overwriteInitial: false,
                autoReplace: true,
                initialPreviewShowDelete: false,
                initialPreviewAsData: true,
                dropZoneEnabled: false,
                required: false,
                allowedFileTypes: ['image'],
                minImageWidth: 960,
                minImageHeight: 450,
                maxImageWidth: 960,
                maxImageHeight: 450,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($blog) && $blog->mobile_banner!=NULL)
                initialPreview: ["{{asset($blog->mobile_banner)}}",],
                initialPreviewConfig: [{
                    caption: "{{ last(explode('/',$blog->mobile_banner))}}",
                    width: "120px"
                }]
                @endif
            });
        });
    </script>
@endsection
