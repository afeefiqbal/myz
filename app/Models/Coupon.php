<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    public static function getPersonUsage($couponId)
    {
        if (Auth::guard('customer')->check()) {
            $orderCustomer = OrderCustomer::where('customer_id', Auth::guard('customer')->user()->customer->id)->get();
            if ($orderCustomer->isNotEmpty()) {
                $orderIds = $orderCustomer->pluck('order_id');
                $orderCoupons = OrderCoupon::whereIn('order_id', $orderIds)->where('coupon_id', $couponId)->count();
                return $orderCoupons;
            } else {
                return 0;
            }
        } else {
            if (Session::has('shipping_phone') && Session::has('shipping_email')) {
                $emails = [Session::get('shipping_email'), Session::get('billing_email')];
                $phones = [Session::get('shipping_phone'), Session::get('billing_phone')];
                $addresses = CustomerAddress::whereNull('customer_id')->where(function ($query) use ($emails, $phones) {
                    $query->whereIn('email', $emails)->orWhereIn('phone', $phones);
                })->get();
                $addressIds = $addresses->pluck('id');
                $orderGuests = OrderCustomer::whereIn('billing_address', $addressIds)->orWhereIn('shipping_address', $addressIds)->get();
                if ($orderGuests->isNotEmpty()) {
                    $orderIds = $orderGuests->pluck('order_id');
                    $orderCoupons = OrderCoupon::whereIn('order_id', $orderIds)->where('coupon_id', $couponId)->count();
                    return $orderCoupons;
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        }
    }

    public static function getTotalUsage($couponId)
    {
        $orderCoupons = OrderCoupon::where('coupon_id', $couponId)->count();
        return $orderCoupons;
    }
}
