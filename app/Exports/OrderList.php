<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Order;
use App\Models\Product;
use Session;

class OrderList implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $from_date = request()->from_date!=null ?  request()->from_date. " 00:00:00" : null;
        $to_date = request()->to_date!=null ? request()->to_date. " 23:59:59" : null;
        $condition = Order::latest();
        if($from_date!=null && $to_date!=null){
            $condition->whereBetween('created_at', [$from_date, $to_date]);
        }
        $orders = $condition->latest()->get();
     
        $orderList =[];
        foreach($orders as $key=>$value){
            $orderList[$key]['order_code'] = 'ARTMYST'.$value->order_code;
            $orderList[$key]['customer_name'] =  $value->orderCustomer->billingAddress->first_name ?? ''.' '.@$value->orderCustomer->billingAddress->last_name ?? '';
            $orderList[$key]['product_details']  = $value->orderProducts;

            $productTotal = Order::getProductTotal($value->id);
            $orderList[$key]['product_total'] = number_format($productTotal,2);

            $orderTotal = Order::getOrderTotal($value->id);

            $orderList[$key]['order_total'] = number_format($orderTotal,2).' '.$value->currency ;
            $orderList[$key]['payment_method'] =$value->payment_method;
            $orderList[$key]['order_status'] = $value->status;
            $orderList[$key]['created_at'] = date('d-m-Y', strtotime($value->created_at));;
        }
    
        return view('Admin/report/order/order_list_excel', [
            'orderList' => $orderList
        ]);
    }
}
