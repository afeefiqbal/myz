
@php
    if($product_snipet){
 $cardProduct = App\Models\Product::active()->where('id', $product_snipet->id)->first();
        $copyProducts = App\Models\Product::active()->where('parent_product_id',$product_snipet->id)->latest()->get();
        $copyProductIds = $copyProducts->pluck('id')->toArray();
        $productPrices = App\Models\ProductPrice::where('product_id',$product_snipet->id)
        ->orWhereIn('product_id',$copyProductIds)
        ->get();
        $prices = $productPrices->pluck('price')->toArray();

        $highestPrice = $productPrices->max('price');
        $lowestPrice = $productPrices->min('price');

 $product_snipet =[
    "name" => $product_snipet->title,
    "image" => [
        asset($product_snipet->thumbnail_image),
        asset($product_snipet->thumbnail_image_webp),
    ],
    //remoe p tag from description
    "description" => strip_tags($product_snipet->description),

    "sku" => $product_snipet->sku,
    "review" => [
        "@type"=> "Review",
        "reviewRating" => [
        "ratingValue" =>  Helper::ratingCount($product_snipet->id),
        "bestRating" => $bestRating,
      ],
    ],
    "aggregateRating" => [
        "@type"=>"AggregateRating",
      "ratingValue" => Helper::averageRating($product_snipet->id),
      "reviewCount" => Helper::reviewCount($product_snipet->id)
    ],
    "offers" => [
        "@type"=> "AggregateOffer",
        "offerCount"=> App\Models\Offer::where('product_id', $product_snipet->id)->count(),
        "lowPrice"=>  $lowestPrice,
        "highPrice"=>$highestPrice,
        "priceCurrency"=> @$defaultCurrency->code,
    ]
  ];
}
@endphp
@if(@$product_snipet)
<script type="application/ld+json">
  {!! json_encode([
    "@context" => "https://schema.org/",
    "@type" => "Product",
    "name" => $product_snipet['name'],
    "image" => $product_snipet['image'],
    "description" => $product_snipet['description'],
    "sku" => $product_snipet['sku'],

    "review" => $product_snipet['review'],
    "aggregateRating" => $product_snipet['aggregateRating'],
    "offers" => $product_snipet['offers']
  ]) !!}
</script>
@endif