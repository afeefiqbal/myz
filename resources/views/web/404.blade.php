@extends('web.layouts.main')
@section('content')
@php
    $banner =   \App\Models\Banner::type('404')->first();
@endphp

@include('web.includes.banner',[$banner, 'title'=> '404','type'=> '404'])
<section class="error_section">
    <div class="container">
        <div class="row justify-content-center">
        
            <div class="col-lg-8 mb-4 mt-5 text-center">
                
                <picture class="d-flex justify-content-center">
                    <img class="img-fluid" src="{{asset('frontend/images/error.png')}}" alt="">
                </picture>
                <p>
                 Page not found
                </p>
                <a class="primary_btn" href="{{url('/')}}">Home</a>
            </div>
        </div>
    </div>
</section>

@endsection

