@extends('Admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-user-shield"></i> {{$title}} </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">{{$title}} </li>
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
                <form role="form" id="formWizard" class="form--wizard" enctype="multipart/form-data"method="post">
                    {{csrf_field()}}
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Banner Form</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
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
                                    <label for="title">Title</label>
                                    <input type="text" class="required form-control" name="title" id="title" placeholder="Title" class="form-control" autocomplete="off" value="{{ isset($collect)?$collect->title:'' }}" maxlength="230">
                                    <div class="help-block with-errors" id="title_error"></div>
                                </div>

                                

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="description">Description*</label>
                                    <textarea class="form-control tinyeditor required reset" id="description"
                                              name="description">{!! @$collect->description !!}</textarea>
                                    <div class="help-block with-errors" id="description_error"></div>
                                </div>
                            </div>
                            <div class="form-row" id="slider-div" style="display: {{@$banner->banner_type=='video'?'none':''}}">
                                <div class="form-group col-md-6">
                                    <label>First Image</label>
                                    <div class="file-loading">
                                         <input id="image" name="image" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: Image dimension must be 450 x 600 PX and Size must be less than 512 KB</span>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label> Image Attribute</label>
                                    <input type="text" class="form-control placeholder-cls required" id="image_attribute"
                                           name="image_attribute" placeholder="Alt='Image Attribute'"
                                           value="{{ isset($collect)?$collect->image_attribute:'' }}">
                                           <div class="help-block with-errors" id="image_attribute_error"></div>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="title">Title</label>
                                    <input type="text" class="required form-control" name="title1" id="title1" placeholder="Title" class="form-control" autocomplete="off" value="{{ isset($collect)?$collect->title1:'' }}" maxlength="230">
                                    <div class="help-block with-errors" id="title1_error"></div>
                                </div>

                                

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="description">Description*</label>
                                    <textarea class="form-control tinyeditor required reset" id="description1"
                                              name="description1">{!! @$collect->description1 !!}</textarea>
                                    <div class="help-block with-errors" id="description1_error"></div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="title">shorturl</label>
                                    <input type="text" class="required form-control" name="shorturl1" id="shorturl1" placeholder="Title" class="form-control" autocomplete="off" value="{{ isset($collect)?$collect->short_url1:'' }}" maxlength="230">
                                    <div class="help-block with-errors" id="shorturl1_error"></div>
                                </div>

                                

                            </div>
                            <div class="form-row" id="slider-div" style="display: {{@$banner->banner_type=='video'?'none':''}}">
                                <div class="form-group col-md-6">
                                    <label>Second Image</label>
                                    <div class="file-loading">
                                        <input id="image1" name="image1" type="file" accept="image/*">
                                    </div>
                                    <span class="caption_note">Note: Image dimension must be 958 x 600 PX and Size must be less than 512 KB</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Second Image Attribute</label>
                                    <input type="text" class="form-control placeholder-cls required" id="image_attribute2"
                                           name="image_attribute2" placeholder="Alt='Image Attribute'"
                                           value="{{ isset($collect)?$collect->image_attribute2:'' }}">
                                           <div class="help-block with-errors" id="image_attribute2_error"></div>
                                </div>
                             <input type="hidden" value="{!! @$collect->id !!}" name="id" >

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="title">Title</label>
                                    <input type="text" class="required form-control" name="title2" id="title2" placeholder="Title" class="form-control" autocomplete="off" value="{{ isset($collect)?$collect->title2:'' }}" maxlength="230">
                                    <div class="help-block with-errors" id="title2_error"></div>
                                </div>

                                

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="description">Description*</label>
                                    <textarea class="form-control tinyeditor required reset" id="description2"
                                              name="description2">{!! @$collect->description3 !!}</textarea>
                                    <div class="help-block with-errors" id="description2_error"></div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="title">shorturl</label>
                                    <input type="text" class="required form-control" name="shorturl2" id="shorturl2" placeholder="Title" class="form-control" autocomplete="off" value="{{ isset($collect)?$collect->short_url2:'' }}" maxlength="230">
                                    <div class="help-block with-errors" id="shorturl2_error"></div>
                                </div>

                                

                            </div>
                            <div class="form-row" id="slider-div" style="display: {{@$banner->banner_type=='video'?'none':''}}">
                                <div class="form-group col-md-6">
                                    <label>Third Image</label>
                                    <div class="file-loading">
                                        <input id="image2" name="image2" type="file" accept="image/*">
                                    </div>
                                    <span class="caption_note">Note: Image dimension must be 450 x 600 PX and Size must be less than 512 KB</span>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Third  Image Attribute</label>
                                    <input type="text" class="form-control placeholder-cls required" id="image_attribute3"
                                           name="image_attribute3" placeholder="Alt='Image Attribute'"
                                           value="{{ isset($collect)?$collect->image_attribute3:'' }}">
                                           <div class="help-block with-errors" id="image_attribute3_error"></div>
                                           
                                </div>
                              

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="title">Title</label>
                                    <input type="text" class="required form-control" name="title3" id="title3" placeholder="Title" class="form-control" autocomplete="off" value="{{ isset($collect)?$collect->title3:'' }}" maxlength="230">
                                    <div class="help-block with-errors" id="title3_error"></div>
                                </div>

                                

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="description">Description*</label>
                                    <textarea class="form-control tinyeditor required reset" id="description3"
                                              name="description3">{!! @$collect->description3 !!}</textarea>
                                    <div class="help-block with-errors" id="description3_error"></div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="title">shorturl</label>
                                    <input type="text" class="required form-control" name="shorturl3" id="shorturl3" placeholder="Title" class="form-control" autocomplete="off" value="{{ isset($collect)?$collect->short_url3:'' }}" maxlength="230">
                                    <div class="help-block with-errors" id="shorturl3_error"></div>
                                </div>

                                

                            </div>
                            <div class="form-row" id="slider-div" style="display: {{@$banner->banner_type=='video'?'none':''}}">
                                <div class="form-group col-md-6">
                                    <label>Fourth Image</label>
                                    <div class="file-loading">
                                        <input id="image3" name="image3" type="file" accept="image/*">
                                    </div>
                                    <span class="caption_note">Note: Image dimension must be 958 x 600 PX and Size must be less than 512 KB</span>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Fourth Image Attribute</label>
                                    <input type="text" class="form-control placeholder-cls required" id="image_attribute4"
                                           name="image_attribute4" placeholder="Alt='Image Attribute4'"
                                           value="{{ isset($collect)?$collect->image_attribute4:'' }}">
                                           <div class="help-block with-errors" id="image_attribute4_error"></div>
                                    
                                </div>
                               

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="title">Title</label>
                                    <input type="text" class="required form-control" name="title4" id="title4" placeholder="Title" class="form-control" autocomplete="off" value="{{ isset($collect)?$collect->title4:'' }}" maxlength="230">
                                    <div class="help-block with-errors" id="title4_error"></div>
                                </div>

                                

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="description">Description*</label>
                                    <textarea class="form-control tinyeditor required reset" id="description4"
                                              name="description4">{!! @$collect->description4 !!}</textarea>
                                    <div class="help-block with-errors" id="description4_error"></div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="title">shorturl</label>
                                    <input type="text" class="required form-control" name="shorturl4" id="shorturl4" placeholder="Title" class="form-control" autocomplete="off" value="{{ isset($collect)?$collect->short_url4:'' }}" maxlength="230">
                                    <div class="help-block with-errors" id="shorturl4_error"></div>
                                </div>

                                

                            </div>
                            <div class="form-row" id="slider-div" style="display: {{@$banner->banner_type=='video'?'none':''}}">
                                <div class="form-group col-md-6">
                                    <label>Fifth Image</label>
                                    <div class="file-loading">
                                        <input id="image4" name="image4" type="file" accept="image/*">
                                    </div>
                                    <span class="caption_note">Note: Image dimension must be 450 x 600 PX and Size must be less than 512 KB</span>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Fifth Image Attribute</label>
                                    <input type="text" class="form-control placeholder-cls required" id="image_attribute5"
                                           name="image_attribute5" placeholder="Alt='Image Attribute'"
                                           value="{{ isset($collect)?$collect->image_attribute5:'' }}">
                                           <div class="help-block with-errors" id="image_attribute6_error"></div>
                                    
                                </div>
                               

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="title">Title</label>
                                    <input type="text" class="required form-control" name="title5" id="title5" placeholder="Title" class="form-control" autocomplete="off" value="{{ isset($collect)?$collect->title5:'' }}" maxlength="230">
                                    <div class="help-block with-errors" id="title5_error"></div>
                                </div>

                                

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="description">Description*</label>
                                    <textarea class="form-control tinyeditor required reset" id="description5"
                                              name="description5">{!! @$collect->description5 !!}</textarea>
                                    <div class="help-block with-errors" id="description5_error"></div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="title">shorturl</label>
                                    <input type="text" class="required form-control" name="shorturl5" id="shorturl5" placeholder="Title" class="form-control" autocomplete="off" value="{{ isset($collect)?$collect->short_url5:'' }}" maxlength="230">
                                    <div class="help-block with-errors" id="shorturl5_error"></div>
                                </div>

                                

                            </div>
                            <div class="form-row" id="slider-div" style="display: {{@$banner->banner_type=='video'?'none':''}}">
                                <div class="form-group col-md-6">
                                    <label>sixth Image</label>
                                    <div class="file-loading">
                                        <input id="image5" name="image5" type="file" accept="image/*">
                                    </div>
                                    <span class="caption_note">Note: Image dimension must be 450 x 600 PX and Size must be less than 512 KB</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>sixth Image Attribute</label>
                                    <input type="text" class="form-control placeholder-cls required" id="image_attribute6"
                                           name="image_attribute6" placeholder="Alt='Image Attribute'"
                                           value="{{ isset($collect)?$collect->image_attribute6:'' }}">
                                           <div class="help-block with-errors" id="image_attribute5_error"></div>
                                   
                                </div>
                             
                             

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="title">Title</label>
                                    <input type="text" class="required form-control" name="title6" id="title6" placeholder="Title" class="form-control" autocomplete="off" value="{{ isset($collect)?$collect->title6:'' }}" maxlength="230">
                                    <div class="help-block with-errors" id="title6_error"></div>
                                </div>

                                

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="description">Description*</label>
                                    <textarea class="form-control tinyeditor required reset" id="description6"
                                              name="description6">{!! @$collect->description6 !!}</textarea>
                                    <div class="help-block with-errors" id="description6_error"></div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="title">shorturl</label>
                                    <input type="text" class="required form-control" name="shorturl6" id="shorturl6" placeholder="Title" class="form-control" autocomplete="off" value="{{ isset($collect)?$collect->short_url6:'' }}" maxlength="230">
                                    <div class="help-block with-errors" id="shorturl6_error"></div>
                                </div>

                                

                            </div>
                            
                            

                           


                            

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input type="submit" class="btn btn-primary form_submit_btn submitBtn" value="Submit">
                                    <input type="reset" class="btn btn-default" value="Reset">
                                    <img class="animation__shake loadingImg" src="{{url('backend/dist/img/loading.gif')}}" style="display:none;">
                                </div>
                            </div>
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
                minImageWidth: 450,
                minImageHeight: 600,
                maxImageWidth: 450,
                maxImageHeight: 600,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($collect) && $collect->mobile_image!=NULL)
                initialPreview: ["{{asset($collect->mobile_image)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($collect->mobile_image!=NULL)?$collect->title:''}}",
                    width: "120px",
                    key: "{{($collect->mobile_image)}}",
                }]
                @endif
            });
            $("#image1").fileinput({
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
                minImageWidth: 958,
                minImageHeight: 600,
                maxImageWidth: 958,
                maxImageHeight: 600,
                maxFileSize: 1500,
                showRemove: true,
                @if(isset($collect) && $collect->mobile_image1!=NULL)
                initialPreview: ["{{asset($collect->mobile_image1)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($collect->mobile_image1!=NULL)?$collect->title:''}}",
                    width: "120px",
                    key: "{{($collect->mobile_image1)}}",
                }]
                @endif
            });
            $("#image2").fileinput({
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
                minImageWidth: 450,
                minImageHeight: 600,
                maxImageWidth: 450,
                maxImageHeight: 600,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($collect) && $collect->mobile_image2!=NULL)
                initialPreview: ["{{asset($collect->mobile_image2)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($collect->mobile_image2!=NULL)?$collect->title:''}}",
                    width: "120px",
                    key: "{{($collect->mobile_image2)}}",
                }]
                @endif
            });
            $("#image3").fileinput({
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
                minImageWidth: 958,
                minImageHeight: 600,
                maxImageWidth: 958,
                maxImageHeight: 600,
                maxFileSize: 1500,
                showRemove: true,
                @if(isset($collect) && $collect->mobile_image3!=NULL)
                initialPreview: ["{{asset($collect->mobile_image3)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($collect->mobile_image3!=NULL)?$collect->title:''}}",
                    width: "120px",
                    key: "{{($collect->mobile_image3)}}",
                }]
                @endif
            });
            $("#image4").fileinput({
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
                minImageWidth: 450,
                minImageHeight: 600,
                maxImageWidth: 450,
                maxImageHeight: 600,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($collect) && $collect->mobile_image4!=NULL)
                initialPreview: ["{{asset($collect->mobile_image4)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($collect->mobile_image4!=NULL)?$collect->title:''}}",
                    width: "120px",
                    key: "{{($collect->mobile_image4)}}",
                }]
                @endif
            });
            $("#image5").fileinput({
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
                minImageWidth: 450,
                minImageHeight: 600,
                maxImageWidth: 450,
                maxImageHeight: 600,
                maxFileSize: 512,
                showRemove: true,
                @if(isset($collect) && $collect->mobile_image4!=NULL)
                initialPreview: ["{{asset($collect->mobile_image5)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($collect->mobile_image5!=NULL)?$collect->title:''}}",
                    width: "120px",
                    key: "{{($collect->mobile_image5)}}",
                }]
                @endif
            });



        });
    </script>
@endsection
