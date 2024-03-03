@extends('web.layouts.main')
@section('content')
<section class="thanks_section">
    <div class="container">
        <div class="row justify-content-center">
            <section class="breadscrumb-section pt-0">
                <div class="container-fluid-lg">
                    <div class="row">
                        <div class="col-12">
                            <div class="breadscrumb-contain breadscrumb-order">
                                <div class="order-box">
                                    <div class="order-image">
                                        <img src="{{asset('assets/images/inner-page/order-success.pn')}}g" class="blur-up lazyload"
                                            alt="">
                                    </div>
        
                                    <div class="order-contain">
                                        <h3 class="theme-color">Order Success</h3>
                                        <h5 class="text-content">Payment Is Successfully And Your Order Is On The Way</h5>
                                        <li>
                                            Order Number : <span>MYZ#{{@$order->order_code}}</span>
                                        </li>
                                        <li>
                                            Payment Method : <span>{{(@$order->payment_method=='COD')? 'Cash on Delivery': 'Online Payment'}}</span>
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
         
        </div>
    </div>
</section>
<section class="breadcrumb_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{url('/')}}">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        Thank You
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>


@endsection