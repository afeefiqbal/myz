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
                        <img src="{{$banners->main_banner}}" class="bg-img blur-up lazyload" alt="">
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
                            <img src="{{$banners->left_side_banner}}" class="bg-img blur-up lazyload"
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
                            <img src="{{$banners->left_second_banner}}" class="bg-img blur-up lazyload"
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
<section class="banner-section ratio_60 wow fadeInUp">
    <div class="container-fluid-lg">
        <div class="row g-sm-4 g-3">
            <div class="col-xxl-3 col-lg-4 col-sm-6">
                <div class="banner-contain hover-effect">
                    <img src="{{$banners->bottom_first_image}}" class="bg-img blur-up lazyload" alt="">
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
                    <img src="{{$banners->bottom_second_image}}" class="bg-img blur-up lazyload" alt="">
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
                    <img src="{{$banners->bottom_third_image}}" class="bg-img blur-up lazyload" alt="">
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
                    <img src="{{$banners->bottom_fourth_image}}" class="bg-img blur-up lazyload" alt="">
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
                                                
                                                <a href="product.php">
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
                                                <h5 class="price"><span class="theme-color">{{$product->price}}</span> <del></del>
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
