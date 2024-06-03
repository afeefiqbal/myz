@extends('Admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <h1><i class="nav-icon fas fa-user-shield"></i> {{$title}}</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'side-menu')}}">Side Menu</a>
                            </li>
                            <li class="breadcrumb-item active">{{$title}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <form role="form" id="formWizard" class="form--wizard" enctype="multipart/form-data" method="post" action="">
                    {{csrf_field()}}
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Menu Form</h3>
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
      
                                <div class="form-group col-md-6 category"
                                     style="display: {{ (@$menu->menu_type=='category')?'block':'none' }}">
                                    <label> Categories*</label>
                                    <select class="form-control menu_category_id" id="menu_category_id"
                                            name="menu_category_id[]">
                                        <option value="">Select Option</option>
                                        @foreach($categories as $category)
                                            <option data-url="{{$category->short_url}}"
                                                    value="{{ $category->id }}" {{ (@$menu->category_id==$category->id)?'selected':'' }}>{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="menu_category_id_error"></div>
                                </div>
                                <div class="form-group col-md-6 color"
                                style="display: {{ (@$menu->menu_type=='color')?'block':'none' }}">
                               <label> Color*</label>
                               <select class="form-control menu_color_id select2" id="menu_color_id"  multiple
                                       name="menu_color_id[]">

                                   @foreach($colors as $color)
                                       <option data-url="{{$color->short_url}}"
                                               value="{{ $color->id }}"
                                               @if(@$sideMenuColors && in_array($color->id,$sideMenuColors))
                                                  selected
                                                @endif
                                               {{ (@$menu->color_id==$color->id)?'selected':'' }}>{{ $color->title }}</option>
                                   @endforeach
                               </select>
                               <div class="help-block with-errors" id="menu_color_id_error"></div>
                           </div>
                           <div class="form-group col-md-6 shape"
                           style="display: {{ (@$menu->menu_type=='shape')?'block':'none' }}">
                          <label> Shape*</label>
                          <select class="form-control menu_shape_id select2"  id="menu_shape_id"  multiple
                                  name="menu_shape_id[]">

                              @foreach($shapes as $shape)
                                  <option data-url="{{$shape->short_url}}"
                                          value="{{ $shape->id }}"
                                          @if(@$sideMenuShapes && in_array($shape->id,$sideMenuShapes))
                                          selected
                                        @endif
                                           {{ (@$menu->shape_id==$shape->id)?'selected':'' }}>{{ $shape->title }}</option>
                              @endforeach
                          </select>
                          <div class="help-block with-errors" id="menu_tag_id_error"></div>
                      </div>


                            </div>
                            <div class="form-row" >
                                <div class="form-group col-md-6">
                                    <label> Title*</label>
                                    <input type="text" name="title" id="title" placeholder="Title"
                                           class="form-control for_canonical_url required" autocomplete="off"
                                           value="{{ @$menu->title }}">
                                    <div class="help-block with-errors" id="title_error"></div>
                                </div>
                                <div class="form-group col-md-6 url_div menu_url"  >
                                    <label> URL*</label>
                                    <input type="text" name="url" id="url" placeholder="URL"
                                           class="form-control    @if(@$menu->menu_type == 'color' || @$menu->menu_type == 'shape' ) @else  required @endif menu_url" autocomplete="off"
                                           value="{{ @$menu->url }}">
                                    <div class="help-block with-errors" id="url_error"></div>
                                </div>
                            </div>
                            <div class="form-row" id="slider-div">
                                <div class="form-group col-md-6">
                                    <label>Image</label>
                                    <div class="file-loading">
                                         <input id="image" name="image" type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <span class="caption_note">Note: uploaded images have a maximum size of <strong> 38x36</strong> pixels and can't be over 80KB</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="image_meta_tag">Image Attribute</label>
                                    <input type="text" name="image_attribute" id="image_attribute" placeholder="Image Alternate Text" class="form-control placeholder-cls required" required autocomplete="off" value="{{ isset($banner)?$banner->image_attribute:'' }}" maxlength="230">
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

            $(document).ready(function(){
                $("#image").fileinput({
                    'theme': 'explorer-fas',
                    validateInitialCount: true,
                    overwriteInitial: false,
                    autoReplace: true,


                    initialPreviewAsData: true,
                    dropZoneEnabled: false,
                    required: false,
                    allowedFileTypes: ['image'],
                    minImageWidth: 38,
                    minImageHeight: 36,
                    maxImageWidth: 38,
                    maxImageHeight: 36,
                    maxFileSize: 300,
                    showRemove: true,
                    @if(isset($menu) && $menu->image!=NULL)
                    initialPreview: ["{{asset($menu->image)}}",],
                    initialPreviewConfig: [{
                        caption: "{{ ($menu->image!=NULL)?$menu->title:''}}",
                        width: "120px",
                        key: "{{'SideMenu/image/'.$menu->id.'/image_webp' }}",
                    }]
                    @endif
                });

            });
        </script>
@endsection
