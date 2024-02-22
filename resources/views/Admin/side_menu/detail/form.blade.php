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
                            <li class="breadcrumb-item">
                                <a href="{{url(Helper::sitePrefix().'dashboard')}}">
                                    Home
                                </a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'menu/detail/')}}">Menu
                                    Detail</a>
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
                            <h3 class="card-title">Menu Detail Form</h3>
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
                               
                                <div class="form-group col-md-6">
                                    <label for="menu_id"> Menu*</label>
                                    <select name="menu_id" id="menu_id" class="form-control required">
                                        <option value="">Select Menu</option>
                                        @foreach($menus as $menu)
                                            <option value="{{$menu->id}}" data-type="{{$menu->menu_type}}"
                                                {{ (@$menuDetail->menu_id==$menu->id)?'selected':'' }}>{{$menu->title}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="menu_id_error"></div>
                                </div>
                              
                                <div class="form-group col-md-6 color"
                                style="display: {{ (@$menu->menu_type=='color')?'block':'none' }}">
                               <label> Color*</label>
                               <select class="form-control menu_color_id select2" id="menu_color_id" 
                                       name="menu_color_id">
                                   <option value="">Select Option</option>
                                   @foreach($colors as $color)
                                       <option data-url="{{$color->short_url}}"
                                               value="{{ $color->id }}" {{ (@$menuDetail->color_id==$color->id)?'selected':'' }}>{{ $color->title }}</option>
                                   @endforeach
                               </select>
                               <div class="help-block with-errors" id="menu_color_id_error"></div>
                           </div>
                           <div class="form-group col-md-6 shape  d-none"
                           style="display: {{ (@$menu->menu_type=='shape')?'block':'none' }}">
                          <label> Shape*</label>
                          <select class="form-control menu_shape_id"  id="menu_shape_id" 
                                  name="menu_shape_id">
                              <option value="">Select Option</option>
                              @foreach($shapes as $shape)
                                  <option data-url="{{$shape->short_url}}"
                                          value="{{ $shape->id }}" {{ (@$menu->shape_id==$shape->id)?'selected':'' }}>{{ $shape->title }}</option>
                              @endforeach
                          </select>
                          <div class="help-block with-errors" id="menu_tag_id_error"></div>
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
            $('#category_id').val([{{@$menuDetail->category_id}}]).change();
        });
    </script>
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
                @if(isset($menuDetail) && $menuDetail->image!=NULL)
                initialPreview: ["{{asset($menuDetail->image)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($menuDetail->image!=NULL)?$menuDetail->title:''}}",
                    width: "120px",
                    key: "{{'SideMenuDetail/image/'.$menuDetail->id.'/image_webp' }}",
                }]
                @endif
            });

        });
    </script>
@endsection
