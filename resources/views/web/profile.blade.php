
@extends('web.layouts.main')
@section('content')

<section class="myaccount_section">
    <section class="mb-3">
        <div class="container position-relative">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">My Account</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <div class="container position-relative">
        <div class="row">
            <div class="col-12 profile_detail_wrapper">
                <div class="left_profile_nav sticky-xl-top sticky-lg-top-110">
                    <div class="info_user_box">
                        <div class="profile_photo">
                            {!! Helper::printImage($user, 'profile_image','profile_image_webp','image_attribute','img-fluid') !!}
                            <div class="upload_photo">
                                <form role="form" id="profileImageForm" enctype="multipart/form-data">
                                        {{ @csrf_field() }}

                                    <label class="custom-file-upload">
                                        <input type="file" name="profile_image" id="profile_image"
                                                   accept="image/*"/>
                                            <i class="fa-solid fa-plus"></i>
                                    </label>
                                </form>
                            </div>
                        </div>
                        <div class="profile_info">
                            <div class="name">
                            {{@$customer->first_name}} {{@$customer->last_name}}
                            </div>
                            <div class="mail">
                            {{@$customer->user->email}}
                            </div>
                        </div>
                    </div>
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a href="{{url('customer/account/profile')}}" class="nav-link {{$tab=='profile'?'active':''}}" id="v-pills-information-tab" data-bs-toggle="pill" data-bs-target="#v-pills-information" type="button" role="tab" aria-controls="v-pills-information" aria-selected="true">
                            <div class="iconBox">
                                <img src="{{asset('frontend/images/myAccount-01.png')}}" alt="">
                            </div>
                            Personal Information
                        </a>
                        <a href="{{url('customer/account/password')}}"   class="nav-link {{$tab=='password'?'active':''}}" id="v-pills-password-tab" data-bs-toggle="pill" data-bs-target="#v-pills-password" type="button" role="tab" aria-controls="v-pills-password" aria-selected="false">
                            <div class="iconBox">
                                <img src="{{asset('frontend/images/myAccount-02.png')}}" alt="">
                            </div>
                            Change Password
                        </a>
                        <a href="{{url('customer/account/order')}}" class="nav-link {{$tab=='order'?'active':''}}" id="v-pills-orders-tab" data-bs-toggle="pill" data-bs-target="#v-pills-orders" type="button" role="tab" aria-controls="v-pills-orders" aria-selected="false">
                            <div class="iconBox">
                                <img src="{{asset('frontend/images/myAccount-03.png')}}" alt="">
                            </div>
                            My Orders
                        </a>
                        <a href="{{url('customer/account/address')}}"  class="nav-link {{$tab=='address'?'active':''}}" id="v-pills-Address-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Address" type="button" role="tab" aria-controls="v-pills-Address" aria-selected="false">
                            <div class="iconBox">
                                <img src="{{asset('frontend/images/myAccount-04.png')}}" alt="">
                            </div>
                            Address
                        </a>
                        <a href="{{url('customer/account/wishlist')}}"  class="nav-link {{$tab=='wishlist'?'active':''}}"  id="v-pills-wishlist-tab" data-bs-toggle="pill" data-bs-target="#v-pills-wishlist" type="button" role="tab" aria-controls="v-pills-wishlist" aria-selected="false">
                            <div class="iconBox">
                                <img src="{{asset('frontend/images/myAccount-05.png')}}" alt="">
                            </div>
                            Wishlist
                        </a>
                        <a class="nav-link" href="{{url('logout')}}">
                            <div class="iconBox">
                                <img src="{{asset('frontend/images/myAccount-06.png')}}" alt="">
                            </div>
                            Logout
                        </a>
                    </div>
                        
                </div>
                <div class="right_detail_wrapper">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade {{$tab=='profile'?'show active':''}}" id="v-pills-information" role="tabpanel" aria-labelledby="v-pills-information-tab">
                            <div id="info_box">
                                <div class="tab-pane-header">
                                    <h4>Personal Information</h4>
                                    <a class="edit_profile" href="javascript:void(0)" id="edit_profile_go"> <i class="fa-solid fa-pen-to-square"></i>Edit Profile</a>
                                </div>
                                <div class="tab-pane-body">
                                    <form action="">
                                        <fieldset disabled="">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"  name="first_name" id="profile_first_name" placeholder="" value="{{@$customer->first_name}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"  name="last_name" id="profile_last_name" placeholder="" value="{{@$customer->last_name}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"  name="email" readonly
                                                     id="email" value="{{@$customer->user->email}}" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <input type="text" value="{{@$customer->user->phone}}"  name="phone_number" id="phone_number" class="form-control" placeholder="+971 12345 6987">
                                                    </div>
                                                </div>
                                                <!-- <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="2022-3-23">
                                                    </div>
                                                </div> -->
                                            </div>
                                        </fieldset>
                                        
                                    </form>
                                </div>
                            </div>
                            <div id="info_box_edit" class="d-none">
                                <div class="tab-pane-header">
                                    <h4>Personal Information</h4>
                                </div>
                                <div class="tab-pane-body">                                        
                                    <form action="#" method="" class="account-form"
                                    id="customerProfileForm">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control"  name="first_name" id="profile_first_name" placeholder="John George" value="{{@$customer->first_name}}">
                                                    <!-- <span class="invalidMessage"> Given Data Error </span> -->
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control"  name="last_name" id="profile_last_name" placeholder="John George" value="{{@$customer->last_name}}">
                                                    <!-- <span class="invalidMessage"> Given Data Error </span> -->
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="johngeorge@gmail.com" name="email"
                                                     id="email" value="{{@$customer->user->email}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control personal-phone" placeholder="+971 12345 6987"  name="phone_number" id="phone_number"  value="{{@$customer->user->phone}}">
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-6">
                                                <div class="form-group">
                                                    <input type="date" class="form-control" value="2012-3-23">
                                                </div>
                                            </div> -->
                                            <div class="col-12 d-flex flex-column flex-sm-row mt-3">
                                                <a href="javascript:void(0)" class="secondary_btn" id="edit_profile_go">Cancel</a>
                                                <div class="form-group mb-0" id="button_edit">
                                                    <button class="btn primary_btn form_submit_btn" data-url="/customer/update-profile" id="profile-update">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade   {{$tab=='password'?'show active':''}}" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-password-tab">
                            <div class="tab-pane-header">
                                <h4>Change Password</h4>
                            </div>
                            <div class="tab-pane-body">
                            <form action="#"id="change-password-form" >
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                              
                                            <input type="password" class="form-control password-required" id="new_password" name="password" aria-describedby="emailHelp" placeholder="New Password">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                
                                                <input type="password" class="form-control password-required" name="password_confirmation" id="confirm_password" aria-describedby="emailHelp" placeholder="Confirm Password">
                                            <p id="confirm_password_error"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="primary_btn " id="change-password-btn">Update</button>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade {{$tab=='order'?'show active':''}}" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab">
                            <div class="tab-pane-header">
                                <h4>My Orders</h4>
                            </div>
                            <div class="tab-pane-body">
                                @if($orders->isNotEmpty())
                                <div id="my_order_list">
                                    @foreach ($orders as $order)
                                    <div class="my_order_list" >
                                      
                                        <div class="order_header">
                                            <ul>
                                                <li>
                                             
                                                    Order ID : ARTMYST# {{$order->orderData->order_code}}
                                                </li>
                                                <li>
                                                    Placed Order on   {{ date("d-m-y", strtotime($order->orderData->created_at))  }}
                                                </li>
                                                <li>
                                                    <a href="{{ url('order/'.base64_encode($order->orderData->order_code)) }}" target="_blank">Order Details <i class="fa-solid fa-arrow-right"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="order_body">
                                            <section id="demos">
                                                <div class="our-works-slider owl-carousel owl-theme ">
                                                    @foreach($order->orderData->orderProducts as $orderProduct)
                                                    @if ($orderProduct->productData != null)
                                                    <div class="item">
                                                        <div class="product-item-info">
                                                            <div class="product-photo ">
                                                            
                                                                <div class="product-image-container w-100">
                                                                    <div class="product-image-wrapper">
                                                                        <a href="{{ url('/product/'.$orderProduct->productData->short_url) }}" tabindex="-1">
                                                                            {!! Helper::printImage($orderProduct->productData, 'thumbnail_image','thumbnail_image_webp','thumbnail_image_attribute','img1') !!}
                                                                        </a>
                                                                    </div>
                                                                    <div class="cartWishlistBox">
                                                                        <ul>
                                                                            @php
                                                                            $productPrice = \App\Models\ProductPrice::where('product_id',$orderProduct->productData->id)->first();
                                                                            $class = '';
                                                                            if ($productPrice->availability=='In Stock' && $productPrice->stock!=0) {
                                                                                $class = 'cart-action';
                                                                            }
                                                                            else{
                                                                                $class = 'out-of-stock';
                                                                            }
                                                                            @endphp
                                                                         @php
                                                                         if($orderProduct->productData->frame_color != null){
                                                                             $frameID = explode(',',$orderProduct->productData->frame_color);
                                                                             $frameColor = \App\Models\Frame::whereIn('id',$frameID)->first()->id;
                                                                         }
                                                                         else{
                                                                             $frameColor = null;
                                                                         }
                                                                     @endphp
                                                                            <li>
                                                                                <a href="javascript:void(0)" class="my_wishlist {{ (Auth::guard('customer')->check())?'wishlist-action':'login-popup' }}
                                                                                        {{ (Auth::guard('customer')->check())?((app('wishlist')->get($orderProduct->productData->id))?'fill':''):'' }}"  data-id="{{$orderProduct->productData->id}}" data-size="{{$productPrice->size_id}}"  data-product_type_id="{{$orderProduct->productData->product_type_id}}"
                                                                                        data-bs-toggle="popover"  id="wishlist_check_{{$orderProduct->productData->id}}" 
                                                                                        data-bs-placement="left" data-bs-trigger="hover" data-bs-content="Wishlist">
                                                                                    <div class="textIcon">
                                                                                        Wishlist
                                                                                    </div>
                                                                                    <div class="iconBox" id="wishlist_check_span_{{$orderProduct->productData->id}}">
                                                                                        <i class="fa-regular fa-heart"></i>
                                                                                    </div>
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                              
                                                                                <a href="javascript:void(0)" class="my_wishlist  cartBtn {{$class}}" data-frame="{{$frameColor}}" data-mount="{{$orderProduct->productData->mount}}" data-id="{{$orderProduct->productData->id}}" data-size="{{$productPrice->size_id}}"  data-product_type_id="{{$orderProduct->productData->product_type_id}}">
                                                                                    <div class="iconBox">
                                                                                        <i class="fa-solid fa-cart-shopping"></i>
                                                                                    </div>
                                                                                    <div class="textIcon">
                                                                                        Add to Cart
                                                                                    </div>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                        <div class="logoArea mt-auto">
                                                                            {!! Helper::printImage($orderProduct->productData, 'thumbnail_image','thumbnail_image_webp','thumbnail_image_attribute','d-block w-100') !!}
                                                                        
                                                                        
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="product-details">
                                                                <a href="{{ url('/product/'.$orderProduct->productData->short_url) }}">
                                                                    <div class="pro-name">
                                                                    {{ $orderProduct->productData->title }}
                                                                    
                                                                </div>
                                                                <ul class="price-area">
                                                            
                                                                        <li class="">
                                                                            {{Helper::defaultCurrency()}} {{$orderProduct->total}}
                                                                            </li>
                                                                         
                                                                           
                                                                        
                                                                                    </ul>
                                                                                    <ul class="type-review">
                                                                                        @if($orderProduct->productData->product_categories->count() > 1)
                                                                                        <li>
                                                                                            @php
                                                                                            //take the first category
                                                                                            $category = $orderProduct->productData->product_categories->first();
                                                                                            @endphp
                                                                                        {{$category->title}}....
                                                                                        </li>
                                                                                    @else
                                                                                        <li>
                                                                                            @php
                                                                                                //take the first category
                                                                                                $category = $orderProduct->productData->product_categories->first();
                                                                                                @endphp
                                                                                            {{$category !=null ? $category->title : ''}}
                                                                                        </li>
                                                                                    @endif
                                                                                   
                                                                                      
                                                                                        @if(Helper::averageRating($orderProduct->productData->id)>0)
                                                                                        <li class="review">
                                                                                            <i class="fa-solid fa-star"></i>{{ Helper::averageRating($orderProduct->productData->id)  }}
                                                                                        </li>
                                                                                        @endif
                                                                                    </ul>
                                                                                </a>
                                                                            </div>
                                                        </div>
                                                    </div>
                                                        
                                                    @endif
                                                    @endforeach
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="tab-pane fade {{$tab=='address'?'show active':''}}" id="v-pills-Address" role="tabpanel" aria-labelledby="v-pills-Address-tab">
                            <div class="tab-pane-header">
                                <h4>Address</h4>
                            </div>
                            <div class="tab-pane-body">
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-billing_address" role="tabpanel" aria-labelledby="nav-billing_address-tab">
                                        <div id="my_address_list">
                                        @include('web.includes.customer_address')
                                        </div>
                                        <div id="my_address_add_form" class="d-none" >
                                        @include('web.includes.customer_address_form')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade {{$tab=='wishlist'?'show active':''}}" id="v-pills-wishlist" role="tabpanel" aria-labelledby="v-pills-wishlist-tab">
                            <div class="tab-pane-header">
                                <h4>Wishlist</h4>
                            </div>
                            <div class="tab-pane-body">
                                <div class="row">
                                    @foreach(app('wishlist')->getContent() as $row)
                                        @php
                                            $product = App\Models\Product::find($row->id);
                                        @endphp
                                        @if($product!=NULL)
                                            <div class="col-md-4 product_card_flex mb-4 wishlist" id="wishlistBox{{$row->id}}">
                                                <div class="product-item-info">
                                                    <div class="product-photo ">

                                                        <div class="product-image-container w-100">
                                                            <div class="product-image-wrapper">
                                                               <a href="{{ url('/product/'.$product->short_url) }}">
                                                                {!! Helper::printImage($product, 'thumbnail_image','thumbnail_image_webp','thumbnail_image_attribute','product-image-photo') !!}
                                                                   
                                                                </a>
                                                            </div>
                                                            <div class="cartWishlistBox">
                                                                <ul>
                                                                    @php
                                                                     $productPrice = \App\Models\ProductPrice::where('product_id',$product->id)->first();
                                                                    $class = '';
                                                                    if ($productPrice->availability=='In Stock' && $productPrice->stock!=0) {
                                                                        $class = 'cart-action';
                                                                    }
                                                                    else{
                                                                        $class = 'out-of-stock';
                                                                    }
                                                                    @endphp
                                                                
                                                                    <li>
                                                                        <a href="javascript:void(0)" class="my_wishlist {{ (Auth::guard('customer')->check())?'wishlist-action':'login-popup' }}
                                                                                {{ (Auth::guard('customer')->check())?((app('wishlist')->get($product->id))?'fill':''):'' }}"  data-id="{{$product->id}}" data-size="{{$productPrice->size_id}}"  data-product_type_id="{{$product->product_type_id}}"
                                                                                data-bs-toggle="popover"  id="wishlist_check_{{$product->id}}" 
                                                                                data-bs-placement="left" data-bs-trigger="hover" data-bs-content="Wishlist">
                                                                            <div class="textIcon">
                                                                                Wishlist
                                                                            </div>
                                                                            <div class="iconBox" id="wishlist_check_span_{{$product->id}}">
                                                                                <i class="fa-regular fa-heart"></i>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @php
                                                                            if($product->frame_color != null){
                                                                                $frameID = explode(',',$product->frame_color);
                                                                                $frameColor = \App\Models\Frame::whereIn('id',$frameID)->first()->id;
                                                                            }
                                                                            else{
                                                                                $frameColor = null;
                                                                            }
                                                                        @endphp
                                                                                                                    <a href="javascript:void(0)" class="my_wishlist  cartBtn {{$class}}" data-frame="{{$frameColor}}" data-mount="Yes" data-id="{{$product->id}}" data-size="{{$productPrice->size_id}}"  data-product_type_id="{{$product->product_type_id}}">
                                                                            <div class="iconBox">
                                                                                <i class="fa-solid fa-cart-shopping"></i>
                                                                            </div>
                                                                            <div class="textIcon">
                                                                                Add to Cart
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                                <div class="logoArea mt-auto">
                                                                    {!! Helper::printImage($product, 'thumbnail_image','thumbnail_image_webp','thumbnail_image_attribute','d-block w-100') !!}
                                                                
                                                                
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="product-details">
                                                        <a href="{{ url('/product/'.$product->short_url) }}">
                                                            <div class="pro-name">
                                                            {{ $product->title }}
                                                        </div>
                                                        <ul class="price-area">
                                                            @if(Helper::offerPrice($product->id)!='')
                                                                <li class="offer">
                                                                    @php
                                                                        $offerId =Helper::offerId($product->id);
                                                                    @endphp
                                                                    {{Helper::defaultCurrency().' '.(Helper::offerPriceSize($product->id,$productPrice->size_id,$offerId))}}
                                                                </li>
                                                                <li>
                                                                    {{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*$productPrice->price,2)}}
                                                                </li>
                                                                 @else
                                                                    <li>
                                                                        {{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*$productPrice->price,2)}}
                                                                    </li>
                                                                 
                                                                   
                                                                 
                                                                  
                                                                    @endif
                                                                            </ul>
                                                                            <ul class="type-review">
                                                                                @if($product->product_categories->count() > 1)
                                                                                <li>
                                                                                    @php
                                                                                    //take the first category
                                                                                    $category = $product->product_categories->first();
                                                                                    @endphp
                                                                                {{$category->title}}....
                                                                                </li>
                                                                            @else
                                                                                <li>
                                                                                    @php
                                                                                        //take the first category
                                                                                        $category = $product->product_categories->first();
                                                                                        @endphp
                                                                                 {{$category !=null ? $category->title : ''}}
                                                                                </li>
                                                                            @endif
                                                                            </ul>
                                                                        </a>
                                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
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
@push('scripts')

    
@endpush