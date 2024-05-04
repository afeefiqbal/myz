<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function payment($order_id, $amount, $billingParams)
    {
        // Fetch order details
        $order = Order::findOrFail($order_id);
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $paymentIntent = PaymentIntent::create([
            'amount' => max(200,  intval($amount * 100)), // Adjust amount as needed
            'currency' => 'AED', // Adjust currency as needed
            'description' => 'Order of: ' . $billingParams['first_name'] . ' with order id ' . $order_id,
        ]);

        // Extract payment intent ID
        $paymentIntentId = $paymentIntent->id;

        $redirectUrl = route('processPayment', ['paymentIntentId' => $paymentIntentId]);
      
        return redirect($redirectUrl);
    }

    public function processPayment(Request $request)
    {
        // Retrieve payment intent ID from the request
        $paymentIntentId = $request->input('paymentIntentId');

        // Retrieve the PaymentIntent from Stripe
        $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

        // Check if payment was successful
        if ($paymentIntent->status === 'succeeded') {
            // Payment successful, handle accordingly (e.g., mark order as paid)
            // Implement your logic here
            return redirect()->route('payment.success');
        } else {
            // Payment failed or requires additional action
            // Implement your logic here (e.g., redirect to payment failure page)
            return redirect()->route('payment.failure');
        }
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
