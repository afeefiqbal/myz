
<table class="table table-bordered table-hover ">
    <div class="row">
        <div class="col-md-8">
           
      
        </div>
        <div class="col-md-2">
           
            <button class="btn btn-success export_customer" id="export_customer">
                
                Export <br></button> 
                <br>
            <br>
        </div>
    </div>
    <thead>
    <tr>
        <th>#</th>
        <th colspan="2">Order Code</th>
        <th colspan="2">No of Items</th>
        <th colspan="2">Payment Method</th>
        <th colspan="2">Remarks</th>
        <th colspan="2">Total</th>
        <th colspan="2">Coupons</th>
        <th colspan="2">Coupon Charge</th>
        <th colspan="2">Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orderList as $order)
        <tr>
            <td >{{ $loop->iteration }}</td>
            <td colspan="2">{{ 'ARTMYST#'.$order['order']->order_code}}</td>
            <td colspan="2">{{ $order['OrderProducts'] }}</td>
            <td colspan="2">{{ $order['order']->payment_method }}</td>
            <td colspan="2">{{ $order['order']->remarks }}</td>
            <td colspan="2">{{ $order['order']->currency.' '.$order['total_price'] }}</td>
            <td colspan="2">
                @if($order['order']->orderCoupons)
                    @foreach($order['order']->orderCoupons as $orderCoupon)
                        {{ $orderCoupon->coupon->code }}
                        {{ !$loop->last ? ',':'' }}
                    @endforeach
                @endif
            </td>
            <td colspan="2">
                @if($order['order']->orderCoupons)
                    @foreach($order['order']->orderCoupons as $orderCoupon)
                        {{ $orderCoupon->coupon_value }}
                        {{ !$loop->last ? ',':'' }}
                    @endforeach
                @else
                    0.00
                @endif
            </td>
            <td colspan="2">{{ date("d-M-Y", strtotime($order['order']->created_at))  }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
