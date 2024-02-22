@extends('Admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                {{$title}}
            </h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{url(Helper::sitePrefix().'dashboard')}}">
                        Home
                    </a>
                </li>
                <li class="active"><a href="{{url(Helper::sitePrefix().'mail/list/')}}">Mail Template</a></li>
                <li class="active">{{$key}} Template</li>
            </ol>
        </section>
        <section class="content">
            @if(session()->has('user_feedback'))
                <div class="alert alert-success">
                    <ul>
                        <li>{{ session()->get('user_feedback') }}</li>
                    </ul>
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
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <form role="form" enctype="multipart/form-data" method="post" id="formWizard">
                            {{csrf_field()}}
                            <div class="box-body">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label> Title*</label>
                                            <input type="text" name="title" id="title" maxlength="230"
                                                   class="form-control" placeholder="Title" required
                                                   value="{{ isset($item)?$item->title:'' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label> Body *</label>
                                            <textarea class="form-control textarea" required id="description"
                                                      name="description"
                                                      placeholder="Mail Body">{{ isset($item)?$item->description:'' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="col-md-12">
                                    <input type="submit" name="btn_save" value="Submit"
                                           class="btn btn-primary pull-left submitBtn">
                                    <input type="hidden" name="id" id="id" value="{{ isset($item)?$item->id:'0' }}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
