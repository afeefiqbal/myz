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
                            <li class="breadcrumb-item">
                                <a href="{{url(Helper::sitePrefix().'offer-strip')}}">Offer Strip</a>
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
                            <h3 class="card-title">Offer Strip Form</h3>
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
                                <div class="form-group col-md-4">
                                    <label> Banner Title*</label>
                                    <input type="text" name="banner_title" id="banner_title"
                                           placeholder="Banner Title"
                                           class="form-control required" autocomplete="off"
                                           value="{{ old("banner_title", @$offer_strip->banner_title) }}">
                                    <div class="help-block with-errors" id="banner_title_error"></div>
                                    @error('banner_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Banner Sub Title*</label>
                                    <input type="text" name="banner_sub_title" id="banner_sub_title"
                                           placeholder="Banner Sub Title"
                                           class="form-control required" autocomplete="off"
                                           value="{{ old("banner_sub_title", @$offer_strip->banner_sub_title) }}">
                                    <div class="help-block with-errors" id="banner_sub_title_error"></div>
                                    @error('banner_sub_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Banner Attribute</label>
                                    <input type="text" class="form-control placeholder-cls" id="banner_attribute"
                                           name="banner_attribute" placeholder="Alt='Banner Attribute'"
                                           value="{{ old("banner_attribute", @$offer_strip->banner_attribute) }}">
                                    @error('banner_attribute')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Desktop Banner*</label>
                                    <div class="file-loading">
                                        <input id="desktop_banner" name="desktop_banner" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image size should be minimum of 1920 x 340</span>
                                    @error('desktop_banner')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Mobile Banner*</label>
                                    <div class="file-loading">
                                        <input id="mobile_banner" name="mobile_banner" type="file" accept="image/*">
                                    </div>
                                    <span class="caption_note">Note: Image size should be minimum of 960 x 450</span>
                                    @error('mobile_banner')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Timer Enabled*</label>
                                    <select class="form-control" name="is_timer_available" id="is_timer_available">
                                        @foreach(["Yes", "No"] AS $timer_value)
                                            <option value="{{ $timer_value }}"
                                                {{ old("is_timer_available", @$offer_strip->is_timer_available) == $timer_value ? "selected" : "" }}
                                            >{{ $timer_value }}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="is_timer_available_error"></div>
                                    @error('is_timer_available')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6 timerEnabled"
                                     style="display:{{(@$offer_strip->is_timer_available=='No')?'none':'block'}}">
                                    <label for="date">Date*</label>
                                    <input type="date" max="2999-12-31" class="form-control required" name="date"
                                           id="date"
                                           value="{{ old("date", @$offer_strip->date)}}">
                                    <div class="help-block with-errors" id="date_error"></div>
                                    @error('date')
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
            $("#desktop_banner").fileinput({
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
                showRemove: true,
                @if(isset($offer_strip) && $offer_strip->desktop_banner!=NULL)
                initialPreview: ["{{asset($offer_strip->desktop_banner)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($offer_strip->desktop_banner!=NULL)?last(explode('/',$offer_strip->desktop_banner)):''}}",
                    width: "120px"
                }]
                @endif
            });
            $("#mobile_banner").fileinput({
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
                minImageWidth: 960,
                minImageHeight: 450,
                maxImageWidth: 960,
                maxImageHeight: 450,
                showRemove: true,
                @if(isset($offer_strip) && $offer_strip->mobile_banner!=NULL)
                initialPreview: ["{{asset($offer_strip->mobile_banner)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($offer_strip->mobile_banner!=NULL)?last(explode('/',$offer_strip->mobile_banner)):''}}",
                    width: "120px"
                }]
                @endif
            });
        });
    </script>
@endsection
