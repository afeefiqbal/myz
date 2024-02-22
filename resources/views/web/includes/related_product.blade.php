<div class="relatedProducts">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Related Products</h3>
                <section id="demos">
                    <div class="relatedSlider owl-carousel owl-theme ">
                        @foreach ($relatedProducts as $rproduct)
                        <div class="item">
                            <div class="product-item-info">
                                <div class="product-photo ">
                            
                                        <div class="product-image-container w-100">
                                            <div class="product-image-wrapper">
                                                <a href="{{ url('/product/'.$rproduct->short_url) }}" tabindex="-1">
                                                {!! Helper::printImage($rproduct, 'thumbnail_image','thumbnail_image_webp','thumbnail_image_attribute','d-block w-100 product-image-photo') !!}
                                                </a>
                                            </div>
                                            @php
                                            $productPrice = \App\Models\ProductPrice::where('product_id',$rproduct->id)->first();
                                            $class = '';
                                            if ($productPrice->availability=='In Stock' && $productPrice->stock!=0) {
                                                $class = 'cart-action';
                                            }
                                            else{
                                                $class = 'out-of-stock';
                                            }
                                        @endphp
                                           @php
                                           if($rproduct->frame_color != null){
                                               $frameID = explode(',',$rproduct->frame_color);
                                               $frameColor = \App\Models\Frame::whereIn('id',$frameID)->first()->id;
                                           }
                                           else{
                                               $frameColor = null;
                                           }
                                       @endphp
                                            <div class="cartWishlistBox">
                                                <ul>
                                                    <li>
                                                        <a href="javascript:void(0)" class="my_wishlist {{ (Auth::guard('customer')->check())?'wishlist-action':'login-popup' }}
                                                                {{ (Auth::guard('customer')->check())?((app('wishlist')->get($rproduct->id))?'fill':''):'' }}"  data-id="{{$rproduct->id}}" data-size="{{$productPrice->size_id}}"  data-product_type_id="{{$rproduct->product_type_id}}"
                                                                data-bs-toggle="popover"  id="wishlist_check_{{$rproduct->id}}" 
                                                                data-bs-placement="left" data-bs-trigger="hover" data-bs-content="Wishlist">
                                                            <div class="textIcon">
                                                                Wishlist
                                                            </div>
                                                            <div class="iconBox" id="wishlist_check_span_{{$rproduct->id}}">
                                                                <i class="fa-regular fa-heart"></i>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                     
                                                        <a href="javascript:void(0)" class="my_wishlist  cartBtn {{$class}}" data-frame="{{$frameColor}}" data-mount="Yes" data-id="{{$rproduct->id}}" data-size="{{$productPrice->size_id}}"  data-product_type_id="{{$rproduct->product_type_id}}">
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
                                                    {{-- {!! Helper::printImage($rproduct, 'thumbnail_image','thumbnail_image_webp','thumbnail_image_attribute','d-block w-100') !!} --}}
                                                
                                                    <img class="img-fluid d-block w-100" src="{{ asset('frontend/images/productListLogo.png') }}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="product-details">
                                    <a href="{{ url('/product/'.$rproduct->short_url) }}">
                                        <div class="pro-name">
                                        {{ $rproduct->title }}
                                    </div>
                                    <ul class="price-area">
                                        @if(Helper::offerPrice($rproduct->id)!='')
                                            <li class="offer">
                                                @php
                                                    $offerId =Helper::offerId($rproduct->id);
                                                @endphp
                                                {{Helper::defaultCurrency().' '.number_format(Helper::offerPriceSize($rproduct->id,$productPrice->size_id,$offerId),2)}}
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
                                            @if($rproduct->product_categories->count() > 1)
                                            <li>
                                                @php
                                                //take the first category
                                                $category = $rproduct->product_categories->first();
                                                @endphp
                                            {{$category->title}}....
                                            </li>
                                        @else
                                            <li>
                                                @php
                                                    //take the first category
                                                    $category = $rproduct->product_categories->first();
                                                    @endphp
                                               {{$category !=null ? $category->title : ''}}
                                            </li>
                                        @endif
                                            
                                            @if(Helper::averageRating($rproduct->id)>0)
                                            <li class="review">
                                                <i class="fa-solid fa-star"></i>{{ Helper::averageRating($rproduct->id)  }}
                                            </li>
                                            @endif
                                        </ul>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>