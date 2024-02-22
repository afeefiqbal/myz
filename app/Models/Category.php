<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
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
     * Scope a query to only include parents.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsParent($query)
    {
        return $query->where('parent_id', null);
    }

    /**
     * Scope a query to find product with given short url.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeShortUrl($query, $hort_url)
    {
        return $query->where('short_url', $hort_url);
    }

    /**
     * relationships with this same Category model
     * a  Category may contain another parent Category
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * relationships with this same Category model
     * a  Category may contain another parent Category
     */
    public function activeParent()
    {
        return $this->belongsTo(Category::class, 'parent_id')->active();
    }

    /**
     * relationships with this same Category model
     * a  Category may have many child Categories
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id','id');
    }
    /**
     * relationships with this same Category model
     * a  Category may have many child Categories
     */
    public function activeChildren()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order')->active();
    }

    // recursive, loads all descendants
    public function activeChildrenRecursive()
    {
        return $this->activeChildren()->with('activeChildrenRecursive');
    }
 
 
}
