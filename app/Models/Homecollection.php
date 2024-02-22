<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homecollection extends Model
{
    use HasFactory;
    protected $table = 'home_collections';

    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

}
