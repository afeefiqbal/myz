@extends('Admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-user-shield"></i> View Orders</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{url(Helper::sitePrefix().'dashboard')}}">
                                    Home
                                </a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'order')}}">Orders</a></li>
                            <li class="breadcrumb-item active">Order View - {{'ARTMYST#'.$order->order_code}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="invoice p-3 mb-3">

                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <i class="fas fa-globe"></i>
                                        @if($orderDetails)
                                            {{@$orderDetails->shippingAddress->first_name .' '.@$orderDetails->shippingAddress->last_name}}
                                        @endif
                                        <small
                                            class="float-right">Date: {{ date("F, d Y", strtotime($order->created_at))  }}</small>
                                    </h4>
                                </div>
                            </div>

                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    <address>
                                        <h6>Shipping Address:</h6>
                                        <strong>
                                            {{@$orderDetails->shippingAddress->first_name .' '.@$orderDetails->shippingAddress->last_name}}
                                        </strong><br>
                                        {{@$orderDetails->shippingAddress->address}}
                                        <br>
                                        {{@$orderDetails->shippingAddress->state->title}}
                                        {{@$orderDetails->shippingAddress->state->country->title}}
                                        <br>
                                        Email:
                                        {{(@$orderDetails->shippingAddress)?$orderDetails->shippingAddress->email:''}}
                                        <br>
                                        Phone:
                                        {{(@$orderDetails->shippingAddress)?@$orderDetails->shippingAddress->phone:''}}
                                        <br>
                                        ZipCode:
                                        {{(@$orderDetails->billingAddress)?@$orderDetails->billingAddress->zipcode:''}}
                                        <br>
                                    </address>
                                </div>

                                <div class="col-sm-4 invoice-col">
                                    <address>
                                        <h6>Billing Address:</h6>
                                        <strong>
                                            {{@$orderDetails->billingAddress->first_name .' '.@$orderDetails->billingAddress->last_name}}
                                        </strong><br>
                                        {{@$orderDetails->billingAddress->address}}
                                        <br>
                                        {{@$orderDetails->billingAddress->state->title}}
                                        {{@$orderDetails->billingAddress->state->country->title}}
                                        <br>
                                        Email:
                                        {{(@$orderDetails->billingAddress)?$orderDetails->billingAddress->email:''}}
                                        <br>
                                        Phone:
                                        {{(@$orderDetails->billingAddress)?@$orderDetails->billingAddress->phone:''}}
                                        <br>
                                        ZipCode:
                                        {{(@$orderDetails->billingAddress)?@$orderDetails->billingAddress->zipcode:''}}
                                        <br>
                                    </address>
                                </div>
                                <div class="col-sm-4 invoice-col">
                                    Invoice :<b> {{'ARTMYST#'.$order->order_code}}</b><br>
                                    User Choosed Currency : <b> {{$order->currency}}</b><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product</th>
                                            <th>Cost</th>
                                            <th>Type</th>

                                            <th>Frame Colour</th>
                                            <th>Size</th>
                                            <th>Mount</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                            <th>Remarks</th>
                                            <th>Price</th>
                                            {{-- <th>Coupon Value</th>
                                            <th>Coupon Price</th> --}}
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $shoppingTotal = [];
                                        $refundStatus = $refundStatusPrevious = null;
                                        @endphp
                                        @foreach($order->orderProducts as $product)
                                            @php
                                                $shoppingTotal[] = $product->total;
                                                $orderStatus = App\Models\OrderLog::where('order_product_id','=',$product->id)->orderBy('created_at','DESC')->first();
                                                $orderStatusPrevious = App\Models\OrderLog::where('order_product_id',$product->id)->orderBy('id','DESC')->skip(1)->take(1)->first();
                                                if ($orderStatus->status == 'Returned' || $orderStatus->status == 'Refunded' || $orderStatus->status == 'Cancelled' || $orderStatus->status == 'Completed' ){
                                                $refundStatus = $orderStatus;
                                                $refundStatusPrevious = $orderStatusPrevious;
                                            }
                                            @endphp
                                            <tr>
                                                @php
                                                $frame = App\Models\Frame::where('id',$product->frame)->first();
                                                $type = App\Models\ProductType::where('id',$product->type)->first();
                                                   $size = App\Models\Size::where('id',$product->size)->first();
                                            @endphp
                                                <td>{{$loop->iteration}}</td>
                                                <td>
                                                    {{$product->productData->title ?? ''}}
                                                </td>
                                                <td>{{'AED'}} {{$product->cost/$order->currency_charge }}</td>
                                                <td>
                                                    @if(@$type)
                                                    {{ $type->title }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(@$frame)
                                                    {{ $frame->title }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(@$size)
                                                    {{ $size->title }}
                                                    @endif
                                                </td>
                                                <td>
                                              
                                                    @if($type->id == '4')
                                                    @if($product->mount == 'Yes')
                                                    <span> With Mount</span>
                                                @else
                                                    <span> No Mount</span>
                                                @endif
                                                @endif
                                                </td>

                                                <td>{{$product->qty}}</td>
                                                <td>
                                                    <select name="status" id="orderStatus" class="form-control"
                                                            data-id="{{ $product->id }}" data-order_id="{{$order->id}}"
                                                            data-coupon_min="{{$order->getMaxCouponsMinimumSpend()}}"
                                                            data-order_total="{{ $orderTotal }}"
                                                            data-price="{{ $product->total }}"
                                                            data-all_product_statuses="{{ implode(',',array_unique($order->orderLogs->pluck(['status'])->toArray())) }}">
                                                        {{-- @foreach(['Pending','Processing','On Hold','Cancelled','Packed','Shipped','Out For Delivery','Delivered','Completed','Returned','Refunded','Failed'] AS $status)--}}
                                                        @foreach(['Pending'=>'Payment Pending','Processing'=>'Processing','On Hold'=>'On Hold','Cancelled'=>'Cancelled','Packed'=>'Packed','Shipped'=>'Shipped','Delivered'=>'Delivered','Completed'=>'Completed','Refunded'=>'Refunded','Failed'=>'Failed','Returned' => 'Returned'] AS $statusKey => $status)
                                                            <option value="{{ $statusKey }}"
                                                                {{ (old("status", @$orderStatus->status) == $statusKey)? "selected" : "" }}>
                                                                {{ $status }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    {{@$orderStatus->remarks}}
                                                </td>
                                                <td>{{'AED'}}
                                                   
                                                    @if(count($order->orderProducts)==1)
                                                        @if($order->orderCoupons!=NULL)
                                                            {{ $product->total/$order->currency_charge }}
                                                        @else
                                                            {{ $product->total/$order->currency_charge  }}
                                                        @endif
                                                    @else
                                                        {{ $product->total/$order->currency_charge  }}
                                                    @endif
                                                </td>
                                                {{-- <td>
                                                    {{$product->coupon_value}}
                                                </td>
                                                --}}
                                                <td>
                                                    {{$product->coupon_after_price}}
                                                </td> 
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <p class="lead">Payment Methods:</p>
                                    <p>
                                        @if($order->payment_method=="COD")
                                            Cash on delivery
                                        @else
                                            {{ $order->payment_method }}
                                        @endif
                                    </p>
                                    <p class="lead">Customer Notes:</p>
                                    <p>
                                        {{ @$order->remarks }}
                                    </p>
                                    <p>
                                    <hr>
                                    @if($refundStatus)
                                        <p class="lead">Return/Refund:</p>
                                        @if(@$refundStatusPrevious->remarks!=NULL)
                                            <p>Remarks: {!!@$refundStatusPrevious->remarks!!}</p>
                                        @endif
                                        <p>Refund Method: {{@$refundStatusPrevious->refund_type}}</p>
                                        @if(@$refundStatusPrevious->refund_type=="Bank Account")
                                            <p> Account Holder: {{@$refundStatusPrevious->account_holder_name}}</p>
                                            <p> Account Number: {{@$refundStatusPrevious->account_number}}</p>
                                            <p> IFSC Code {{@$refundStatusPrevious->ifsc_code}}</p>
                                        @elseif(@$refundStatusPrevious->refund_type=="Credit Point")
                                            @php
                                                $pointAgainstOrder = App\Models\CreditPoint::where([['order_id',$order->id],['type','Backend'],['status','Active']])->first();
                                            @endphp
                                            <p> Credit Point: {{@$pointAgainstOrder->earned_points}} (pts)</p>
                                        @elseif(@$refundStatusPrevious->refund_type=="Voucher")
                                            @php
                                                $couponAgainstOrder = App\Models\VoucherCoupon::where([['order_id',$order->id],['status','Active']])->first();
                                            @endphp
                                            @if($couponAgainstOrder!=NULL)
                                                <p> Voucher: {{@$couponAgainstOrder->coupon->code}}</p>
                                            @endif
                                        @else
                                            <p>{{'AED'.' '.number_format($orderGrandTotal['returnAmount'],2)}}</p>
                                            @endif
                                            @endif
                                            </p>
                                </div>
                                <div class="col-6">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th style="width:50%">
                                                        Subtotal {{ ($order->tax_type == 'Inside')? '(Tax Inclusive)':''}}:
                                                    </th>
                                                    <td>{{'AED'.' '.number_format($orderTotal/$order->currency_charge,2)}}</td>
                                                </tr>
                                                @if($order->tax_type == 'Outside')
                                                    <tr>
                                                       
                                                        <th>Tax ({{$order->tax}}%)</th>
                                                        <td  style="color : red"> + {{'AED'.' '.number_format($order->tax_amount/$order->currency_charge,2)}}</td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <th>Tax ({{$order->tax}}%)</th>
                                                      
                                                        <td  style="color : red">+ {{'AED'.' '.(($orderTotal-$order->orderCoupons->sum('coupon_value'))*$order->tax/100)}}</td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <th>Shipping:</th>
                                                    <td>{{'AED'.' '.$order->shipping_charge}}</td>
                                                </tr>
                                               
                                                @if($order->payment_method=='COD' && $order->cod_extra_charge!='0.00')
                                                    <tr>
                                                        <th>COD Charge</th>
                                                        <td  style="color : red">  + {{'AED'.' '.$order->cod_extra_charge}}</td>
                                                    </tr>
                                                @endif
                                                @if($order->orderCoupons!=NULL)
                                                    @foreach($order->orderCoupons as $orderCoupon)
                                                        <tr>
                                                            <th>Coupon ({{$orderCoupon->coupon->code}}):</th>
                                                            <td style="color : green"> - {{'AED'.' '.$orderCoupon->coupon_value}}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                               
                                                <tr>
                                                    <th>Order Total:</th>
                                                    <td>{{'AED'}} {{number_format(($orderGrandTotal['orderTotalAmount']>0)?$orderGrandTotal['orderTotalAmount']:'0',2)}}</td>
                                                </tr>
                                                @if(@$refundStatus)
                                                @if($refundStatus->status=="Refunded" || $refundStatus->status=="Cancelled" || $refundStatus->status=="Completed")
                                                <tr>

                                                    <th>Return/Refund:</th>
                                                    <td style="color : red"> - {{'AED'}} {{number_format($orderGrandTotal['returnAmount'],2)}}</td>
                                                </tr>
                                                @endif
                                                @endif
                                                <tr>
                                                    <th>Grand Total:</th>
                                                    <td>{{'AED'}} {{number_format(($orderGrandTotal['orderGrandTotal']>0)?$orderGrandTotal['orderGrandTotal']:'0',2)}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row no-print">
                                <div class="col-12">
                                    <a href="{{url(Helper::sitePrefix().'order/print-invoice/'.$order->id)}}"
                                       target="_blank" rel="noopener" class="btn btn-default">
                                        <i class="fas fa-print"></i> Print
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
