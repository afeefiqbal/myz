<?php

namespace App\Http\Middleware;

use App\Models\Affiliate;
use Closure;
use Illuminate\Http\Request;

class TrackAffiliate
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('referral_code')) {
            $affiliate = Affiliate::where('referral_code', $request->query('referral_code'))->first();
       
            if ($affiliate) {
                session(['affiliate_id' => $affiliate->id]);
            }
        }

        return $next($request);
    }
}
