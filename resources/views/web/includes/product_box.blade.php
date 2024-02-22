
@php
    if($product){
        $cardProduct = App\Models\Product::active()->where('id', $product->id)->first();
        $copyProducts = App\Models\Product::active()->where('parent_product_id',$product->id)->latest()->get();
        $copyProductIds = $copyProducts->pluck('id')->toArray();
        $productPrices = App\Models\ProductPrice::where('product_id',$product->id)
        ->orWhereIn('product_id',$copyProductIds)
        ->get();
        $prices = $productPrices->pluck('price')->toArray();

        $highestPrice = $productPrices->max('price');
        $lowestPrice = $productPrices->min('price');

    }
@endphp

<div class="product-item-info">
    <div class="product-photo ">
        <div class="product-image-container w-100">
            <div class="product-image-wrapper">
                <a href="{{ url('/product/'.$product->short_url) }}" tabindex="-1">
                    {!! Helper::printImage($product, 'thumbnail_image','thumbnail_image_webp','thumbnail_image_attribute','d-block w-100 product-image-photo') !!}
                </a>
            </div>
                <div class="cartWishlistBox">
                    <ul>
                        @php
                         $productPrice = \App\Models\ProductPrice::where('product_id',$product->id)->first();
                        $class = '';
                        if (@$productPrice->availability=='In Stock' && @$productPrice->stock!=0) {
                            $class = 'cart-action';
                        }
                        else{
                            $class = 'out-of-stock';
                        }
                        @endphp
                    
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
                            @php
                                if($product->frame_color != null){
                                    $frameID = explode(',',$product->frame_color);
                                    $frameColor = \App\Models\Frame::whereIn('id',$frameID)->first()->id;
                                }
                                else{
                                    $frameColor = null;
                                }
                            @endphp
                          
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
                        <!-- {!! Helper::printImage($product, 'thumbnail_image','thumbnail_image_webp','thumbnail_image_attribute','d-block w-100') !!} -->
                    
                        <img class="img-fluid d-block w-100" src="{{ asset('frontend/images/productListLogo.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
        @php
        $productFirstPrice = \App\Models\ProductPrice::where('product_id',$product->id)->first();
        $productLastPrice = \App\Models\ProductPrice::where('product_id',$product->id)->orderBy('id','desc')->first();
        @endphp
        <div class="product-details">
            <a href="{{ url('/product/'.$product->short_url) }}">
                <div class="pro-name">
                {{ ucfirst($product->title) }}
            </div>
            <ul class="price-area">
              
                @if(Helper::offerPrice($product->id)!='')
                    @php
                        $offerId =Helper::offerId($product->id);
                    @endphp
                
                    <li class="offer"> {{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*$productPrice->price,2)}}</li>
                    <li> {{Helper::defaultCurrency().' '.number_format(Helper::offerPriceSize($product->id,$productPrice->size_id,$offerId),2)}}</li>
                @else
                

                    <li> {{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()* $lowestPrice,2)}}-{{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()* $highestPrice,2)}}</li> 
               @endif
            </ul>
            <ul class="type-review">
            @if($product->product_categories->count() > 1)
                <li>
                    @foreach ($product->product_categories as $categories)
                    {{ $categories->title }}
                    @endforeach
                {{-- {{ $product->product_categories[0]->title }}, ... --}}
                
                </li>
                @else
                <li>
                   
                    @foreach ($product->product_categories as $categories)
                    <!-- no coma for last category title -->

                    {{ $categories->title }}
                    @endforeach
                {{-- {{ $product->product_categories->title }} --}}
                
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
