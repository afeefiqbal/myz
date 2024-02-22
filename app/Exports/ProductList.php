<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Order;
use App\Models\Product;
use Session;

class ProductList implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $condition = Product::active();
        $products = $condition->latest()->get();
        $productList =[];
        foreach($products as $key=>$value){
            $productList[$key]['title'] = $value->title;
            $productList[$key]['category'] =  $value->product_categories;
            $productList[$key]['sub_category'] = $value->product_sub_categories;
            $productList[$key]['product_code'] = $value->sku;
            $productList[$key]['capacity'] = $value->capacity;
            $productList[$key]['availablity'] = $value->availability;
            $productList[$key]['stock'] = $value->stock;
            $productList[$key]['colour'] = $value->color_id;
            $productList[$key]['price'] = $value->price;
            $productList[$key]['description'] = $value->short_url;
            $productList[$key]['similar_products'] = $value->product_similar_products;
            $productList[$key]['related_products'] = $value->product_related_products;
            $productList[$key]['url'] = url('product/'.$value->short_url);
            $productList[$key]['image_url'] =asset($value->thumbnail_image);
        }
    
        return view('Admin/report/product_list_excel', [
            'productList' => $productList
        ]);
    }
}
