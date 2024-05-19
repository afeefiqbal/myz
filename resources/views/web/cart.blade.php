@extends('web.layouts.main')
@section('content')
    <!-- mobile fix menu end -->

    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>Cart</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="index.php">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Cart</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
   
@if (Session::has('session_key') && !Cart::session($sessionKey)->isEmpty())
<!-- Cart Section Start -->
<section class="cart-section section-b-space">
    @if (!Cart::session($sessionKey)->isEmpty())
    <div class="container-fluid-lg">
        <h5 id="offcanvasRightLabel"><span>(<span  class="cart-count">  {{ Helper::getCartItemCount()}}</span> Items )</span> <br></h5> <br>
        <div class="row g-sm-5 g-3">
            <div class="col-xxl-9">
                <div class="cart-table">
                    <div class="table-responsive-xl">
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
                                                            <p class="product-name">
                                                                @php
                                                                $productName = 'sldfjls;djf posdfpsdfjsdpofjsdpfjspdofjpsoodpfjspodfjpsdfposjfpofsdpofpojfpsojfposjpfpopsojpsjpsdpjsdpjfpsjdfpojfpsfpojfspoj';
                                                                $length = 50;
                                                                $truncatedString = '';
                                                                $currentLength = 0;
                                
                                                                foreach (explode(' ', $productName) as $word) {
                                                                    $wordLength = strlen($word) + 1; // +1 for the space
                                                                    if ($currentLength + $wordLength > $length) {
                                                                        $truncatedString .= '<br>';
                                                                        $currentLength = 0;
                                                                    }
                                                                    $truncatedString .= $word . ' ';
                                                                    $currentLength += $wordLength;
                                                                }
                                
                                                                echo trim($truncatedString);
                                                            @endphp
                                                            </p>
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
            </div>

            <div class="col-xxl-3">
                <div class="summery-box p-sticky ">
                    @if (Session::has('session_key') && !Cart::session($sessionKey)->isEmpty())
                    <div class="summery-header">
                        <h3>Cart Total</h3>
                    </div>

                    <div class="summery-contain">
                        <div class="coupon-cart">
                            <h6 class="text-content mb-2">Coupon Apply</h6>
                            <div class="mb-3 coupon-box input-group">
                                <input type="text" class="form-control" name="coupon" id="coupon" value="{{ (Session::has('coupons'))?session('coupons')[count(session('coupons')) -  1]['code']:'' }}"
                                    placeholder="Enter Coupon Code Here...">
                                <button id="coupon-apply" class="btn-apply">{{Session::has('coupons')?'disabled':''}} {{Session::has('coupons')?'Applied':'Apply Coupon'}}</button>
                            </div>
                        </div>
                        <ul>
                            <li>
                                <h4>Subtotal</h4>
                                <h4 class="price"> {{ ($siteInformation->tax_type == 'Inside')? '(Tax Inclusive - '.$siteInformation->tax.'%)':''}}</h4>
                            </li>
                            @if (Session::exists('coupons'))
                            @foreach(Session::get('coupons') as $session_coupon)
                            <li>

                                <h4>Coupon Discount ({{ $session_coupon['code'] }}):</h4>
                                <h4 class="price">(-) {{Helper::defaultCurrency()}} {{number_format($session_coupon['coupon_value'],2)}}</h4>
                                <a class="coupon_remove_btn remove_coupon" href="javascript:void(0)"
                                data-coupon="{{ $session_coupon['code'] }}">Remove Coupon<i class="fa-solid fa-xmark"></i></a>
                            </li>
                            @endforeach
                            
                            @endif

                            <li class="align-items-start">
                                <h4>Shipping</h4>
                                <h4 class="price text-end">{{Helper::defaultCurrency()}} {{number_format($calculation_box['shippingAmount'],2)}}</h4>
                            </li>
                        </ul>
                    </div>

                    <ul class="summery-total">
                        <li class="list-total border-top-0">
                            <h4>Total (USD)</h4>
                            <h4 class="price theme-color">{{Helper::defaultCurrency()}} {{number_format($calculation_box['final_total_with_tax'],2)}}</h4>
                        </li>
                    </ul>

                    <div class="button-group cart-button">
                        <ul>
                            <li>                              
                                @if(!Auth::guard('customer')->check())
                                <button onclick="location.href = 'login';"
                                class="btn btn-animation proceed-btn fw-bold">Login</button>
                                @else
                                <button onclick="location.href = 'checkout';"
                                    class="btn btn-animation proceed-btn fw-bold">Process To Checkout</button>
                                @endif
                            </li>

                            <li>
                                <button onclick="location.href = 'index.php';"
                                    class="btn btn-light shopping-button text-dark">
                                    <i class="fa-solid fa-arrow-left-long"></i>Return To Shopping</button>
                            </li>
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</section>
@else
<section class="emptyCart">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <br>
                <br>
            </div>
            <div class="col-md-6 text-center">
                <br>
                <br>
                <picture>
                    <img class="img-fluid mb-4" src="{{asset('frontend/images/emptyCart.png')}}" alt="">
                </picture>
                <br>
                <a href="{{ url('/') }}" class="conShop">
                    <i class="fa-sharp fa-solid fa-arrow-left-long"></i>
                    Continue Shopping <br>
                    <br>
                </a>
                <br>
            </div>
            <div class="col-md-3">
                <br>
            </div>
        </div>
    </div>
</section>
@endif

@endsection


