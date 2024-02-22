@php
    use App\Models\Product;
    use App\Models\Frame;
    use App\Models\ProductType;
    use App\Models\Size;
@endphp
<table id="recordsReport" class="table table-bordered table-hover">
    <tbody>
    <tr>
        <th>#</th>
        <th colspan="4">Code</th>
        <th colspan="4">Customer</th>
        <th colspan="4">Total</th>
    
        <th colspan="15">Product Details</th>
        <th colspan="4">Order Total</th>
        <th colspan="4">Payment Method</th>
        <th colspan="4">Order Status</th>
        <th colspan="4">Created Date</th>
       
    </tr>
    @php 
    $i=1 
    @endphp
    @foreach($orderList as $order)
    <tr>
        <td colspan="1">{{ $i }}</td>
        <td colspan="4">{{ $order['order_code'] }}</td>
        <td colspan="4">
            {{ $order['customer_name'] }}</td>   
        <td colspan="4">{{ $order['product_total'] }}</td>
    
        <td colspan="15">
            @foreach($order['product_details'] as $product)
           
                @php
                    $product1 = Product::find($product['product_id']);
                    $frame = Frame::find($product['frame']);
                    $type = ProductType::find($product['type']);
                    $size = Size::find($product['size']);
                @endphp
                {{ $product1->title }} 
                    @if(@$type)
                    - 
                    {{ $type->title }}
                    @endif
                  
                  @if(@$frame)
                  - 
                  {{ $frame->title }}
                  @endif
                  
                  @if(@$size)
                  - 
                  {{ $size->title }}
                  @endif
               
                  @if(@$type->id == '4')
                  - 
                  @if($product->mount == 'yes')
                  
                  <span> With Mount</span>
              @else
                  <span> No Mount</span>
              @endif
              @endif
              
           
            @endforeach
           
        </td>
        <td colspan="4">{{ $order['order_total'] }}</td>
        <td colspan="4">{{ $order['payment_method'] }}</td>
        <td colspan="4">{{ $order['order_status'] }}</td>
        <td colspan="4">{{ $order['created_at'] }}</td>
    </tr>
    @php
        $i++;
    @endphp
    @endforeach
    </tbody>
</table>
