@extends('web.layouts.main')
@section('content')
  <!-- Breadcrumb Section Start -->
  <section class="breadscrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadscrumb-contain">
                    <h2>Checkout</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="index.php">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Checkout section Start -->
<section class="checkout-section section-b-space">
    <div class="container-fluid-lg">
        <div class="row g-sm-4 g-3">
            <div class="col-xxl-3 col-lg-4">
                <!-- Nav tabs -->
                <ul class="nav nav-pills nav-justified custom-navtab" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <div class="nav-link active" id="shopping-cart" data-bs-toggle="tab"
                            data-bs-target="#s-cart" role="tab">
                            <div class="nav-item-box">
                                <div>
                                    <span>STEP 1</span>
                                    <h4>Shopping Cart</h4>
                                </div>
                                <lord-icon target=".nav-item" src="https://cdn.lordicon.com/ggihhudh.json"
                                    trigger="loop-on-hover"
                                    colors="primary:#121331,secondary:#646e78,tertiary:#0baf9a" class="lord-icon">
                                </lord-icon>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item" role="presentation">
                        <div class="nav-link" id="delivery-address" data-bs-toggle="tab" data-bs-target="#d-address"
                            role="tab">
                            <div class="nav-item-box">
                                <div>
                                    <span>STEP 2</span>
                                    <h4>Delivery Address</h4>
                                </div>
                                <lord-icon target=".nav-item" src="https://cdn.lordicon.com/oaflahpk.json"
                                    trigger="loop-on-hover" colors="primary:#0baf9a" class="lord-icon">
                                </lord-icon>
                            </div>
                        </div>
                    </li>

                 

                    <li class="nav-item" role="presentation">
                        <div class="nav-link" id="payment-option" data-bs-toggle="tab" data-bs-target="#p-options"
                            role="tab">
                            <div class="nav-item-box">
                                <div>
                                    <span>STEP 4</span>
                                    <h4>Payment Options</h4>
                                </div>
                                <lord-icon target=".nav-item" src="https://cdn.lordicon.com/qmcsqnle.json"
                                    trigger="loop-on-hover" colors="primary:#0baf9a,secondary:#0baf9a"
                                    class="lord-icon">
                                </lord-icon>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="col-xxl-9 col-lg-8">
                <!-- Tab panes -->
                <div class="tab-content" id="progressBar">
                    <div class="tab-pane active" id="s-cart" role="tabpanel" aria-labelledby="shopping-cart">
                        <h2 class="tab-title">Shopping Cart</h2>
                        @if (!Cart::session($sessionKey)->isEmpty())
                        <div class="cart-table p-0">
                            <div class="table-responsive">
                                <h5 id="offcanvasRightLabel"><span>(<span  class="cart-count">  {{ Helper::getCartItemCount()}}</span> Items )</span> <br></h5> <br>
                                <table class="table">
                                    <tbody>
                                        @foreach(Cart::session($sessionKey)->getContent()->sort() as $row)
                                        @php
                                        $product = App\Models\Product::find($row->attributes['product_id']);
                                        @endphp
                                   <tr class="product-box-contain" id="sub-cart-item-div-{{$row->id}}">
                                    <td class="product-detail">
                                        <div class="product border-0">
                                            <a href="{{ url('/product/'.$product->short_url) }}" class="product-image">
                                                {!! Helper::printImage($product, 'thumbnail_image','thumbnail_image_webp','thumbnail_image_attribute','img-fluid blur-up lazyload') !!}
                                                
                                            </a>
                                            <div class="product-detail">
                                                <ul>
                                                    <li class="name">
                                                        <a href="{{ url('/product/'.$product->short_url) }}">
                                                            <h6>
                                                                {{ $product->title }}
                                                            </h6>
                                                        </a>
                                                    </li>

                                                    <li class="text-content"><span class="text-title">Sold
                                                            By:</span> {{$product->vendor->name}}</li>

                                                    <li class="text-content"><span
                                                            class="text-title">Quantity</span> - {{$product->stock}} g</li>

                                                    <li>
                                                        <ul class="price_area">
                                                            @if(Helper::offerPrice($product->id)!='')
                                                            <li>{{Helper::defaultCurrency().' '.Helper::offerPriceAmount($product->id)}}</li>
                                                            <li>{{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*$product->price,2)}}</li>
                                                        @else
                                                        <li>{{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*$product->price,2)}}</li>
                                                        <li></li>
                                                        @endif
                                                       </ul>
                                                        {{-- <h5 class="text-content d-inline-block">Price :</h5>
                                                        <span>$35.10</span>
                                                        <span class="text-content">$45.68</span> --}}
                                                    </li>

                                                    

                                                    <li class="quantity-price-box">
                                                        <div class="cart_qty">
                                                            <div class="input-group">
                                                                <button type="button" class="btn qty-left-minus"
                                                                    data-type="minus" data-field="">
                                                                    <i class="fa fa-minus ms-0"
                                                                        aria-hidden="true"></i>
                                                                </button>
                                                                <input class="form-control input-number qty-input"
                                                                    type="text" name="quantity" value="0">
                                                                <button type="button" class="btn qty-right-plus"
                                                                    data-type="plus" data-field="">
                                                                    <i class="fa fa-plus ms-0"
                                                                        aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @php
                                                    $price = ($row->price * $row->quantity);
                                                @endphp
                                                    <li>
                                                        <h6 class="price{{$row->id}}">{{Helper::defaultCurrency()}} {{number_format(($price),2)}}</h6>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="price">
                                        <h4 class="table-title text-content">Price</h4>
                                        
                                         @if(Helper::offerPrice($product->id)!='')
                                         <h5>{{Helper::offerPriceAmount($product->id)}} <del class="text-content">{{number_format(Helper::defaultCurrencyRate()*$product->price,2)}}</del></h5>
                                         @else
                                         {{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*$product->price,2)}}
                                         @endif
                                        
                                    </td>

                                    <td class="quantity">
                                        <h4 class="table-title text-content">Qty</h4>
                                        <div class="quantity-price">
                                            <div class="cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus"
                                                        data-type="minus" data-field="">
                                                        <i class="fa fa-minus ms-0" aria-hidden="true"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="{{$row->quantity}}">
                                                    <button type="button" class="btn qty-right-plus"
                                                        data-type="plus" data-field="">
                                                        <i class="fa fa-plus ms-0" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="subtotal">
                                        <h4 class="table-title text-content">Total</h4>
                                        <h5>{{Helper::defaultCurrency()}} {{number_format(($price),2)}}</h5>
                                    </td>

                                    <td class="save-remove">
                                        <h4 class="table-title text-content">Action</h4>
                                        <a class="save notifi-wishlist" href="javascript:void(0)">Save for later</a>
                                        <a class="remove close_button" href="javascript:void(0)">Remove</a>
                                    </td>
                                </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif

                        <div class="button-group">
                            <ul class="button-group-list">
                                <li>
                                    <button onclick="location.href = 'index.php';"
                                        class="btn btn-light shopping-button text-dark"><i
                                            class="fa-solid fa-arrow-left-long ms-0"></i>Continue Shopping</button>
                                </li>

                                <li>
                                    <button class="btn btn-animation proceed-btn">Continue Delivery Address</button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="tab-pane" id="d-address" role="tabpanel" aria-labelledby="delivery-address">
                        <div class="d-flex align-items-center mb-3">
                            <h2 class="tab-title mb-0">Delivery Address</h2>
                            <button class="btn btn-animation btn-sm fw-bold ms-auto" type="button"
                                data-bs-toggle="modal" data-bs-target="#add-address">
                                <i class="fa-solid fa-plus d-block d-sm-none m-0"></i>
                                <span class="d-none d-sm-block">+ Add New</span>
                            </button>
                        </div>

                        <div class="row g-4">
                            
                            @if (@$customerAddresses)
                            @foreach($customerAddresses as $address)
                            <div class="col-xxl-6 col-lg-12 col-md-6">
                                <div class="delivery-address-box">
                                    <div>
                                        <div class="form-check">
                                            <input  @if(session('selected_customer_address') == $address->id) @checked(true) @else @endif class="form-check-input set_d_add deliver login{{$address->id}}" type="radio" name="jack" " data-id="{{$address->id}}"  data-address-type="shipping"
                                                id="flexRadioDefault1">
                                        </div>

                                        <div class="label">
                                            <label>  {{$address->address_type}}</label>
                                        </div>

                                        <ul class="delivery-address-detail">
                                            <li>
                                                <h4 class="fw-500">   {{$address->first_name}}  {{ $address->last_name }}</h4>
                                            </li>

                                            <li>
                                                <p class="text-content"><span class="text-title">Address
                                                        : </span>   {{$address->address}}</p>
                                            </li>

                                            <li>
                                                <h6 class="text-content"><span class="text-title">Pin Code
                                                        :</span>{{$address->zipcode}}</h6>
                                            </li>

                                            <li>
                                                <h6 class="text-content mb-0"><span class="text-title">Phone
                                                        :</span> {{$address->phone}}</h6>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                            @endif

                   
                        </div>

                        <div class="button-group">
                            <ul class="button-group-list">
                                <li>
                                    <button class="btn btn-light shopping-button backward-btn text-dark">
                                        <i class="fa-solid fa-arrow-left-long ms-0"></i>Return To Shopping
                                        Cart</button>
                                </li>

                                <li>
                                    <button class="btn btn-animation proceed-btn">Continue Payment Option</button>
                                </li>
                            </ul>

                        </div>
                    </div>

                    {{-- <div class="tab-pane" id="d-options" role="tabpanel" aria-labelledby="delivery-option">
                        <h2 class="tab-title">Delivery Option</h2>
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="delivery-option">
                                    <div class="row g-4">
                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="delivery-category">
                                                <div class="shipment-detail">
                                                    <div class="form-check custom-form-check">
                                                        <input class="form-check-input" type="radio" name="standard"
                                                            id="standard" checked>
                                                        <label class="form-check-label" for="standard">Standard
                                                            Delivery Option</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="delivery-items">
                                                <div>
                                                    <h5 class="items text-content"><span>3 Items</span> @ $693.48
                                                    </h5>
                                                    <h5 class="charge text-content">Delivery Charge $28.12
                                                        <button type="button" class="btn p-0"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Extra Charge">
                                                            <i class="fa-solid fa-circle-exclamation"></i>
                                                        </button>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-md-12">
                                            <div class="select-option">
                                                <div class="form-floating theme-form-floating">
                                                    <select class="form-select" aria-label="Default select example">
                                                        <option value="0">TOMORROW 10:00 PM - 6:00 PM</option>
                                                        <option value="2">Tuesday 11:00 AM - 6:45 PM</option>
                                                        <option value="3">Wednesday 10:30 AM - 8:00 PM</option>
                                                    </select>
                                                    <label>Select Timing</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="delivery-option">
                                    <div class="row g-4">
                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="delivery-category">
                                                <div class="shipment-detail">
                                                    <div class="form-check custom-form-check">
                                                        <input class="form-check-input" type="radio" name="standard"
                                                            id="sameDay">
                                                        <label class="form-check-label" for="sameDay">Same Day
                                                            Delivery Option</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="delivery-items">
                                                <div>
                                                    <h5 class="items text-content"><span>3 Items</span> @ $693.48
                                                    </h5>
                                                    <h5 class="charge text-content">Delivery Charge $32.15
                                                        <button type="button" class="btn p-0"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Extra Charge">
                                                            <i class="fa-solid fa-circle-exclamation"></i>
                                                        </button>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-md-12">
                                            <div class="select-option">
                                                <div class="form-floating theme-form-floating">
                                                    <select class="form-select theme-form-select"
                                                        aria-label="Default select example">
                                                        <option value="0">TOMORROW 10:00 PM - 6:00 PM</option>
                                                        <option value="2">Tuesday 11:00 AM - 6:45 PM</option>
                                                        <option value="3">Wednesday 10:30 AM - 8:00 PM</option>
                                                    </select>
                                                    <label>Select Timing</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="delivery-option">
                                    <div class="row g-4">
                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="delivery-category">
                                                <div class="shipment-detail">
                                                    <div class="form-check mb-0 custom-form-check">
                                                        <input class="form-check-input" type="radio" name="standard"
                                                            id="future">
                                                        <label class="form-check-label" for="future">Future Delivery
                                                            Option</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="delivery-items">
                                                <div>
                                                    <h5 class="items text-content"><span>3 Items</span> @ $693.48
                                                    </h5>
                                                    <h5 class="charge text-content">Delivery Charge $34.67
                                                        <button type="button" class="btn p-0"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Extra Charge">
                                                            <i class="fa-solid fa-circle-exclamation"></i>
                                                        </button>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-md-12">
                                            <form class="form-floating theme-form-floating date-box">
                                                <input type="date" class="form-control">
                                                <label>Select Date</label>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="button-group">
                            <ul class="button-group-list">
                                <li>
                                    <button class="btn btn-light shopping-button backward-btn text-dark">
                                        <i class="fa-solid fa-arrow-left-long ms-0"></i>Return To Delivery
                                        Address</button>
                                </li>

                                <li>
                                    <button class="btn btn-animation proceed-btn">Continue Payment Option</button>
                                </li>
                            </ul>
                        </div>
                    </div> --}}

                    <div class="tab-pane" id="p-options" role="tabpanel" aria-labelledby="payment-option">
                        <h2 class="tab-title">Payment Option</h2>
                        <div class="row g-sm-4 g-2">
                            <div class="col-xxl-4 col-lg-12 col-md-5 order-xxl-2 order-lg-1 order-md-2">
                                <div class="summery-box">
                                    @if (Session::has('session_key') && !Cart::session($sessionKey)->isEmpty())
                                    <div class="summery-header bg-white">
                                        <h3>Order Summery</h3>
                                        
                                    </div>
                                    
                                     <ul class="summery-total bg-white">
                                         <li>
                                             <h4>Subtotal</h4>
                                             <h4 class="price">{{ ($siteInformation->tax_type == 'Inside')? '(Tax Inclusive - '.$siteInformation->tax.'%)':''}}</h4>
                                         </li>
 
                                         <li>
                                             <h4>Shipping</h4>
                                             <h4 class="price">{{Helper::defaultCurrency()}} {{number_format($calculation_box['shippingAmount'],2)}}</h4>
                                         </li>
 
                                         <li>
                                             <h4>Tax{{ ' ('. $siteInformation->tax . '% )' }}</h4>
                                             <h4 class="price">{{Helper::defaultCurrency()}} {{number_format($calculation_box['tax_amount'],2)}}</h4>
                                         </li>
 
                                         @if (Session::exists('coupons'))
                                            @foreach(Session::get('coupons') as $session_coupon)
                                                <li class="flex-column justify-content-end align-items-end couponDiscount">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <div class="left">
                                                            <h6>Coupon ({{ $session_coupon['code'] }}):</h6>
                                                        </div>
                                                        <div class="right">

                                                            <h6 class="tableData">- {{Helper::defaultCurrency()}} {{number_format($session_coupon['coupon_value'],2)}}</h6>
                                                        </div>
                                                    </div>
                                                    <a class="coupon_remove_btn remove_coupon" href="javascript:void(0)"
                                                    data-coupon="{{ $session_coupon['code'] }}">Remove Coupon<i class="fa-solid fa-xmark"></i></a>
                                                </li>
                                            @endforeach
                                        @endif
                                         <li class="list-total">
                                             <h4>Total (USD)</h4>
                                             <h4 class="price">{{Helper::defaultCurrency()}} {{number_format($calculation_box['final_total_with_tax'],2)}}  </h4>
                                         </li>
                                     </ul>
                                    @endif

                                </div>
                            </div>

                            <div class="col-xxl-8 col-lg-12 col-md-7 order-xxl-1 order-lg-2 order-md-1">
                                <div class="accordion accordion-flush custom-accordion" id="accordionFlushExample">
                                    {{-- <div class="accordion-item">
                                        <div class="accordion-header" id="flush-headingOne">
                                            <div class="accordion-button collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapseOne">
                                                <div class="custom-form-check form-check mb-0">
                                                    <label class="form-check-label" for="credit"><input
                                                            class="form-check-input mt-0" type="radio"
                                                            name="flexRadioDefault" id="credit" checked> Credit or
                                                        Debit Card</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse show"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="row g-2">
                                                    <div class="col-12">
                                                        <div class="payment-method">
                                                            <div
                                                                class="form-floating mb-lg-3 mb-2 theme-form-floating">
                                                                <input type="text" class="form-control" id="credit2"
                                                                    placeholder="Enter Credit & Debit Card Number">
                                                                <label for="credit2">
                                                                    Enter Credit & Debit Card Number</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xxl-4">
                                                        <div class="form-floating mb-lg-3 mb-2 theme-form-floating">
                                                            <input type="text" class="form-control" id="expiry"
                                                                placeholder="Enter Expiry Date">
                                                            <label for="expiry">Expiry Date</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-xxl-4">
                                                        <div class="form-floating mb-lg-3 mb-2 theme-form-floating">
                                                            <input type="text" class="form-control" id="cvv"
                                                                placeholder="Enter CVV Number">
                                                            <label for="cvv">CVV Number</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-xxl-4">
                                                        <div class="form-floating mb-lg-3 mb-2 theme-form-floating">
                                                            <input type="password" class="form-control"
                                                                id="password" placeholder="Enter Password">
                                                            <label for="password">Password</label>
                                                        </div>
                                                    </div>

                                                    <div class="button-group mt-0">
                                                        <ul>
                                                            <li>
                                                                <button
                                                                    class="btn btn-light shopping-button">Cancel</button>
                                                            </li>

                                                            <li>
                                                                <button class="btn btn-animation">Use This
                                                                    Card</button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <div class="accordion-header" id="flush-headingTwo">
                                            <div class="accordion-button collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapseTwo">
                                                <div class="custom-form-check form-check mb-0">
                                                    <label class="form-check-label" for="banking"><input
                                                            class="form-check-input mt-0" type="radio"
                                                            name="flexRadioDefault" id="banking"> Net
                                                        Banking</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <h5 class="text-uppercase mb-4">Select Your Bank</h5>
                                                <div class="row g-2">
                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <input class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault" id="bank1">
                                                            <label class="form-check-label" for="bank1">Industrial &
                                                                Commercial Bank</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <input class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault" id="bank2">
                                                            <label class="form-check-label" for="bank2">Agricultural
                                                                Bank</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <input class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault" id="bank3">
                                                            <label class="form-check-label" for="bank3">Bank of
                                                                America</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <input class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault" id="bank4">
                                                            <label class="form-check-label" for="bank4">Construction
                                                                Bank Corp.</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <input class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault" id="bank5">
                                                            <label class="form-check-label" for="bank5">HSBC
                                                                Holdings</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <input class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault" id="bank6">
                                                            <label class="form-check-label" for="bank6">JPMorgan
                                                                Chase & Co.</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="select-option">
                                                            <div class="form-floating theme-form-floating">
                                                                <select class="form-select theme-form-select"
                                                                    aria-label="Default select example">
                                                                    <option value="hsbc">HSBC Holdings</option>
                                                                    <option value="loyds">Lloyds Banking Group
                                                                    </option>
                                                                    <option value="natwest">Nat West Group</option>
                                                                    <option value="Barclays">Barclays</option>
                                                                    <option value="other">Others Bank</option>
                                                                </select>
                                                                <label>Select Other Bank</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <div class="accordion-header" id="flush-headingThree">
                                            <div class="accordion-button collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapseThree">
                                                <div class="custom-form-check form-check mb-0">
                                                    <label class="form-check-label" for="wallet"><input
                                                            class="form-check-input mt-0" type="radio"
                                                            name="flexRadioDefault" id="wallet"> My Wallet</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="flush-collapseThree" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <h5 class="text-uppercase mb-4">Select Your Wallet</h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <label class="form-check-label" for="amazon"><input
                                                                    class="form-check-input mt-0" type="radio"
                                                                    name="flexRadioDefault" id="amazon"> Amazon
                                                                Pay</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <input class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault" id="gpay">
                                                            <label class="form-check-label" for="gpay">Google
                                                                Pay</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <input class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault" id="airtel">
                                                            <label class="form-check-label" for="airtel">Airtel
                                                                Money</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <input class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault" id="paytm">
                                                            <label class="form-check-label" for="paytm">Paytm
                                                                Pay</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <input class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault" id="jio">
                                                            <label class="form-check-label" for="jio">JIO
                                                                Money</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <input class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault" id="free">
                                                            <label class="form-check-label"
                                                                for="free">Freecharge</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="accordion-item">
                                        <div class="accordion-header" id="flush-headingFour">
                                            <div class="accordion-button collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapseFour">
                                                <div class="custom-form-check form-check mb-0">
                                                    <label class="form-check-label" for="cash">
                                                        <input class="form-check-input mt-0payment_method" type="radio" id="cod" name="paymentOption" value="COD"> Cash On
                                                        Delivery</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="flush-collapseFour" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <h5 class="cod-review">Pay digitally with SMS Pay Link. Cash may not
                                                    be accepted in COVID restricted areas. <a
                                                        href="javascript:void(0)">Know more.</a></h5>
                                            </div>
                                            <span class="error" id="payment-method-error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="button-group">
                            <ul class="button-group-list">
                                <li>
                                    <button class="btn btn-light shopping-button backward-btn text-dark">
                                        <i class="fa-solid fa-arrow-left-long ms-0"></i>Return To Delivery
                                        Option</button>
                                </li>

                                <li>
                                    <button type="button" class="primary_btn login btn btn-animation confirm_payment_btn checkout_btn" id="confirm_payment" >Place Order</button>
                                 
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Checkout section End -->

<!-- Footer Section Start -->
<!-- Footer Section End -->


<!-- Location Modal Start -->
<div class="modal location-modal fade theme-modal" id="locationModal" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Choose your Delivery Location</h5>
                <p class="mt-1 text-content">Enter your address and we will specify the offer for your area.</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="location-list">
                    <div class="search-input">
                        <input type="search" class="form-control" placeholder="Search Your Area">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>

                    <div class="disabled-box">
                        <h6>Select a Location</h6>
                    </div>

                    <ul class="location-select custom-height">
                        <li>
                            <a href="javascript:void(0)">
                                <h6>Alabama</h6>
                                <span>Min: $130</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Arizona</h6>
                                <span>Min: $150</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>California</h6>
                                <span>Min: $110</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Colorado</h6>
                                <span>Min: $140</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Florida</h6>
                                <span>Min: $160</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Georgia</h6>
                                <span>Min: $120</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Kansas</h6>
                                <span>Min: $170</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Minnesota</h6>
                                <span>Min: $120</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>New York</h6>
                                <span>Min: $110</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Washington</h6>
                                <span>Min: $130</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Location Modal End -->

<!-- Add address modal box start -->
<div class="modal fade theme-modal" id="add-address" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Add a new address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="addShippingLoginAddressForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">First Name</label>
                                <input type="text" name="first_name" id="first_name"  class="form-control required " maxlength="60" required placeholder="First Name*"  value="{{(Session::has('shipping_first_name'))?session('shipping_first_name'):''}}">
                               
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Last Name</label>
                                <input type="text" name="last_name" id="last_name"  class="form-control required " maxlength="60" required placeholder="Last Name*"  value="{{(Session::has('shipping_last_name'))?session('shipping_last_name'):''}}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="text" class="form-control required "   name="email" id="email"  maxlength="70" required placeholder="Email*"  value="{{(Session::has('shipping_email'))?session('shipping_email'):''}}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Phone Number</label>
                                <input type="text" class="form-control required  required login-shipping-phone" placeholder="Phone Number*"  name="phone" id="phone"   maxlength="70"  value="{{(Session::has('shipping_phone'))?session('shipping_phone'):''}}">
                            </div>
                        </div>
                    
                        <div class="col-lg-6">
                            <div class="form-group" >
                                <label for="">Country</label>
                                <select name="country" id="shipping_country" class="form-control form_select required " >
                                    <option selected disabled value="">Select Country*</option>
                                    @foreach($countries as $country)
                                    <option value="{{ $country->id }}"
                                        {{(session('shipping_country')==$country->id)?'selected':''}}
                                    >{{$country->title}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            
                            <div class="form-group" >
                                <label for="">Emirate</label>
                                <select class="form-control form_select required " name="state" id="shipping_state" >
                                    <option selected disabled value="">Select Emirate*</option>
                                    @if(!empty($states))
                                        @foreach($states as $shipping_state)
                                            <option value="{{ $shipping_state->id }}"
                                                {{(session('shipping_state')==$shipping_state->id)?'selected':''}}
                                            >{{$shipping_state->title}}</option>
                                        @endforeach
                                     @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Zip Code</label>
                                <input type="text" class="form-control  "   name="zipcode" id="zipcode" placeholder="Zip code"  value="{{(Session::has('shipping_zipcode'))?session('shipping_zipcode'):''}}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Address</label>
                                <textarea class="form-control form-message  "  data-reload="true"   name="address" id="address" placeholder="Address*">{{(Session::has('shipping_address'))?session('shipping_address'):''}}</textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="account_type" name="account_type" value="{{(Auth::guard('customer')->check())?1:0}}">
                    <input type="hidden" name="is_default" id="is_default" value="1">
                     <input type="hidden" id="id" name="id" value="0">
                     <input type="hidden" id="choose" name="choose" value="same" class="choose">
                    <input type="hidden" name="set_session" id="set_session"  value="1">
                    <div class="col-12 btnsBox align-items-end">
                        <button href="" class="submit-btn shipping-login-value-change btn theme-bg-color btn-md text-white">Submit</button>
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
             
            </div>
        </div>
    </div>
</div>
<!-- Add address modal box end -->



<!-- Bg overlay End -->
@endsection
@push('scripts')

<!-- latest jquery-->
<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>

<!-- jquery ui-->
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>

<!-- Lordicon Js -->
<script src="{{asset('assets/js/lusqsztk.js')}}"></script>

<!-- Bootstrap js-->
<script src="{{asset('assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap/bootstrap-notify.min.js')}}"></script>

<!-- feather icon js-->
<script src="{{asset('assets/js/feather/feather.min.js')}}"></script>
<script src="{{asset('assets/js/feather/feather-icon.js')}}"></script>

<!-- Lazyload Js -->
<script src="{{asset('assets/js/lazysizes.min.js')}}"></script>

<!-- Wizard js -->
<script src="{{asset('assets/js/wizard.js')}}"></script>

<!-- Slick js-->
<script src="{{asset('assets/js/slick/slick.js')}}"></script>
<script src="assets/js/slick/custom_slick.js"></script>

<!-- Quantity js -->
<script src="{{asset('assets/js/quantity.js')}}"></script>

<!-- script js -->
<script src="{{asset('assets/js/script.js')}}"></script>

<!-- thme setting js -->
<script src="{{asset('assets/js/theme-setting.js')}}"></script>
<script>

</script>
@endpush
