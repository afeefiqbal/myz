@extends('Admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-user-shield"></i> Manage Home Slider</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Slider</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
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


                        {{-- <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Banner Type</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <form role="form" id="formWizard" class="form--wizard" enctype="multipart/form-data"
                                  method="post">
                                {{csrf_field()}}
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="home_title">Banner Type*</label>
                                            <select class="form-control required" name="banner_type" id="banner_type">
                                                <option
                                                    value="slider" {{ (@$siteInformation->banner_type=='slider')?'selected':''}}>
                                                    Slider
                                                </option>
                                                <option
                                                    value="video" {{  (@$siteInformation->banner_type=='video')?'selected':'' }}>
                                                    Video
                                                </option>
                                            </select>
                                            <div class="help-block with-errors" id="banner_type_error"></div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <input type="button" id="bannertypeSubmit" data-type=""
                                           name="btn_save" data-url="/home/banner/banner-type-store" value="Submit"
                                           class="btn btn-primary pull-left">
                                    <button type="reset" class="btn btn-default">Cancel</button>
                                    <img class="animation__shake loadingImg" src="{{asset('backend/dist/img/loading.gif')}}"
                                         style="display:none;">
                                </div>
                            </form>
                        </div> --}}


                        <div class="card card-success card-outline">
                            <div class="card-header">
                                <a href="{{url(Helper::sitePrefix().'home/banner/create')}}"
                                   class="btn btn-success pull-right">Add
                                    Slider <i class="fa fa-plus-circle pull-right mt-1 ml-2"></i></a>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover dataTable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Slider Image</th>
                                        <th>Sort Order</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th class="not-sortable">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($bannerList as $banner)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $banner->title }} {{ $banner->subtitle }}</td>
                                            <td>
                                                <img src="{{asset($banner->desktop_image)}}" alt="" height="100">
                                            </td>
                                         
                                            <td>
                                               @if($banner->banner_type!='video')
                                                <input type="text" name="banner_order"
                                                       id="banner_order_{{$loop->iteration}}"
                                                       data-table="HomeBanner" data-id="{{ $banner->id }}"
                                                       class="common_sort_order" style="width:25%"
                                                       value="{{$banner->sort_order}}">
                                                @endif
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" class="status_check"
                                                           data-url="/status-change" data-table="HomeBanner"
                                                           data-field="status"data-pk="{{ $banner->id}}"
                                                           @if($banner->banner_type=='video')
                                                           data-limit-field="banner_type" data-limit="1" data-limit-field-value="{{$banner->banner_type}}"
                                                        @endif
                                                        {{($banner->status=="Active")?'checked':''}}>
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td>{{ date("d-M-Y", strtotime($banner->created_at)) }}</td>
                                            <td class="text-right py-0 align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{url(Helper::sitePrefix().'home/banner/edit/'.$banner->id)}}"
                                                       class="btn btn-success mr-2 tooltips" title="Edit Banner"><i
                                                            class="fas fa-edit"></i></a>
                                                    <a href="#" class="btn btn-danger mr-2 delete_entry tooltips"
                                                       title="Delete Banner" data-url="home/banner/delete"
                                                       data-id="{{$banner->id}}"><i class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
