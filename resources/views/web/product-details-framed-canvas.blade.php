@extends('web.layouts.main')
@section('content')
@section('snippet')
@include('web.includes.product_snippet',['product_snipet'=>@$product])
@endsection
<!--Inner Banner Start-->
<section class="innerBanner innerBannerProducts">

    <div class="innerBannerDetails">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                  
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}"><img
                                        src="{{ asset('frontend/images/home.png') }}" alt=""></a></li>
                            <li class="breadcrumb-item"><a href="{{url('products')}}">Products</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$product->title}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Inner Banner End-->

<!--Product Details Page Start-->

<section class="productDetailsPage">
    <div class="container">
        <div class="row justify-content-between align-items-start">
            <div class="col-xxl-5  col-lg-5 product_details_gallery framed-canvas">
                <div class="row sliderWrapperArea ">
                    <div class=" col-9 productDetailsLeftSecond " >
                        <div class="productDetailsLargeImages">
                            <div class="item position-relative">
                                <div class="fotorama__stage__frame" >
                                    <div class="fotorama__html">
                                        @php
                                            $frame  = explode(',',$product->frame_color);
                                            $fr = \App\Models\Frame::whereIn('id',$frame)->first();
                                        @endphp
                                       @if($fr != null)
                                            <img class="framed-canvas fotorama__img frame_product_detail_img @if(@$product->is_mount) imageMountClass @endif " style="border: 15px solid {{$fr->code}} !important;" src="{{asset($product->thumbnail_image)}}" aria-hidden="false">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="item position-relative">
                                <div class="fotorama__stage__frame" >
                                    <div class="fotorama__html">
                                        <img class="fotorama__img" src="{{asset('frontend/images/frame/wooden-frame_th.jpg')}}" aria-hidden="false">
                                    </div>
                                </div>
                            </div> --}}
                            @php
                            $frame  = explode(',',$product->frame_color);
                            $frame = \App\Models\Frame::whereIn('id',$frame)->first();
                            @endphp
                            @if(@$productType)
                                @if($productType->alternate_image != '')
                                    <div class="fotorama__nav__frame ">
                                        <div class="fotorama__thumb fotorama_vertical_ratio ">
                                        {!! Helper::printImage(@$productType,'alternate_image','alternate_image_webp','alternate_image_attribute','fotorama__img img-fluid') !!}
                                        </div>
                                    </div>
                                @endif
                            @endif
                             @if($frame != null)
                             <div class="fotorama__nav__frame ">
                                 <div class="fotorama__thumb fotorama_vertical_ratio">
                                     <img src="{{asset($frame->image)}}" alt="{{$frame->image_attribute}}" class="fotorama__img img-fluid frame_product_border_image">
                            
 
                                 </div>
                             </div>
                             @endif
                            {{-- <div class="item position-relative">
                                <div class="fotorama__stage__frame" >
                                    <div class="fotorama__html">
                                        <img class="fotorama__img frame_product_border_image" src="{{asset($frame->image)}}" aria-hidden="false">
                                    </div>
                                </div>
                            </div> --}}
                            @if($product->activeGalleries->count() > 0)
                            @foreach ($product->activeGalleries as $gallery)
                                <div class="item position-relative">
                                    <div class="fotorama__stage__frame" >
                                        <div class="fotorama__html">
                                            <img class="fotorama__img" src="{{asset($gallery->image)}}" aria-hidden="false">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        </div>
                    </div>
                    <div class="col-3 productDetailsLeftFirst" >
                        <div class="productDetailsThumbs ">
                            <div class="fotorama__nav__frame">
                                <div class="fotorama__thumb fotorama_horizontal_ratio">
                                    <img src="{{asset($product->thumbnail_image)}}" class="fotorama__img img-fluid">
                                </div>
                            </div>
                            @if(@$productType)
                                @if($productType->alternate_image != '')
                                    <div class="fotorama__nav__frame ">
                                        <div class="fotorama__thumb fotorama_vertical_ratio ">
                                            {!! Helper::printImage(@$productType,'alternate_image','alternate_image_webp','alternate_image_attribute','fotorama__img img-fluid') !!}
                                        </div>
                                    </div>
                                @endif
                             @endif
                            @php
                            $frame  = explode(',',$product->frame_color);
                            $frm = \App\Models\Frame::whereIn('id',$frame)->first();
                            @endphp
                              @if($frm != null)
                            <div class="fotorama__nav__frame ">
                                <div class="fotorama__thumb fotorama_vertical_ratio">
                                    <img src="{{asset($frm->image)}}" alt="{{$frm->image_attribute}}" class="fotorama__img img-fluid frame_product_border_image">
                           

                                </div>
                            </div>
                            @endif
                            
                            @if($product->activeGalleries->count() > 0)
                                @foreach ($product->activeGalleries as $gallery)
                                    <div class="fotorama__nav__frame ">
                                        <div class="fotorama__thumb fotorama_vertical_ratio">
                                            {!! Helper::printImage(@$gallery,'image','image_webp','image_attribute','fotorama__img img-fluid') !!}

                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-7 col-lg-7 productDetailsInfo ps-xxl-5 ps-xl-4">
                <div class="productNameStock">
                    <div class="name">
                        <h4>{{$product->title}}</h4>
                        <input type="hidden" id="pid" value="{{$product->id}}">
                    </div>
                    <div class="instock outOfStock d-none stock"> </div>
                            @php
                            $productPrice = \App\Models\ProductPrice::where('product_id',$product->id)->first();
                            @endphp
                            @if (@$productPrice->availability != 'In Stock')
                                <div class="stock outOfStock">
                                {{ $productPrice->availability}}
                                </div>
                            @endif
                </div>
                <div class="productRatingPrice">
                    <div class="rating">
                        @if($totalRatings >0)
                        <h6>  {{ $totalRatings }} Ratings</h6>
                        @endif
                        @if($averageRatings >0)
                        <div class="rate_area">
                            <i class="fa-solid fa-star"></i>  {{ $averageRatings }}
                        </div>
                        @endif
                    </div>
                    <div class="price">
                       
                        @if(Helper::offerPrice($product->id)!='')
                        @php
                            $offerId =Helper::offerId($product->id);
                            $sizes = \App\Models\ProductPrice::where('product_id',$product->id)->get();
                            $sizeID = $sizes->map(function($item) {
                                return $item->size_id;
                            })->toArray();
                           $sizes = \App\Models\Size::whereIn('id',$sizeID)->orderBy('sort_order')->get();
                            $firstSizeId = $sizes->first()->id;
                            $productPrice = \App\Models\ProductPrice::where('product_id',$product->id)->where('size_id',$firstSizeId)->first();
                        @endphp
                        <h5 class="offer_price">{{Helper::defaultCurrency().' '.number_format(Helper::offerPriceSize($product->id,$firstSizeId,$offerId),2)}}  </h5>
                        @else
                            <h5 class="offer_price">{{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*$productPrice->price,2)}}</h5>
                            <h5 class="product_price"></h5>
                        @endif
                    </div>
                </div>
                <div class="productCode">
                    <h5>
                        Product Code : <strong>{{$product->sku}}</strong>
                    </h5>
                </div>
                <div class="textArea">
                    {!! @$product->description !!}
                </div>

                <div class="relatedProductsTypesSelect">
                    <h5>
                        Select Product Type
                    </h5>
                    <div class="relatedProductsTypesWrapper">
                        @foreach ($products as $prd)
                        <div class="item typeBtn {{$prd->productType->id ==  $product->productType->id ?  'active' : '' }}">
                            <a href=" {{url('/product/'.$prd->short_url)}} ">
                               {!! Helper::printImage($prd->productType, 'image','image_webp','image_attribute') !!}
                                <p>{{$prd->productType->title}}</p>

                                <input type="hidden" id="ptype" value="{{$product->productType->id}}">
                            </a>
                        </div>

                        @endforeach

                    </div>
                </div>


                @if(@$productFrames->isNotEmpty())

                <div class="relatedProductsTypesSelect">
                    <h5>
                        Select Frame Color
                    </h5>

                    <div class="relatedProductsTypesWrapper">
                        @php
                            $n = 1;
                        @endphp
                        @foreach ($productFrames as $frame)
                        <div class="item {{ $frm->id == $frame->id ?  'active'  : '' }}  colorBtn frame" data-color="{{$frame->code}}" data-img="{{asset($frame->image)}}" data-id="{{$frame->id}}">
                            <div class="colorBox" style="background: {{$frame->code}}">

                            </div>
                            <p>{{$frame->title}}</p>
                            <input type="hidden" id="pframe" value="{{$frame->id}}">
                        </div>
                        @php
                            $n++;
                            @endphp
                        @endforeach
                        {{-- <div class="item colorBtn" data-color="#000000" data-img="assets/images/frame/wooden-frame2.jpg">
                            <div class="colorBox" style="background: #000000">

                            </div>
                            <p>Black</p>    
                        </div> --}}
                    </div>
                </div>
                @endif

                @if(@$product->mount != null  &&$product->is_mount)
                    <div class="relatedProductsTypesSelect">
                        <h5>
                            Mount
                        </h5>
                        <div class="relatedProductsTypesWrapper">
                            <div class="item @if(@$product->is_mount) active @endif mountSpaceBtn btnMountClass mount"  data-mount="Yes">
                                <div class="colorBox" >
                                    <img class="img-fluid w-100" src="{{asset('frontend/images/frame/wooden-frame-no-mount.jpg')}}" alt="">
                                </div>
                                <p>With Mount</p>
                            </div>
                            <div class="item mountSpaceBtn @if(@$product->is_mount != true) active @endif mount" data-mount= "No">
                                <div class="colorBox" >
                                    <img class="img-fluid w-100" src="{{asset('frontend/images/frame/wooden-frame-mount.jpg')}}" alt="">
                                </div>
                                <p>No Mount</p>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="relatedProductsTypesSelect">
                    <h5>
                        Select Size <span>(Size in cms)</span>
                    </h5>
                   @php
                        $sizes = \App\Models\ProductPrice::where('product_id',$product->id)->get();
                        $sizeID = $sizes->map(function($item) {
                            return $item->size_id;
                        })->toArray();
                        $sizes = \App\Models\Size::whereIn('id',$sizeID)->orderBy('sort_order')->get();
                        $firstSizeId = $sizes->first()->id;
                    @endphp
                    <div class="relatedProductsTypesWrapper sizeSection">
                        @foreach ($sizes as $size)
                        <div class="item {{$size->id ==   $firstSizeId ?  'active' : '' }} checkprice size " data-id="{{$size->id}}" data-product_id="{{$product->id}}"  data-product_type_id="{{$product->product_type_id}}">
                            <div class="sizeImageBox">
                                {!! Helper::printImage($size, 'image','image_webp','image_attribute', 'img-fluid') !!}
                            </div>
                            <p>{{$size->title}}</p>
                            <input type="hidden" id="psize" value="{{$size->id}}">
                        </div>
                        @endforeach

                    </div>
                </div>
                <div class="totalBox">
                    <h5>
                        Total
                    </h5>
                    <div class="priceQuantityArea">
                        <div class="priceArea">
                            @if(Helper::offerPrice($product->id)!='')
                            <h3 class="offer_price">{{Helper::defaultCurrency().' '.number_format(Helper::offerPriceSize($product->id,$firstSizeId,$offerId),2)}}  </h3>
                                <h6 class="product_price">{{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*$productPrice->price,2)}}</h6>
                            @else
                                <h3 class="offer_price">{{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*$productPrice->price,2)}}</h3>
                                <h6 class="product_price"></h6>
                            @endif
                        </div> 
                        <div class="quantity_parice_order_area">
                            <div class="quantity-counter">
                                <button class="btn btn-quantity-down">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                </button>
                                 <input type="number" disabled  name="qty" data-id="{{$product->id}}"
                                    class="input-number__input form-control2 form-control-lg qty" min="1"
                                    max="100" step="1" value="1">
                                <button class="btn btn-quantity-up">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="btnsArea">
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
                       <a href="javascript:void(0)" data-id="{{$product->id}}" class="primary_btn cartBtn {{ $class }}">Add to Cart</a>
                        <a class="primary_btn secondary_btn" href="" data-bs-target="#bulk_order_form_pop" data-bs-toggle="modal" data-bs-dismiss="modal" >Bulk Enquiry</a>
                    </div>
                </div>

                <div class="tagArea">
                    <h6>Product Tags</h6>
                    @foreach ($productTags as $tag)

                    <div class="tag">{{$tag->title}}</div>
                    @endforeach

                </div>
            </div>
        </div>
        @if(@$product->about_item != null)
        <div class="moreDetails">
            @if($product->about_item)
            <div class="row">
                <div class="col-12">
                    <h4>
                        About This Item
                    </h4>
                    <div class="textArea">
                       {!! $product->about_item !!}
                    </div>
                </div>
            </div>
            @endif
            @if($product->featured_image)
            <div class="row justify-content-center mt-4">
                <div class="col-lg-5">
                    {!! Helper::printImage($product, 'featured_image','featured_image_webp','featured_image_attribute', 'img-fluid') !!}
                </div>
                <div class="col-lg-5 right ps-xl-5">
                    <div class="textArea">
                        <div>
                           {!! $product->featured_description !!}
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
</section>

