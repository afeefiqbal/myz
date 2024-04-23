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
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
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
                            <h3 class="card-title">Contact-Us Page Form</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Title*</label>
                                    <input type="text" name="contact_page_title" id="title" placeholder="Title"
                                           class="form-control " autocomplete="off"
                                           value="{{ !empty($contact)?$contact->contact_page_title:'' }}"
                                           maxlength="230">
                                    <div class="help-block with-errors" id="title_error"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Contact Request Title</label>
                                    <input type="text" name="contact_request_title" id="contact_request_title"
                                           placeholder="Contact Request Title"
                                           class="form-control " autocomplete="off"
                                           value="{{ !empty($contact)?$contact->contact_request_title:'' }}"
                                           maxlength="230">
                                    <div class="help-block with-errors" id="contact_request_title_error"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Address </label>
                                    <textarea name="address" id="address" placeholder="Address"
                                              class="form-control tinyeditor"
                                              autocomplete="off">{{ @$contact->address }}</textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Description</label>
                                    <textarea name="description" id="description" placeholder="description"
                                              class="form-control tinyeditor" autocomplete="off"
                                    >{{ @$contact->description }}</textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Phone Number</label>
                                    <input type="text" name="phone" id="phone"
                                           placeholder="Phone Number" class="form-control" autocomplete="off"
                                           value="{{ !empty($contact)?$contact->phone:'' }}" minlength="7"
                                           maxlength="15">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Alternate Phone Number</label>
                                    <input type="text" name="alternate_phone" id="alternate_phone"
                                           placeholder="Alternate Phone Number" class="form-control"
                                           autocomplete="off"
                                           value="{{ !empty($contact)?$contact->alternate_phone:'' }}" minlength="7"
                                           maxlength="15">
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Whatsapp Number</label>
                                    <input type="text" name="whatsapp_number" id="whatsapp_number"
                                           class="form-control" placeholder="Whatsapp Number"
                                           value="{{ !empty($contact)?$contact->whatsapp_number:'' }}" minlength="7"
                                           maxlength="15">
                                    <div class="help-block with-errors" id="whatsapp_number_error"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="form-group">
                                        <label for="google_review"> Google Review URL</label>
                                        <input type="text" name="google_review_url" id="google_review_url"
                                               class="form-control" placeholder="Google Review URL"
                                               value="{{ !empty($contact)?$contact->google_review:'' }}"></div>
                                    <div class="help-block with-errors" id="google_review_url_error"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Email*</label>
                                    <input type="email" name="email" id="email" class="form-control required"
                                           placeholder="Email"
                                           value="{{ !empty($contact)?$contact->email:'' }}"
                                           maxlength="230">
                                    <div class="help-block with-errors" id="email_error"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Alternate Email</label>
                                    <input type="email" name="alternate_email" id="alternate_email"
                                           class="form-control " placeholder="Alternate Email"
                                           value="{{ !empty($contact)?$contact->alternate_email:'' }}"
                                           maxlength="230">
                                           <div class="help-block with-errors" id="alternate_email_error"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Order Receiving Emails*</label>
                                    <input type="text" name="order_emails" id="order_emails" class="form-control required"
                                           placeholder="Order Receiving Emails"
                                           value="{{ !empty($contact)?$contact->order_emails:'' }}"
                                           maxlength="230">
                                    <div class="help-block with-errors" id="order_emails_error"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Enquiry Receiving Emails *</label>
                                    <input type="text" name="enquiry_emails" id="enquiry_emails"
                                           class="form-control required" placeholder="Enquiry Receiving Emails"
                                           value="{{ !empty($contact)?$contact->enquiry_emails:'' }}"
                                           maxlength="230">
                                           <div class="help-block with-errors" id="enquiry_emails_error"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Email Recipient Name*</label>
                                    <input type="text" name="email_recipient" id="email_recipient"
                                           class="form-control required"
                                           placeholder="Email Recipient Name"
                                           value="{{ !empty($contact)?$contact->email_recipient:'' }}"
                                           maxlength="230">
                                    <div class="help-block with-errors" id="email_recipient_error"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Follow Us Title</label>
                                    <input type="text" name="follow_title" id="follow_title"
                                           class="form-control" placeholder="Follow Us Title"
                                           value="{{ !empty($contact)?$contact->follow_title:'' }}"
                                           maxlength="230">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Facebook</label>
                                    <input type="text" name="facebook_url" id="facebook_url" class="form-control"
                                           placeholder="Facebook"
                                           value="{{ !empty($contact)?$contact->facebook_url:'' }}" maxlength="230">
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Instagram</label>
                                    <input type="text" name="instagram_url" id="instagram_url" class="form-control"
                                           placeholder="Instagram"
                                           value="{{ !empty($contact)?$contact->instagram_url:'' }}"
                                           maxlength="230">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Twitter</label>
                                    <input type="text" name="twitter_url" id="twitter_url" class="form-control"
                                           placeholder="Twitter"
                                           value="{{ !empty($contact)?$contact->twitter_url:'' }}"
                                           maxlength="230">
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Linkedin</label>
                                    <input type="text" name="linkedin_url" id="linkedin_url" class="form-control"
                                           placeholder="Linkedin"
                                           value="{{ !empty($contact)?$contact->linkedin_url:'' }}" maxlength="230">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Youtube</label>
                                    <input type="text" name="youtube_url" id="youtube_url" class="form-control"
                                           placeholder="Youtube"
                                           value="{{ !empty($contact)?$contact->youtube_url:'' }}"
                                           maxlength="230">
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Pinterest</label>
                                    <input type="text" name="pinterest_url" id="pinterest_url" class="form-control"
                                           placeholder="Pinterest"
                                           value="{{ !empty($contact)?$contact->pinterest_url:'' }}"
                                           maxlength="230">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Snapchat</label>
                                    <input type="text" name="snapchat_url" id="snapchat_url" class="form-control"
                                           placeholder="Snapchat"
                                           value="{{ !empty($contact)?$contact->snapchat_url:'' }}" maxlength="230">
                                </div>
                                {{-- <div class="form-group col-md-6">
                                    <label> Career EMail</label>
                                    <input type="email" name="career_email" id="career_email" class="form-control"
                                           placeholder="Career EMail"
                                           value="{{ !empty($contact)?$contact->career_email:'' }}" maxlength="230">
                                </div>
                            </div> --}}
                            {{-- <div class="form-row"> --}}

                                <div class="form-group col-md-6">
                                    <label> Google Map</label>
                                    <input type="text" name="google_map" id="google_map" class="form-control"
                                           placeholder="Google Map"
                                           value="{{ !empty($contact)?$contact->google_map:'' }}">
                                    <span
                                        style='color:green;font-size:14px;'>Note: src from google map iframe</span>
                                </div>
                            </div>

                        {{-- <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Phone Image*</label>
                                <div class="file-loading">
                                    <input id="phone_image" name="phone_image" type="file"  accept="image/png, image/jpg, image/jpeg">
                                </div>
                                <span class="caption_note">Note: Image dimension must be  100 x 100 and Size must be
                                    less than 512 KB</span>
                                @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label> Phone Image Attribute</label>
                                <input type="text" class="form-control placeholder-cls" id="phone_image_attribute"
                                       name="phone_image_attribute" placeholder="Alt='Phone Image Attribute'"
                                       value="{{ isset($contact)?$contact->phone_image_attribute:'' }}">
                                @error('phone_image_attribute')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Address Image*</label>
                                <div class="file-loading">
                                    <input id="address_image" name="address_image" type="file"  accept="image/png, image/jpg, image/jpeg">
                                </div>
                                <span class="caption_note">Note: Image dimension must be  100 x 100 and Size must be
                                    less than 512 KB</span>
                                @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label> Address Image Attribute</label>
                                <input type="text" class="form-control placeholder-cls" id="address_image_attribute"
                                       name="address_image_attribute" placeholder="Alt='Address Image Attribute'"
                                       value="{{ isset($contact)?$contact->banner_image_attribute:'' }}">
                                @error('address_image_attribute')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label> Email Image*</label>
                                <div class="file-loading">
                                    <input id="email_image" name="email_image" type="file"  accept="image/png, image/jpg, image/jpeg">
                                </div>
                                <span class="caption_note">Note: Image dimension must be  100 x 100 and Size must be
                                    less than 512 KB</span>
                                @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label> Email Image Attribute</label>
                                <input type="text" class="form-control placeholder-cls" id="email_image_attribute"
                                       name="email_image_attribute" placeholder="Alt='Email Image Attribute'"
                                       value="{{ isset($contact)?$contact->email_image_attribute:'' }}">
                                @error('email_image_attribute')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="card-footer">
                            <input type="submit" name="btn_save" value="Submit"
                                   class="btn btn-primary pull-left submitBtn">
                            <input type="hidden" name="id" id="id" value="{{ !empty($contact)?$contact->id:'0' }}">
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
            // $("#phone_image",).fileinput({
            //     'theme': 'explorer-fas',
            //     validateInitialCount: true,
            //     overwriteInitial: false,
            //     autoReplace: true,
            //     layoutTemplates: {actionDelete: ''},
            //     removeLabel: "Remove",
            //     initialPreviewAsData: true,
            //     dropZoneEnabled: false,
            //     required: true,
            //     allowedFileTypes: ['image'],
            //     minImageWidth: 100,
            //     minImageHeight: 100,
            //     maxImageWidth: 100,
            //     maxImageHeight: 100,
            //     showRemove: true,
            //     @if(isset($contact) && $contact->phone_image!=NULL)
            //     initialPreview: ["{{asset($contact->phone_image)}}",],
            //     initialPreviewConfig: [{
            //         caption: "{{ ($contact->phone_image!=NULL)?last(explode('/',$contact->phone_image)):''}}",
            //         width: "120px"
            //     }]
            //     @endif
            // });
            // $("#address_image",).fileinput({
            //     'theme': 'explorer-fas',
            //     validateInitialCount: true,
            //     overwriteInitial: false,
            //     autoReplace: true,
            //     layoutTemplates: {actionDelete: ''},
            //     removeLabel: "Remove",
            //     initialPreviewAsData: true,
            //     dropZoneEnabled: false,
            //     required: true,
            //     allowedFileTypes: ['image'],
            //     minImageWidth: 100,
            //     minImageHeight: 100,
            //     maxImageWidth: 100,
            //     maxImageHeight: 100,
            //     showRemove: true,
            //     @if(isset($contact) && $contact->address_image!=NULL)
            //     initialPreview: ["{{asset($contact->address_image)}}",],
            //     initialPreviewConfig: [{
            //         caption: "{{ ($contact->address_image!=NULL)?last(explode('/',$contact->address_image)):''}}",
            //         width: "120px"
            //     }]
            //     @endif
            // });
            // $("#email_image",).fileinput({
            //     'theme': 'explorer-fas',
            //     validateInitialCount: true,
            //     overwriteInitial: false,
            //     autoReplace: true,
            //     layoutTemplates: {actionDelete: ''},
            //     removeLabel: "Remove",
            //     initialPreviewAsData: true,
            //     dropZoneEnabled: false,
            //     required: true,
            //     allowedFileTypes: ['image'],
            //     minImageWidth: 100,
            //     minImageHeight: 100,
            //     maxImageWidth: 100,
            //     maxImageHeight: 100,
            //     showRemove: true,
            //     @if(isset($contact) && $contact->email_image!=NULL)
            //     initialPreview: ["{{asset($contact->email_image)}}",],
            //     initialPreviewConfig: [{
            //         caption: "{{ ($contact->email_image!=NULL)?last(explode('/',$contact->email_image)):''}}",
            //         width: "120px"
            //     }]
            //     @endif
            // });
        });
    </script>
@endsection
