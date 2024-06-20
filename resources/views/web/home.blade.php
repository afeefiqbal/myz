@extends('web.layouts.main')
@section('content')
 <!-- Home Section Start -->
 @isset($banners)
 <section class="home-section pt-2">
    <div class="container-fluid-lg">
        <div class="row g-4" >
            <div class="col-xl-8 ratio_65">

                <div class="home-contain h-100 ">
                    <div class="h-100">
                        <img src="{{$banners->main_banner}}" class="bg-img blur-up lazyload" alt="{{ @$banners->main_banner_attribute }}">
                    </div>
                    <div class="home-detail p-center-left w-75">
                        <div>
                            <h6><span></span></h6>
                            <h1 class="text-uppercase"> <span class="daily"></span></h1>
                            <p class="w-75 d-none d-sm-block"></p>
                            <button onclick="location.href = '{{url($banners->main_banner_url)}}';"
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
                            <img src="{{@$banners->left_side_banner}}" class="bg-img blur-up lazyload"
                                alt="{{@$banners->left_banner_attribute}}">
                            <div class="home-detail p-center-left home-p-sm w-75">
                                <div>
                                    <h2 class="mt-0 text-danger"><span class="discount text-title"></span>
                                    </h2>
                                    <h3 class="theme-color"></h3>
                                    <p class="w-75"></p>
                                    <a href="{{url($banners->left_side_banner_url)}}" class="shop-button"><i
                                            class="fa-solid fa-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-md-6">
                        <div class="home-contain">
                            <img src="{{@$banners->left_second_banner}}" class="bg-img blur-up lazyload"
                                alt="{{@$banners->left_second_banner_attribute}}">
                            <div class="home-detail p-center-left home-p-sm w-75">
                                <div>
                                    <h3 class="mt-0 theme-color fw-bold"></h3>
                                    <h4 class="text-danger"></h4>
                                    <p class="organic"></p>
                                    <a href="{{url($banners->left_second_banner_url)}}" class="shop-button"><i
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
<section class="banner-section ratio_60 wow fadeInUp">
    <div class="container-fluid-lg">
        <div class="row g-sm-4 g-3">
            <div class="col-xxl-3 col-lg-4 col-sm-6">
                <div class="banner-contain hover-effect">
                    <img src="{{@$banners->bottom_first_image}}" class="bg-img blur-up lazyload" alt="{{@$banners->bottom_first_image_attribute}}">
                    <div class="banner-details">
                        <div class="banner-box">
                            <h6 class="text-danger"></h6>
                            <h5></h5>
                            <h6 class="text-content"></h6>
                        </div>
                        <a href="{{url($banners->bottom_first_image_url)}}" class="banner-button text-white">Shop Now <i
                                class="fa-solid fa-right-long ms-2"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-lg-4 col-sm-6">
                <div class="banner-contain hover-effect">
                    <img src="{{@$banners->bottom_second_image}}" class="bg-img blur-up lazyload" alt="{{@$banners->bottom_second_image_attribute}}">
                    <div class="banner-details">
                        <div class="banner-box">
                            <h6 class="text-danger"></h6>
                            <h5></h5>
                            <h6 class="text-content"></h6>
                        </div>
                        <a href="{{url($banners->bottom_second_image_url)}}" class="banner-button text-white">Shop Now <i
                                class="fa-solid fa-right-long ms-2"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-lg-4 col-sm-6">
                <div class="banner-contain hover-effect">
                    <img src="{{@$banners->bottom_third_image}}" class="bg-img blur-up lazyload" alt="{{@$banners->bottom_third_image_attribute}}">
                    <div class="banner-details">
                        <div class="banner-box">
                            <h6 class="text-danger"></h6>
                            <h5></h5>
                            <h6 class="text-content"></h6>
                        </div>
                        <a href="{{url($banners->bottom_third_image_url)}}" class="banner-button text-white">Shop Now <i
                                class="fa-solid fa-right-long ms-2"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-lg-4 col-sm-6">
                <div class="banner-contain hover-effect">
                    <img src="{{$banners->bottom_fourth_image}}" class="bg-img blur-up lazyload" alt="{{@$banners->bottom_fourth_image_attribute}}">
                    <div class="banner-details">
                        <div class="banner-box">
                            <h6 class="text-danger"></h6>
                            <h5></h5>
                            <h6 class="text-content"></h6>
                        </div>
                        <a href="{{url($banners->bottom_fourth_image_url)}}" class="banner-button text-white">Shop Now <i
                                class="fa-solid fa-right-long ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endisset
