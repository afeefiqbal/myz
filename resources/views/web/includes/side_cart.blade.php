<div class="offcanvas-header">
    <h5 id="offcanvasRightLabel"><img  src="{{ asset('frontend/images/cartRight.jpg')}}" alt=""><span>(<span  class="cart-count">  {{ Helper::getCartItemCount()}}</span> Items )</span></h5>
    <button type="button" class="btn-close text-reset " data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body">
    <span class="cart-error"></span>
    <span class="cart-success"></span>
    @if($sessionKey)
    @if (!Cart::session($sessionKey)->isEmpty())
    <div class="orderProductSummary">
                @foreach(Cart::session($sessionKey)->getContent()->sort() as $row)
                @php
               $product = App\Models\Product::find($row->id);
                @endphp
                <div id="cart-item-div-{{$row->id}}">
                    <div class="item">
                        <div class="leftImgDetails">
                            <div class="imgBox">
                                <a href="{{ url('/product/'.@$product->short_url) }}">
                                    {!! Helper::printImage($product, 'thumbnail_image','thumbnail_image_webp','thumbnail_image_attribute','d-block w-100') !!}
                                </a>
                            </div>
                            <div class="details">
                                <div>

                                    <a href="{{ url('/product/'.@$product->short_url) }}">
                                        <h5>
                                            {{ @$product->title }}
                                        </h5>
                                        <ul>
                                            <li>
                                                Type :

                                                    <span> {{ @$product->productType->title }}</span>

                                            </li>
                                            @if(@$row->attributes['frame'] != null)
                                            <li>
                                                Frame Colour :
                                            @php
                                                $frame = App\Models\Frame::find($row->attributes['frame']);
                                            @endphp
                                                <span> {{ $frame->title }}</span>
                                            </li>
                                            @endif
                                            @if(@$row->attributes['mount'] != null)
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
                    <div class="price">
                        <ul class="price-area">
                        @php
                            $price = \App\Models\ProductPrice::where('product_id',@$product->id)->where('size_id',$row->attributes['size'])->first();
                        @endphp
                        
                            <!-- <li class="offer">
                            @if(Helper::offerPrice(@$product->id)!='')
                            </li>
                            @endif -->
                            @if(Helper::offerPrice($product->id)!='')
                            @php
                            $offerId =Helper::offerId($product->id);
                             @endphp
                              @if(Helper::offerPriceSize($product->id,$row->attributes['size'],$offerId)!='')
                            <li>
                                {{Helper::defaultCurrency().' '.(Helper::offerPriceSize($product->id,$row->attributes['size'],$offerId))}}
                            </li>
                            @endif
                            <li>
                                {{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*@$price->price,2)}}
                            </li>
                            @else
                            <li>
                                {{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*@$price->price,2)}}
                            </li>
                            @endif
                        </ul>
                    
                            <div class="qntyClose">
                                <div class="quantity-counter">
                                    <button class="btn btn-quantity-down">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    </button>
                                    <input type="number" class="input-number__input form-control2 form-control-lg cartQuantity" min="1" max="100" step="1" value="{{$row->quantity}}"data-id="{{$row->id}}" data-size ={{$row->attributes['size']}} data-product_id = {{$row->attributes['product_id']}}>
                                    <button class="btn btn-quantity-up">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    </button>
                                </div>
                                <a href="javascript:void(0)" class="closeBtn remove-cart-item" id="{{$row->id}}"  data-id="{{$row->id}}">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                @endforeach
            </div>
            @endif
        @endif
</div>
@if(@$sessionKey)
@if (!Cart::session($sessionKey)->isEmpty())
<div class="offcanvas-footer">
    <div class="sub_total">
        <div class="sub_left">
            <h6>Subtotal</h6>
        </div>
        <div class="sub_right">
           
        
        <h5 class="sub_totall price{{@$product->id}}">{{Helper::defaultCurrency()}} {{ number_format(Cart::session($sessionKey)->getSubTotal(),2)}}</h5>
        
        </div>
    </div>
   
    <div class="btnsBox">
        <a href="{{url('checkout')}}" class="primary_btn checkout_btn">Proceed To Checkout</a>
        <a href="{{url('cart')}}" class="primary_btn login">View Cart</a>
    </div>
</div>
@endif @endif    