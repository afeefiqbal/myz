<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SideMenuDetail extends Model
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
        return $this->belongsTo(SideMenu::class, 'menu_id');
    }
    
    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
    public function shape()
    {
        return $this->belongsTo(Shape::class, 'shape_id');
    }
}
