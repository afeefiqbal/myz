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
                                <a href="{{url(Helper::sitePrefix().'service')}}">Service</a></li>
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
                                           value="{{ @$service->title }}">
                                    <div class="help-block with-errors" id="title_error"></div>
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Short URL*</label>
                                    <input type="text" name="short_url" id="short_url" placeholder="Short URL"
                                           class="form-control required" autocomplete="off"
                                           value="{{ @$service->short_url }}">
                                    <div class="help-block with-errors" id="short_url_error"></div>
                                    @error('short_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label> Service</label>
                                    <select name="service" id="service"
                                            class="form-control select2">
                                        <option value="">Select Service</option>
                                        @foreach($services as $sub)
                                            <option
                                                value="{{ $sub->id }}" {{ (@$sub->id==@$service->service_id)?'selected':'' }}>{{ $sub->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="service_error"></div>
                                    @error('$service')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>


                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="list_description">Short Description</label>
                                        <textarea class="form-control tinyeditor reset" id="list_description"
                                                  name="short_description">{!! isset($service)?$service->short_description:'' !!}</textarea>
                                        <div class="help-block with-errors" id="list_description_error"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="description">Description</label>
                                        <textarea class="form-control tinyeditor  reset" id="description"
                                                  name="description">{!! isset($service)?$service->description:'' !!}</textarea>
                                        <div class="help-block with-errors" id="description_error"></div>
                                    </div>
                                </div>



                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="description">Alternate Description</label>
                                        <textarea class="form-control tinyeditor  reset" id="alternate_description"
                                                  name="alternate_description">{!! isset($service)?$service->alternate_description:'' !!}</textarea>
                                        <div class="help-block with-errors" id="alternate_description_error"></div>
                                    </div>
                                </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Image*</label>
                                    <div class="file-loading">
                                       <input id="image" name="image" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image dimension must be 792 x 505 PX and Size must be less than 512 KB</span>
                                    @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Image Attribute</label>
                                    <input type="text" class="form-control placeholder-cls" id="image_attribute"
                                           name="image_attribute" placeholder="Alt='Banner Attribute'"
                                           value="{{ isset($service)?$service->image_attribute:'' }}">
                                    @error('image_attribute')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Banner Image</label>
                                        <div class="file-loading">
                                           <input id="banner_image" name="banner_image" type="file" accept="image/png, image/jpg, image/jpeg">
                                        </div>
                                        <span class="caption_note">Note: Image dimension must be 1920 x 340 PX and Size must be less than 512 KB</span>
                                        @error('banner_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Banner Image Attribute</label>
                                        <input type="text" class="form-control placeholder-cls" id="banner_image_attribute"
                                               name="banner_image_attribute" placeholder="Alt='Banner Attribute'"
                                               value="{{ isset($service)?$service->banner_attribute:'' }}">
                                        @error('banner_image_attribute')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>




                                <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Meta Title</label>
                                    <textarea class="form-control" id="meta_title" name="meta_title"
                                              placeholder="Meta Title">{{ isset($service)?$service->meta_title:'' }}</textarea>
                                    @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Meta Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description"
                                              placeholder="Meta Description">{{ isset($service)?$service->meta_description:'' }}</textarea>
                                    @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Meta Keyword</label>
                                    <textarea class="form-control" id="meta_keyword" name="meta_keyword"
                                              placeholder="Meta Keyword">{{ isset($service)?$service->meta_keyword:'' }}</textarea>
                                    @error('meta_keyword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Other Meta Tag</label>
                                    <textarea class="form-control" id="other_meta_tag" name="other_meta_tag"
                                              placeholder="Other Meta Tag">{{ isset($service)?$service->other_meta_tag:'' }}</textarea>
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
                minImageWidth: 792,
                minImageHeight: 505,
                maxImageWidth: 792,
                maxImageHeight: 505,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($service) && $service->image!=NULL)
                initialPreview: ["{{asset($service->image)}}",],
                initialPreviewConfig: [{
                    caption: "{{last(explode('/',$service->image))}}",
                    width: "120px"
                }]
                @endif
            });

            $("#banner_image").fileinput({
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
                minImageHeight: 340,
                maxImageWidth: 1920,
                maxImageHeight: 340,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($service) && $service->desktop_banner!=NULL)
                initialPreview: ["{{asset($service->desktop_banner)}}",],
                initialPreviewConfig: [{
                    caption: "{{last(explode('/',$service->desktop_banner))}}",
                    width: "120px"
                }]
                @endif
            });


        });
    </script>
@endsection
