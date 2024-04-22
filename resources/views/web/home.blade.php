@extends('web.layouts.main')
@section('content')
 <!-- Home Section Start -->
 <section class="home-section pt-2">
    <div class="container-fluid-lg">
        <div class="row g-4">
            <div class="col-xl-8 ratio_65">
                <div class="home-contain h-100 ">
                    <div class="h-100">
                        <img src="{{asset('frontend/main-banner.jpg')}}" class="bg-img blur-up lazyload" alt="">
                    </div>
                    <div class="home-detail p-center-left w-75">
                        <div>
                            <h6><span></span></h6>
                            <h1 class="text-uppercase"> <span class="daily"></span></h1>
                            <p class="w-75 d-none d-sm-block"></p>
                            <button onclick="location.href = '{{url('products')}}';"
                                class="btn btn-animation mt-xxl-4 mt-2 home-button mend-auto">Shop Now <i
                                    class="fa-solid fa-right-long icon"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 ratio_65">
                <div class="row g-4">
                    <div class="col-xl-12 col-md-6">
                        <div class="home-contain">
                            <img src="{{asset('frontend/banner1.jpg')}}" class="bg-img blur-up lazyload"
                                alt="">
                            <div class="home-detail p-center-left home-p-sm w-75">
                                <div>
                                    <h2 class="mt-0 text-danger"><span class="discount text-title"></span>
                                    </h2>
                                    <h3 class="theme-color"></h3>
                                    <p class="w-75"></p>
                                    <a href="{{url('products')}}" class="shop-button"><i
                                            class="fa-solid fa-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-md-6">
                        <div class="home-contain">
                            <img src="{{asset('frontend/banner3.jpg')}}" class="bg-img blur-up lazyload"
                                alt="">
                            <div class="home-detail p-center-left home-p-sm w-75">
                                <div>
                                    <h3 class="mt-0 theme-color fw-bold"></h3>
                                    <h4 class="text-danger"></h4>
                                    <p class="organic"></p>
                                    <a href="{{url('products')}}" class="shop-button"><i
                                            class="fa-solid fa-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Home Section End -->

<!-- Banner Section Start -->
<section class="banner-section ratio_60 wow fadeInUp">
    <div class="container-fluid-lg">
        <div class="row g-sm-4 g-3">
            <div class="col-xxl-3 col-lg-4 col-sm-6">
                <div class="banner-contain hover-effect">
                    <img src="{{asset('frontend/card1.jpg')}}" class="bg-img blur-up lazyload" alt="">
                    <div class="banner-details">
                        <div class="banner-box">
                            <h6 class="text-danger"></h6>
                            <h5></h5>
                            <h6 class="text-content"></h6>
                        </div>
                        <a href="{{url('products')}}" class="banner-button text-white">Shop Now <i
                                class="fa-solid fa-right-long ms-2"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-lg-4 col-sm-6">
                <div class="banner-contain hover-effect">
                    <img src="{{asset('frontend/card1.jpg')}}" class="bg-img blur-up lazyload" alt="">
                    <div class="banner-details">
                        <div class="banner-box">
                            <h6 class="text-danger"></h6>
                            <h5></h5>
                            <h6 class="text-content"></h6>
                        </div>
                        <a href="{{url('products')}}" class="banner-button text-white">Shop Now <i
                                class="fa-solid fa-right-long ms-2"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-lg-4 col-sm-6">
                <div class="banner-contain hover-effect">
                    <img src="{{asset('frontend/card1.jpg')}}" class="bg-img blur-up lazyload" alt="">
                    <div class="banner-details">
                        <div class="banner-box">
                            <h6 class="text-danger"></h6>
                            <h5></h5>
                            <h6 class="text-content"></h6>
                        </div>
                        <a href="{{url('products')}}" class="banner-button text-white">Shop Now <i
                                class="fa-solid fa-right-long ms-2"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-lg-4 col-sm-6">
                <div class="banner-contain hover-effect">
                    <img src="{{asset('frontend/card1.jpg')}}" class="bg-img blur-up lazyload" alt="">
                    <div class="banner-details">
                        <div class="banner-box">
                            <h6 class="text-danger"></h6>
                            <h5></h5>
                            <h6 class="text-content"></h6>
                        </div>
                        <a href="{{url('products')}}" class="banner-button text-white">Shop Now <i
                                class="fa-solid fa-right-long ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->

