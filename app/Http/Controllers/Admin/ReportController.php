<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BulkExport;
use App\Exports\CustomerOrderReport;
use App\Exports\OrderReport;
use App\Exports\ProductList;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Imports\ProductsImport;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderLog;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\SiteInformation;
use App\Models\Size;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Nette\Utils\Html;
use Termwind\Components\Dd;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    }

    public function out_of_stock(Request $request)
    {
        $title = "Out Of Stock";
        $productList = Product::active()->get();
      

        $productPrice = ProductPrice::where('availability', 'Out of Stock')
        ->orWhere('stock','=>', '0')
        ->get();
       $productIds = $productPrice->pluck('product_id')->toArray();

       
       if ($request->ajax()) {
            $productList = Product::active()->whereIn('id',$productIds);

            return Datatables::of($productList)
            ->addIndexColumn()
            ->addColumn('title',function($row){
                return $row->title;
            })
            ->addColumn('status',function($row){
                if($row->status == 'Active'){
                    $span = '<span class="badge badge-success">Active</span>';
                }else{
                    $span = '<span class="badge badge-danger">Inactive</span>';
                }
                    return $span;
            })
            ->addColumn('productType',function($row){
                return $row->productType->title;
            })
            ->addColumn('size',function($row){
                $sizeID =  $row->productprice->size_id;
               $size =  Size::where('id',$sizeID)->first();
                return $size->title;
            })
            ->addColumn('action', function ($row) {
                
                $btn = '<a href="'.url(Helper::sitePrefix().'product/edit/'.$row->id).'" class="btn btn-success mr-2 tooltips" title="Edit Product"><i class="fas fa-edit"></i></a>';
                return $btn;
            })
            ->rawColumns(['action','status'])
            ->make(true);
        }
        return view('Admin.report.product.out_of_stock_report',compact('title'));
    }

    public function featured_products(Request $request)
    {
        $title = "Featured Products";
        if ($request->ajax()) {
            $productList = Product::where('is_featured','Yes')->orderBy('id','desc');
            return DataTables::of($productList)
            ->addIndexColumn()
            ->addColumn('title',function($row){
                return $row->title;
            })
            ->addColumn('status',function($row){
                if($row->status == 'Active'){
                    $span = '<span class="badge badge-success">Active</span>';
                }else{
                    $span = '<span class="badge badge-danger">Inactive</span>';
                }
                 return $span;
            })
            ->addColumn('productType',function($row){
                return $row->productType->title;
            })
            ->addColumn('action', function ($row) {
              
                $btn = '<a href="'.url(Helper::sitePrefix().'product/edit/'.$row->id).'" class="btn btn-success mr-2 tooltips" title="Edit Product"><i class="fas fa-edit"></i></a>';
                return $btn;
            })
            ->rawColumns(['action','status'])
            ->make(true);
        }
        return view('Admin.report.product.featured_report',compact('title'));
    }

    public function new_products(Request $request)
    {
        $title = "New Products";

        if ($request->ajax()) {
            //taje all
            $productList = Product::where('new_arrival','Yes')->orderBy('id','desc')->get();
          
            return Datatables::of($productList)
            ->addIndexColumn()
            ->addColumn('title',function($row){
                return $row->title;
            })
            ->addColumn('status',function($row){
                if($row->status == 'Active'){
                    $span = '<span class="badge badge-success">Active</span>';
                }else{
                    $span = '<span class="badge badge-danger">Inactive</span>';
                }
                return $span;
            })
            ->addColumn('productType',function($row){
                return $row->productType->title;
            })
        
            ->addColumn('action', function ($row) {
            
                $btn = '<a href="'.url(Helper::sitePrefix().'product/edit/'.$row->id).'" class="btn btn-success mr-2 tooltips" title="Edit Product"><i class="fas fa-edit"></i></a>';
                return $btn;
            })
            ->rawColumns(['action','status'])
            ->blacklist(['actions'])
            ->make(true);
        }
        return view('Admin.report.product.new_product_report',compact('title'));
    }

    public function detail_report(Request $request)
    {
       
        $title = "Detailed Order Report";
        $boxValues = Order::boxValues();
        $customerList = Customer::oldest('first_name', 'last_name')->get();
        $productList = Product::where('status', 'Active')->oldest('title')->get();
        $couponList = Coupon::where('status', 'Active')->get();
     
        $date_range = $request->date_range;
        $status = $request->order_report_status;
        $customer = $request->order_report_customer;
        $product = $request->order_report_product;
        $coupon = $request->order_report_coupon;
        if($date_range != null || $status != null || $customer != null || $product != null || $coupon != null){

            $boxValues = Order::getDetailedOrdersBoxValues($date_range, $status, $customer, $product, $coupon);
            session(['date_range' => $date_range]);
            session(['status' => $status]);
            session(['customer' => $customer]);
            session(['product' => $product]);
            session(['coupon' => $coupon]);
        }
      
        if ($request->ajax()) {
            
            $orderList = Order::get();
            if($date_range != null || $status != null || $customer != null || $product != null || $coupon != null){
                $orderList = Order::getDetailedOrders($date_range, $status, $customer, $product, $coupon);
            }
            return Datatables::of($orderList)
            ->addIndexColumn()
            ->addColumn('code', function ($row) {
                return 'ARTMYST# '.$row->order_code;
            })
            ->addColumn('customer_details', function ($row) {
                if($row->orderCustomer->CustomerData != null)
                    return $row->orderCustomer->CustomerData->first_name.' '.$row->orderCustomer->CustomerData->last_name;
                else
                return   $row->orderCustomer->billingAddress->first_name.' '.$orderCustomer = $row->orderCustomer->billingAddress->last_name;
                
            })
            ->addColumn('created_date', function ($row) {
            
                $createdDate = date('d M Y', strtotime($row->created_at));
                return $createdDate;
            })
            ->addColumn('total', function ($row) {
                $productTotal = Order::getProductTotal($row->id);
               
                return  number_format($productTotal,2).' '.$row->currency;
            })
            ->addColumn('order_total', function ($row) {
                $orderTotal = Order::getOrderTotal($row->id);
                return number_format($orderTotal,2).' '.$row->currency;
            })
            ->addColumn('product_details', function ($row) {
               
                $productDetails = '';
                $productDetails .= '<table class="table table-bordered table-striped table-hover">';
                $productDetails .= '<tr>';
                $productDetails .= '<td>#</td>';
                $productDetails .= '<td colspan="1">Product</td>';
                $productDetails .= '<td>Qty</td>';
                $productDetails .= '<td>Offer</td>';
                $productDetails .= '<td>Cost</td>';
                $productDetails .= '<td>Sub Total</td>';
                $productDetails .= '<td style="border-right: 1px solid #f4f4f4;">Status</td>';
                $productDetails .= '</tr>';
                $i = 1;
                foreach($row->orderProducts as $products){
                
                    $productDetails .= '<tr>';
                    $productDetails .= '<td>'.$i.'</td>';
                    $productDetails .= '<td colspan="1">'.$products->productData->title.'</td>';
                    $productDetails .= '<td>'.$products->qty.'</td>';
                   if($products->offer_id != 0){
                        $productDetails .= '<td>Yes</td>';
                    }else{
                        $productDetails .= '<td>No</td>';
                    }
                    $productDetails .= '<td>'.$products->cost.'</td>';
                    $productDetails .= '<td>'.$products->total.'</td>';
                    $orderStatus = OrderLog::where('order_product_id','=',$products->id)->orderBy('created_at','DESC')->first();
                    $productDetails .= '<td style="border-right: 1px solid #f4f4f4;">'.Order::getStatus($orderStatus->status) .'</td>';

                    $productDetails .= '</tr>';
                    $i++;
                }
                $productDetails .= '</table>';
                return $productDetails;
                

                // <tr>
                // <td>#</td>
                // <td colspan="1">Product</td>
                // <td>Qty</td>
                // <td>Offer</td>
                // <td>Cost</td>
                // <td>Sub Total</td>
                // <td style="border-right: 1px solid #f4f4f4;">Status</td>
            // </tr>
            })
            ->rawColumns(['action','product_details'])
            ->blacklist(['actions'])
            ->make(true);
        }
        return view('Admin/report/order/order_detail_report', compact( 'title', 'boxValues', 'customerList', 'productList', 'couponList'));
    }

  
    public function order_detail_filter(Request $request)
    {
     
        $date_range = $request->date_range;
        $status = $request->order_report_status;
        $customer = $request->order_report_customer;
        $product = $request->order_report_product;
        $coupon = $request->order_report_coupon;
        $orderList = Order::getDetailedOrders($date_range, $status, $customer, $product, $coupon);
        $boxValues = Order::getDetailedOrdersBoxValues($date_range, $status, $customer, $product, $coupon);
        session(['date_range' => $date_range]);
        session(['status' => $status]);
        session(['customer' => $customer]);
        session(['product' => $product]);
        session(['coupon' => $coupon]);
        return view('Admin.report.order.order_detail_report_filter', compact('orderList', 'boxValues'));
    }
    
    /********************* Order Report ****************************/

    public function orders($status, Request $request){
        if($status == 'hold'){
            $status = 'On Hold';
        }
        $from_date = request()->from_date!=null ?  request()->from_date. " 00:00:00" : null;
        $to_date = request()->to_date!=null ? request()->to_date. " 23:59:59" : null;
        $title = ucfirst($status)." orders";
        if($status=='cod'){
            $boxValues = Order::boxValuesForgetOrderByPaymentMethod('COD', $from_date, $to_date);
        }
        else if($status=='online-payment'){
            $boxValues = Order::boxValuesForgetOrderByPaymentMethod('Credit-Card', $from_date, $to_date);
        }
        else{
            $boxValues = Order::boxValuesForgetOrderByStatus(ucfirst($status), $from_date, $to_date);
        }
      //make orderlist array for yajra datatable

      
      
      if ($request->ajax()) {
        $from_date = request()->from_date!=null ?  request()->from_date. " 00:00:00" : null;
        $to_date = request()->to_date!=null ?  request()->to_date. " 23:59:59" : null;
        if($status=="on hold"){
            $status = 'On Hold';
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
        
     
            return DataTables::of($orderList)
                ->addIndexColumn()
                ->addColumn('order_code', function($row){
                    $btn = '<a href="'.url(Helper::sitePrefix().'order/view/'.$row['order']->id).'">ARTMYST'.$row['order']->order_code.'</a>';
                    return $btn;
                })
                ->addColumn('customer', function($row){
                   $customer =  $row['order']->orderCustomer->shippingAddress->first_name ?? ''.' '.@$row['order']->orderCustomer->shippingAddress->last_name ?? '';
                    return $customer;
                })
                ->addColumn('no_of_items', function($row) use($status){
                   
                    $orderProducts = OrderProduct::where('order_id','=',$row['order']->id)->pluck('id')->toArray();
                   $orderLog = OrderLog::whereIn('order_product_id',$orderProducts)->where('status','=',$status)->count();
          
                    return $row['OrderProducts'];
                })
                ->addColumn('payment_method', function($row){
                    return $row['order']->payment_method;
                })
                ->addColumn('price', function($row) use($status){
                
                   if($status=='cancelled'){
                    
                       $total_price = $row['total_price'];
                       if($total_price >= 0){
                           $total_price = $row['total_price'];
                           return $row['order']->currency .' '.   number_format($total_price,2);
                       }
                       else{
                           return $row['order']->currency .' '. number_format($row['return_amount'],2);
                          
                       }
                   }

                    
                   
                })
               
                ->addColumn('date', function($row){
                    return date("d-M-Y", strtotime($row['order']->created_at));
                })
                ->rawColumns(['order_code'])
                ->make(true);
        }
        // return view('Admin.report.order.orders_report',compact());

        return view('Admin.report.order.orders_report',compact('title','boxValues','status'));
    }
    public function export()
    {
        
        return Excel::download(new BulkExport, 'order-report.xlsx');
    }
    public function method($method)
    {
        $title = strtoupper($method) . " orders";
        $orderList = Order::getOrderByPaymentMethod(strtoupper($method));
        $boxValues = Order::boxValuesForgetOrderByPaymentMethod(strtoupper($method));
        return view('Admin/report/order/orders_report', compact('orderList', 'title', 'boxValues', 'method'));
    }

    public function offer_orders()
    {
        $title = "Offer Applied Orders";
        $orderList = Order::getOrderByOffers();
        return view('Admin/report/order/offer_orders_report', compact('orderList', 'title'));
    }

    public function render_offer_orders(Request $request)
    {

        $order_id = $request->order_id;
   
        $orderList = Order::getOrderByOffers($order_id);
        return view('Admin/report/order/render_offer_orders_report', compact('orderList'));
    }

    /********************** Customer order report *********************************/

    public function customer_info(Request $request){
        $title = "Customers";
        if ($request->ajax()) {
            $from_date = request()->from_date!=null ?  request()->from_date. " 00:00:00" : null;
            $to_date = request()->to_date!=null ?  request()->to_date. " 23:59:59" : null;
            $customerList = Customer::with(['customerAddress' => function($q) {
                        $q->with('state');
                    }]);
                    if($from_date != null && $to_date != null){
                        $customerList = $customerList->whereBetween('created_at',[$from_date,$to_date]);
                   
                    }
                    return Datatables::of($customerList)
                    ->addIndexColumn()
                    ->addColumn('customer_name',function($row){
                        return $row->first_name;
                    })
                    ->addColumn('phone_number',function($row){
                        return $row->user->phone ??' ';
                    })
                    ->addColumn('email',function($row){
                        return $row->user->email ?? '';
                    })
                    ->addColumn('username',function($row){
                        return $row->user->username ?? '';
                    })
                    ->addColumn('status',function($row){
                        if($row->status == 'Active'){
                            $span = '<span class="badge badge-success">Active</span>';
                        }else{
                            $span = '<span class="badge badge-danger">Inactive</span>';
                        }
                         return $span;

                    })
                    ->addcolumn('address',function($row){
                    $address = '    ';
                        $row->customerAddress;
                        
                     
                    })
                    ->addColumn('created_at',function($row){
                        return date('d-m-Y',strtotime($row->created_at));
                    })
                    ->rawColumns(['status','address'])
                    ->make(true); 
        }
        return view('Admin.report.customer.customer_report',compact('title'));
    }

    public function customer_order()
    {
        $title = "Customer Report";
        $customerList = Customer::get();
        return view('Admin/report/customer/customer_orders_report', compact('customerList', 'title'));
    }

    public function render_customer_order(Request $request)
    {
        $customer_id = $request->customer;
        $order_status = $request->status;
        $orderList = Order::getCustomerOrder($customer_id, $order_status);
    
        return view('Admin/report/customer/render_customer_orders_report', compact('orderList'));
    }
     public function order_export()
    {
    
    //pass orderlist variable to excel file

        return Excel::download(new OrderReport, 'order-list.xlsx');
        // return Excel::download(new OrderList, 'order-list.xlsx');
    }
    public function customer_order_report_excel ()
    {
        return Excel::download(new CustomerOrderReport, 'customer-orders.xlsx');

    }
}
