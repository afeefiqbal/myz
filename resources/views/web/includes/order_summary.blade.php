
<h5 class="head">Order Summary</h5>
<div class="orderProductSummary  @if (Request::is('checkout'))  @else d-none  @endif">
    @if (Session::has('session_key') && !Cart::session($sessionKey)->isEmpty())
        @if (!Cart::session($sessionKey)->isEmpty())
            @foreach(Cart::session($sessionKey)->getContent()->sort() as $row)
                @php
               $product = App\Models\Product::find($row->id);
                @endphp
                <div class="item">
                    <div class="leftImgDetails">
                        <div class="imgBox">
                            <a href="{{ url('/product/'.$product->short_url) }}">
                                {!! Helper::printImage($product, 'thumbnail_image','thumbnail_image_webp','thumbnail_image_attribute','d-block w-100') !!}
                            </a>
                        </div>
                        <div class="details">
                            <div>
                                <a href="{{ url('/product/'.$product->short_url) }}">
                                    <h5>
                                        {{ $product->title }}
                                    </h5>
                                    <ul>
                                        <li>
                                            Type :

                                                <span> {{ $product->productType->title }}</span>

                                        </li>
                                        @if($row->attributes['frame'] != null)
                                        <li>
                                            Frame Colour :
                                        @php
                                            $frame = App\Models\Frame::find($row->attributes['frame']);
                                        @endphp
                                            <span> {{ $frame->title }}</span>
                                        </li>
                                        @endif
                                        @if($row->attributes['mount'] != null)
                                        <li>
                                            Mount :
                                            @if($row->attributes['mount'] == 'Yes')
                                                <span> With Mount</span>
                                            @else
                                                <span> No Mount</span>
                                            @endif
                                        </li>
                                        @endif
                                        @if($row->attributes['size'] != null)
                                        <li>
                                            @php
                                            $size = App\Models\Size::find($row->attributes['size']);
                                        @endphp
                                            Size :
                                            <span> {{ $size->title ?? '' }}</span>
                                        </li>
                                        @endif

                                    </ul>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="details">
                       <span> {{ $row->quantity }} Items</span>
                    </div>
                    <div class="price">
                        <ul class="price_area">
                            @php
                            $price = \App\Models\ProductPrice::where('product_id',$product->id)->where('size_id',$row->attributes['size'])->first();
                            @endphp

                          @if(Helper::offerPrice($product->id)!='')
                          @php
                          $offerId =Helper::offerId($product->id);
                           @endphp
                          <li>
                              {{Helper::defaultCurrency().' '.(Helper::offerPriceSize($product->id,$row->attributes['size'],$offerId))}}
                          </li>
                          <li>
                              {{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*$price->price,2)}}
                          </li>
                          @else
                          <li>
                              {{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*$price->price,2)}}
                          </li>
                          <li></li>
                          @endif
                        </ul>
                    </div>
                </div>
            @endforeach
        @endif
    @endif

</div>

