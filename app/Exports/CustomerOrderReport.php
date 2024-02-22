<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class CustomerOrderReport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $customer_id = request()->order_customer_id;
        $order_status = request()->order_status;

        $orderList = Order::getCustomerOrder($customer_id, $order_status);
        return view('Admin/report/customer/render_customer_orders_report', [
            'orderList' => $orderList,
        ]);
    }
}
