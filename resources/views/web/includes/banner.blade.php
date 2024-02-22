{{-- @if($banner)

    <div class="d-none d-md-block">
        <section class="inner_banner ">
            @if ($banner->desktop_banner != null)
                {!! Helper::printImage($banner, 'desktop_banner','desktop_banner_webp','banner_attribute','img-fluid') !!}
                
            @endif
        </section>
    </div>

    <div class="d-block d-md-none">
        <section class="inner_banner ">
            @if ($banner->mobile_banner != null)
                {!! Helper::printImage($banner, 'mobile_banner','mobile_banner_webp','banner_attribute','img-fluid') !!}
            @endif
        </section>
    </div>
@endif
<section class="breadcrumb_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        {{ $type }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section> --}}



@if($banner)
@if ($banner->desktop_banner != null)
<section class="innerBanner">
    <div class="innerBannerImageArea">
            {!! Helper::printImage($banner, 'desktop_banner','desktop_banner_webp','banner_attribute','img-fluid') !!}
       
    </div>
    <div class="innerBannerDetails">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>{{$title}}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}"><img
                                        src="{{ asset('frontend/images/home.png') }}" alt=""></a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endif