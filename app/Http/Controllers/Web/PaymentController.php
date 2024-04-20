<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PaymentController extends Controller
{
    public function payment($order_id, $amount, $billingParams)
    {
        // Fetch order details
        $order = Order::findOrFail($order_id);

        // Remove slashes from phone number and + sign
        $phone_number = str_replace('/', '', $billingParams['phone_number']);
        $phone_number = str_replace('+', '', $phone_number);
        $billingParams['phone'] = $phone_number;
        $billingParams['currency'] = $order->currency;

        // Determine description
        $description = 'Order of: ' . $billingParams['first_name'] . ' with order id ' . $order_id;

        // Determine country code
        if ($billingParams['country'] != null) {
            $country = \App\Models\Country::where('title', $billingParams['country'])->first();
            $billingParams['country'] = $country->country_code;
        } else {
            $state = \App\Models\State::where('title', $billingParams['city'])->first();
            if ($state) {
                $country = \App\Models\Country::where('id', $state->country_id)->first();
                $billingParams['country'] = $country->country_code;
            } else {
                $billingParams['country'] = '';
            }
        }

        // Make a request to create payment intent
        $client = new Client();
        $response = $client->request('POST', 'https://api-v2.ziina.com/api/payment_intent', [
            'json' => [
                'amount' => max(200, $amount), // Adjust amount as needed
                'currency_code' => 'AED',
                'message' => $description,
                'success_url' => url('/payment/success'),
                'cancel_url' => url('/payment/cancel'),
                'test' => true, 
            ],
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer 1jnTSlh0smrSSavQGccEbHWrdXwh9fi3/lJsu+haXH74e7jw6LjhpUEuZ4JVP4EW', 
                'content-type' => 'application/json',
            ],
        ]);

        // Extract payment intent ID
        $paymentIntent = json_decode($response->getBody(), true);
        $paymentIntentId = $paymentIntent['id'];
  
        $redirectUrl = "https://pay.ziina.com/payment_intent/{$paymentIntentId}";
        return ($redirectUrl);
    }

    public function charge(Request $request)
    {
        $response = app(CartController::class)->order_success(1);
        return redirect(url($response['data'])); 
       
        // Handle payment success
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
        $response = app(CartController::class)->order_payment_failed(1);

        return redirect(url($response['data']));
    }
}
