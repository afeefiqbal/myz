<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateCommission extends Model
{
    use HasFactory;

    protected $fillable = ['affiliate_id', 'order_id', 'commission_amount'];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }
}
