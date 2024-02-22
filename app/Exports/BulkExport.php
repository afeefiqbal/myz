<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Order;
use Session;

class BulkExport implements FromView
{
    public function view(): View
    {
        $date_range = session('date_range');
        $status = session('status');
        $customer = session('customer');
        $product = session('product');
        $coupon = session('coupon');
       
        if (Session::has('date_range')) {
            $orderList = Order::getDetailedOrders($date_range, $status, $customer, $product, $coupon);
            $boxValues = Order::getDetailedOrdersBoxValues($date_range, $status, $customer, $product, $coupon);
        } else {
            $orderList = Order::get();
            $boxValues = Order::boxValues();
        }
        session()->forget('date_range');
        session()->forget('status');
        session()->forget('customer');
        session()->forget('product');
        session()->forget('coupon');
        return view('Admin/report/order/detail_report_excel', [
            'orderList' => $orderList
        ]);
    }
}
