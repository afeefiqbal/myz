@extends('Admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-user-shield"></i> {{ $title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url(Helper::sitePrefix() . 'dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ url(Helper::sitePrefix() . 'currency') }}">Currency</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <form role="form" id="formWizard" class="form--wizard" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Currency Form</h3>
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
                                    <label for="title"> Currency*</label>
                                    <input type="text" name="title" id="title" placeholder="Currency"
                                        class="form-control required" autocomplete="off"
                                        value="{{ isset($currency) ? $currency->title : '' }}">
                                    <div class="help-block with-errors" id="title_error"></div>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="code"> Code*</label>
                                    <input type="text" name="code" id="code" placeholder="Currency Code"
                                        class="form-control required" autocomplete="off"
                                        value="{{ isset($currency) ? $currency->code : '' }}">
                                    <div class="help-block with-errors" id="code_error"></div>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="symbol"> Symbol</label>
                                    <input type="text" name="symbol" id="symbol" placeholder="Currency Symbol"
                                        class="form-control" autocomplete="off"
                                        value="{{ isset($currency) ? $currency->symbol : '' }}">
                                    @error('symbol')
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
                                    <span class="caption_note">Note: Image size must be 25 x 25px</span>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Image Attribute</label>
                                    <input type="text" class="form-control placeholder-cls" id="image_attribute"
                                        name="image_attribute" placeholder="Alt='Image Attribute'"
                                        value="{{ isset($currency) ? $currency->image_attribute : '' }}">
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
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
   
    <script type="text/javascript">
        $(document).ready(function() {
            $("#image").fileinput({
                'theme': 'explorer-fas',
                validateInitialCount: true,
                overwriteInitial: false,
                autoReplace: true,
                layoutTemplates: {
                    actionDelete: ''
                },
                removeLabel: "Remove",
                initialPreviewAsData: true,
                dropZoneEnabled: false,
                required: false,
                allowedFileTypes: ['image'],
                minImageWidth: 25,
                minImageHeight: 25,
                maxImageWidth: 25,
                maxImageHeight: 25,
                maxFileSize: 512,
                showRemove: true,
                @if (isset($currency) && $currency->image != null)
                    initialPreview: ["{{ asset($currency->image) }}", ],
                    initialPreviewConfig: [{
                        caption: "{{ $currency->image != null ? last(explode('/', $currency->image)) : '' }}",
                        width: "120px"
                    }]
                @endif
            });

        });
    </script>
@endsection
