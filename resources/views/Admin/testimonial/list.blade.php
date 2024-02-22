@extends('Admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-user-shield"></i> Manage Testimonial</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Testimonial Feature</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
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
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Heading Form</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <form role="form" id="formWizard" action="{{ url('/admin/home-heading') }}"
                                  class="form--wizard" enctype="multipart/form-data" method="post">
                                {{csrf_field()}}
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="homeTitle">Title*</label>
                                            <input type="text" class="form-control required" id="homeTitle"
                                                   name="homeTitle"
                                                   placeholder="Title"
                                                   value="{{ old('homeTitle', @$home_heading->title)}}">
                                            <div class="help-block with-errors" id="homeTitle_error"></div>
                                            @error('homeTitle')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="image"> Image*</label>
                                            <div class="file-loading">
                                                 <input id="image" name="image" type="file" accept="image/png, image/jpg, image/jpeg">
                                            </div>
                                            <span class="caption_note">Note: Image dimension must be 890 x 660 px
                                            and Size must be less than 512 KB</span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="image_attribute"> Image Attribute*</label>
                                            <input type="text" class="form-control required placeholder-cls"
                                                   id="image_attribute" name="image_attribute"
                                                   placeholder="Alt='Image Attribute'"
                                                   value="{{ isset($home_heading)?$home_heading->image_attribute:'' }}">
                                            <div class="help-block with-errors" id="image_attribute_error"></div>
                                            @error('image_attribute')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <input name="type" type="hidden" value="testimonial">
                                    <input type="submit" name="btn_save" value="Submit"
                                           class="btn btn-primary pull-left submitBtn">
                                    <button type="reset" class="btn btn-default">Cancel</button>
                                    <img class="animation__shake loadingImg"
                                         src="{{asset('backend/dist/img/loading.gif')}}"
                                         style="display:none;">
                                </div>
                            </form>
                        </div>
                        <div class="card card-success card-outline">
                            <div class="card-header">
                                <a href="{{url(Helper::sitePrefix().'testimonial/create')}}"
                                   class="btn btn-success pull-right">Add Testimonial <i
                                        class="fa fa-plus-circle pull-right mt-1 ml-2"></i></a>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover dataTable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Highlight</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th class="not-sortable">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($testimonialList as $testimonial)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $testimonial->name }}</td>
                                            <td>{{ $testimonial->designation ?? '-NA-' }}</td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" class="bool_status"
                                                           data-url='change-bool-status' data-table="Testimonial"
                                                           data-id="{{$testimonial->id}}" data-field="highlight"
                                                        {{($testimonial->highlight == "Yes")?'checked':''}}>
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" class="status_check"
                                                           data-url="/status-change" data-table="Testimonial"
                                                           data-field="status" data-pk="{{ $testimonial->id}}"
                                                        {{($testimonial->status=="Active")?'checked':''}}>
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td>{{ date("d-M-Y", strtotime($testimonial->created_at)) }}</td>
                                            <td class="text-right py-0 align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{url(Helper::sitePrefix().'testimonial/edit/'.$testimonial->id)}}"
                                                       class="btn btn-success mr-2 tooltips" title="Edit Testimonial"><i
                                                            class="fas fa-edit"></i></a>
                                                    <a href="#" class="btn btn-danger mr-2 delete_entry tooltips"
                                                       title="Delete Testimonial" data-url="testimonial/delete"
                                                       data-id="{{$testimonial->id}}"><i class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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
                minImageWidth: 890,
                minImageHeight: 660,
                maxImageWidth: 890,
                maxImageHeight: 660,
                showRemove: false,
                @if(isset($home_heading) && $home_heading->image!=NULL)
                initialPreview: ["{{asset($home_heading->image)}}"],
                initialPreviewConfig: [{
                    caption: "{{ last(explode('/',$home_heading->image)) }}",
                    width: "120px"
                }]
                @endif
            });
        });
    </script>
@endsection
