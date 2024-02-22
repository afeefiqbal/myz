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
                                <div class="col-md-12 text-right">
                                    <img src="{{asset('frontend/images/artemystLogo.png')}}" class="mb-3">
                                </div>
                            </div>
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
                                        Email:
                                        {{(@$orderDetails->shippingAddress)?$orderDetails->shippingAddress->email:''}}
                                        <br>
                                        Phone:
                                        {{(@$orderDetails->shippingAddress)?@$orderDetails->shippingAddress->phone:''}}
                                       
                                        @if($order->orderCustomer->billingAddress->state!=NULL)
                                        <p>{{$order->orderCustomer->billingAddress->state->title}},
                                            {{$order->orderCustomer->billingAddress->state->country->title}}</p>
                                    @endif
                                    Zipcode:
                                    {{(@$orderDetails->billingAddress)?@$orderDetails->billingAddress->zipcode:''}}
                               
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
                                        Email:
                                        {{(@$orderDetails->billingAddress)?$orderDetails->billingAddress->email:''}}
                                        <br>
                                        Phone:
                                        {{(@$orderDetails->billingAddress)?@$orderDetails->billingAddress->phone:''}}
                                     
                                        @if($order->orderCustomer->billingAddress->state!=NULL)
                                        <p>{{$order->orderCustomer->billingAddress->state->title}},
                                            {{$order->orderCustomer->billingAddress->state->country->title}}</p>
                                    @endif
                                    Zipcode:
                                    {{(@$orderDetails->billingAddress)?@$orderDetails->billingAddress->zipcode:''}}
                                        
                                    </address>
                                </div>
                                <div class="col-sm-4 invoice-col">
                                    <b>Invoice {{'ARTMYST#'.$order->order_code}}</b><br>
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
                                        
                                            <th>Quantity</th>
                                 
                                            <th>Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $shoppingTotal = [];
                                        @endphp
                                        @foreach($order->orderProducts as $product)
                                            @php
                                                $shoppingTotal[] = $product->total;
                                                $orderStatus = App\Models\OrderLog::where('order_product_id','=',$product->id)->orderBy('created_at','DESC')->first();
                                                $orderStatusPrevious = App\Models\OrderLog::where('order_product_id',$product->id)->orderBy('id','DESC')->skip(1)->take(1)->first();
                                            @endphp
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>
                                                    {{$product->productData->title}}
                                                </td>
                                                <td>{{$order->currency}} {{$product->cost}}</td>
                                                @php
                                                $frame = App\Models\Frame::where('id',$product->frame)->first();
                                                $type = App\Models\ProductType::where('id',$product->type)->first();
                                                   $size = App\Models\Size::where('id',$product->size)->first();
                                                    @endphp
                                       
                                            
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
                                                <td>{{$product->qty}}</td>
                                                <td>{{$order->currency}}
                                                    @if(count($order->orderProducts)==1)
                                                        @if($order->orderCoupons!=NULL)
                                                            {{ $product->total-$order->orderCoupons->sum('coupon_value') }}
                                                        @else
                                                            {{ $product->total }}
                                                        @endif
                                                    @else
                                                        {{ $product->total }}
                                                    @endif
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
                                    <p>
                                    <hr>
                                    @if($orderStatus->status=="Refunded")
                                        <p class="lead">Return/Refund:</p>
                                        @if($orderStatusPrevious->remarks!=NULL)
                                            <p>Remarks: {!!$orderStatusPrevious->remarks!!}</p>
                                        @endif
                                        <p>Refund Method: {{$orderStatusPrevious->refund_type}}</p>
                                        @if($orderStatusPrevious->refund_type=="Bank Account")
                                            <p> Account Holder: {{$orderStatusPrevious->account_holder_name}}</p>
                                            <p> Account Number: {{$orderStatusPrevious->account_number}}</p>
                                            <p> IFSC Code {{$orderStatusPrevious->ifsc_code}}</p>
                                        @elseif($orderStatusPrevious->refund_type=="Credit Point")
                                            @php
                                                $pointAgainstOrder = App\Models\CreditPoint::where([['order_id',$order->id],['type','Backend'],['status','Active']])->first();
                                            @endphp
                                            <p> Credit Point: {{$pointAgainstOrder->earned_points}} (pts)</p>
                                        @elseif($orderStatusPrevious->refund_type=="Voucher")
                                            @php
                                                $couponAgainstOrder = App\Models\VoucherCoupon::where([['order_id',$order->id],['status','Active']])->first();
                                            @endphp
                                            @if($couponAgainstOrder!=NULL)
                                                <p> Voucher: {{$couponAgainstOrder->coupon->code}}</p>
                                            @endif
                                        @else
                                            <p>{{$order->currency.' '.number_format($orderGrandTotal['returnAmount'],2)}}</p>
                                            @endif
                                            @endif
                                            </p>
                                </div>
                                <div class="col-6">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <th style="width:50%">Subtotal:</th>
                                                <td>{{$order->currency.' '.$orderTotal}}</td>
                                            </tr>
                                            <tr>
                                                <th>Tax</th>
                                                <td>{{$order->currency.' '.$order->tax_amount}}</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping:</th>
                                                <td>{{$order->currency.' '.$order->shipping_charge}}</td>
                                            </tr>
                                            @if($order->payment_method=='COD' && $order->cod_extra_charge!='0.00')
                                                <tr>
                                                    <th>COD Charge</th>
                                                    <td>{{$order->currency.' '.$order->cod_extra_charge}}</td>
                                                </tr>
                                            @endif
                                            @if($order->orderCoupons!=NULL)
                                                @foreach($order->orderCoupons as $orderCoupon)
                                                    <tr>
                                                        <th>Coupon ({{$orderCoupon->coupon->code}}):</th>
                                                        <td>{{$order->currency.' '.$orderCoupon->coupon_value}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <tr>
                                                <th>Total:</th>
                                                <td>{{$order->currency}} {{number_format(($orderGrandTotal['orderGrandTotal']>0)?$orderGrandTotal['orderGrandTotal']:'0',2)}}</td>
                                            </tr>
                                            @if($orderStatus->status=="Refunded")
                                                <tr>
                                                    <th>Return/Refund:</th>
                                                    <td>{{$order->currency}} {{number_format($orderGrandTotal['returnAmount'],2)}}</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            window.print();
            $('.invoice-page-btn').on('click', function () {
                window.print();
            });
        });
    </script>
@endsection
