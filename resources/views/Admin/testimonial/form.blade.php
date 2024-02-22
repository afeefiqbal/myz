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
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'home/testimonial')}}">
                                    Testimonial</a></li>
                            <li class="breadcrumb-item active">{{$title}}</li>
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
                <form role="form" id="formWizard" class="form--wizard" enctype="multipart/form-data" method="post">
                    {{csrf_field()}}
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Testimonial Form</h3>
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
                                    <label for="name"> Name*</label>
                                    <input type="text" name="name" id="name" placeholder="Name"
                                           class="form-control required" autocomplete="off"
                                           value="{{ old('name',isset($testimonial)?$testimonial->name:'') }}">
                                    <div class="help-block with-errors" id="name_error"></div>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="designation"> Designation</label>
                                    <input type="text" name="designation" id="designation" placeholder="Designation"
                                           class="form-control" autocomplete="off"
                                           value="{{ old('designation',isset($testimonial)?$testimonial->designation:'') }}">
                                    @error('designation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="rating"> Rating *</label>
                                    <select class="form-control required" name="rating" id="rating">
                                        <option value="">Select Rating</option>
                                        @foreach([1,2,3,4,5] AS $rating)
                                            <option value="{{ $rating }}"
                                                {{ (old("rating", @$testimonial->rating) == $rating)? "selected" : "" }}>
                                                {{ $rating }}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="rating_error"></div>
                                    @error('rating')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Review Type*</label>
                                    <select class="form-control required" name="review_type" id="review_type">
                                        @foreach(["Normal", "Google", "Facebook", "Instagram"] AS $review_type)
                                            <option value="{{ $review_type }}"
                                                {{ (old("review_type", @$testimonial->review_type) == $review_type)? "selected" : "" }}>
                                                {{ $review_type }}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="review_type_error"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="message">Message*</label>
                                    <textarea class="form-control tinyeditor required reset" id="message"
                                              name="message">{!! old('message',isset($testimonial)?$testimonial->message:'') !!}</textarea>
                                    <div class="help-block with-errors" id="message_error"></div>
                                </div>
                            </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="image"> Image*</label>
                                <div class="file-loading">
                                     <input id="image" name="image" type="file" accept="image/png, image/jpg, image/jpeg">
                                </div>
                                <span class="caption_note">Note: Image dimension must be 200 x 200 px
                                and Size must be less than 512 KB</span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="image_attribute"> Image Attribute*</label>
                                <input type="text" class="form-control required placeholder-cls"
                                        id="image_attribute" name="image_attribute"
                                        placeholder="Alt='Image Attribute'"
                                        value="{{ isset($testimonial)?$testimonial->image_attribute:'' }}">
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
                minImageWidth: 200,
                minImageHeight: 200,
                maxImageWidth: 200,
                maxImageHeight: 200,
                showRemove: false,
                @if(isset($testimonial) && $testimonial->image!=NULL)
                initialPreview: ["{{asset($testimonial->image)}}"],
                initialPreviewConfig: [{
                    caption: "{{ last(explode('/',$testimonial->image)) }}",
                    width: "120px"
                }]
                @endif
            });
        });
    </script>
@endsection
