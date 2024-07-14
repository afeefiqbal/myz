<?php

namespace App\Http\Controllers\Web;

use App\Events\OrderPlaced;
use App\Http\Controllers\Admin\SiteInformationController;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\SiteInformation;
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
                'price' =>intval($prd->cost* 100),
                'qty' =>($prd->qty),

            ];
        }
        $settings = SiteInformation::first();
        
       

        $order = Order::where('id', $order_id)->first();

        $phone_number = str_replace('/', '', $billingParams['phone_number']);
        $phone_number = str_replace('+', '', $phone_number);
        $billingParams['phone'] = $phone_number;
        $billingParams['currency'] =  $order->currency;
        $currency = $order->currency;
        $description = 'Order of : ' . $billingParams['first_name'] . ' with order id ' . $order_id;
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $lineItems = [];
        $calculation_box = Helper::calculationBox();
        $shipping = intval(number_format($calculation_box['shippingAmount'],2)*100) ;
        $tax = intval(number_format($calculation_box['tax_amount'],2)*100);
        foreach ($products as $product) {
            $lineItems[] = [
                'price_data' => [
                    'currency'     => $currency,
                    'product_data' => [
                        'name' => $product['name'],
                    ],
                    'unit_amount'  =>$product['price'] ,
                ],
                'quantity'   =>$product['qty'],
            ];
        }
        $lineItems[] = [
            'price_data' => [
                'currency' => $currency,
                'product_data' => [
                    'name' => 'Shipping',
                ],
                'unit_amount' => $shipping,
            ],
            'quantity' => 1,
        ];
        $lineItems[] = [
            'price_data' => [
                'currency' => $currency,
                'product_data' => [
                    'name' => 'Tax',
                ],
                'unit_amount' => $tax,
            ],
            'quantity' => 1,
        ];
       

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => $lineItems,
            'mode'                 => 'payment',
            'success_url'          => route('payment.success'),
            'cancel_url'           => route('payment.failure'),
        ]);
        session(['order_id' => $order_id]);
    
        return ($session->url);

    }

    public function paymentSuccess(Request $request)
    {
        $order_id = session()->get('order_id');

        $order = Order::with('orderProducts')->find($order_id);
        event(new OrderPlaced($order));
        $response = app(CartController::class)->order_success($order_id);

        return redirect(url($response['data']));
        // Handle payment cancellation
        // You can implement this method according to your business logic
    }
    public function paymentCancel(Request $request)
    {
        $order_id = session()->get('order_id');
        $response = app(CartController::class)->order_payment_cancelled($order_id);

        return redirect(url($response['data']));
        // Handle payment cancellation
        // You can implement this method according to your business logic
    }

    public function paymentDeclined(Request $request)
    {
        $order_id = session()->get('order_id');
   
        $response = app(CartController::class)->order_payment_failed($order_id);

        return redirect(url($response['data']));
    }

}
