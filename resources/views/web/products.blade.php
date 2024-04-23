@extends('web.layouts.main')
@section('content')

    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>Shop Now</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="index.php">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Shop Now</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Poster Section Start -->
    <section>
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="slider-1 slider-animate product-wrapper no-arrow">



                        <div>
                            <div class="banner-contain-2 hover-effect">
                                <img src="https://img.freepik.com/free-vector/electronics-store-template-design_23-2151143816.jpg?w=1380&t=st=1705509934~exp=1705510534~hmac=866be796d522d2263017e0f9b11e8eb26c357165a9685a01f8ca2d36c8167e2b" class="bg-img rounded-3 blur-up lazyload" alt="">
                                <div
                                    class="banner-detail p-center-right position-relative shop-banner ms-auto banner-small">
                                    <div>
                                        <h2></h2>
                                        <h3>Save upto 50%</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Poster Section End -->

    <!-- Shop Section Start -->
    <section class="section-b-space shop-section">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-3 col-lg-4">
                    <div class="left-box wow fadeInUp">
                        <div class="shop-left-sidebar">
                            <div class="back-button">
                                <h3><i class="fa-solid fa-arrow-left"></i> Back</h3>
                            </div>

                            {{-- <div class="filter-category">
                                <div class="filter-title">
                                    <h2>Filters</h2>
                                    <a href="javascript:void(0)">Clear All</a>
                                </div>
                                <ul>
                                    <li>
                                        <a href="javascript:void(0)">Smart Phone</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">Desktop</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">Laptop</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">Smart  Home</a>
                                    </li>
                                  
                                </ul>
                            </div> --}}

                            <div class="accordion custome-accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            <span>Categories</span>
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne">
                                        <div class="accordion-body">
                                            <div class="form-floating theme-form-floating-2 search-box">
                                                <input type="search" class="form-control" id="search"
                                                    placeholder="Search ..">
                                                <label for="search">Search</label>
                                            </div>

                                            <ul class="category-list custom-padding custom-height">
                                                @isset($parentCategories)
                                                    @foreach ($parentCategories as $categories)
                                                    <li>
                                                        <div class="form-check ps-0 m-0 category-list-box filterItem categoryFilterItem">
                                                            <input class="checkbox_animated" type="checkbox" id="fruit">
                                                            <label class="form-check-label" for="fruit">
                                                                <span class="name">{{$categories->title}}</span>
                                                                {{-- <span class="number">(15)</span> --}}
                                                            </label>
                                                        </div>
                                                    </li>
                                                        
                                                    @endforeach
                                            
                                                @endisset
                                            </ul>
                                        </div>
                                    </div>
                                </div>



                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                            aria-expanded="false" aria-controls="collapseThree">
                                            <span>Price</span>
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse show"
                                        aria-labelledby="headingThree">
                                        <div class="accordion-body">
                                            <div class="range-slider">
                                                <input type="text" class="js-range-slider" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                          
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-9 col-lg-8">
                    <div class="show-button">
                        <div class="filter-button-group mt-0">
                            <div class="filter-button d-inline-block d-lg-none">
                                <a><i class="fa-solid fa-filter"></i> Filter Menu</a>
                            </div>
                        </div>

                        <div class="top-filter-menu">
                            <div class="category-dropdown">
                                <h5 class="text-content">Sort By :</h5>
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown">
                                        <span>Most Popular</span> <i class="fa-solid fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item" id="pop" href="javascript:void(0)">Popularity</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" id="low" href="javascript:void(0)">Low - High
                                                Price</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" id="high" href="javascript:void(0)">High - Low
                                                Price</a>
                                        </li>
                                  
                                        <li>
                                            <a class="dropdown-item" id="aToz" href="javascript:void(0)">A - Z Order</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" id="zToa" href="javascript:void(0)">Z - A Order</a>
                                        </li>
                                       
                                    </ul>
                                </div>
                            </div>

                 
                        </div>
                    </div>

                    <div
                        class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section">
                        @isset($products)
                            @foreach ($products as $product)
                            <div>
                                <div class="product-box-3 h-100 wow fadeInUp">
                                    <div class="product-header">
                                        <div class="product-image">
                                            <a href="{{ url('/product/'.$product->short_url) }}" tabindex="-1">
                                                <img src="{{$product->thumbnail_image}}"
                                                    class="img-fluid blur-up lazyload" alt="">
                                            </a>
    
                                            <ul class="product-option">
                                                <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#view">
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
                            <div class="modal fade theme-modal view-modal" id="view" tabindex="-1" aria-labelledby="exampleModalLabel"aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-sm-down">
                                    <div class="modal-content">
                                        <div class="modal-header p-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-sm-4 g-2">
                                                <div class="col-lg-6">
                                                    <div class="slider-image">
                                                        <img src="{{$product->thumbnail_image}}" class="img-fluid blur-up lazyload"
                                                            alt="">
                                                    </div>
                                                </div>
                        
                                                <div class="col-lg-6">
                                                    <div class="right-sidebar-modal">
                                                        <h4 class="title-name">{{$product->title}}</h4>
                                                        <h4 class="price">{{$product->price}}</h4>
                                                        <div class="product-rating">
                                                            {{-- <ul class="rating">
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
                                                            <span class="ms-2">8 Reviews</span>
                                                        --}}
                                                        </div>
                        
                                                        <div class="product-detail">
                                                            <h4>Product Details :</h4>
                                                            <p>{!! $product->description !!}</p>
                                                        </div>
                        
                                                    
                                                        
                                                    
                        
                                                        <div class="modal-button">
                                                            <button 
                                                                class="btn btn-md add-cart-button iconbtn-add-cart cart-action cartBtn" data-frame="1" data-mount="Yes" data-id="{{$product->id}}" data-size="{{@$productPrice->size_id}}"  data-product_type_id="{{$product->product_type_id}}">Add
                                                                To Cart</button>
                                                            <button onclick="location.href = '{{ url('/product/'.$product->short_url) }}'"
                                                                class="btn theme-bg-color view-button icon text-white fw-bold btn-md">
                                                                View More Details</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            @endforeach
                        @endisset
                    </div>

                    <nav class="custome-pagination">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="javascript:void(0)" tabindex="-1" aria-disabled="true">
                                    <i class="fa-solid fa-angles-left"></i>
                                </a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="javascript:void(0)">1</a>
                            </li>
                            <li class="page-item" aria-current="page">
                                <a class="page-link" href="javascript:void(0)">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0)">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0)">
                                    <i class="fa-solid fa-angles-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('scripts')
<script>
$( document ).ready(function() {
    
    $("#tags").hide();
   
});

</script>
    
@endpush


