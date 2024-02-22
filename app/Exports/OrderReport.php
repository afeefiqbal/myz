<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Order;
use Termwind\Components\Dd;

class OrderReport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    //create a constructor to get the data

    public function view(): View
    {
       
        $status = request()->status;
        $from_date = request()->from_date!=null ?  request()->from_date. " 00:00:00" : null;
        $to_date = request()->to_date!=null ? request()->to_date. " 23:59:59" : null;

          if($status=="hold"){
              $status = 'On-Hold';
          }elseif($status=='delivery'){
              $status = 'Out for Delivery';
          }else{
              $status = $status;
          }
          if($status=='cod'){
            
              $orderList=Order::getOrderByPaymentMethod('COD', $from_date, $to_date);
          }
          else if($status=='online-payment'){
              $orderList=Order::getOrderByPaymentMethod('Credit-Card',$from_date, $to_date);
          }
          else{
     
              $orderList = Order::getOrderByStatus(ucfirst($status), $from_date, $to_date);
    
          }
       
        return view('Admin/report/order/order_report_excel', [
            'orderList' => $orderList
        ]);
    }
}
