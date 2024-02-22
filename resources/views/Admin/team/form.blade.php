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
                        <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'team')}}">Team</a></li>
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
                        <h3 class="card-title">Team Form</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
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
                            <div class="form-group col-md-12">
                                <label> Name*</label>
                                <input type="text" name="name" id="name" placeholder="Name" class="form-control for_canonical_url required " autocomplete="off"  value="{{ isset($team)?$team->name:'' }}" maxlength="230">
                                <div class="help-block with-errors" id="name_error"></div>
                            </div>
                        </div>

                        <div class="form-row">

{{--                            <div class="form-group col-md-6">--}}
{{--                                <label> Department*</label>--}}
{{--                                <select name="department" id="department" class="form-control required">--}}
{{--                                <option value="">Select Department</option>--}}
{{--                                @foreach($departments as $department)--}}
{{--                                <option value="{{$department->id}}"  {{ isset($team)?($team->department_id==$department->id?'selected':''):'' }}>{{$department->title}}</option>--}}
{{--                                @endforeach--}}
{{--                                </select>--}}
{{--                                <div class="help-block with-errors" id="department_error"></div>--}}
{{--                            </div>--}}

                            <div class="form-group col-md-6">
                                <label> Short URL*</label>
                                <input type="text" name="short_url" id="short_url" placeholder="Short URL"
                                       class="form-control required" autocomplete="off"
                                       value="{{ @$team->short_url }}">
                                <div class="help-block with-errors" id="short_url_error"></div>
                                @error('short_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label> Designation*</label>
                                <select name="designation" id="designation" class="form-control required">
                                <option value="">Select Designation</option>
                                @foreach($designations as $designation)
                                <option value="{{$designation->id}}"  {{ isset($team)?($team->designation_id==$designation->id?'selected':''):'' }}>{{$designation->title}}</option>
                                @endforeach
                                </select>
                                <div class="help-block with-errors" id="designation_error"></div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label> Image*</label>
                                <div class="file-loading">
                                     <input id="image" name="image" type="file" accept="image/png, image/jpg, image/jpeg">
                                </div>
                                <span class="caption_note">Note: Image dimension must be 830 x 830 PX and Size must be less than 512 KB</span>
                            </div>
                            <div class="form-group col-md-6">
                                <label> Image Attribute </label>
                                <input type="text" class="form-control  placeholder-cls" id="image_attribute" name="image_attribute" placeholder="Alt='Banner Attribute'" value="{{ isset($team)?$team->image_attribute:'' }}" maxlength="230">
                            </div>
                        </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="description">Description</label>
                                    <textarea class="form-control tinyeditor reset" id="description"
                                              name="description">{!! isset($team)?$team->description:'' !!}</textarea>
                                    <div class="help-block with-errors" id="description_error"></div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Meta Title</label>
                                    <textarea class="form-control" id="meta_title" name="meta_title"
                                              placeholder="Meta Title">{{ isset($team)?$team->meta_title:'' }}</textarea>
                                    @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Meta Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description"
                                              placeholder="Meta Description">{{ isset($team)?$team->meta_description:'' }}</textarea>
                                    @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Meta Keyword</label>
                                    <textarea class="form-control" id="meta_keyword" name="meta_keyword"
                                              placeholder="Meta Keyword">{{ isset($team)?$team->meta_keyword:'' }}</textarea>
                                    @error('meta_keyword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Other Meta Tag</label>
                                    <textarea class="form-control" id="other_meta_tag" name="other_meta_tag"
                                              placeholder="Other Meta Tag">{{ isset($team)?$team->other_meta_tag:'' }}</textarea>
                                    @error('other_meta_tag')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                    </div>
                    <div class="card-footer">
                        <input type="submit" id="btn_save" name="btn_save" data-id="{{isset($team)?$team->id:''}}"value="Submit" class="btn btn-primary pull-left submitBtn">
                        <button type="reset" class="btn btn-default">Cancel</button>
                        <input type="hidden" name="id" id="id" value="{{ isset($team)?$team->id:'0' }}">
                        <img class="animation__shake loadingImg" src="{{url('backend/dist/img/loading.gif')}}" style="display:none;">
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
<script type="text/javascript">
$(document).ready(function(){
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
        minImageHeight: 830,
        maxImageWidth: 830,
        maxImageHeight: 830,
        maxFileSize: 512,
        showRemove: true,
        @if(isset($team) && $team->image!=NULL)
            initialPreview: [
                "{{asset($team->image)}}",
            ],
            initialPreviewConfig: [
                {caption: "{{ ($team->image!=NULL)?$team->name:'';}}", width: "120px"}
            ]
        @endif
    });

});
</script>
@endsection
