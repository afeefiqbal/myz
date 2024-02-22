<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderCustomer extends Model
{
    use HasFactory, SoftDeletes;

    public function orderData()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function CustomerData()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(CustomerAddress::class, 'shipping_address');
    }

    public function billingAddress()
    {
        return $this->belongsTo(CustomerAddress::class, 'billing_address');
    }
    public function CustomerAddressData()
    {
        return $this->belongsTo(CustomerAddress::class, 'address_id');
    }
}
