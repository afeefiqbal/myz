<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use Stripe\Charge;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\StripeClient;

class PaymentController extends Controller
{
  
    public function payment($order_id, $amount, $billingParams)
    {
        dd($order_id, $amount, $billingParams);

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'gbp',
                        'product_data' => [
                            'name' => 'T-shirt',
                        ],
                        'unit_amount'  => 500,
                    ],
                    'quantity'   => 1,
                ],
            ],
            'mode'        => 'payment',
            'success_url' => route('payment.success'),
            'cancel_url'  => route('payment.failure'),
        ]);
        
        return ($session->url);

    }

    public function paymentSuccess(Request $request)
    {

        $response = app(CartController::class)->order_success(1);
        
        return redirect(url($response['data']));
        // Handle payment cancellation
        // You can implement this method according to your business logic
    }
    public function paymentCancel(Request $request)
    {

        $response = app(CartController::class)->order_payment_cancelled(1);
        
        return redirect(url($response['data']));
        // Handle payment cancellation
        // You can implement this method according to your business logic
    }

    public function paymentDeclined(Request $request)
    {
        dd('s');
        $response = app(CartController::class)->order_payment_failed(1);

        return redirect(url($response['data']));
    }

}
