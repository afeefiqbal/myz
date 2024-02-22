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
                            <h3 class="card-title">{{ $key }} Advertisement - {{ ucfirst($type) }}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Title*</label>
                                    <input type="text" class="form-control required" name="title" placeholder="Title"
                                           id="title" value="{{ isset($advertisement)?$advertisement->title:'' }}"
                                           maxlength="230">
                                    <div class="help-block with-errors" id="title_error"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">URL</label>
                                    <input type="text" class="form-control" name="url" placeholder="URL" id="url"
                                           value="{{ isset($advertisement)?$advertisement->url:'' }}" maxlength="230">
                                    <div class="help-block with-errors" id="title_error"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Image*</label>
                                    <div class="file-loading">
                                         <input id="image" name="image" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span
                                        class="caption_note">Note: Image size must be {{$imageDimension['width']}} X {{$imageDimension['height']}}</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="image_attribute">Image Attribute*</label>
                                    <input type="text" name="image_attribute" id="image_attribute"
                                           placeholder="alt='alt Image'" class="form-control required placeholder-cls"
                                           autocomplete="off"
                                           value="{{ isset($advertisement)?$advertisement->image_attribute:'' }}"
                                           maxlength="230">
                                    <div class="help-block with-errors" id="image_attribute_error"></div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <input type="hidden" name="id" id="id"
                                   value="{{ isset($advertisement)?$advertisement->id:'0' }}">
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
                showRemove: true,
                minImageWidth: {{$imageDimension['width']}},
                minImageHeight: {{$imageDimension['height']}},
                maxImageWidth: {{$imageDimension['width']}},
                maxImageHeight: {{$imageDimension['height']}},
                maxFileSize: 512,
                @if(isset($advertisement) && $advertisement->image != NULL)
                initialPreview: ["{{asset($advertisement->image)}}"],
                initialPreviewConfig: [{
                    caption: "{{ last(explode('/',$advertisement->image))}}",
                    width: "120px",
                    key: "{{($advertisement->image)}}",
                }]
                @endif
            });
        });
    </script>
@endsection
