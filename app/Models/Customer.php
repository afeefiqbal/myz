<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $guard = 'customer';

    protected $fillable = [
        'first_name', 'last_name', 'email',
    ];

    /**
     * relationships with User model
     * a customer is a user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function defaultActiveAddress()
    {
        return $this->hasOne(CustomerAddress::class, 'customer_id')->active()->where('is_default', 'Yes');
    }

    public function customerAddress()
    {
        return $this->hasMany(CustomerAddress::class, 'customer_id');
    }

    public function activeCustomerAddresses()
    {
        return $this->hasMany(CustomerAddress::class, 'customer_id')->orderBy('is_default','asc')->active();
    }
}
