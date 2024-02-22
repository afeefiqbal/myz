@php
    use App\Models\Product;
@endphp
<table id="recordsReport" class="table table-bordered table-hover">
    <tbody>
        <tr>
            <th>#</th>
            <th colspan="4">Order Code</th>
            <th colspan="4">Customer</th>
            <th colspan="4">No of Items</th>
            <th colspan="4">Payment Method</th>
            <th colspan="4">Price</th>
            <th colspan="4">Date</th>
         
        </tr>
    @php 
    $i=1 
    @endphp
        @foreach($orderList as $order)
   
        <tr>
            <td>{{ $i }}</td>
            <td colspan="4"><a href="{{url(Helper::sitePrefix().'order/view/'.$order['order']->id)}}">{{ 'ARTMYST'.$order['order']->order_code}}</a></td>

                <td colspan="4">{{ @$order['order']->orderCustomer->shippingAddress->first_name.' '.@$order['order']->orderCustomer->shippingAddress->last_name }}</td>
            <td colspan="4">{{ $order['OrderProducts'] }}</td>
            <td colspan="4">{{ $order['order']->payment_method }}</td>
            <td colspan="4">{{ $order['order']->currency.' '.$order['total_price'] }}</td>
      
            <td colspan="4">{{ date("d-M-Y", strtotime($order['order']->created_at))  }}</td>
        </tr>
        @php 
        $i++;
        @endphp 
        @endforeach
    </tbody>
</table>
