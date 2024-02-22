<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Session;

class ProductBulkExport implements FromView
{

    public function view(): View
    {
        $productList = Product::get();
        return view('Admin/product/product_excel', [
            'productList' => $productList
        ]);
    }
}
