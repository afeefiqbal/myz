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
                                           value="{{ @$event->title }}">
                                    <div class="help-block with-errors" id="title_error"></div>
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Event Type*</label>
                                    <select name="event_type" id="event_type"
                                            class="form-control required select2">
                                        <option value="">Select Event Type</option>
                                        @foreach($eventTypes as $type)
                                            <option
                                                value="{{ $type->id }}" {{ (@$type->id==@$event->event_type_id)?'selected':'' }}>{{ $type->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="event_type_error"></div>
                                    @error('event_type')
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
                                    <span class="caption_note">Note: Image dimension must be 458 x 320 PX and Size must be less than 512 KB</span>
                                    @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Image Attribute</label>
                                    <input type="text" class="form-control placeholder-cls" id="image_attribute"
                                           name="image_attribute" placeholder="Alt='Banner Attribute'"
                                           value="{{ isset($event)?$event->image_attribute:'' }}">
                                    @error('image_attribute')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>



                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label> Location*</label>
                                        <input type="text" name="location" id="location" placeholder="Location"
                                               class="form-control required" autocomplete="off"
                                               value="{{ @$event->location }}">
                                        <div class="help-block with-errors" id="location_error"></div>
                                        @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label> Event Date*</label>
                                        <input type="date" max="2999-12-31" name="event_date" id="event_date"
                                               placeholder=""
                                               class="form-control required" autocomplete="off"
                                               value="{{ @$event->event_date }}">
                                        <div class="help-block with-errors" id="event_date_error"></div>
                                        @error('event_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="start_time">Start Time*</label>
                                        <input type="time" name="start_time"
                                               class="form-control required @error('start_time') is-invalid @enderror"
                                               id="start_time"
                                               value="{{ old('start_time', @$event? date("H:i", strtotime($event->start_time)):'') }}"
                                               placeholder="{{__('Start Time')}}">
                                        <div class="help-block with-errors" id="start_time_error"></div>

                                        @error('start_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="end_time">End Time*</label>
                                        <input type="time" name="end_time"
                                               class="form-control required @error('end_time') is-invalid @enderror"
                                               id="end_time"
                                               value="{{ old('end_time', @$event? date("H:i", strtotime($event->end_time)):'') }}"
                                               placeholder="{{__('End Time')}}">
                                        <div class="help-block with-errors" id="end_time_error"></div>

                                        @error('end_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label> Google Map URL</label>
                                        <input type="text" class="form-control" id="google_map_url"
                                               name="google_map_url" placeholder="Google Map URL"
                                               value="{{ isset($event)?$event->google_map_url:'' }}">
                                        @error('google_map_url')
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
                minImageWidth: 458,
                minImageHeight: 320,
                maxImageWidth: 458,
                maxImageHeight: 320,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($event) && $event->image!=NULL)
                initialPreview: ["{{asset($event->image)}}",],
                initialPreviewConfig: [{
                    caption: "{{last(explode('/',$event->image))}}",
                    width: "120px"
                }]
                @endif
            });


        });
    </script>
@endsection