<ul class="calc_area">
    <li>
        <div class="left">
            <h6>  Subtotal {{ ($siteInformation->tax_type == 'Inside')? '(Tax Inclusive - '.$siteInformation->tax.'%)':''}}</h6>
        </div>
        <div class="right">
            <h5 class="sub_totall">{{Helper::defaultCurrency()}} {{ number_format(Cart::session($sessionKey)->getSubTotal(),2)}}</h5>
        </div>
    </li>
    @if($siteInformation->tax_type == 'Outside')
    <li class="@if (Request::is('cart'))    @else   @endif">
        <div class="left">
            <h6>Tax{{ ' ('. $siteInformation->tax . '% )' }}</h6>
        </div>
        <div class="right">
            <h5 class="tax_amount">{{Helper::defaultCurrency()}} {{number_format($calculation_box['tax_amount'],2)}}</h5>
        </div>
    </li>
    @endif
    <li class="cod-charge" style="display:none;">
        <div class="left">
            <h6>COD Charge</h6>
        </div>
        <div class="right">
            <h5 class="cod-charge">{{Helper::defaultCurrency()}} {{Helper::defaultCurrencyRate()*$siteInformation->cod_extra_charge}}</h5>
        </div>
    </li>
    <li class=" @if (Request::is('checkout'))  @else   @endif">
        <div class="left">
            <h6>Shipping Charge</h6>
        </div>
        <div class="right">

            <h5 class="shipping_amount">{{Helper::defaultCurrency()}} {{number_format($calculation_box['shippingAmount'],2)}}</h5>
        </div>
    </li>
    <li class="@if (Request::is('cart')) d-none   @else couponList  @endif block-noti">
        <form action="#">
            <div class="form-group position-relative">
                <input type="text" class="form-control"name="coupon" id="coupon" placeholder="Coupon Code" value="{{ (Session::has('coupons'))?session('coupons')[count(session('coupons')) -  1]['code']:'' }}" >
                @if (Session::exists('coupons'))
                    <a class="coupon_remove_btn remove_coupon" href="javascript:void(0)" data-coupon="{{ (Session::has('coupons'))?session('coupons')[count(session('coupons')) -  1]['code']:'' }}" ><i class="fa-solid fa-xmark"></i></a>
                @endif
               

            </div>
         
            <button id="coupon-apply" class="btn primary_btn " {{Session::has('coupons')?'disabled':''}}> {{Session::has('coupons')?'Applied':'Apply Coupon'}}</button>
        </form>
         <span class="invalidMessage coupon invalidMessage-applay"></span>
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
</ul>
<div class="sub_total">
    <input type="hidden" name="grand_total_amount" id="grand_total_amount" value="{{number_format($calculation_box['final_total_with_tax'],2)}}">
    <div class="sub_left">
        <h6>Total</h6>
    </div>
    <div class="sub_right">

        <h5 class="cart_final_total">{{Helper::defaultCurrency()}} {{number_format($calculation_box['final_total_with_tax'],2)}}</h5>
    </div>
</div>
<div class="btnsBox @if (Request::is('cart'))  @else d-none  @endif ">
    @if(!Auth::guard('customer')->check())
        <a @if(isset($button_class) && $button_class == "outOfStock") href="javascript:void(0)" @else  href="{{ url('checkout') }}"  @endif   class="primary_btn checkout_btn {{@$button_class}}">Guest Checkout</a>
        <a href="{{ url('login') }}" class="primary_btn login">Login</a>
    @else
    <a @if(isset($button_class) && $button_class == "outOfStock") href="javascript:void(0)" @else  href="{{ url('checkout') }}"  @endif   class="primary_btn checkout_btn {{@$button_class}}">Proceed to Checkout</a>

    @endif

</div>
<div class=" @if (Request::is('checkout'))  @else d-none  @endif ">
    <div class="banks">
        <div class="accordion" id="accordionExample">
            {{-- <div class="accordion-item">
                <h3 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <input class="bank-radio" type="radio" checked id="credit" name="bank">
                        <label for="credit"><img src="assets/images/mastercard.svg" alt=""></label>
                    </button>
                </h3>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                    <div class="accordion-body">
                        <p>Pay with Credit card or Debit card.</p>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h3 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <input class="bank-radio" type="radio" id="paypal" name="bank">
                        <label for="paypal"><img src="assets/images/paypal.svg" alt=""></label>
                    </button>
                </h3>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample" style="">
                    <div class="accordion-body">
                        <p>Pay with PayPal.</p>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h3 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <input class="bank-radio" type="radio" id="applepay" name="bank">
                        <label for="applepay"><img src="assets/images/applepay.svg" alt=""></label>
                    </button>
                </h3>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
                    <div class="accordion-body">
                        <p>Pay with Apple Pay.</p>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h3 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        <input class="bank-radio" type="radio" id="bitcoin" name="bank">
                        <label for="bitcoin"><img src="assets/images/bitcoin.svg" alt=""></label>
                    </button>
                </h3>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample" style="">
                    <div class="accordion-body">
                        <p>Pay with Bitcoin.</p>
                    </div>
                </div>
            </div> --}}

