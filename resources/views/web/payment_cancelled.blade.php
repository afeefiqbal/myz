@extends('web.layouts.main')
@section('content')
<section class="thanks_section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
               
               
                <ul>
                    
                    <li>
                        Order Number : <span>MYZ#{{@$order->order_code}}</span>
                    </li>
                    <li>
                        Payment Method : <span>{{(@$order->payment_method=='COD')? 'Cash on Delivery': 'Online Payment'}}</span>
                    </li>
                </ul>
                <div class="buttons_box">
                   
                    <a class="secondary_btn" href="#"> 
                        <p>Order Status :  <p style="color: red"> Cancelled </p></p>
                       </a>
                    <a class="primary_btn" href="{{ url('/') }}">Home</a>
                </div>
            </div>
        </div>
    </div>
</section>




@endsection