

@extends('web.layouts.main')
@section('content')
<!--Inner Banner Start-->

{{-- @include('web.includes.banner',[$banner, 'type'=> 'Blogs     >     '.$blog->title,'title'=> $blog->title]) --}}
<!--Inner Banner End-->
<section class="innerBanner ">
@if($blog->desktop_banner !='' || $blog->desktop_banner != null)
    <div class="innerBannerImageArea">
        {!! Helper::printImage($blog, 'desktop_banner','desktop_banner_webp','banner_attribute', 'img-fluid') !!}
    </div>
    @endif
    <div class="innerBannerDetails">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Blog Detail</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="i{{url('/')}}"><img src="{{asset('frontend/images/home.png')}}"></a></li>
                            <li class="breadcrumb-item"><a href="{{url('blogs')}}">Blogs</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$blog->title}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Blog Listing Page Start-->
    <section class="blogListingPage blogDetailsPage">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-lg-8">
                    <h6 class="subHeading">{{ $blog->subtitle }}</h6>
                    <h2 class="mainHeading">  {{ $blog->title }}</h2>
                  
                        {{-- <div class="date">{{ date('d-m-Y', strtotime($blog->posted_date)) }}</div>
                        <div class="time">By : {{$blog->author}}</div> --}}
                    <div class="blogImage">
                    {!! Helper::printImage($blog, 'image','image_webp','image_attribute', 'img-fluid') !!}
                    </div>
                    <div class="textArea">
                        {!! $blog->description !!}
                    </div>
                    @if($blog->video_thumbnail_image !='' || $blog->video_thumbnail_image != null)
                    <div class="video-area">
                    {!! Helper::printImage($blog, 'video_thumbnail_image', 'video_thumbnail_image_webp', 'video_thumbnail_image_attribute', 'img-fluid') !!}
                            @if($blog->video_url !='' || $blog->video_url != null)
                        <a href="{{ $blog->video_url }}" data-fancybox="group">
                            <button type="button" class="video-btn">
                                <img class="img-fluid" src="{{asset('frontend/images/videoPlay.png')}}" alt="">
                            </button>
                        </a>
                        @endif
                    </div>
                    @endif
                    <div class="textArea">


                        {!! $blog->alternate_description !!}


                        @php
                            // share url fb, twitter, linkedin, whatsapp
                            $shareUrl = Request::fullUrl();
                            $imageUrl = asset('frontend/images/logo.png');


                        @endphp
                    </div>
                    <div class="share_navigation_area">
                        <div class="share">
                            <p>Share</p>
                            <div>
                                <a href="{{'https://www.facebook.com/sharer/sharer.php?u='. urlencode( Request::fullUrl()) }}" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                                <a class="whatsapp-send1" data-href="{{Request::fullUrl()}}" target="_blank" data-text='{!! ($blog->title) !!}'     data-title='{!! ($blog->title) !!}' data-image="{{ asset($blog->thumbnail_image)}}"><i class="fa-brands fa-whatsapp"></i></a>
                                <a href="{{'https://twitter.com/intent/tweet/?url='.urlencode(Request::fullUrl()) }}" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                                <a href="{{'https://www.linkedin.com/shareArticle?&url='.urlencode(Request::fullUrl()) }}" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
                            </div>
                        </div>
                        <div class="prev_next">
                            @if($previousBlog)
                            <a class="primary_btn" href="{{ url('blog/'.$previousBlog->short_url) }}">Previous</a>
                            @endif
                            @if($nextBlog)
                            <a class="primary_btn" href="{{ url('blog/'.$nextBlog->short_url) }}">Next</a>
                            @endif
                        </div>
                    </div>
                </div>
                @if($recentBlogs->isNotEmpty())
                <div class="col-lg-4 ps-lg-5 sticky-lg-top">
                    <div class="recentBlog">
                        <h4>Recent Blog</h4>
                        <div class="blogRecentSlider">
                        @foreach( $recentBlogs as $blog)
                            <div class="recentBlogCard">
                                <div class="blogImage">
                                {!! Helper::printImage($blog, 'image', 'image_webp', '', 'img-fluid') !!}
                                </div>
                                <div class="recentBlogDetails">
                                    <h6>
                                    {{ $blog->title }}
                                    </h6>
                                    
                                        <div class="date">
                                        {{ date('d-m-Y', strtotime($blog->posted_date)) }}</div>
    
                                    
                                    <a href="{{ url('blog/'.$blog->short_url) }}">Read More</a>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>

                @endif
            </div>

        </div>
    </section>
    @endsection
@push('scripts')
<script>

    $( document ).on( "click", '.whatsapp-send1', function() {
    
    
    
    var b="\n";
    
    var rt="Read More Click👇";
    
    var text = $( this ).attr( "data-text" )+b+rt+b;
    
    var url = $( this ).attr( "data-href" );
    
    var img  = $( this ).attr( "data-image" );
    
    console.log(img);
    
    var c="*";
    
    var b="\n";
    
    var x="  🔰 ";
    
    var titletext = x+c+$( this ).attr( "data-title")+c+b+b;
    
    var message =encodeURIComponent( titletext) + encodeURIComponent( text ) + " - " + encodeURIComponent( window.location.href );
    
    var whatsapp_url = "https://api.whatsapp.com/send?text=" + message;
    
    window.location.href = whatsapp_url;
    
    } );
    
    </script>
    <script>
    
     </script>
@endpush
<!--Blog Listing Page End -->





