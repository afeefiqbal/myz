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
{{--                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'about')}}">About</a>--}}
{{--                            </li>--}}
                            <li class="breadcrumb-item active">{{$title}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
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
                <form role="form" id="formWizard" class="form--wizard" enctype="multipart/form-data" method="post" action="">
                    {{csrf_field()}}
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title"> Form</h3>
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
                                    <input type="text" name="title" id="title" placeholder="Title"
                                           class="form-control required" autocomplete="off"
                                           value="{{ old('title', isset($affiliate)?$affiliate->title:'') }}">
                                    <div class="help-block with-errors" id="title_error"></div>
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                               <div class="form-group col-md-6">
                                   <label> Commission</label>
                                   <input type="number" min="1" name="commision_amount" id="commision_amount" placeholder="Commission Amount"
                                          class="form-control " autocomplete="off"
                                          value="{{ isset($affiliate)?$affiliate->commision_amount:'' }}">
                                   <div class="help-block with-errors" id="commision_amount_error"></div>
                                   @error('commision_amount')
                                   <div class="invalid-feedback">{{ $message }}</div>
                                   @enderror
                               </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <input type="hidden" name="id" id="id" value="{{isset($affiliate)?$affiliate->id:'0'}}">
                            <input type="submit" name="btn_save" value="Submit"
                                   class="btn btn-primary pull-left submitBtn">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

@endsection
