<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
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

        $orderProducts = OrderProduct::with('productData')->where('order_id',$order_id)->get();
        $products = [];
        foreach($orderProducts as $prd){
            $products []= [
                'name' => $prd->productData->title,
                'price' => $prd->productData->price
            ];
        }

        $order = Order::where('id', $order_id)->first();

        $phone_number = str_replace('/', '', $billingParams['phone_number']);
        $phone_number = str_replace('+', '', $phone_number);
        $billingParams['phone'] = $phone_number;
        $billingParams['currency'] =  $order->currency;
        $currency = $order->currency;
        $description = 'Order of : ' . $billingParams['first_name'] . ' with order id ' . $order_id;
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => $currency,
                        'product_data' => $products,
                        'unit_amount'  => $amount,
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
   
        $response = app(CartController::class)->order_payment_failed(1);

        return redirect(url($response['data']));
    }

}
