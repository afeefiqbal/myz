<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuDetail extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * relationships with menu
     * a menu detail has a menu
     */


    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }


    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
