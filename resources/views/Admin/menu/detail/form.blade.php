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
                                            <option value="{{$menu->id}}"
                                                {{ (@$menuDetail->menu_id==$menu->id)?'selected':'' }}>{{$menu->title}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="menu_id_error"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="category_id">Category</label>
                                    <select class="form-control multiple select2 sub-category-drop" name="category_id[]"
                                            multiple id="category_id">
                                        <option>Select Sub Category</option>
                                        @if(isset($categories))
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}"
                                                    {{(@$category->id==@$menuDetail->category_id)?'selected':'' }}>
                                                    {{$category->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
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
@endsection
