@if($products->isNotEmpty())
        @include('web.includes.product_list_inner')
    @else
        <div class="col-12 text-center no_product">
            <picture>
                <img class="img-fluid mb-4" src="{{asset('frontend/images/no-products.png')}}" alt="">
            </picture>
            <h4>No products</h4>
        </div>
    @endif
</div>
@push('scripts')
<script>
    $('#product_count').html({{ $offset }});
    $('#total_product_count').html({{ $totalProducts }});
    $('#loading_offset').val({{ $offset }});
    $('#productListingTitle').html('{{ $title }}');
</script> 
@endpush
