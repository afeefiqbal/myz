<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrderList;
use App\Exports\ProductList;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderCoupon;
use App\Models\OrderCustomer;
use App\Models\OrderLog;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ShippingCharge;
use App\Models\SiteInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Termwind\Components\Dd;
use Yajra\DataTables\Facades\DataTables;
class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    } 
    public function list(Request $request){
            $title = "Order List";
            if ($request->ajax()) {
                $from_date = request()->from_date!=null ?  request()->from_date. " 00:00:00" : null;
                $to_date = request()->to_date!=null ? request()->to_date. " 23:59:59" : null;

                $orderList = Order::latest();
            
                if($from_date && $to_date){
                    $orderList = $orderList->whereBetween('created_at', [$from_date, $to_date]);
                }
                return DataTables::of($orderList)
                ->addIndexColumn()
                ->addColumn('order_code', function ($row) {
                return 'ARTMYST'.$row->order_code;
                })
                ->addColumn('customer_name', function ($row) {
                   $orderCustomer = $row->orderCustomer;
                   if($orderCustomer){
                       $customeData = $orderCustomer->customerData;
                          if($customeData){
                            return $customeData->first_name.' '.$customeData->last_name;
                          }
                          else{
                            
                            return   $orderCustomer = $row->orderCustomer->billingAddress->first_name.' '.$orderCustomer = $row->orderCustomer->billingAddress->last_name;
                            
                          }
                   }
                   else{
                    return 'NIL';
                   }
                   
                })
                ->addColumn('product_total', function ($row) {
                    $productTotal = Order::getProductTotal($row->id);
                    return number_format($productTotal,2);
                })
                ->addColumn('currency', function ($row) {
                   
                    return $row->currency;
                })
                ->addColumn('tax_amount', function ($row) {
                    return $row->tax_amount;
                })

                ->addColumn('coupon_value', function ($row) {
                    return ($row->orderCoupons)?$row->orderCoupons->sum('coupon_value'):'0';
                })
                ->addColumn('order_total', function ($row) {
                
                    $orderTotal = Order::getOrderTotal($row->id);
                    $cancelledTotal = Order::getCancelledProductTotal($row->id);
                    return number_format($orderTotal,2).' '.$row->currency ;
                })
                ->addColumn('payment_method', function ($row) {
                    return $row->payment_method;
                })
                ->addColumn('order_status', function ($row) {
                    $btn = '';
                    $btn .= ' <span
                    class="badge bg-'.Helper::statusColour($row->status).' orderStatusChange"
                    data-toggle="modal" data-target="#orderStatusModal"
                    data-id="'.$row->id .'"
                    data-status="'.$row->status .'" role="button">'.$row->status.'
                <i class="fas fa-exchange-alt"></i></span>';
                return $btn;
            
                })
                ->addColumn('created_at', function ($row) {
                return date('d-m-Y', strtotime($row->created_at));  
                })
                ->addColumn('action', function ($row) {
                    $btn = ' ';
                    $btn .= '  <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-sm btn-default mr-2 tooltips track-order-products" title="Track Order" data-toggle="modal"><img src="'.asset('backend/dist/img/track-order.svg').'"></a>';
                    $btn .= ' <a href="'.url(Helper::sitePrefix().'order/view/'.$row->id).'" class="btn btn-sm btn-primary mr-2 tooltips" title="View Order"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></a>';
                    $btn .= '   <a href="javascript:void(0)" class="btn btn-sm btn-warning mr-2 tooltips invoice_resend" title="Order Invoice Resend" data-id="'.$row->id.'"><i class="fa fa-paper-plane fa-lg" aria-hidden="true"></i></a>';
                    return $btn;
                })
            
                ->rawColumns(['action','order_status'])
            
                ->make(true);
        }
        $boxValues = Order::boxValues();
        return view('Admin/order/order_list', compact( 'title', 'boxValues'));
    }

    public function order_filter(Request $request)
    {
        if ($request->date_range) {
            $dateExploded = explode('-', $request->date_range);
            $startDate = date("Y-m-d", strtotime($dateExploded[0]));
            $endDate = date("Y-m-d", strtotime($dateExploded[1]));
            $start = $startDate . ' 00:00:00';
            $end = $endDate . ' 23:59:59';
            $orderList = Order::whereBetween('created_at', [$start, $end])->get();
            $boxValues = Order::boxValues($start, $end);
            return view('Admin.order.filter_order', compact('orderList', 'boxValues'));
        } else {
            echo "0";
        }
    }


    public function order_view($id)
    {
        $orderDetails = OrderCustomer::where('order_id', $id)->first();
        if ($orderDetails) {
            $title = "Order View";
            $orderTotal = Order::getProductTotal($id);
            $orderGrandTotal = Order::OrderGrandTotal($id);
            if ($orderDetails->user_type == "User") {
                $order = Order::with(['orderProducts' => function ($t) use ($orderDetails) {
                    $t->with('productData');
                    $t->with('colorData');
                }])->with(['orderCustomer' => function ($c) {
                    $c->with('customerData');
                    $c->with('billingAddress');
                }])->with('orderCoupons')->find($id);
            } else {
                $order = Order::with(['orderProducts' => function ($t) {
                    $t->with('productData');
                    $t->with('colorData');
                }])->with(['orderCustomer' => function ($c) {
                    $c->with('billingAddress');
                }])->with('orderCoupons')->find($id);
            }
            return view('Admin/order/order_view', compact('orderDetails', 'title', 'orderTotal', 'orderGrandTotal', 'order'));
        } else {
            return view('Admin.error.404');
        }
    }


    public function track_order_products(Request $request)
    {
        if ($request->order_id) {
            $order = Order::find($request->order_id);
            $orderproducts = $order->orderProducts;
            return view('Admin/order/track_order_product_modal', compact('orderproducts', 'order'));
        } else {
            return 0;
        }
    }

    public function order_status(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');
        $order_product_id = $request->product_id;
        if ($order_product_id) {
            DB::beginTransaction();
            $orderLog = new OrderLog;
            $orderLog->order_product_id = $order_product_id;
            $orderLog->status = $request->status;
           
            if ($orderLog->save()) {
                $order = Order::find($request->order_id);
                $orderProduct = OrderProduct::find($order_product_id);
                $orderCustomer = OrderCustomer::where('order_id', $request->order_id)->first();
                $cartProducts = OrderProduct::where('order_id', $request->order_id)->get();
                $valid = $couponValid = true;
                $orderSubTotal = Order::getActiveProductTotal($request->order_id);
                dd($orderSubTotal);
                $orderProductTotal = $orderSubTotal = $tax_amount = 0;
          
                // if ($order->tax != 0) {
                //     $tax_amount = $orderSubTotal * $order->tax / 100;
                //     if ($order->tax_type == "Outside") {
                //         $orderSubTotal = $orderSubTotal + $tax_amount;
                //     }
                // }
               
                $shippingAmount = ShippingCharge::getShippingCharge($orderCustomer->shippingAddress->state, $orderProductTotal);

                $coupon = OrderCoupon::where([['order_id', $request->order_id], ['status', 'Active']])->first();
                
                if ($coupon != NULL) {
                    $valid = $second_valid = $third_valid = $fourth_valid = $minimum_valid = $maximum_valid = true;
                
                    /*if($request->status=="Processing" || $request->status=="On Hold" || $request->status=="Delivery" || $request->status=="Completed"){
                        $status="Active";
                    }else{
                        $status="Inactive";
                    }*/
                    if ($coupon->minimum_spend != '0.00') {
                        if ($coupon->minimum_spend <= $orderProductTotal) {
                            $minimum_valid = true;
                        } else {
                            $minimum_valid = false;
                        }
                    }
                    if ($coupon->maximum_spend != '0.00') {
                        if ($coupon->maximum_spend >= $orderProductTotal) {
                            $maximum_valid = true;
                        } else {
                            $maximum_valid = false;
                        }
                    }
                    if ($minimum_valid == true && $maximum_valid == true) {
                   
                        $excludedProductList = $productCharge = $includedProducts = [];
                        $includedProductCost = $excludedProductCost = [];
                      
                        foreach ($cartProducts as $product) {
                            $orderStatusData = OrderLog::where('order_product_id', '=', $product->id)->latest()->first();
                        
                            if ($orderStatusData->status == "Processing" || $orderStatusData->status == "On Hold" || $orderStatusData->status == "Out for Delivery" || $orderStatusData->status == "Completed") {
                                $productData = Product::find($product->product_id);
                        
                                if (count($includedProducts) > 0) {
                                    if (in_array($productData->product_id, $includedProducts)) {
                                        $includedProductList[] = $product->product_id;
                                        if ($coupon->applicable_only_if_sale_price == "No") {
                                            if ($product->offer_id == 0) {
                                                $includedProductCost[] = $product->total;
                                            }
                                        } else {
                                            if ($product->offer_id != 0) {
                                                $includedProductCost[] = $product->total;
                                            }
                                        }
                                    } else {
                                        $excludedProductList[] = $product->id;
                                    }
                                } else {
                                    if ($coupon->applicable_only_if_sale_price == "No") {
                                        if ($product->offer_id == 0) {
                                            $includedProductCost[] = $product->total;
                                        }
                                    } else {
                                        if ($product->offer_id != 0) {
                                            $includedProductCost[] = $product->total;
                                        }
                                    }
                                }
                            }
                     
                        }
                        if ($orderSubTotal != 0) {
                            
                            if (!empty($includedProducts)) {
                                if (count($excludedProductList) > 0) {
                                    $third_valid = false;
                                }
                            }
                            if ($third_valid == false) {
                                if ($coupon->type == "Fixed") {
                                    $disabled = true;
                                } else {
                                    if (count($includedProductCost) > 0) {
                                        $coupon_value = array_sum($includedProductCost) * $coupon->coupon_value / 100;
                                    } else {
                                    
                                        $coupon_value = $orderSubTotal * $coupon->coupon_value / 100;
                                    }
                                    $final_amount_after_coupon = $orderSubTotal - $coupon_value;
                                    $fourth_valid = true;
                                }
                            } else {
                                if ($coupon->type == "Fixed") {
                                    $coupon_value = $coupon->coupon_value;
                                    if (count($includedProductCost) > 0) {
                                        $final_amount_after_coupon = array_sum($includedProductCost) - $coupon_value;
                                    } else {
                                        $final_amount_after_coupon = $orderSubTotal - $coupon_value;
                                    }
                                } else {
                                    if (count($includedProductCost) > 0) {
                                        
                                        $coupon_value = array_sum($includedProductCost) * $coupon->coupon_value / 100;
                                    } else {
                                        $coupon_value = $orderSubTotal * $coupon->coupon_value / 100;
                                    }
                                    $final_amount_after_coupon = $orderSubTotal - $coupon_value;
                                }
                                $fourth_valid = true;
                            }
                            if ($fourth_valid == true) {
                                // if($order->gift_wrapper_enabled=="Yes"){
                                //     $final_amount_after_coupon = $final_amount_after_coupon+$order->gift_wrapper_charge;
                                // }
                                /*$orderCoupon = OrderCoupon::find($coupon->id);
                                // $orderCoupon->coupon_value = $coupon_value;
                                $orderCoupon->status = $status;
                                if($orderCoupon->save()){*/
                                $couponValid = true;
                                $disabled = false;
                                /*}*/
                            } else {
                                $disabled = true;
                            }
                        } else {
                            $disabled = true;
                        }
                    } else {
                        $disabled = true;
                    }
                    if ($disabled == true) {
                        /*$orderCoupon = OrderCoupon::find($coupon->id);
                        $orderCoupon->status = $status;
                        if($orderCoupon->save()){*/
                        $couponValid = true;
                        /*}*/
                    }
                }
                if ($couponValid == true) {
                    //$order->tax_amount = $tax_amount;
                    if ($order->save()) {
                        $valid = true;
                    } else {
                        $valid = false;
                    }
                    if ($order->orderCustomer->user_type == "User") {
                        $orderData = Order::with(['orderProducts' => function ($t) {
                            $t->with('productData');
                        }])->with(['orderCustomer' => function ($c) use ($orderCustomer) {
                            $c->with('customerData');
                            $c->with('billingAddress');
                            $c->where('customer_id', '=', $orderCustomer->customer_id);
                        }])->with('orderCoupons')->find($request->order_id);
                    } else {
                        $orderData = Order::with(['orderProducts' => function ($t) {
                            $t->with('productData');
                        }])->with('orderCustomer')->with('orderCoupons')->find($request->order_id);
                    }
                    if($orderProduct->productData != null){

                        $produtName = $orderProduct->productData->title;
                    }
                    else{
                        return response()->json(['status' => false, 'message' => 'Product not found']);
                    }
                
             
       
                    if($orderProduct->productData != null){      
                        
                        // $orderMail = Order::sendOrderStatusMail($orderData->id, $request->status, $orderProduct->id);
                        // return response()->json(['status' => 'true', 'message' => 'Order status has been changed successfully']);
                        DB::commit();
                        return response()->json(['status' => 'true', 'message' => 'Order status has been changed successfully']);
                   }
                } else {
                    DB::rollBack();
                    return response()->json(['status' => false, 'message' => 'Error while updating the order status']);
                }
            } else {
                DB::rollBack();
                return response()->json(['status' => false, 'message' => 'Error while changing the status']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Order not found']);
        }
    }

    public function cancel_all(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');
        $order = Order::find($request->order_id);
        foreach ($order->orderProducts as $orderProduct) {
            if ($orderProduct->id != $request->product_id) {
                $orderLog = new OrderLog;
                $orderLog->order_product_id = $orderProduct->id;
                $orderLog->status = 'Cancelled';
                $orderLog->save();
            } else {
                $orderLog = new OrderLog;
                $orderLog->order_product_id = $orderProduct->id;
                $orderLog->status = $request->status;
                $orderLog->save();
            }
        }
        return response()->json(['status' => 'true', 'message' => 'All products in this order cancelled.']);
    }

    public function invoice_resend(Request $request)
    {
        $order = Order::find($request->order_id);
        if ($order != NULL) {
            if ($order->orderCustomer->user_type == "User") {
                $orderData = Order::with(['orderProducts' => function ($t) {
                    $t->with('productData');
                }])->with(['orderCustomer' => function ($c) use ($order) {
                    $c->with('customerData');
                    $c->with('billingAddress');
                    $c->where('customer_id', $order->orderCustomer->customer_id);
                }])->with('orderCoupons')->find($request->order_id);
            } else {
                $orderData = Order::with(['orderProducts' => function ($t) {
                    $t->with('productData');
                }])->with('orderCustomer')->with('orderCoupons')->find($request->order_id);
            }
//            if ($order->orderCustomer->billingAddress != NULL) {
            if (Helper::SendOrderPlacedMail($orderData, '0')) {
                return response()->json(['status' => true, 'message' => 'Order invoice has been sent successfully']);
            } else {
                return response()->json(['status' => false, 'message' => 'Error while sending the order invoice']);
            }
//            } else {
//                return response()->json(['status' => false, 'message' => 'Address not found']);
//            }
        } else {
            return response()->json(['status' => false, 'message' => 'Order not found']);
        }
    }

    public function cancelled_splitup(Request $request)
    {
        if ($request->order_id) {
            $order = Order::find($request->order_id);
            $cancelledTotal = Order::getCancelledProductTotal($request->order_id);
            return view('Admin/order/cancelled_product_modal', compact('cancelledTotal', 'order'));
        } else {
            return 0;
        }
    }


    public function print_invoice($id)
    {
        $orderDetails = OrderCustomer::where('order_id', $id)->first();
        if ($orderDetails) {
            $orderTotal = Order::getProductTotal($id);
            $orderGrandTotal = Order::OrderGrandTotal($id);
            if ($orderDetails->user_type == "User") {
                $order = Order::with(['orderProducts' => function ($t) use ($orderDetails) {
                    $t->with('productData');
                    $t->with('colorData');
                }])->with(['orderCustomer' => function ($c) use ($orderDetails) {
                    $c->with('customerData');
                    $c->with('shippingAddress');
                    $c->where('customer_id', $orderDetails->customer_id);
                }])->with('orderCoupons')->find($id);
            } else {
                $order = Order::with(['orderProducts' => function ($t) {
                    $t->with('productData');
                    $t->with('colorData');
                }])->with('orderCustomer')->with('orderCoupons')->find($id);
            }
            $title = "Order View - MYZ#" . $order->order_code;
            return view('Admin.order.print_invoice', compact('orderDetails', 'title', 'orderTotal', 'orderGrandTotal', 'order'));
        } else {
            return view('Admin.error.404');
        }
    }
    public function export()
    {
       
        //pass the from and to date to the query
    
        return Excel::download(new OrderList, 'order-list.xlsx');
        // return Excel::download(new OrderList, 'order-list.xlsx');
    }
}
