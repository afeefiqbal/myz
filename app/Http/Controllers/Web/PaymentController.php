<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\CartController;
use App\Http\Helpers\Helper;
use App\Models\Order;
use Illuminate\Http\Request;
use TelrGateway\TelrManager;
use TelrGateway\Transaction;

class PaymentController extends Controller
{
    public function payment($order_id, $amount, $billingParams)
    {
    
      
        $order = Order::where('id', $order_id)->first();
        //remove slashes from phone number and + sign
        $phone_number = str_replace('/', '', $billingParams['phone_number']);
        $phone_number = str_replace('+', '', $phone_number);
        $billingParams['phone'] = $phone_number;
        $billingParams['currency'] =  $order->currency;
   
       $currency = $order->currency;
        $telrManager = new TelrManager();
        $description = 'Order of : ' . $billingParams['first_name'] . ' with order id ' . $order_id;

        if($billingParams['country'] != null){
            $country = \App\Models\Country::where('title',$billingParams['country'])->first();
            
            $billingParams['country'] = $country->country_code;
        }
        else{
            $state = \App\Models\State::where('title',$billingParams['city'])->first();
            if($state){
                $country = \App\Models\Country::where('id', $state->country_id)->first();
                $billingParams['country'] = $country->country_code;
            } else{
                $billingParams['country'] = '';
            }
        }
       
    

        $url_link = $telrManager->pay($order_id, $amount, $description, $billingParams,$currency)->redirect();
       
        $url = $url_link->getTargetUrl();

        // Display Result Of Response
        return $url;
//        return redirect($url);
//        return view('payment', compact('url'));
    }


    public function paymentSuccess(Request $request)
    {
        // Store Transaction Details
        $telrManager = new TelrManager();
        $transaction = $telrManager->handleTransactionResponse($request);

        $response = app(CartController::class)->order_success($transaction->order_id);

        //Card Details
        $card_last_4 = $transaction->response['order']['card']['last4'];
        $card_holder_name = $transaction->response['order']['customer']['name']['forenames'] . " " . $transaction->response['order']['customer']['name']['surname'];

        //Queries
//        $paymentDetails = Transaction::where('cart_id', $request->cart_id)->firstOrFail();

        // Display Result Of Response
//        dump('paymentSuccess :: ', $transaction);
//        dump('transaction Response :: ', $transaction->response);
//        dd('payment Details :: ', $paymentDetails);

        return redirect(url($response['data']));
    }

    public function paymentCancel(Request $request)
    {
        $telrManager = new TelrManager();
        $transaction = $telrManager->handleTransactionResponse($request);
        $response = app(CartController::class)->order_payment_cancelled($transaction->order_id);
//        dd('paymentCancel :: ', $transaction);

        return redirect(url($response['data']));
    }

    public function paymentDeclined(Request $request)
    {
        $telrManager = new \TelrGateway\TelrManager();
        $transaction = $telrManager->handleTransactionResponse($request);

        $response = app(CartController::class)->order_payment_failed($transaction->order_id);

//        dd('paymentDeclined :: ', $transaction);

        return redirect(url($response['data']));
    }

}
