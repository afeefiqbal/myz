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
                <form role="form" id="formWizard" class="form--wizard" enctype="multipart/form-data" method="post">
                    {{csrf_field()}}
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">{{ $key }} Banner - {{ ucfirst($type) }}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Banner*</label>
                                    <div class="file-loading">
                                        <input id="desktop_banner" name="desktop_banner" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image dimension must be 1920 x 340 PX and Size must be less than 512 KB</span>
                                    @error('desktop_banner')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Banner Attribute</label>
                                    <input type="text" class="form-control placeholder-cls" id="banner_attribute"
                                           name="banner_attribute" placeholder="Alt='Banner Attribute'"
                                           value="{{ isset($banner)?$banner->banner_attribute:'' }}">
                                    @error('banner_attribute')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" name="id" id="id" value="{{ isset($banner)?$banner->id:'0' }}">
                                <input type="hidden" name="type" id="type" value="{{ $type }}">
                                <input type="submit" name="btn_save" value="Submit"
                                       class="btn btn-primary pull-left submitBtn">
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
            // $("#desktop_banner").fileinput({
            //     'theme': 'explorer-fas',
            //     validateInitialCount: true,
            //     overwriteInitial: false,
            //     autoReplace: true,
            //     layoutTemplates: {actionDelete: ''},
            //     removeLabel: "Remove",
            //     initialPreviewAsData: true,
            //     dropZoneEnabled: false,
            //     required: true,
            //     showRemove: true,
                
    
                
            //     @if(isset($banner) && $banner->desktop_banner != NULL)
            //     initialPreview: ["{{asset($banner->desktop_banner)}}"],
            //     initialPreviewConfig: [{
            //         caption: "{{ last(explode('/',$banner->desktop_banner))}}",
            //         width: "120px",
            //         key: "{{($banner->desktop_banner)}}",
            //     }]
            //     @endif
            // });
            $("#desktop_banner").fileinput({
            'theme': 'explorer-fas',
            validateInitialCount: true,
            overwriteInitial: false,
            autoReplace: true,
            initialPreviewShowDelete: false,
            initialPreviewAsData: true,
            dropZoneEnabled: false,
            required: false,
            allowedFileTypes: ['image'],
            showRemove: true,
            minImageWidth: 1920,
                minImageHeight: 340,
                maxImageWidth: 1920,
                maxImageHeight: 340,
                maxFileSize: 512,
            @if(isset($banner) && $banner->desktop_banner!=NULL)
                initialPreview: ["{{asset($banner->desktop_banner)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($banner->desktop_banner!=NULL)?last(explode('/',$banner->desktop_banner)):''}}",
                    width: "120px",
                    key: "{{'Banner/desktop_banner/'.$banner->id.'/desktop_banner_webp' }}",
                }],
                @endif
        })
        });
    </script>
@endsection
