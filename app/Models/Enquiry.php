<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enquiry extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * relationships with product
     * a quote is generated for a product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function Size()
    {
        return $this->belongsTo(Size::class,'size_id','id');
    }
    public function Frame()
    {
        return $this->belongsTo(Frame::class);
    }

}
