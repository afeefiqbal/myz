
@extends('web.layouts.main')
@section('content')


    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>User Dashboard</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{url('//')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">User Dashboard</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- User Dashboard Section Start -->
    <section class="user-dashboard-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-3 col-lg-4">
                    <div class="dashboard-left-sidebar">
                        <div class="close-button d-flex d-lg-none">
                            <button class="close-sidebar">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <div class="profile-box">
                            <div class="cover-image">
                                <img src="../assets/images/inner-page/cover-img.jpg" class="img-fluid blur-up lazyload"
                                    alt="">
                            </div>

                            <div class="profile-contain">
                                <div class="profile-image">
                                    <div class="position-relative">
                                        {!! Helper::printImage($user, 'profile_image','profile_image_webp','image_attribute','blur-up lazyload update_img') !!}
                                       
                                        <div class="cover-icon">
                                            <i class="fa-solid fa-pen">
                                                <input type="file" onchange="readURL(this,0)">
                                            </i>
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-name">
                                    <h3>Vicki E. Pope</h3>
                                    <h6 class="text-content">vicki.pope@gmail.com</h6>
                                </div>
                            </div>
                        </div>

                        <ul class="nav nav-pills user-nav-pills" id="pills-tab" role="tablist">
                            
                            
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                                                data-bs-target="#pills-profile" type="button" role="tab"
                                                                aria-controls="pills-profile" aria-selected="false"><i data-feather="user"></i>
                                                                Profile</button>
                                                        </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-order-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                                    aria-selected="false"><i data-feather="shopping-bag"></i>Order</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-wishlist-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-wishlist" type="button" role="tab"
                                    aria-controls="pills-wishlist" aria-selected="false"><i data-feather="heart"></i>
                                    Wishlist</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-card-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-card" type="button" role="tab" aria-controls="pills-card"
                                    aria-selected="false"><i data-feather="credit-card"></i>My Affilates</button>
                            </li>

                            {{-- <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-address-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-address" type="button" role="tab"
                                    aria-controls="pills-address" aria-selected="false"><i data-feather="map-pin"></i>
                                    Address</button>
                            </li> --}}

                            {{-- <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-security-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-security" type="button" role="tab"
                                    aria-controls="pills-security" aria-selected="false"><i data-feather="shield"></i>
                                    Privacy</button>
                            </li> --}}
                        </ul>
                    </div>
                </div>

                <div class="col-xxl-9 col-lg-8">
                    <button class="btn left-dashboard-show btn-animation btn-md fw-bold d-block mb-4 d-lg-none">Show
                        Menu</button>
                    <div class="dashboard-right-sidebar">
                        <div class="tab-content" id="pills-tabContent">
                      
                            <div class="tab-pane fade show" id="pills-wishlist" role="tabpanel"
                                aria-labelledby="pills-wishlist-tab">
                                <div class="dashboard-wishlist">
                                    <div class="title">
                                        <h2>My Wishlist History</h2>
                                        <span class="title-leaf title-leaf-gray">
                                            <svg class="icon-width bg-gray">
                                                <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="row g-sm-4 g-3">
                                        @foreach(app('wishlist')->getContent() as $row)
                                        @php
                                            $product = App\Models\Product::find($row->id);
                                        @endphp
                                        @if($product!=NULL)
                                        @endif
                                        <div class="col-xxl-3 col-lg-6 col-md-4 col-sm-6" id="wishlistBox{{$row->id}}">
                                            <div class="product-box-3 theme-bg-white h-100">
                                                <div class="product-header">
                                                    <div class="product-image">
                                                        <a href="#">
                                                        
                                                                {!! Helper::printImage($product, 'thumbnail_image','thumbnail_image_webp','thumbnail_image_attribute','img-fluid blur-up lazyload"') !!}
                                                                   
                                                        </a>

                                                        <div class="product-header-top">
                                                            <button class="btn wishlist-button close_button">
                                                                <i data-feather="x"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="product-footer">
                                                    <div class="product-detail">
                                                        <a href="{{ url('/product/'.$product->short_url) }}">
                                                            <h5 class="name">{{$product->title}}</h5>
                                                        </a>
                                                        
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
                                                        @if($product->availability === "In Stock")
                                                        <h6 class="theme-color">In Stock</h6>
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
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="pills-order" role="tabpanel"
                                aria-labelledby="pills-order-tab">
                                <div class="dashboard-order">
                                    <div class="title">
                                        <h2>My Orders History</h2>
                                        <span class="title-leaf title-leaf-gray">
                                            <svg class="icon-width bg-gray">
                                                <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
                                            </svg>
                                        </span>
                                    </div>
                                    @if($orders->isNotEmpty())
                                    <div class="order-contain">
                                        @foreach ($orders as $order)
                                        <div class="order-box dashboard-bg-box">
                                            <div class="order-container">
                                                <div class="order-icon">
                                                    <i data-feather="box"></i>
                                                </div>

                                                <div class="order-detail">
                                                    <h4>Order ID : MYZ# {{$order->orderData->order_code}} <span>{{$order->orderData->status}}</span>
                                                        <a href="{{ url('track-order',$order->orderData->id) }}" tabindex="-1">
                                                            <button class="btn btn-sm" >Track</button>
                                                        </a>
                                                        </h4>
                                                    <h6 class="text-content">  Placed Order on   {{ date("d-m-y", strtotime($order->orderData->created_at))  }}</h6>
                                                </div>
                                            </div>
                                            <div class="row g-sm-4 g-3">
                                                @foreach($order->orderData->orderProducts as $orderProduct)
                                                @if ($orderProduct->productData != null)
                                                <div class="col-xxl-3 col-lg-6 col-md-4 col-sm-6">
                                                    
                                                    <div class="product-box-3 theme-bg-white h-100">
                                                        <div class="product-header">
                                                            <div class="product-image">
                                                                <a href="{{ url('/product/'.$orderProduct->productData->short_url) }}" tabindex="-1">
                                                                
                                                                        {!! Helper::printImage($orderProduct->productData, 'thumbnail_image','thumbnail_image_webp','thumbnail_image_attribute','img-fluid blur-up lazyload"') !!}
                                                                           
                                                                </a>
                                                            </div>
                                                            
                                                        </div>
        
                                                        <div class="product-footer">
                                                            <div class="product-detail">
                                                                <span class="span-name">Vegetable</span>
                                                                <a href="{{ url('/product/'.$orderProduct->productData->short_url) }}" tabindex="-1">
                                                                    <h5 class="name">{{$orderProduct->productData->title}}</h5>
                                                                </a>
                                                        
                                                                <h5 class="price">
                                                                    @if(Helper::offerPrice($orderProduct->productData->id)!='')
                                                                    <span class="theme-color">
                                                                        {{Helper::defaultCurrency().' '.(Helper::offerPriceAmount($orderProduct->productData->id))}}
                                                                    </span> 
                                                                    <del>
                                                                        {{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*$orderProduct->productData->price,2)}}
                                                                    </del>
                                                                    @else
                                                                    <span class="theme-color">
                                                                        {{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*$orderProduct->productData->price,2)}}
                                                                    </span> 
                                                                    @endif
                                                                </h5>
                                                                <div class="add-to-cart-box mt-2">
                                                                    @if($orderProduct->productData->availability === "In Stock")
                                                                    <h6 class="theme-color">In Stock</h6>
                                                                    <div class="add-to-cart-box bg-white ">
                                                                         <button type="button" class="btn btn-add-cart cart-action cartBtn" data-frame="1" data-mount="Yes" data-id="{{$orderProduct->productData->id}}" data-size="{{@$productPrice->size_id}}"  data-product_type_id="{{$orderProduct->productData->product_type_id}}">Add
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
                                                                             <a href="https://wa.me/{!! @$contact->whatsapp_number!!}?text=I%20am%20interested%20in%20this%20product%20{{$orderProduct->productData->title}}.%20Can%20you%20provide%20more%20details%3F
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
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>

                            {{-- <div class="tab-pane fade show" id="pills-address" role="tabpanel"
                                aria-labelledby="pills-address-tab">
                                <div class="dashboard-address">
                                    <div class="title title-flex">
                                        <div>
                                            <h2>My Address Book</h2>
                                            <span class="title-leaf">
                                                <svg class="icon-width bg-gray">
                                                    <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
                                                </svg>
                                            </span>
                                        </div>

                                        <button class="btn theme-bg-color text-white btn-sm fw-bold mt-lg-0 mt-3"
                                            data-bs-toggle="modal" data-bs-target="#add-address"><i data-feather="plus"
                                                class="me-2"></i> Add New Address</button>
                                    </div>

                                    <div class="row g-sm-4 g-3">
                                        <div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6">
                                            <div class="address-box">
                                                <div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="jack"
                                                            id="flexRadioDefault2" checked>
                                                    </div>

                                                    <div class="label">
                                                        <label>Home</label>
                                                    </div>

                                                    <div class="table-responsive address-table">
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="2">Jack Jennas</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Address :</td>
                                                                    <td>
                                                                        <p>8424 James Lane South San Francisco, CA 94080
                                                                        </p>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Pin Code :</td>
                                                                    <td>+380</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Phone :</td>
                                                                    <td>+ 812-710-3798</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="button-group">
                                                    <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                                        data-bs-target="#editProfile"><i data-feather="edit"></i>
                                                        Edit</button>
                                                    <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                                        data-bs-target="#removeProfile"><i data-feather="trash-2"></i>
                                                        Remove</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6">
                                            <div class="address-box">
                                                <div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="jack"
                                                            id="flexRadioDefault3">
                                                    </div>

                                                    <div class="label">
                                                        <label>Office</label>
                                                    </div>

                                                    <div class="table-responsive address-table">
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="2">Terry S. Sutton</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Address :</td>
                                                                    <td>
                                                                        <p>2280 Rose Avenue Kenner, LA 70062</p>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Pin Code :</td>
                                                                    <td>+25</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Phone :</td>
                                                                    <td>+ 504-228-0969</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="button-group">
                                                    <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                                        data-bs-target="#editProfile"><i data-feather="edit"></i>
                                                        Edit</button>
                                                    <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                                        data-bs-target="#removeProfile"><i data-feather="trash-2"></i>
                                                        Remove</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6">
                                            <div class="address-box">
                                                <div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="jack"
                                                            id="flexRadioDefault4">
                                                    </div>

                                                    <div class="label">
                                                        <label>Neighbour</label>
                                                    </div>

                                                    <div class="table-responsive address-table">
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="2">Juan M. McKeon</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Address :</td>
                                                                    <td>
                                                                        <p>1703 Carson Street Lexington, KY 40593</p>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Pin Code :</td>
                                                                    <td>+78</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Phone :</td>
                                                                    <td>+ 859-257-0509</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="button-group">
                                                    <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                                        data-bs-target="#editProfile"><i data-feather="edit"></i>
                                                        Edit</button>
                                                    <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                                        data-bs-target="#removeProfile"><i data-feather="trash-2"></i>
                                                        Remove</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6">
                                            <div class="address-box">
                                                <div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="jack"
                                                            id="flexRadioDefault5">
                                                    </div>

                                                    <div class="label">
                                                        <label>Home 2</label>
                                                    </div>

                                                    <div class="table-responsive address-table">
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="2">Gary M. Bailey</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Address :</td>
                                                                    <td>
                                                                        <p>2135 Burning Memory Lane Philadelphia, PA
                                                                            19135</p>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Pin Code :</td>
                                                                    <td>+26</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Phone :</td>
                                                                    <td>+ 215-335-9916</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="button-group">
                                                    <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                                        data-bs-target="#editProfile"><i data-feather="edit"></i>
                                                        Edit</button>
                                                    <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                                        data-bs-target="#removeProfile"><i data-feather="trash-2"></i>
                                                        Remove</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6">
                                            <div class="address-box">
                                                <div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="jack"
                                                            id="flexRadioDefault1">
                                                    </div>

                                                    <div class="label">
                                                        <label>Home 2</label>
                                                    </div>

                                                    <div class="table-responsive address-table">
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="2">Gary M. Bailey</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Address :</td>
                                                                    <td>
                                                                        <p>2135 Burning Memory Lane Philadelphia, PA
                                                                            19135</p>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Pin Code :</td>
                                                                    <td>+26</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Phone :</td>
                                                                    <td>+ 215-335-9916</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="button-group">
                                                    <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                                        data-bs-target="#editProfile"><i data-feather="edit"></i>
                                                        Edit</button>
                                                    <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                                        data-bs-target="#removeProfile"><i data-feather="trash-2"></i>
                                                        Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="tab-pane fade show" id="pills-card" role="tabpanel"
                                aria-labelledby="pills-card-tab">
                                <div class="dashboard-card">
                                    <div class="title title-flex">
                                        <div>
                                            <h2>My Affiliates</h2>
                                            <span class="title-leaf">
                                                <svg class="icon-width bg-gray">
                                                    <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
                                                </svg>
                                            </span>
                                        </div>

                                     
                                    </div>
                                    
                                        <div class="row g-sm-4 g-3">
                                            <div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6">
                                                <div class="address-box">
                                                    <button id="generate-link-btn" class="btn theme-bg-color text-white btn-sm fw-bold mt-lg-0 mt-3"
                                                    ><i data-feather="plus"
                                                        class="me-2"></i> Generate Link</button>
                                                        <br>
                                                </div>
                                            </div>
                                            <div id="link-container"></div>
                                        </div>

                                        <div class="row g-4">
                                            <div class="col-12">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Referral Code</th>
                                                            <th>Created At</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($affiliates as $affiliate)
                                                            <tr>
                                                                <td>{{ $affiliate->id }}</td>
                                                                <td>{{ $affiliate->name }}</td>
                                                                <td>{{ $affiliate->email }}</td>
                                                                <td>{{ $affiliate->referral_code }}</td>
                                                                <td>{{ $affiliate->created_at }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5">
                                                                    <table class="table table-sm table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Order ID</th>
                                                                                <th>Commission Amount</th>
                                                                                <th>Created At</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($affiliate->commissions as $commission)
                                                                                <tr>
                                                                                    <td>{{ $commission->order_id }}</td>
                                                                                    <td>{{ $commission->commission_amount }}</td>
                                                                                    <td>{{ $commission->created_at }}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                 
                                </div>
                            </div>

                            <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <div class="dashboard-profile">
                                    <div class="title">
                                        <h2>My Profile</h2>
                                        <span class="title-leaf">
                                            <svg class="icon-width bg-gray">
                                                <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
                                            </svg>
                                        </span>
                                    </div>

                                    <div class="profile-detail dashboard-bg-box">
                                        <div class="dashboard-title">
                                            <h3>Profile Name</h3>
                                        </div>
                                        <div class="profile-name-detail">
                                            <div class="d-sm-flex align-items-center d-block">
                                                <h3>{{@$customer->first_name}} {{@$customer->last_name}}</h3>
                                                <div class="product-rating profile-rating">
                                             
                                                </div>
                                            </div>

                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                data-bs-target="#editProfile">Edit</a>
                                        </div>

                                        <div class="location-profile">
                                            <ul>
                                                <li>
                                                    <div class="location-box">
                                                        <i data-feather="map-pin"></i>
                                                        <h6>Downers Grove, IL</h6>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="location-box">
                                                        <i data-feather="mail"></i>
                                                        <h6>vicki.pope@gmail.com</h6>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="location-box">
                                                        <i data-feather="check-square"></i>
                                                        <h6>Licensed for 2 years</h6>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                         
                                    </div>

                                    <div class="profile-about dashboard-bg-box">
                                        <div class="row">
                                            <div class="col-xxl-7">
                                       
                                                <div class="dashboard-title mb-3">
                                                    <h3>Login Details</h3>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <td>Email :</td>
                                                                <td>
                                                                    <a href="javascript:void(0)">vicki.pope@gmail.com
                                                                        <span data-bs-toggle="modal"
                                                                            data-bs-target="#editProfile">Edit</span></a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Password :</td>
                                                                <td>
                                                                    <a href="javascript:void(0)">●●●●●●
                                                                        <span data-bs-toggle="modal"
                                                                            data-bs-target="#editProfile">Edit</span></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-xxl-5">
                                                <div class="profile-image">
                                                    <img src="../assets/images/inner-page/dashboard-profile.png"
                                                        class="img-fluid blur-up lazyload" alt="">
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
    <!-- User Dashboard Section End -->

    <div class="modal fade theme-modal" id="editProfile" tabindex="-1" aria-labelledby="exampleModalLabel2"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-xxl-12">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <input type="text" class="form-control" id="pname" value="Jack Jennas">
                                    <label for="pname">Full Name</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-xxl-6">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <input type="email" class="form-control" id="email1" value="vicki.pope@gmail.com">
                                    <label for="email1">Email address</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-xxl-6">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <input class="form-control" type="tel" value="4567891234" name="mobile" id="mobile"
                                        maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value =
                                            this.value.slice(0, this.maxLength);">
                                    <label for="mobile">Email address</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-12">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <input type="text" class="form-control" id="address1"
                                        value="8424 James Lane South San Francisco">
                                    <label for="address1">Add Address</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-12">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <input type="text" class="form-control" id="address2" value="CA 94080">
                                    <label for="address2">Add Address 2</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-xxl-4">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <select class="form-select" id="floatingSelect1"
                                        aria-label="Floating label select example">
                                        <option selected>Choose Your Country</option>
                                        <option value="kindom">United Kingdom</option>
                                        <option value="states">United States</option>
                                        <option value="fra">France</option>
                                        <option value="china">China</option>
                                        <option value="spain">Spain</option>
                                        <option value="italy">Italy</option>
                                        <option value="turkey">Turkey</option>
                                        <option value="germany">Germany</option>
                                        <option value="russian">Russian Federation</option>
                                        <option value="malay">Malaysia</option>
                                        <option value="mexico">Mexico</option>
                                        <option value="austria">Austria</option>
                                        <option value="hong">Hong Kong SAR, China</option>
                                        <option value="ukraine">Ukraine</option>
                                        <option value="thailand">Thailand</option>
                                        <option value="saudi">Saudi Arabia</option>
                                        <option value="canada">Canada</option>
                                        <option value="singa">Singapore</option>
                                    </select>
                                    <label for="floatingSelect">Country</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-xxl-4">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <select class="form-select" id="floatingSelect">
                                        <option selected>Choose Your City</option>
                                        <option value="kindom">India</option>
                                        <option value="states">Canada</option>
                                        <option value="fra">Dubai</option>
                                        <option value="china">Los Angeles</option>
                                        <option value="spain">Thailand</option>
                                    </select>
                                    <label for="floatingSelect">City</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-xxl-4">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <input type="text" class="form-control" id="address3" value="94080">
                                    <label for="address3">Pin Code</label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-animation btn-md fw-bold"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" data-bs-dismiss="modal"
                        class="btn theme-bg-color btn-md fw-bold text-light">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Profile End -->

    <!-- Edit Card Start -->
    <div class="modal fade theme-modal" id="editCard" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel8">Edit Card</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-xxl-6">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <input type="text" class="form-control" id="finame" value="Mark">
                                    <label for="finame">First Name</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-xxl-6">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <input type="text" class="form-control" id="laname" value="Jecno">
                                    <label for="laname">Last Name</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-xxl-4">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <select class="form-select" id="floatingSelect12"
                                        aria-label="Floating label select example">
                                        <option selected>Card Type</option>
                                        <option value="kindom">Visa Card</option>
                                        <option value="states">MasterCard Card</option>
                                        <option value="fra">RuPay Card</option>
                                        <option value="china">Contactless Card</option>
                                        <option value="spain">Maestro Card</option>
                                    </select>
                                    <label for="floatingSelect12">Card Type</label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-animation btn-md fw-bold"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn theme-bg-color btn-md fw-bold text-light">Update Card</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Card End -->

    <!-- Remove Profile Modal Start -->
    <div class="modal fade theme-modal remove-profile" id="removeProfile" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header d-block text-center">
                    <h5 class="modal-title w-100" id="exampleModalLabel22">Are You Sure ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="remove-box">
                        <p>The permission for the use/group, preview is inherited from the object, object will create a
                            new permission for this object</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-animation btn-md fw-bold" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn theme-bg-color btn-md fw-bold text-light"
                        data-bs-target="#removeAddress" data-bs-toggle="modal">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade theme-modal remove-profile" id="removeAddress" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel12">Done!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="remove-box text-center">
                        <h4 class="text-content">It's Removed.</h4>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn theme-bg-color btn-md fw-bold text-light"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')

<script>
   $(document).ready(function() {
        $('#generate-link-btn').on('click', function() {
            $.ajax({
                url: '{{ route('affiliate.generateLink') }}',
                method: 'GET',
                success: function(data) {
                    if (data.link) {
                        $('#link-container').html(`
                            <p>Your affiliate link: <a href="${data.link}" target="_blank">${data.link}</a></p>
                            <button id="copy-link-btn" class="btn btn-secondary">Copy to Clipboard</button>
                        `);
                        $('#copy-link-btn').on('click', function() {
                            navigator.clipboard.writeText(data.link).then(function() {
                                alert('Affiliate link copied to clipboard!');
                            }, function(err) {
                                alert('Failed to copy text: ', err);
                            });
                        });
                    } else {
                        console.log(data)
                        $('#link-container').html(`<p>${data.error}</p>`);
                    }
                },
                error: function(xhr, status, error) {
                    $('#link-container').html(`<p>An error occurred: ${xhr.responseText}</p>`);
                }
            });
        });
    });
    </script>
@endpush