<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Scope a query to only include active items.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    /**
     * relationships with menu details
     * a menu has several menu details
     */
    public function menu_details()
    {
        return $this->hasMany(MenuDetail::class);
    }

    /**
     * relationships with category
     * a menu may has one category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