<!--Product Details Page End -->

<!--Reviews Section Start-->

<section class="reviewSection">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 pe-xl-5">
                <div class="reviewDetailsLeft">
                    <div class="left">
                        <h5>Customer Reviews</h5>
                        <p>What others think about the item</p>
                        <h6>{{ $totalRatings }} Ratings & {{ $totalReviews }} Reviews</h6>
                        <div class="my-rating-readonly" data-rating="{{ $totalRatings }}"></div>
                    </div>
                    <div class="right">
                         <h5><img src="{{ asset('frontend/images/star.png') }}" alt="">{{ $averageRatings }}</h5>
                        <p>Average customer rating</p>
                    </div>
                </div>
                <div class="ratings_reviews_right_bar">
                    <h6>Reviews</h6>
                    <ul>
                        <ul>
                            @for($i=5;$i>=1;$i--)

                            <li>
                                <div class="ratings_reviews_star">
                                    <p>{{ $i }}<img src="{{ asset('frontend/images/star.png') }}" alt=""></p>
                                </div>
                                @php $var = 'starPercent'.$i @endphp
                                <div class="ratings_reviews_bar">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $$var }}%" aria-valuenow="{{ $$var }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p>
                                        {{ $$var }}%
                                    </p>
                                </div>
                            </li>
                            @endfor

                        </ul>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                @include('web.includes.review_form',['product_id'=>$product->id])
            </div>
        </div>
    </div>
</section>

<!--Reviews Section End-->

<!-- Testimonial Start-->

@include('web.includes._review_inner',[$reviews, $totalRatings])

<!-- Testimonial End-->
@if(@$similarProducts->isNotEmpty())
@include('web.includes.similar_products',[$similarProducts])
@endif
@if(@$relatedProducts->isNotEmpty())
@include('web.includes.related_product',[$relatedProducts])
@endif


<section class="bottomStickyBar">
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="bottomItemWrapper">
                    <div class="imageName">
                        <div class="imgBox">
                          {!! Helper::printImage(@$product,'thumbnail_image','thumbnail_image_webp','thumbnail_image_attribute','img-fluid') !!}
                        </div>
                        <div class="name">
                            <p>
                             {{$product->title}}
                            </p>
                        </div>
                    </div>
                    <div class="qntyAddBtn totalBox">
                        <div class="quantity-counter">
                            <button class="btn btn-quantity-down">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </button>
                            <input type="number" disabled class="input-number__input form-control2 form-control-lg qty"
                                min="1" max="100" step="1" value="1">
                            <button class="btn btn-quantity-up">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </button>
                        </div>
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
                       <a href="javascript:void(0)" data-id="{{$product->id}}" class="primary_btn cartBtn {{ $class }}">Add to Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade login_create" id="bulk_order_form_pop" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> <i class="fa-solid fa-list"></i> Bulk Enquiry</h5>
                <button type="button" class="btn " data-bs-dismiss="modal" aria-label="Close"><img
                        class="img-fluid" src="{{ asset('frontend/images/svg/colse_login.svg') }}"
                        alt=""></button>
            </div>
            <div class="modal-body">
                <form action="#"  id="bulkenquiryForm" name="bulkenquiryForm">
                    <div class="row">
                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Name*">
                        </div>
                        <div class="form-group">
                            <input type="text" name="email" id="email" class="form-control"
                                placeholder="Email*">
                        </div>
                        <div class="form-group">
                            <input type="text" name="phone" id="phone"class="form-control bulk-framed-phone"
                                placeholder="Phone*">
                        </div>
                        <div class="form-group">
                            <textarea name="message" id="message" class="form-control form-message" placeholder="Message*"></textarea>
                            <!-- <input type="password" class="form-control" placeholder="Password*"> -->
                        </div>
                        {{-- <input type="hidden" name="subject" value="subject"> --}}

                        <input type="hidden" id="type" name="type" value="product">
                        <input type="hidden" id="proid" name="product_id" value="">
                        <input type="hidden" id="product_type_id" name="product_type_id" value="">
                        <input type="hidden" id="size_id" name="size_id" value="">
                        <input type="hidden" id="frameid" name="frame_id" value="">
                        <input type="hidden" id="mount_id" name="mount" value="">
                        <div class="form-group">
                           <button class="btn primary_btn form_submit_btn" data-url="/enquiry">Send</button>
                        </div>


                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
 var type_id   = $('.size.active').data('product_type_id');
$('#product_type_id').val(type_id);

var frame_id = $('.frame.active').data('id');

 $('#frameid').val(frame_id);

 var size = $('.size.active').data('id');
 $('#size_id').val(size);


 var pid = $('#pid').val();
 $('#proid').val(pid);

 var mount = $('.mount.active').data('mount');
 $('#mount_id').val(mount);

 $('.size').on('click',function(){
    var size = $(this).data('id');
    $('#size_id').val(size);
});
$('.mount').on('click',function(){
    var mount = $(this).data('mount');
  
    $('#mount_id').val(mount);
});
$('.frame').on('click',function(){
    var frame_id = $(this).data('id');
    $('#frameid').val(frame_id);
});
</script>

@endpush
