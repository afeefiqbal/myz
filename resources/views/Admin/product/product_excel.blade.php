<table class="table table-bordered table-hover dataTable" width="100%">
    <thead>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Category</th>
        <th>Sub-Category</th>
        <th>SKU</th>
        <th>Measurement Unit</th>
        <th>Brand</th>
        <th>Qty</th>
        <th>Stock</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
    @php $i=1 @endphp @foreach($productList as $product)

        <tr>
            <td>{{ $i }}</td>
            <td>{{ $product->title }}</td>
            <td>@foreach($product->product_categories as $product_category) {{$product_category->title }} @endforeach</td>
            <td>@foreach($product->product_sub_categories as $product_sub_category) {{$product_sub_category->title }} @endforeach</td>
            <td>{{$product->sku}}</td>
            <td>{{@$product->measurementUnit ? @$product->quantity.@$product->measurementUnit->symbol: ''}}</td>
            <td>{{@$product->brand->title}}</td>
            <td>{{$product->stock}}</td>
            <td>{{$product->quantity}}</td>
            <td>{{$product->price}}</td>

        </tr>
        @php $i++@endphp @endforeach
    </tbody>
</table>
