@extends('Admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-user-shield"></i> {{$title}} Admin</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'vendor')}}">Vendor
                                    list</a>
                            </li>
                            <li class="breadcrumb-item active">{{$title}} Admin</li>
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
                                <div class="form-group col-md-4">
                                    <label for="name">Name*</label>
                                    <input type="text" class="form-control required" name="name" placeholder="Name"
                                           id="name" value="{{ old('name', @$admin->name) }}" maxlength="32">
                                    <div class="help-block with-errors" id="name_error"></div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="login_email">Email*</label>
                                    <input type="email" name="email" id="login_email" placeholder="Email ID"
                                           class="form-control required" autocomplete="off"
                                           value="{{ old('email',@$admin->user->email) }}">
                                    <div class="help-block with-errors" id="login_email_error"></div>
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="phone">Phone Number</label>
                                    <input type="number" class="form-control required" id="phone"
                                           name="phone" placeholder="Phone Number" minlength="7" maxlength="15"
                                           value="{{ old('phone',@$admin->user->phone) }}">
                                    <div class="help-block with-errors" id="phone_error"></div>
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="phone">Password</label>
                                    <input type="password" class="form-control required" id=""
                                           name="password" placeholder="" minlength="7" maxlength="15"
                                           value="">
                                    <div class="help-block with-errors" id="password_error"></div>
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="profile_image">Profile Image</label>
                                    <div class="file-loading">
                                        <input id="profile_image" name="profile_image" type="file" accept="image/*">
                                    </div>
                                    <span class="caption_note">Note: Image size must be 300x300 px</span>
                                    @error('profile_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="image_attribute"> Profile Image Attribute*</label>
                                    <input type="text" name="image_attribute" id="image_attribute"
                                           required placeholder="Alt='Image Attribute'"
                                           class="form-control required placeholder-cls" autocomplete="off"
                                           value="{{ old('image_attribute',@$admin->image_attribute) }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="address">Address</label>
                                    <textarea class="form-control tinyeditor" name="address" id="address"
                                    >{{ old('more_info',@$admin->address) }}</textarea>
                                    <div class="help-block with-errors" id="address_error"></div>
                                    @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="more_info">About Vendor</label>
                                    <textarea class="form-control tinyeditor" name="more_info" id="more_info"
                                    >{{ old('more_info',@$admin->more_info) }}</textarea>
                                </div>
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
                </form>
            </div>
        </section>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            passwordGenerate();

            $("#profile_image").fileinput({
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
                minImageWidth: 300,
                minImageHeight: 300,
                maxImageWidth: 300,
                maxImageHeight: 300,
                maxFilesize: 512,
                showRemove: true,
                @if(isset($admin) && $admin->user->profile_image!=NULL)
                initialPreview: ["{{asset($admin->user->profile_image)}}",],
                initialPreviewConfig: [{
                    caption: "{{ last(explode('/',$admin->user->profile_image))}}",
                    width: "120px",
                    key: "{{($admin->user->profile_image)}}",
                }]
                @endif
            });
        });
    </script>
@endsection
