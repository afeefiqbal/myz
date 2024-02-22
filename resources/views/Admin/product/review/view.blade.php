@extends('Admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-bell"></i> View Review - {{$review->name}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'product/review')}}">Review</a></li>
                            <li class="breadcrumb-item active">{{$title}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-tabs">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                                           href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                                           aria-selected="true">Basic Information</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                                         aria-labelledby="custom-tabs-one-home-tab">
                                        <div class="post">
                                            <strong><i class="fas fa-user mr-1"></i> Name</strong>
                                            <p class="text-muted">{{$review->name}}</p>
                                            <hr>
                                            <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                                            <p class="text-muted">{{$review->email}}</p>
                                            <hr>
                                            <strong><i class="fas fa-star mr-1"></i>Rating</strong>
                                            <p class="text-muted">{{$review->rating}}</p>
                                            <hr>
                                            <strong><i class="fas fa-envelope mr-1"></i>Review</strong>
                                            <p class="text-muted">{{$review->review}}</p>
                                            <hr>
                                            <strong><i class="fas fa-address-book mr-1"></i> Status</strong>
                                            <p class="text-muted">{!! $review->comments!!}</p>
                                            <hr>
                                            <strong><i class="fas fa-address-book mr-1"></i> Review Date</strong>
                                            <p class="text-muted">{{date("d-M-Y", strtotime($review->created_at)) }}</p>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
