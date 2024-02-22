<div class="relatedProducts">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Related Products</h3>
                <section id="demos">
                    <div class="relatedSlider owl-carousel owl-theme ">
                        @foreach ($related_products as $product)
                        <div class="item">
                            <div class="product-item-info">
                                <div class="product-photo ">
                            
                                        <div class="product-image-container w-100">
                                            <div class="product-image-wrapper">
                                                <a href="{{ url('/product/'.$product->short_url) }}" tabindex="-1">
                                                {!! Helper::printImage($product, 'thumbnail_image','thumbnail_image_webp','thumbnail_image_attribute','d-block w-100 product-image-photo') !!}
                                                </a>
                                            </div>
                                            @php
                                             $productPrice = \App\Models\ProductPrice::where('product_id',$product->id)->first();
                                            $class = '';
                                            if (@$productPrice->availability=='In Stock' && $productPrice->stock!=0) {
                                                $class = 'cart-action';
                                            }
                                            else{
                                                $class = 'out-of-stock';
                                            }
                                        @endphp
                                           @php
                                           if($product->frame_color != null){
                                               $frameID = explode(',',$product->frame_color);
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
                                                                {{ (Auth::guard('customer')->check())?((app('wishlist')->get($product->id))?'fill':''):'' }}"  data-id="{{$product->id}}" data-size="{{@$productPrice->size_id}}"  data-product_type_id="{{$product->product_type_id}}"
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
                                                     
                                                        <a href="javascript:void(0)" class="my_wishlist  cartBtn {{$class}}" data-frame="{{$frameColor}}" data-mount="Yes" data-id="{{$product->id}}" data-size="{{@$productPrice->size_id}}"  data-product_type_id="{{$product->product_type_id}}">
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
                                                    {{-- {!! Helper::printImage($product, 'thumbnail_image','thumbnail_image_webp','thumbnail_image_attribute','d-block w-100') !!} --}}
                                                    <img class="img-fluid d-block w-100" src="{{ asset('frontend/images/productListLogo.png') }}" alt="">
                                                
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
                                        @php
                                            $offerId =Helper::offerId($product->id);
                                        @endphp
                                    
                                        <li class="offer"> {{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*$productPrice->price,2)}}</li>
                                        <li> {{Helper::defaultCurrency().' '.number_format(Helper::offerPriceSize($product->id,$productPrice->size_id,$offerId),2)}}</li>
                                    @else
                                    
                    
                                        <li> {{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()* $product->price,2)}}-{{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()* $product->price,2)}}</li> 
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
                                            
                                            @if(Helper::averageRating($product->id)>0)
                                            <li class="review">
                                                <i class="fa-solid fa-star"></i>{{ Helper::averageRating($product->id)  }}
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