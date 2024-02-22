
<table class="table table-bordered table-hover dataTable" width="100%">
    <thead>
    <tr>
        <th>id</th>
        <th>title</th>
        <th>description</th>
        <th>link</th>
        <th>condition</th>
        <th>price</th>
        <th>availability</th>
        <th>image link</th>
    </tr>
    </thead>
    <tbody>
    @foreach($datas as $product)
        <tr>
            <td>{{ $product->sku }}</td>
            <td>{{ $product->title }}</td>
            <td>{!! $product->description !!}</td>
            <td>{{ url('product/'.$product->short_url) }}</td>
            <td></td>
            <td>{{ $product->price }}</td>
            <td>{{ ($product->quantity=="In Stock" && $product->stock!=0) ? 'In Stock' : 'Out Of Stock' }}</td>
            <td>{{ asset($product->thumbnail_image) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
