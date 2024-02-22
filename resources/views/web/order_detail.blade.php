@extends('web.layouts.main')
@section('content')
<section class="myOrderDetails">
    <section class="mb-3">
        <div class="container position-relative">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Order Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="row">
            <div class="col-12 profile_detail_wrapper position-relative">
                <div id="my_order_list_details" >
                    <div class="order_details">
                        <div class="order_details_header">
                            <ul>
                                <li>
                                    Order ID : ARTMYT# {{$order->order_code}}
                                </li>
                                <li>
                                    Placed Order on  {{date('d-m-Y',strtotime($order->created_at))}}
                                </li>
                                <li>
                                    <a href="{{url('/')}}"><i class="fa-solid fa-arrow-left"></i>Back</a>
                                </li>
                            </ul>
                        </div>
                        <div class="order_address_area">
                            <div class="address_card">
                                <h5>Billing Address</h5>

                                <div class="address">

                                    <h6>{{ $order->orderCustomer->billingAddress->first_name . ' ' .$order->orderCustomer->billingAddress->last_name }}</h6>
                                    <p>{{ $order->orderCustomer->billingAddress->address }}</p>
                                    @if($order->orderCustomer->billingAddress->state!=NULL)
                                        <p>{{$order->orderCustomer->billingAddress->state->title}},
                                            {{$order->orderCustomer->billingAddress->state->country->title}}</p>
                                    @endif
                                </div>
                             
                                <ul>
                                    <li>
                                        {{ $order->orderCustomer->billingAddress->zipcode }}
                                    </li>
                                    <li>
                                        Email: {{ $order->orderCustomer->billingAddress->email }}
                                    </li>
                                    <li>
                                        Phone: {{ $order->orderCustomer->billingAddress->phone }}
                                    </li>
                                   
                                </ul>
                            </div>
                            <div class="address_card">
                                <h5>Shipping Address</h5>
                                <div class="address">
                                    <h6>{{ $order->orderCustomer->shippingAddress->first_name . ' ' .$order->orderCustomer->shippingAddress->last_name }}</h6>
                                    <p>{{ $order->orderCustomer->shippingAddress->address }} </p>
                                    <p> {{ $order->orderCustomer->shippingAddress->state->country->title }}
                                        , {{ $order->orderCustomer->shippingAddress->state->title }}</p>
                                        <p>  {{ $order->orderCustomer->shippingAddress->zipcode }}</p>
                                </div>
                                
                                <ul>
                                    <li>
                                        Email:{{ $order->orderCustomer->shippingAddress->email }}
                                    </li>
                                    <li>
                                        Phone: {{ $order->orderCustomer->shippingAddress->phone }}
                                    </li>
                                    
                                    
                                </ul>
                            </div>
                        </div>
                        @php
                        $refundStatus = $refundStatusPrevious = null;
                        @endphp

                        @foreach($order->orderProducts as $product)
                        @php
                            $orderStatus = App\Models\OrderLog::where('order_product_id',$product->id)->orderBy('created_at','DESC')->first();
                     
                            $orderStatusPrevious = App\Models\OrderLog::where('order_product_id',$product->id)->latest()->skip(1)->take(1)->first();
                            if($orderStatusPrevious != null){
                                $orderStatusPrevious = $orderStatus;
                                if (@$orderStatus->status == 'Refunded' || $orderStatus->status == 'Cancelled' || $orderStatus->status == 'Completed' ){
                                    $refundStatus = $orderStatus;
                                    $refundStatusPrevious = $orderStatusPrevious;
                                }
                            }
                         
                        @endphp
                          @if ($product->productData != null)
                            <div class="order_details_item">
                                <div class=" products_item">
                                    <div class="product_image">
                                        <a href="{{ url('/product/'.$product->productData->short_url) }}" tabindex="-1">
                                            {!! Helper::printImage($product->productData, 'thumbnail_image','thumbnail_image_webp','thumbnail_image_attribute','d-block w-100') !!}
                                        </a>
                                    </div>
                                    <div class="product_details">
                                        <div>
                                            <h6>
                                                <a href="{{ url('/product/'.$product->productData->short_url) }}">
                                                {{ $product->productData->title }}
                                                </a>
                                            </h6>

                                           @php
                                               $frame = App\Models\Frame::where('id',$product->frame)->first();
                                               $type = App\Models\ProductType::where('id',$product->type)->first();
                                                  $size = App\Models\Size::where('id',$product->size)->first();
                                           @endphp
                                            <ul>
                                                <li>
                                                    @if($type)
                                                    Type :

                                                    <span>{{ $type->title }}</span>
                                                    @endif
                                                </li>
                                                @if($frame)
                                                <li>
                                                    Frame Colour :
                                                     <span>{{$frame->title}}</span>
                                                    </li>
                                                    @endif
                                                <li>
                                                   Size :
                                                    @if($size)
                                                     <span>{{$size->title ?? ''}}</span>
                                                    @endif
                                                </li>
                                                @if($product->type == '4')
                                                <li>
                                                    Mount :
                                                 
                                                    @if($product->mount == "No")
                                                    <span>No Mount</span>
                                                    @else
                                                    <span>With Mount </span>
                                                    @endif
                                               
                                                @endif
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="priceStatus">
                                    <div class="price">
                                        {{$product->qty}} items
                                    </div>
                                </div>
                                <div class="priceStatus">
                                    <div class="price">
                                        <ul class="price-area">

                                            <li>
                                                {{Helper::defaultCurrency()}} {{$product->total}}
                                            </li>
                                         {{-- @php
                                                $sizes = \App\Models\ProductPrice::where('product_id',$product->productData->id)->where('size_id',$size->id)->first();
                                         @endphp
                                            @if(Helper::offerPrice($product->productData->id)!='')
                                            <li>
                                                {{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*$sizes->price,2)}}
                                            </li>
                                            <li>
                                                @php
                                                $price = \App\Models\ProductPrice::where('product_id',$product->productData->id)->where('size_id',$product->size)->first();
                                                @endphp
                                                @php
                                                $offerId =Helper::offerId($product->productData->id);
                                                 @endphp
                                                {{Helper::defaultCurrency().' '.number_format(Helper::offerPriceSize($product->productData->id,$product->size,$offerId),2)}}
                                            </li>



                                            @else
                                            <li></li>
                                            <li>

                                                {{Helper::defaultCurrency().' '.number_format(Helper::defaultCurrencyRate()*$sizes->price,2)}}
                                            </li>
                                            <li>

                                            </li>
                                            @endif --}}

                                        </ul>
                                    </div>
                                   
                                    <div class="status">
                                      
                                        <div class="d-flex flex-column align-items-center">
                                            <h6>Status : <span>{{@$orderStatus->status}}</span></h6>
                                            @if(Auth::guard('customer')->check())
                                            @if($orderStatus)
                                                @if($orderStatus->status=="Processing" || $orderStatus->status=="Packed" || $orderStatus->status=="Pending")
                                                <form action="">
                                                    <div class="form-group mb-0">
                                                        <a href="javascript:void(0)"
                                                           class="btn primary_btn cancel cancel-order"
                                                           data-status="cancel" data-id="{{$product->id}}"
                                                           data-order_id="{{$order->id}}"
                                                           data-coupon_min="{{$order->getMaxCouponsMinimumSpend()}}"
                                                           data-order_total="{{ $orderTotal }}"
                                                           data-price="{{ $product->total }}"
                                                           data-all_product_statuses="{{ implode(',',array_unique($order->orderLogs->pluck(['status'])->toArray())) }}">Cancel</a>
                                                    </div>
                                                </form>
                                                @endif
                                                
                                                @if($orderStatus->status=="Out for Delivery" || $orderStatus->status=="Delivered")
                                                    @if($order->payment_method !="COD")
                                                  
                                                    <form action="">
                                                     <div class="form-group mb-0">
                                                         <a href="javascript:void(0)"
                                                            class="btn primary_btn return return-order"
                                                            data-status="return" data-id="{{$product->id}}"
                                                            data-order_id="{{$order->id}}"
                                                            data-refund_method="None"
                                                            data-coupon_min="{{$order->getMaxCouponsMinimumSpend()}}"
                                                            data-order_total="{{ $orderTotal }}"
                                                            data-price="{{ $product->total }}"
                                                            data-all_product_statuses="{{ implode(',',array_unique($order->orderLogs->pluck(['status'])->toArray())) }}">Return</a>
                                                     </div>
                                                 </form>
                                                    @endif
                                         @endif
                                         @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach


                        <div class="order_bill_note_area">
                            <div class="bill_note_card">
                                <h5>Customer Notes</h5>
                                <p>
                                    {{ $order->remarks }}
                                </p>
                            </div>
                            <div class="bill_note_card bill_note_cardTotal">
                                <ul>
                                    <li>
                                        <div class="left">
                                            <h6>Subtotal   {{ ($order->tax_type == 'Inside')? '(Tax Inclusive - '.$order->tax.'%)':''}}</h6>
                                        </div>
                                        <div class="right">
                                            <h5>{{$order->currency.' '.$orderTotal}}</h5>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="left">
                                            <h6>Tax ({{$order->tax}}%)</h6>
                                        </div>
                                        <div class="right">
                                           
                                            <h5>{{$order->currency.' '.$order->tax_amount}}</h5>
                                        </div>
                                    </li>
                                    @if($order->orderCoupons)
                                        @foreach ($order->orderCoupons as $orderCoupon)
                                        <li>
                                            <div class="left">
                                                <h6>Coupon Code({{$orderCoupon->coupon->code}})</h6>
                                            </div>
                                            <div class="right">
                                                <h5 style="color : red"> - {{$order->currency.' '.$orderCoupon->coupon_value}}</h5>
                                            </div>
                                        </li>
                                        @endforeach
                                    @endif
                                    @if($order->payment_method=='COD' && $order->cod_extra_charge!='0.00')
                                        <li>
                                            <div class="left">
                                                <h6>COD Charge</h6>
                                            </div>
                                            <div class="right">
                                                <h5>{{$order->currency.' '.$order->cod_extra_charge}}</h5>
                                            </div>
                                        </li>
                                    @endif
                                    <li>
                                        <div class="left">
                                            <h6>Shipping Charge</h6>
                                        </div>
                                        <div class="right">
                                            <h5>{{$order->currency.' '.$order->shipping_charge}}</h5>
                                        </div>
                                    </li>
                                    @if(@$refundStatus)
                                    @if($refundStatus->status=="Cancelled" || $refundStatus->status=="Completed")
                                        <li>
                                            <div class="left">
                                            <h6>Refund Amount</h6>
                                            </div>
                                            @if($refundStatusPrevious->refund_type=="Bank Account" || $refundStatusPrevious->refund_type=="None")
                                            <div class="right">
                                                <h5>{{$order->currency.' '.number_format($orderGrandTotal['returnAmount'],2)}}</h5>
                                            </div>
                                            @else
                                            <div class="right">
                                                <h5>{{$order->currency.' 0.00'}}</h5>
                                            </div>
                                            @endif
                                        </li>
                                        @endif
                                    @endif
                                    <li>
                                        <div class="left">
                                            <h6>Total</h6>
                                        </div>
                                        <div class="right">
                                            <h5>{{$order->currency}} {{number_format(($orderGrandTotal['orderGrandTotal']>0)?$orderGrandTotal['orderGrandTotal']:'0',2)}}</h5>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade quickEnquiryModal" id="cancelOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Cancel Order</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
               <div class="row">
                   <div class="col-md-12">
                       <form action="" id="cancelOrderForm" enctype="multipart/form-data">
                           <div class="col-md-12 ">
                               <div class="form-group">
                                   <div class="customer_note">
                                       <label for="reason">Customer Notes</label>
                                       <textarea name="reason" id="reason" class="form-control mt-3"
                                                 placeholder="Please enter your reason to cancel this order"></textarea>
                                   </div>
                               </div>
                           </div>
                           <input type="hidden" name="product_id" id="product_id">
                           <input type="hidden" name="order_id" id="order_id">
                           <input type="hidden" name="order_status" id="order_status">
                           <button type="submit" class="primary_btn " id="cancel-order-submit" data-url="/cancel-order"
                           >Submit
                           </button>
                       </form>
                   </div>
               </div>
           </div>
       </div>
   </div>
</div>
<div class="modal fade quickEnquiryModal" id="returnOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Return  Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="" id="returnOrderForm" enctype="multipart/form-data">
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <div class="customer_note">
                                        <label for="reason">Customer Notes</label>
                                        <textarea name="reason" id="reason" class="form-control mt-3"
                                                  placeholder="Please enter your reason "></textarea>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="product_id" id="return_product_id">
                            <input type="hidden" name="order_id" id="return_order_id" class="">
                            <input type="hidden" name="order_status" id="return_order_status">
                            <input type="hidden" name="refund_method" id="refund_method">
                            <button type="submit" class="primary_btn " id="return-order-submit" data-url="/return-order"
                            >Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>
</section>
@endsection
