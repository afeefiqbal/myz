@extends('web.layouts.main')
@section('content')
<!-- Breadcrumb Section Start -->
<section class="breadscrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadscrumb-contain">
                    <h2></h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="index.php">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>

                            <li class="breadcrumb-item active">{{$product->title}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Product Left Sidebar Start -->
<section class="product-section">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-xxl-9 col-xl-8 col-lg-7 wow fadeInUp">
                <div class="row g-4">
                    <div class="col-xl-6 wow fadeInUp">
                        <div class="product-left-box">
                            <div class="row g-sm-4 g-2">
                             
                                <div class="col-xxl-10 col-lg-12 col-md-10 order-xxl-2 order-lg-1 order-md-2">
                                    <div class="product-main no-arrow">
                                        <div>
                                            <div class="slider-image">
                                                <img src="{{asset($product->thumbnail_image)}}" id="img-1"
                                                    data-zoom-image="{{asset($product->thumbnail_image)}}" class="
                                                    img-fluid image_zoom_cls-0 blur-up lazyload" alt="">
                                            </div>
                                        </div>
                                        @if($product->activeGalleries->count() > 0)
                                        @foreach ($product->activeGalleries as $gallery)
                                        <div>
                                            <div class="slider-image">
                                                <img src="{{asset($gallery->image)}}" id="img-1"
                                                    data-zoom-image="{{asset($gallery->image)}}" class="
                                                    img-fluid image_zoom_cls-0 blur-up lazyload" alt="">
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif

                                       
                                    </div>
                                </div>

                                <div class="col-xxl-2 col-lg-12 col-md-2 order-xxl-1 order-lg-2 order-md-1">
                                    <div class="left-slider-image left-slider no-arrow slick-top">
                                        <div class="sidebar-image">
                                            <img src="{{asset($product->thumbnail_image)}}"
                                                class="img-fluid blur-up lazyload" alt="">
                                        </div>
                                        @if($product->activeGalleries->count() > 0)
                                        @foreach ($product->activeGalleries as $gallery)
                                        <div>
                                            <div class="sidebar-image">
                                                <img src="{{asset($gallery->image)}}"
                                                    class="img-fluid blur-up lazyload" alt="">
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 wow fadeInUp">
                        <div class="right-box-contain">
                            {{-- <h6 class="offer-top">30% Off</h6> --}}
                            <h2 class="name">{{$product->title}}</h2>
                            <div class="price-rating">
                                <h3 class="theme-color price">{{$product->price}}
                                     {{-- <del class="text-content">$58.46</del>  --}}
                                     {{-- <span class="offer theme-color">(8% off)</span> --}}
                                    </h3>
                                <div class="product-rating custom-rate">
                                    <ul class="rating">
                                        @if($averageRatings >0)
                                        <div class="rate_area">
                
                                            <i class="fa-solid fa-star"></i>  {{ $averageRatings }}
                                        </div>
                                        @endif
                                        {{-- <li>
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
                                        </li> --}}
                                    </ul>
                                    @if($totalRatings >0)
                                    <span class="review">{{ $totalRatings }}Customer Review</span>
                                    @endif
                                </div>
                            </div>

                            <div class="procuct-contain">
                                <p>
                                    {!! $product->description !!}
                                </p>
                            </div>

                            {{-- <div class="product-packege">
                                <div class="product-title">
                                    <h4>RAM</h4>
                                </div>
                                <ul class="select-packege">
                                    <li>
                                        <a href="javascript:void(0)" class="active">8 gb</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">128 gb</a>
                                    </li>
                                  
                                 
                                </ul>
                            </div> --}}

                            {{-- <div class="time deal-timer product-deal-timer mx-md-0 mx-auto">
                                <div class="product-title">
                                    <h4>Hurry up! Sales Ends In</h4>
                                </div>
                                <ul>
                                    <li>
                                        <div class="counter">
                                            <div>
                                                <h5 id="days2"></h5>
                                                <h6>Days</h6>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="counter">
                                            <div>
                                                <h5 id="hours2"></h5>
                                                <h6>Hours</h6>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="counter">
                                            <div>
                                                <h5 id="minutes2"></h5>
                                                <h6>Min</h6>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="counter">
                                            <div>
                                                <h5 id="seconds2"></h5>
                                                <h6>Sec</h6>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div> --}}



                            <div class="note-box product-packege">
                                <div class="cart_qty qty-box product-qty">
                                    <div class="input-group">
                                        <button type="button" class="qty-right-plus" data-type="plus" data-field="">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                        <input class="form-control input-number qty-input" type="text"
                                            name="quantity" value="0">
                                        <button type="button" class="qty-left-minus" data-type="minus"
                                            data-field="">
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>

                                <button 
                                    class="btn btn-md bg-dark cart-button text-white w-100">Add To Cart</button>
                            </div>

                            <div class="buy-box">
                                <a href="javascript:void(0)">
                                    <i data-feather="heart"></i>
                                    <span>Add To Wishlist</span>
                                </a>

                                {{-- <a href="compare.php">
                                    <i data-feather="shuffle"></i>
                                    <span>Add To Compare</span>
                                </a> --}}
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-xl-4 col-lg-5 d-none d-lg-block wow fadeInUp">
                <div class="right-sidebar-box">
                    <div class="vendor-box">
                        <div class="verndor-contain">
                            <div class="vendor-image">
                                {{-- <img src="https://img.freepik.com/free-vector/branding-identity-corporate-logo-vector-design-template_460848-13935.jpg?w=740&t=st=1705594291~exp=1705594891~hmac=b105ea166f061647355869064c197d124e04c40457605aee8b04703da31b9478" class="blur-up lazyload" alt=""> --}}
                            </div>

                            <div class="vendor-name">
                                <h5 class="fw-500">Asus</h5>

                                <div class="product-rating mt-1">
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

                            </div>
                        </div>

                        <p class="vendor-detail">ASUS is one of Fortune magazine's World's Most Admired Companies, and is dedicated to creating products for today and tomorrow's smart life.</p>

                        <div class="vendor-list">
                            <ul>
                                <li>
                                    <div class="address-contact">
                                        <i data-feather="map-pin"></i>
                                        <h5>Address: <span class="text-content">1288 Franklin Avenue</span></h5>
                                    </div>
                                </li>

                                <li>
                                    <div class="address-contact">
                                        <i data-feather="headphones"></i>
                                        <h5>Contact Seller: <span class="text-content">(+1)-123-456-789</span></h5>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="pt-25">
                        <div class="hot-line-number">
                            <h5>Hotline Order:</h5>
                            <h6>Mon - Fri: 07:00 am - 08:30PM</h6>
                            <h3>(+1) 123 456 789</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Left Sidebar End -->

<!-- Nav Tab Section Start -->
<section>
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="product-section-box m-0">
                    <ul class="nav nav-tabs custom-nav" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                data-bs-target="#description" type="button" role="tab" aria-controls="description"
                                aria-selected="true">Description</button>
                        </li>

                        

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review"
                                type="button" role="tab" aria-controls="review"
                                aria-selected="false">Review</button>
                        </li>
                    </ul>

                    <div class="tab-content custom-tab" id="myTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel"
                            aria-labelledby="description-tab">
                            <div class="product-description">
                            
                                <div class="nav-desh">
                                    <div class="desh-title">
                                        <!-- <h5>Organic:</h5> -->
                                    </div>
                                    <p>
                                        {!! $product->about_item !!}
                                    </p>
                                </div>

                      
                            </div>
                        </div>

             
                        <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                            <div class="review-box">
                                <div class="row g-4">
                                    <div class="col-xl-6">
                                        <div class="review-title">
                                            <h4 class="fw-500">Customer reviews</h4>
                                        </div>

                                        <div class="d-flex">
                                            <div class="product-rating">
                                                <ul class="rating">
                                                    @for($i=5;$i>=1;$i--)
                                                    <li>
                                                        {{ $i }} <i data-feather="star" class="fill"></i>
                                                    </li>
                                                    @php $var = 'starPercent'.$i @endphp
                                                   @endfor
                                                </ul>
                                            </div>
                                            <h6 class="ms-3">{{ $totalRatings     }} Ratings & {{ $totalReviews }} Reviews</h6>
                                        </div>

                                        <div class="rating-box">
                                            <ul>
                                                <li>
                                                    <div class="rating-list">
                                                        <h5>5 Star</h5>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 68%" aria-valuenow="100"
                                                                aria-valuemin="0" aria-valuemax="100">
                                                                68%
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="rating-list">
                                                        <h5>4 Star</h5>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 67%" aria-valuenow="100"
                                                                aria-valuemin="0" aria-valuemax="100">
                                                                67%
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="rating-list">
                                                        <h5>3 Star</h5>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 42%" aria-valuenow="100"
                                                                aria-valuemin="0" aria-valuemax="100">
                                                                42%
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="rating-list">
                                                        <h5>2 Star</h5>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 30%" aria-valuenow="100"
                                                                aria-valuemin="0" aria-valuemax="100">
                                                                30%
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="rating-list">
                                                        <h5>1 Star</h5>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 24%" aria-valuenow="100"
                                                                aria-valuemin="0" aria-valuemax="100">
                                                                24%
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="review-title">
                                            <h4 class="fw-500">Add a review</h4>
                                        </div>

                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <div class="form-floating theme-form-floating">
                                                    <input type="text" class="form-control" id="name"
                                                        placeholder="Name">
                                                    <label for="name">Your Name</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-floating theme-form-floating">
                                                    <input type="email" class="form-control" id="email"
                                                        placeholder="Email Address">
                                                    <label for="email">Email Address</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-floating theme-form-floating">
                                                    <input type="url" class="form-control" id="website"
                                                        placeholder="Website">
                                                    <label for="website">Website</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-floating theme-form-floating">
                                                    <input type="url" class="form-control" id="review1"
                                                        placeholder="Give your review a title">
                                                    <label for="review1">Review Title</label>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-floating theme-form-floating">
                                                    <textarea class="form-control"
                                                        placeholder="Leave a comment here" id="floatingTextarea2"
                                                        style="height: 150px"></textarea>
                                                    <label for="floatingTextarea2">Write Your
                                                        Comment</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="review-title">
                                            <h4 class="fw-500">Customer questions & answers</h4>
                                        </div>

                                        <div class="review-people">
                                            <ul class="review-list">
                                                <li>
                                                    <div class="people-box">
                                                        <div>
                                                            <div class="people-image">
                                                                <img src="assets/images/review/1.jpg"
                                                                    class="img-fluid blur-up lazyload" alt="">
                                                            </div>
                                                        </div>

                                                        <div class="people-comment">
                                                            <a class="name" href="javascript:void(0)">Tracey</a>
                                                            <div class="date-time">
                                                                <h6 class="text-content">14 Jan, 2022 at 12.58 AM
                                                                </h6>

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
                                                                            <i data-feather="star"></i>
                                                                        </li>
                                                                        <li>
                                                                            <i data-feather="star"></i>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>

                                                            <div class="reply">
                                                                <p>Icing cookie carrot cake chocolate cake sugar
                                                                    plum jelly-o danish. Dragée dragée shortbread
                                                                    tootsie roll croissant muffin cake I love gummi
                                                                    bears. Candy canes ice cream caramels tiramisu
                                                                    marshmallow cake shortbread candy canes
                                                                    cookie.<a href="javascript:void(0)">Reply</a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="people-box">
                                                        <div>
                                                            <div class="people-image">
                                                                <img src="assets/images/review/2.jpg"
                                                                    class="img-fluid blur-up lazyload" alt="">
                                                            </div>
                                                        </div>

                                                        <div class="people-comment">
                                                            <a class="name" href="javascript:void(0)">Olivia</a>
                                                            <div class="date-time">
                                                                <h6 class="text-content">01 May, 2022 at 08.31 AM
                                                                </h6>
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
                                                                            <i data-feather="star"></i>
                                                                        </li>
                                                                        <li>
                                                                            <i data-feather="star"></i>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>

                                                            <div class="reply">
                                                                <p>Tootsie roll cake danish halvah powder cake.
                                                                    Tootsie roll candy marshmallow cookie brownie
                                                                    apple pie pudding brownie chocolate bar. Jujubes
                                                                    gummi bears I love powder danish oat cake tart
                                                                    croissant.<a href="javascript:void(0)">Reply</a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="people-box">
                                                        <div>
                                                            <div class="people-image">
                                                                <img src="assets/images/review/3.jpg"
                                                                    class="img-fluid blur-up lazyload" alt="">
                                                            </div>
                                                        </div>

                                                        <div class="people-comment">
                                                            <a class="name" href="javascript:void(0)">Gabrielle</a>
                                                            <div class="date-time">
                                                                <h6 class="text-content">21 May, 2022 at 05.52 PM
                                                                </h6>

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
                                                                            <i data-feather="star"></i>
                                                                        </li>
                                                                        <li>
                                                                            <i data-feather="star"></i>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>

                                                            <div class="reply">
                                                                <p>Biscuit chupa chups gummies powder I love sweet
                                                                    pudding jelly beans. Lemon drops marzipan apple
                                                                    pie gingerbread macaroon croissant cotton candy
                                                                    pastry wafer. Carrot cake halvah I love tart
                                                                    caramels pudding icing chocolate gummi bears.
                                                                    Gummi bears danish cotton candy muffin marzipan
                                                                    caramels awesome feel. <a
                                                                        href="javascript:void(0)">Reply</a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Nav Tab Section End -->

<!-- Releted Product Section Start -->
<section class="product-list-section section-b-space">
    <div class="container-fluid-lg">
        <div class="title">
            <h2>Related Products</h2>
            <span class="title-leaf">
                <svg class="icon-width">
                    <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
                </svg>
            </span>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="slider-6_1 product-wrapper">
                    <div>
                        <div class="product-box-3 wow fadeInUp">
                            <div class="product-header">
                                <div class="product-image">
                                    <a href="product.php">
                                        <img src="https://img.freepik.com/free-vector/new-modern-realistic-front-view-black-iphone-mockup-isolated-white-mobile-template-vector_90220-957.jpg?t=st=1705510825~exp=1705511425~hmac=0a8967fb72342dd8df017b7f071982b14de3fef16056652fd6bdb2648aad9c3e"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>

                                    <ul class="product-option">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.php">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.php" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="product-footer">
                                <div class="product-detail">
                                    <span class="span-name">Smart Phone</span>
                                    <a href="product.php">
                                        <h5 class="name">Iphone</h5>
                                    </a>
                                    <div class="product-rating mt-2">
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
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                        </ul>
                                        <span>(5.0)</span>
                                    </div>
                                 
                                    <h5 class="price"><span class="theme-color">$10.25</span> <del>$12.57</del>
                                    </h5>
                                   <div class="add-to-cart-box bg-white">
                                        <button class="btn btn-add-cart addcart-button">Add
                                            <i class="fa-solid fa-plus bg-gray"></i></button>
                                        <div class="cart_qty qty-box">
                                            <div class="input-group bg-white">
                                                <button type="button" class="qty-left-minus bg-gray"
                                                    data-type="minus" data-field="">
                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                </button>
                                                <input class="form-control input-number qty-input" type="text"
                                                    name="quantity" value="0">
                                                <button type="button" class="qty-right-plus bg-gray"
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

                    <div>
                        <div class="product-box-3 wow fadeInUp" data-wow-delay="0.05s">
                            <div class="product-header">
                                <div class="product-image">
                                    <a href="product.php">
                                        <img src="https://img.freepik.com/free-vector/wifi-router-front-side-view-mockup_107791-5061.jpg?w=1060&t=st=1705510903~exp=1705511503~hmac=3cc0dafdb9f9020d8c28f83b575bb11ed268ee18341cab188b9a7482cd0b124b"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>

                                    <ul class="product-option">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.php">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.php" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-footer">
                                <div class="product-detail">
                                    <span class="span-name">PC</span>
                                    <a href="product.php">
                                        <h5 class="name">iMac</h5>
                                    </a>
                                    <div class="product-rating mt-2">
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
                                        <span>(4.0)</span>
                                    </div>
                             
                                    <h5 class="price"><span class="theme-color">$08.02</span> <del>$15.15</del>
                                    </h5>
                                   <div class="add-to-cart-box bg-white">
                                        <button class="btn btn-add-cart addcart-button">Add
                                            <i class="fa-solid fa-plus bg-gray"></i></button>
                                        <div class="cart_qty qty-box">
                                            <div class="input-group bg-white">
                                                <button type="button" class="qty-left-minus bg-gray"
                                                    data-type="minus" data-field="">
                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                </button>
                                                <input class="form-control input-number qty-input" type="text"
                                                    name="quantity" value="0">
                                                <button type="button" class="qty-right-plus bg-gray"
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

                    <div>
                        <div class="product-box-3 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="product-header">
                                <div class="product-image">
                                    <a href="product.php">
                                        <img src="https://img.freepik.com/free-vector/new-modern-realistic-front-view-black-iphone-mockup-isolated-white-mobile-template-vector_90220-957.jpg?t=st=1705510825~exp=1705511425~hmac=0a8967fb72342dd8df017b7f071982b14de3fef16056652fd6bdb2648aad9c3e"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>

                                    <ul class="product-option">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.php">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.php" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="product-footer">
                                <div class="product-detail">
                                    <span class="span-name">Router</span>
                                    <a href="product.php">
                                        <h5 class="name">Router</h5>
                                    </a>
                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(2.4)</span>
                                    </div>
                                 
                                    <h5 class="price"><span class="theme-color">$04.33</span> <del>$10.36</del>
                                    </h5>
                                   <div class="add-to-cart-box bg-white">
                                        <button class="btn btn-add-cart addcart-button">Add
                                            <i class="fa-solid fa-plus bg-gray"></i></button>
                                        <div class="cart_qty qty-box">
                                            <div class="input-group bg-white">
                                                <button type="button" class="qty-left-minus bg-gray"
                                                    data-type="minus" data-field="">
                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                </button>
                                                <input class="form-control input-number qty-input" type="text"
                                                    name="quantity" value="0">
                                                <button type="button" class="qty-right-plus bg-gray"
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

                    <div>
                        <div class="product-box-3 wow fadeInUp" data-wow-delay="0.15s">
                            <div class="product-header">
                                <div class="product-image">
                                    <a href="product.php">
                                        <img src="https://img.freepik.com/free-vector/wifi-router-front-side-view-mockup_107791-5061.jpg?w=1060&t=st=1705510903~exp=1705511503~hmac=3cc0dafdb9f9020d8c28f83b575bb11ed268ee18341cab188b9a7482cd0b124b"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>

                                    <ul class="product-option">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.php">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.php" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="product-footer">
                                <div class="product-detail">
                                    <span class="span-name">Elecornics</span>
                                    <a href="product.php">
                                        <h5 class="name">Smart Device</h5>
                                    </a>
                                    <div class="product-rating mt-2">
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
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                        </ul>
                                        <span>(5.0)</span>
                                    </div>
                                  
                                    <h5 class="price"><span class="theme-color">$12.52</span> <del>$13.62</del>
                                    </h5>
                                   <div class="add-to-cart-box bg-white">
                                        <button class="btn btn-add-cart addcart-button">Add
                                            <i class="fa-solid fa-plus bg-gray"></i></button>
                                        <div class="cart_qty qty-box">
                                            <div class="input-group bg-white">
                                                <button type="button" class="qty-left-minus bg-gray"
                                                    data-type="minus" data-field="">
                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                </button>
                                                <input class="form-control input-number qty-input" type="text"
                                                    name="quantity" value="0">
                                                <button type="button" class="qty-right-plus bg-gray"
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

                    <div>
                        <div class="product-box-3 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="product-header">
                                <div class="product-image">
                                    <a href="product.php">
                                        <img src="https://img.freepik.com/free-vector/laptop-realistic_78370-511.jpg?w=740&t=st=1705510753~exp=1705511353~hmac=00360f5dab99b617f54ed6a71bdec5ed6e7c91aeddbc9eed4ddd97a8b7015462"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>

                                    <ul class="product-option">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.php">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.php" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="product-footer">
                                <div class="product-detail">
                                    <span class="span-name">Smart Werable</span>
                                    <a href="product.php">
                                        <h5 class="name">Amazefit</h5>
                                    </a>
                                    <div class="product-rating mt-2">
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
                                                <i data-feather="star"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(3.8)</span>
                                    </div>
                               
                                    <h5 class="price"><span class="theme-color">$10.25</span> <del>$12.36</del>
                                    </h5>
                                   <div class="add-to-cart-box bg-white">
                                        <button class="btn btn-add-cart addcart-button">Add
                                            <i class="fa-solid fa-plus bg-gray"></i></button>
                                        <div class="cart_qty qty-box">
                                            <div class="input-group bg-white">
                                                <button type="button" class="qty-left-minus bg-gray"
                                                    data-type="minus" data-field="">
                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                </button>
                                                <input class="form-control input-number qty-input" type="text"
                                                    name="quantity" value="0">
                                                <button type="button" class="qty-right-plus bg-gray"
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

                    <div>
                        <div class="product-box-3 wow fadeInUp" data-wow-delay="0.25s">
                            <div class="product-header">
                                <div class="product-image">
                                    <a href="product.php">
                                        <img src="https://img.freepik.com/free-vector/new-modern-realistic-front-view-black-iphone-mockup-isolated-white-mobile-template-vector_90220-957.jpg?t=st=1705510825~exp=1705511425~hmac=0a8967fb72342dd8df017b7f071982b14de3fef16056652fd6bdb2648aad9c3e"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>

                                    <ul class="product-option">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.php">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.php" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="product-footer">
                                <div class="product-detail">
                                    <span class="span-name">Laptop</span>
                                    <a href="product.php">
                                        <h5 class="name">Lenovo</h5>
                                    </a>
                                    <div class="product-rating mt-2">
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
                                        <span>(4.0)</span>
                                    </div>

                                    <h6 class="unit">550 G</h6>

                                    <h5 class="price"><span class="theme-color">$14.25</span> <del>$16.57</del>
                                    </h5>
                                   <div class="add-to-cart-box bg-white">
                                        <button class="btn btn-add-cart addcart-button">Add
                                            <i class="fa-solid fa-plus bg-gray"></i></button>
                                        <div class="cart_qty qty-box">
                                            <div class="input-group bg-white">
                                                <button type="button" class="qty-left-minus bg-gray"
                                                    data-type="minus" data-field="">
                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                </button>
                                                <input class="form-control input-number qty-input" type="text"
                                                    name="quantity" value="0">
                                                <button type="button" class="qty-right-plus bg-gray"
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

                </div>
            </div>
        </div>
    </div>
</section>
@endsection