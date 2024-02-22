<?php

namespace App\Models;

use App\Http\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;

class ShippingCharge extends Model
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

    public static function getShippingCharge($state_id, $grand_total)
    {
        $siteInformation = SiteInformation::first();
        $shippingCharge = ShippingCharge::active()->where('state_id', $state_id)->first();
        if ($shippingCharge != NULL) {
            if ($shippingCharge->type == "free") {
                if ($shippingCharge->free_shipping_type == "min") {
                    if (($shippingCharge->min_amount * Helper::defaultCurrencyRate()) <= $grand_total) {
                        $shippingAmount = '0.00';
                    } else {
                        $shippingAmount = $shippingCharge->fixed_price;
                    }
                } else {
                    $shippingAmount = '0.00';
                }
            } else {
                $shippingAmount = $shippingCharge->fixed_price;
            }
        } else {
            $shippingAmount = $siteInformation->default_shipping_charge;
        }
        return $shippingAmount * Helper::defaultCurrencyRate();
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
