@php
    use App\Models\Product;
@endphp
<table id="recordsReport" class="table table-bordered table-hover">
    <tbody>
    <tr>
        <th >#</th>
        <th  colspan="5">Title</th>
        <th  colspan="2" >Product Code</th>
        <th  colspan="6" >Category</th>
        <th  colspan="6">Sub category</th>


        <th  colspan="1">Price</th>
        <th  colspan="10">Description</th>
        <th  colspan="10">Url</th>
        <th  colspan="10">Image</th>
        <th  colspan="10">Similar Products</th>
        <th  colspan="10">Related Products</th>
       
    </tr>
    @php 
    $i=1 
    @endphp
    @foreach($productList as $product)
    <tr>
        <td colspan="1">{{ $i }}</td>
        <td colspan="5">{{ $product['title'] }}</td>
        <td colspan="2">
            {{ $product['product_code'] }}</td>
        <td colspan="6"> @foreach ($product['category']  as $category)
            {{ $category->title }}
           
        @endforeach </td>
        <td colspan="6">
            @foreach ($product['sub_category']  as $sub_cat)
            {{ $sub_cat->title }}
           
        @endforeach 
        </td>
   
        <td colspan="1">{{ $product['price'] }}</td>
        <td colspan="10">{{ $product['description'] }}</td>
        <td colspan="10">{{ $product['url'] }}</td>
        <td colspan="10">{{ $product['image_url'] }}</td>
        <td colspan="10">
            @if(isset($product['similar_products']))
            @foreach($product['similar_products'] as $similar_product) 

            "{{$similar_product->title }}", <br> 
            @endforeach
            @endif
        </td>
        <td colspan="10">
            @if(isset($product['related_products']))
            @foreach($product['related_products'] as $related_product) 

            "{{$related_product->title }}", <br> 
            @endforeach
            @endif
        </td>
        {{-- <td>@foreach(@$product['similar_products'] as $similar_product) {{$similar_product->title }} @endforeach</td>
        <td>@foreach(@$product['related_products'] as $related_product) {{$related_product->title }} @endforeach</td> --}}
    </tr>
    @php
        $i++;
    @endphp
    @endforeach
    </tbody>
</table>
