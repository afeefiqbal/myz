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

                                <button  type="button"
                                    class="btn btn-md bg-dark cart-button text-white w-100 btn btn-add-cart cart-action cartBtn"  data-frame="1" data-mount="Yes" data-id="{{$product->id}}" data-size="{{@$productPrice->size_id}}"  data-product_type_id="{{$product->product_type_id}}">Add To Cart</button>
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
                                <h5 class="fw-500">{{$product->vendor->name}}</h5>

                              

                            </div>
                        </div>

                        <p class="vendor-detail">{!! $product->vendor->about_us !!}</p>

                        

                 
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
                                                @for($i=5;$i>=1;$i--)
                                                <li>
                                                    <div class="rating-list">
                                                        <h5>{{ $i }} Star</h5>
                                                        @php $var = 'starPercent'.$i @endphp
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar" style="width: {{ $$var }}%" aria-valuenow="{{ $$var }}" aria-valuemin="0" aria-valuemax="100">
                                                                68%
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endfor

                                            </ul>
                                        </div>
                                    </div>

                                    {{-- <div class="col-xl-6">
                                        <div class="review-title">
                                            <h4 class="fw-500">Add a review</h4>
                                        </div>
                                        <div class="my-rating" data-rating="0"></div>
                                        <input type="hidden" name="rating" id="rating" class="review-required rating">
                                        <form id="review-form" class="product-review-form" method="post">
                                            <div class="formArea">
                                                <div class="head">
                                         
                                                    <div>
                                                        <div class="my-rating" data-rating="0"></div>
                                                        <input type="hidden" name="rating" id="rating" class="review-required rating">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    @if(!Auth::guard('customer')->check())
                                                        <div class=" col-12 name">
                                                            <div class="form-group">
                                                                <label for="">Full Name</label>
                                                                <img src="{{ asset('frontend/images/loginUser.png') }}" alt="">
                                                                <input type="text" class="form-control product-review-required form-review" placeholder="Full Name"  name="name" id="name">
                                                            </div>
                                                        </div>
                                                        <div class=" col-12 email">
                                                            <div class="form-group">
                                                                <label for="">Email Address</label>
                                                                <img src="{{ asset('frontend/images/icon-email.png') }}" alt="">
                                                                <input   name="email" id="email"  type="text" class="form-control form-review product-review-required" placeholder="Email Address">
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="col-12 message review">
                                                        <div class="form-group">
                                                            <label for="">Message</label>
                                                            <img src="{{ asset('frontend/images/icon-pen.png') }}" alt="">
                                                            <textarea class="form-control form-review product-review-required" rows="4"name="message" id="message" placeholder="Say Something" required></textarea>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="product_id" id="product_id"  value="{{$product->id}}">
                                                    <div class="col-12x ">
                                                        <div class="form-group d-flex align-items-end mb-0">
                                                            <button type="submit" data-url="/product-review" id="-form-btn" class="primary_btn form_submit_btn btn-2-animation ">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                
                                    </div> --}}

                                    <div class="col-12">
                                        <div class="review-title">
                                            <h4 class="fw-500">Customer questions & answers</h4>
                                        </div>

                                        <div class="review-people">
                                            {{-- <ul class="review-list">
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
                                            </ul> --}}
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