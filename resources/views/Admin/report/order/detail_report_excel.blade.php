@php
    use App\Models\Order;
    use App\Models\OrderLog;
@endphp
<table id="recordsReport" class="table table-bordered table-hover">
    <tbody>
    <tr>
        <td rowspan="2">#</td>
        <td rowspan="2">Code</td>
        <td rowspan="2">Customer</td>
        <td colspan="7" style="text-align: center;">Product</td>
        <td rowspan="2">Total</td>
        <td rowspan="2">Tax</td>
        <td rowspan="2">Shipping</td>
        <td rowspan="2">Coupon</td>
        <td rowspan="2">Order Total</td>
        <td rowspan="2">Refund/Cancelled</td>
        <td rowspan="2">Payment Method</td>
        <td rowspan="2">Created Date</td>
    </tr>
    <tr>
        <td>#</td>
        <td colspan="1">Product</td>
        <td>Qty</td>
        <td>Offer</td>
        <td>Cost</td>
        <td>Sub Total</td>
        <td style="border-right: 1px solid #f4f4f4;">Status</td>
    </tr>
    @php $i=1 @endphp 
    @foreach($orderList as $order)
        @if($order->orderProducts->isNotEmpty())
            @php
                $products = $order->orderProducts;
                $productTotal = Order::getProductTotal($order->id);
                $orderTotal = Order::getOrderTotal($order->id);
                $cancelledTotal = Order::getCancelledProductTotal($order->id);
                $total = $cancelledTotal['total']-$cancelledTotal['couponCharge'];
                $returnAmount = $total+$cancelledTotal['taxAmount']+$cancelledTotal['shippingCharge']+$cancelledTotal['otherCouponCharge'];
                $orderStatus = OrderLog::where('order_product_id',$products[0]->id)->latest()->first();
            @endphp
            <tr>
                <td colspan="1" rowspan="{{count($products)}}">{{ $i }}</td>
                <td colspan="1" rowspan="{{count($products)}}">{{ 'MYZ# '.$order->order_code }}</td>
                @if($order->orderCustomer->user_type=="User")
                    <td colspan="1"
                        rowspan="{{count($products)}}">{{ $order->orderCustomer->CustomerData->first_name.' '.$order->orderCustomer->CustomerData->last_name }}</td>
                @else
                    <td colspan="1"
                        rowspan="{{count($products)}}">{{ $order->orderCustomer->billingAddress->first_name.' '.$order->orderCustomer->billingAddress->last_name}}</td>
                @endif
                <td>1</td>
                <td>{{($products[0]->productData)?$products[0]->productData->title:''}}</td>
                <td>{{$products[0]->qty}}</td>
                <td>{{ ($products[0]->offer_id!=0)?'Yes':'No'}}</td>
                <td>{{ $order->currency.' '.($products[0]->cost)}}</td>
                <td>{{$order->currency.' '. $products[0]->total}}</td>
                <td>{!! Order::getStatus($orderStatus->status) !!}</td>
                <td colspan="1" rowspan="{{count($products)}}">{{ number_format($productTotal,2) }}</td>
                <td colspan="1" rowspan="{{count($products)}}">{{ $order->tax_amount }}</td>
                <td colspan="1" rowspan="{{count($products)}}">{{ $order->shipping_charge }}</td>
                <td colspan="1" rowspan="{{count($products)}}">
                    @if($order->orderCoupons)
                        @foreach($order->orderCoupons as $orderCoupon)
                            {{ $orderCoupon->coupon_value }}
                            ({{ $orderCoupon->coupon->code }})
                            {{ !$loop->last ? ',':'' }}
                        @endforeach
                    @endif
                </td>
                <td colspan="1"
                    rowspan="{{count($products)}}">{{ number_format($orderTotal,2).' '.$order->currency }}</td>
                <td colspan="1"
                    rowspan="{{count($products)}}">{{ number_format($returnAmount,2).' '.$order->currency }}</td>
                <td colspan="1" rowspan="{{count($products)}}">{{ $order->payment_method }}</td>
                <td colspan="1" rowspan="{{count($products)}}">{{ date("d-M-Y", strtotime($order->created_at))  }}</td>
            </tr>
            @for($j=1;$j < count($products);$j++)
                @php
                    $orderStatus = OrderLog::where('order_product_id','=',$products[$j]->id)->latest()->first();
                @endphp
                <tr>
                    <td>{{$j+1}}</td>
                    <td>{{($products[$j]->productData)?$products[$j]->productData->title:''}}</td>
                    <td>{{$products[$j]->qty}}</td>
                    <td>{{ ($products[$j]->offer_id!=0)?'Yes':'No'}}</td>
                    <td>{{ $order->currency.' '.($products[$j]->cost)}}</td>
                    <td>{{$order->currency.' '. $products[$j]->total}}</td>
                    <td style="border-right: 1px solid #f4f4f4;">{!! Order::getStatus($orderStatus->status) !!}</td>
                </tr>
            @endfor
            @php $i++; @endphp
        @endif
    @endforeach
    </tbody>
</table>
