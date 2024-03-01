@extends('web.layouts.main')
@section('content')

    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>About Us</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="index.php">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">About Us</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Fresh Vegetable Section Start -->
    <section class="fresh-vegetable-section section-lg-space">
        <div class="container-fluid-lg">
            <div class="row gx-xl-5 gy-xl-0 g-3 ratio_148">
                <div class="col-xl-6 col-12">
                    <div class="row">
                        <div class="col-6">
                         
                            <div class="fresh-image-2">
                                <div>
                                    <img src="{{$about->banner_image}}"
                                        class="bg-img blur-up lazyload" alt="{{$about->banner_image_attribute}}">
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="fresh-image">
                                <div>
                                    <img src="{{$about->image}}"
                                        class="bg-img blur-up lazyload" alt="{{$about->image_attribute}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-12">
                    <div class="fresh-contain p-center-left">
                        <div>
                            <div class="review-title">
                                <h4>{{$about->subtitle}}</h4>
                                <h2>{{$about->title}}</h2>
                            </div>

                            <div class="delivery-list">
                                <p class="text-content">{!! $about->description !!}</p>

                             
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fresh Vegetable Section End -->

    <!-- Client Section Start -->
    <section class="client-section section-lg-space">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="about-us-title text-center">
                        <h4>What We Do</h4>
                        <h2 class="center">We are Trusted by Clients</h2>
                    </div>

                    <div class="slider-3_1 product-wrapper">
                        <div>
                            <div class="clint-contain">
                                <div class="client-icon">
                                    <img src="https://themes.pixelstrap.com/fastkart/assets/svg/3/work.svg" class="blur-up lazyload" alt="">
                                </div>
                                <h2>10</h2>
                                <h4>Business Years</h4>
                                <p>A coffee shop is a small business that sells coffee, pastries, and other morning
                                    goods. There are many different types of coffee shops around the world.</p>
                            </div>
                        </div>

                        <div>
                            <div class="clint-contain">
                                <div class="client-icon">
                                    <img src="https://themes.pixelstrap.com/fastkart/assets/svg/3/buy.svg" class="blur-up lazyload" alt="">
                                </div>
                                <h2>80 K+</h2>
                                <h4>Products Sales</h4>
                                <p>Some coffee shops have a seating area, while some just have a spot to order and then
                                    go somewhere else to sit down. The coffee shop that I am going to.</p>
                            </div>
                        </div>

                        <div>
                            <div class="clint-contain">
                                <div class="client-icon">
                                    <img src="https://themes.pixelstrap.com/fastkart/assets/svg/3/user.svg" class="blur-up lazyload" alt="">
                                </div>
                                <h2>90%</h2>
                                <h4>Happy Customers</h4>
                                <p>My goal for this coffee shop is to be able to get a coffee and get on with my day.
                                    It's a Thursday morning and I am rushing between meetings.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Client Section End -->

@isset($testimonials)
<section class="review-section section-lg-space">
    <div class="container-fluid">
        <div class="about-us-title text-center">
            <h4 class="text-content">Latest Testimonals</h4>
            <h2 class="center">What people say</h2>
        </div>
       
        <div class="row">
            <div class="col-12">
                <div class="slider-4-half product-wrapper">
                    @foreach ($testimonials as $testimonial)
                        
                    <div>
                        <div class="reviewer-box">
                            <i class="fa-solid fa-quote-right"></i>
                            <div class="product-rating">
                                <ul class="rating">
    
                                    <li>
                                        <i data-feather="star" class="fill"></i>
                                    </li>
                                    <li>
                                        <i data-feather="star" class="fill"></i>
                                    </li>
                                    <li>
                                        <i data-feather="star" class="fill"></i>
                                    </li>
                                    <li>
                                        <i data-feather="star" class="fill"></i>
                                    </li>
                                    <li>
                                        <i data-feather="star"></i>
                                    </li>
                                </ul>
                            </div>
    
                            <h3></h3>
    
                            <p>"{!! $testimonial->message!!}"</p>
                            <div class="reviewer-profile">
                                <div class="reviewer-image">
                                    <img src="{{$testimonial->image}}" class="blur-up lazyload"
                                        alt="">
                                </div>
    
                                <div class="reviewer-name">
                                    <h4>{{$testimonial->name}}</h4>
                                    <h6>{{$testimonial->designatio }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                   

                </div>
            </div>
        </div>
    </div>
</section>
    
@endisset
    <!-- Review Section Start -->
@endsection
<!--About Us Page End -->
