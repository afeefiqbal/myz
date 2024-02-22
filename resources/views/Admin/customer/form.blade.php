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
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'customer')}}">Customer</a>
                            </li>
                            <li class="breadcrumb-item active">{{$title}}</li>
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
                            <h3 class="card-title">Customer Form</h3>
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
                                <div class="form-group col-md-6">
                                    <label> First Name*</label>
                                    <input type="text" name="first_name" id="first_name" placeholder="First Name"
                                           class="form-control required" autocomplete="off" maxlength="60"
                                           value="{{ old('first_name', @$customer->first_name) }}">
                                    <div class="help-block with-errors" id="first_name_error"></div>
                                    @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Last Name</label>
                                    <input type="text" name="last_name" id="last_name" placeholder="Last Name"
                                           class="form-control" autocomplete="off" maxlength="60"
                                           value="{{ old('last_name', @$customer->last_name) }}">
                                    @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group @if ($errors->has('username')) has-error @endIf">
                                        <label> Username*</label>
                                        <input type="text" name="username" id="username" placeholder="Username"
                                               class="form-control required" autocomplete="off"
                                               value="{{ old('last_name', @$customer->user->username) }}">
                                        <div class="help-block with-errors" id="username_error"></div>
                                        @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                @if(!isset($customer))
                                    <div class="col-md-6">
                                        <div class="form-group @if ($errors->has('password')) has-error @endIf">
                                            <label> Password*</label>
                                            <input type="password" name="password" id="password" placeholder="Password"
                                                   class="form-control required" autocomplete="off">
                                            <div class="help-block with-errors" id="password_error"></div>
                                            @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group col-md-6">
                                    <label> Email ID*</label>
                                    <input type="email" name="email" id="email" placeholder="Email ID"
                                           class="form-control required" autocomplete="off" maxlength="70"
                                           value="{{ old('email', @$customer->user->email) }}">
                                    <div class="help-block with-errors" id="email_error"></div>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Phone Number*</label>
                                    <input type="number" name="phone" id="phone"
                                           placeholder="Phone Number" class="form-control required" autocomplete="off"
                                           minlength="7" maxlength="15" value="{{ old('phone', @$customer->user->phone) }}">
                                    <div class="help-block with-errors" id="phone_error"></div>
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Profile Image</label>
                                    <div class="file-loading">
                                        <input id="profile_image" name="profile_image" type="file" accept="image/*">
                                    </div>
                                    <span class="caption_note">Note: Profile image size must be 300x300 px</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Profile Image Attribute</label>
                                    <input type="text" name="image_attribute" id="image_attribute"
                                           placeholder="Alt='Banner Attribute'" class="form-control placeholder-cls"
                                           autocomplete="off"
                                           value="{{ isset($customer)?$customer->user->image_attribute:'' }}">
                                    @error('image_attribute')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
        $(document).ready(function () {
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
                showRemove: true,
                @if(isset($customer) && $customer->user->profile_image!=NULL)
                initialPreview: ["{{asset($customer->user->profile_image)}}",],
                initialPreviewConfig: [{
                    caption: "{{ last(explode('/',$customer->user->profile_image)) }}",
                    width: "120px"
                }]
                @endif
            });
        });
    </script>
@endsection
