<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeAdvertisement extends Model
{
    use HasFactory,SoftDeletes;

    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }
}