<!-- Home Section End -->

<!-- Banner Section Start -->
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

<!-- Product Section End -->

    <!-- Product Section Start -->
    <section class="product-section">
        <div class="container-fluid-lg">
            <div class="row g-sm-4 g-3">
                <div class="col-xxl-3 col-xl-4 d-none d-xl-block">
                    <div class="p-sticky">
                        <div class="category-menu">
                            <h3>Category</h3>
                            @isset($categories)
                            <ul>
                                @foreach ($categories as $item)
                                <li>
                                    <div class="category-list">
                                        <img src="{{$item->icon}}"  class="blur-up lazyload" alt="{{$item->image_attribute}}">
                                        <h5>
                                            <a href="/category/{{$item->short_url}}">
                                                <h5>{{$item->title}}</h5></a>
                                        </h5>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            @endisset
                        </div>
                        @if(@$Hbanners)
                        <div class="ratio_156 section-t-space">
                            <div class="home-contain hover-effect">
                                <img src="{{ $Hbanners->side_first_banner }}" class="bg-img blur-up lazyload"
                                    alt="">
                                <div class="home-detail p-top-left home-p-medium">
                                    <div>
                                        <h6 class="text-yellow home-banner"></h6>
                                        <h3 class="text-uppercase fw-normal"><span
                                                class="theme-color fw-bold"></span> </h3>
                                        <h3 class="fw-light"> </h3>
                                        <button onclick="location.href = '{{url($Hbanners->side_first_banner_url)}}';"
                                            class="btn btn-animation btn-md mend-auto">Shop Now <i
                                                class="fa-solid fa-arrow-right icon"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(@$Hbanners)
                        <div class="ratio_medium section-t-space">
                            <div class="home-contain hover-effect">
                                <img src="{{ $Hbanners->side_second_banner }}" class="img-fluid blur-up lazyload"
                                    alt="{{ $Hbanners->side_second_banner_attribute }}">
                                <div class="home-detail p-top-left home-p-medium">
                                    <div>
                                        <h4 class="text-yellow text-exo home-banner"></h4>
                                        <h2 class="text-uppercase fw-normal mb-0 text-russo theme-color"></h2>
                                        <h2 class="text-uppercase fw-normal text-title"></h2>
                                        <p class="mb-3"></p>
                                        <button onclick="location.href = '{{url($Hbanners->side_second_banner)}}';"
                                            class="btn btn-animation btn-md mend-auto">Shop Now <i
                                                class="fa-solid fa-arrow-right icon"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>

                <div class="col-xxl-9 col-xl-8">
                    <div class="title title-flex">
                        <div>
                            <h2>Top Products</h2>
                            <span class="title-leaf">
                                <svg class="icon-width">
                                    <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
                                </svg>
                            </span>
                            <p>Don't miss this opportunity at a special discount just for this week.</p>
                        </div>

                    </div>

                    <div class="section-b-space">
                        @isset($products)

                        <div class="product-border border-row">
                            <div class="slider-6_2 no-arrow">
                                @foreach ($products as $product )
                                <div class="col-6 px-0">
                                    <div class="product-box-3 h-100 wow fadeInUp">
                                        <div class="product-header">
                                            <div class="product-image">
                                                <a href="{{ url('/product/'.$product->short_url) }}" tabindex="-1">
                                                    <img src="{{asset($product->thumbnail_image)}}"
                                                        class="img-fluid blur-up lazyload" alt="">
                                                </a>

                                                <ul class="product-option">
                                                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                        <a href="{{ url('/product/'.$product->short_url) }}" tabindex="-1">
                                                            <i data-feather="eye"></i>
                                                        </a>
                                                    </li>



                                                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                                        <a id="wishlist_check_{{@$product->id}}"  href="avascript:void(0)" class="notifi-wishlist {{ (Auth::guard('customer')->check())?'wishlist-action':'login-popup' }} ">
                                                            <i data-feather="heart"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product-footer">
                                            <div class="product-detail">

                                                <a href="{{ url('/product/'.$product->short_url) }}">
                                                    <h5 class="name">{{$product->title}}</h5>
                                                </a>

                                                <div class="product-rating mt-2">
                                                    <ul class="rating">
                                                        @if(Helper::averageRating($product->id)>0)
                                                        <li class="review">
                                                            <i class="fa-solid fa-star"></i>{{ Helper::averageRating($product->id)  }}
                                                        </li>
                                                        @endif
                                                    </ul>
                                                    {{-- <span>(4.0)</span> --}}
                                                </div>
                                                <!-- <h6 class="unit">250 ml</h6> -->
                                                <h5 class="price">
                                                    @if(Helper::offerPrice($product->id)!='')
                                                    <span class="theme-color">
                                                        {{Helper::defaultCurrency().' '.(Helper::offerPriceAmount($product->id))}}
                                                    </span>
                                                    <del>
                                                        {{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*$product->price,2)}}
                                                    </del>
                                                    @else
                                                    <span class="theme-color">
                                                        {{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*$product->price,2)}}
                                                    </span>
                                                    @endif
                                                </h5>
                                               <div class="add-to-cart-box bg-white ">
                                                    <button type="button" class="btn btn-add-cart cart-action cartBtn" data-frame="1" data-mount="Yes" data-id="{{$product->id}}" data-size="{{@$productPrice->size_id}}"  data-product_type_id="{{$product->product_type_id}}">Add
                                                        <i class="fa-solid fa-plus bg-gray"></i></button>
                                                    {{-- <div class="cart_qty qty-box">
                                                        <div class="input-group bg-white">
                                                            <button type="button" class="qty-left-minus bg-gray cartBtn"
                                                                data-type="minus" data-field="">
                                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                                            </button>
                                                            <input class="form-control input-number qty-input cartBtn" type="text"
                                                                name="quantity" value="0">
                                                            <button type="button" class="qty-right-plus bg-gray"
                                                                data-type="plus" data-field="">
                                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div> --}}
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
                    @isset($popularProducts)

                    <div class="title d-block">
                        <h2>Populat Products</h2>
                        <span class="title-leaf">
                            <svg class="icon-width">
                                <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
                            </svg>
                        </span>
                        <p></p>
                    </div>
                    <div class="product-border overflow-hidden wow fadeInUp">
                        <div class="product-box-slider no-arrow">
                            @foreach ($popularProducts as $product )
                            <div>
                                <div class="row m-0">
                                    <div class="col-12 px-0">
                                        <div class="product-box">
                                            <div class="product-image">
                                                <a href="{{ url('/product/'.$product->short_url) }}">
                                                    <img src="{{asset($product->thumbnail_image)}}"
                                                        class="img-fluid blur-up lazyload" alt="">
                                                </a>
                                                <ul class="product-option">
                                                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                        <a href="{{ url('/product/'.$product->short_url) }}" tabindex="-1">
                                                            <i data-feather="eye"></i>
                                                        </a>
                                                    </li>



                                                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                                        <a id="wishlist_check_{{@$product->id}}"  href="avascript:void(0)" class="notifi-wishlist {{ (Auth::guard('customer')->check())?'wishlist-action':'login-popup' }} ">
                                                            <i data-feather="heart"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="product-detail">
                                                <a href="{{ url('/product/'.$product->short_url) }}">
                                                    <h5 class="name">{{$product->title}}</h5>
                                                </a>

                                                <h5 class="sold text-content">
                                                    @if(Helper::offerPrice($product->id)!='')
                                                    <span class="theme-color">
                                                        {{Helper::defaultCurrency().' '.(Helper::offerPriceAmount($product->id))}}
                                                    </span>
                                                    <del>
                                                        {{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*$product->price,2)}}
                                                    </del>
                                                    @else
                                                    {{Helper::offerPriceAmount($product->id)}}
                                                    <span class="theme-color">
                                                        {{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*$product->price,2)}}
                                                    </span>
                                                    @endif
                                                </h5>

                                                <div class="product-rating mt-2">
                                                    <ul class="rating">

                                                    </ul>
                                                    @if($product->availability === "In Stock")
                                                    <h6 class="theme-color">In Stock</h6>
                                                    @endif
                                                </div>
                                                @if($product->availability === "In Stock")
                                                <div class="add-to-cart-box bg-white ">
                                                    <button type="button" class="btn btn-add-cart cart-action cartBtn" data-frame="1" data-mount="Yes" data-id="{{$product->id}}" data-size="{{@$productPrice->size_id}}"  data-product_type_id="{{$product->product_type_id}}">Add
                                                        <i class="fa-solid fa-plus bg-gray"></i></button>
                                                    {{-- <div class="cart_qty qty-box">
                                                        <div class="input-group bg-white">
                                                            <button type="button" class="qty-left-minus bg-gray cartBtn"
                                                                data-type="minus" data-field="">
                                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                                            </button>
                                                            <input class="form-control input-number qty-input cartBtn" type="text"
                                                                name="quantity" value="0">
                                                            <button type="button" class="qty-right-plus bg-gray"
                                                                data-type="plus" data-field="">
                                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div> --}}
                                               </div>
                                                @else
                                                <div class="add-to-cart-box bg-white ">
                                                    <a href="https://wa.me/{!! @$contact->whatsapp_number!!}?text=I%20am%20interested%20in%20this%20product%20{{$product->title}}.%20Can%20you%20provide%20more%20details%3F
                                                    " class="btn btn-add-cart cart-action cartBtn">Enquiry
                                                       <i class="fa-solid fa fa-whatsapp bg-gray"></i>
                                                    </a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                    @endisset
                    <div class="section-t-space section-b-space">
                        <div class="row g-md-4 g-3">
                            @if(@$Hbanners)
                            <div class="col-xxl-8 col-xl-12 col-md-7">
                                <div class="banner-contain hover-effect">

                                    <img src="{{ $Hbanners->category_second_banner }}" class="bg-img blur-up lazyload"
                                        alt="{{ $Hbanners->category_first_banner_attribute }}">
                                    <div class="banner-details p-center-left p-4">
                                        <div>
                                            <h2 class="text-kaushan fw-normal theme-color"></h2>
                                            <h3 class="mt-2 mb-3"> <BR></BR></h3>

                                            <button onclick="location.href = '{{ @$Hbanners->category_first_banner_url }}';"
                                                class="btn btn-animation btn-sm mend-auto">Shop Now <i
                                                    class="fa-solid fa-arrow-right icon"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(@$Hbanners)
                            <div class="col-xxl-4 col-xl-12 col-md-5">
                                <a href="shop-left-sidebar.html" class="banner-contain hover-effect h-100">
                                    <img src="{{ @$Hbanners->category_second_banner }}" class="bg-img blur-up lazyload"
                                        alt="{{ @$Hbanners->category_second_banner_attribute }}">
                                    <div class="banner-details p-center-left p-4 h-100">
                                        <div>
                                            <h2 class="text-kaushan fw-normal text-danger"></h2>
                                            <h3 class="mt-2 mb-2 theme-color"> <br></h3>
                                            <h3 class="fw-normal product-name text-title"></h3>
                                            <button onclick="location.href = '{{ @$Hbanners->category_second_banner_url }}';"
                                                class="btn btn-animation btn-sm mend-auto">Shop Now <i
                                                    class="fa-solid fa-arrow-right icon"></i></button>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="title d-block">
                        <div>
                            <h2>Our best Seller</h2>
                            <span class="title-leaf">
                                <svg class="icon-width">
                                    <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
                                </svg>
                            </span>
                            <p></p>
                        </div>
                    </div>
                    @isset($bestProducts)
                    <div class="best-selling-slider product-wrapper wow fadeInUp">
                        @foreach($bestProducts->chunk(4) as $productChunk)
                            <div>
                                <ul class="product-list">
                                    @foreach($bestProducts as $product)
                                        <li>
                                            <div class="offer-product">
                                                <a href="{{ url('/product/'.$product->short_url) }}">
                                                    <img src="{{asset($product->thumbnail_image)}}"
                                                        class="img-fluid blur-up lazyload" alt="">
                                                </a>
                                                <div class="offer-detail">
                                                    <div>
                                                        <a href="{{ url('/product/'.$product->short_url) }}" class="text-title">
                                                            <h6 class="name">{{ $product->name }}</h6>
                                                        </a>

                                                        <h6 class="price theme-color">
                                                            {{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*$product->price,2)}}

                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>

                    @endisset

                </div>




                </div>
            </div>
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
