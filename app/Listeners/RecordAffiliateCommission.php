<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Models\AffiliateCommision;
use App\Models\AffiliateCommission;
use App\Models\OrderProduct;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RecordAffiliateCommission
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderPlaced $event)
    {
        $order = $event->order;
        $affiliateId = session('affiliate_id');
        $orderProduct = OrderProduct::where('order_id',$order->id)->sum('total');
        $affilaiteCommsions = AffiliateCommision::first();
        $amount = ($affilaiteCommsions->commision_amount);
        if ($affiliateId) {
            AffiliateCommission::create([
                'affiliate_id' => $affiliateId,
                'order_id' => $order->id,
                'commission_amount' => $orderProduct *$amount, // 10% commission
            ]);

            session()->forget('affiliate_id');
        }
    }
}