<!-- Home Section End -->

<!-- Category Section Start -->
<section>
    <div class="container-fluid-lg">
        <div class="title">
            <h2>Browse by Categories</h2>
            <span class="title-leaf">
                <svg class="icon-width">
                    <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
                </svg>
            </span>
            <!-- <p>Top Categories Of The Week</p> -->
        </div>
        <div class="row">
            <div class="col-12">
                <div class="slider-9">
                    @isset($categories)
                        @foreach ($categories as $item)
                        
                            <div>
                                <a href="/category/{{$item->short_url}}" class="category-box wow fadeInUp">
                                    <div>
                                    
                                        <img src="{{$item->icon}}"  class="blur-up lazyload" alt="{{$item->image_attribute}}">
                                        <h5>{{$item->title}}</h5>
                                    </div>
                                </a>
                            </div>
                            
                        @endforeach
                    @endisset
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Category Section End -->


<!-- Product Section Start -->
<section>
    <div class="container-fluid-lg">
        <div class="title">
            <h2>Our  Products</h2>
            <span class="title-leaf">
                <svg class="icon-width">
                    <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
                </svg>
            </span>

        </div>
        @isset($products)
            
        <div class="product-border border-row">
            <div class="slider-6_2 no-arrow">
                @foreach ($products as $product )
                <div class="col-6 px-0">
                    <div class="product-box wow fadeIn">
                        <div class="product-image">
                            <a href="{{ url('/product/'.$product->short_url) }}" tabindex="-1">
                                <img src="{{$product->thumbnail_image}}"
                                    class="img-fluid blur-up lazyload" alt="">
                            </a>
                            <ul class="product-option justify-content-around">
                                <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                        data-bs-target="#view">
                                        <i data-feather="eye"></i>
                                    </a>
                                </li>

                            

                                <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                    <a href="#" class="notifi-wishlist">
                                        <i data-feather="heart"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="product-detail">
                            <a href="product.php">
                                <h6 class="name name-2 h-100">{{$product->title}}</h6>
                            </a>

                            <div class="product-rating mt-2">
                                <ul class="rating">
                                    @if(Helper::averageRating($product->id)>0)
                                    <li class="review">
                                        <i class="fa-solid fa-star"></i>{{ Helper::averageRating($product->id)  }}
                                    </li>
                                    @endif
                                </ul>
                               
                            </div>

                            <h6 class="sold weight text-content fw-normal"></h6>

                            <div class="counter-box">
                                <h6 class="sold theme-color">{{$product->price}}</h6>

                                <div class="addtocart_btn">
                                    <button class="add-button addcart-button btn buy-button text-light">
                                        <span>Add</span>
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                    <div class="qty-box cart_qty">
                                        <div class="input-group">
                                            <button type="button" class="btn qty-left-minus"
                                                data-type="minus" data-field="">
                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                            </button>
                                            <input class="form-control input-number qty-input" type="text"
                                                name="quantity" value="1">
                                            <button type="button" class="btn qty-right-plus"
                                                data-type="plus" data-field="">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                @endforeach

            </div>
        </div>
        @endisset
    </div>
</section>
<!-- Product Section End -->



<!-- Product Section Start -->

<!-- Product Section End -->


<!-- Blog Section Start -->

<!-- Blog Section End -->

<!-- Newsletter Section Start -->
<section class="newsletter-section section-b-space">
    <div class="container-fluid-lg">
        <div class="newsletter-box newsletter-box-2">
            <div class="newsletter-contain py-5">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-4 col-sm-8 offset-xl-3">
                            <div class="newsletter-detail">
                                <h2> Subscribe our newsletter</h2>
                              
                                <div class="input-box">
                                    <input type="email" class="form-control" id="exampleFormControlInput1"
                                        placeholder="Enter Your Email">
                                    <i class="fa-solid fa-envelope arrow"></i>
                                    <button class="sub-btn btn">
                                        <span class="d-sm-block d-none">Subscribe</span>
                                        <i class="fa-solid fa-arrow-right icon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Home Testimonial End-->
@endsection
@push('scripts')

@endpush
