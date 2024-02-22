<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Termwind\Components\Dd;

class ProductsImport implements ToCollection, WithValidation
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
       
        foreach ($rows->skip(1) as $row) { // skip the first row (header)
            $product = new Product();
            $product->title = $row[1];
            $product->short_url = $row[2];
            $product->sku = $row[3];
            $product->description = $row[4];
            $product->new_arrival = $row[5];
            $product->is_featured = $row[6];
            $product->best_seller = $row[7];
            $product->status = $row[8];
            $product->product_type_id = $row[9];
            $product->save();

        }
        
    }
    public function rules(): array
    {
        return [
            '*.0' => Rule::unique('products', 'short_url')
        ];
    }
}
