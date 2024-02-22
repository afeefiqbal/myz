<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductType extends Model
{
    use HasFactory;
    protected $table = 'product_types';

    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    public function enquirys()
    {
        return $this->hasOne(Enquiry::class, 'product_type_id', 'id');
    }


}
