<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Color;
use App\Models\Customer;
use App\Models\HomeAdvertisement;
use App\Models\HomeBanner;
use App\Models\HomeHeading;
use App\Models\MeasurementUnit;
use App\Models\Brand;
use App\Models\ProductType;

use App\Models\Tag;
use App\Models\HotDeal;
use App\Models\KeyFeature;
use App\Models\Order;
use App\Models\Product;
use App\Models\Latest;
use App\Models\SiteInformation;
use App\Models\Testimonial;
use App\Models\HomeGetQuote;
use App\Models\Homecollection;
use App\Models\IndexBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    }

    public function admin_dashboard()
    {
        $title = "Dashboard";
        $processingOrders = Order::OrderCountByStatus('Processing');
        $ohHoldOrders = Order::OrderCountByStatus('On Hold');
        $outOfStock = Product::active()->where('quantity', 'Out of stock')->count();
        $today_start = date('Y-m-d') . ' 00:00:00';
        $today_end = date('Y-m-d') . ' 23:59:59';
        $todaySales = Order::SalesByDate($today_start, $today_end, 1);
        $month_start = date('Y-m-01') . ' 00:00:00';
        $month_end = date('Y-m-d') . ' 23:59:59';
        $monthSales = Order::SalesByDate($month_start, $month_end, 1);
        $year_start = date('Y-01-01') . ' 00:00:00';
        $year_end = date('Y-m-d') . ' 23:59:59';
        $yearSales = Order::SalesByDate($year_start, $year_end, 1);
        $latestProducts = Product::active()->latest()->take(6)->get();
        $currentMonthOnProcessing = Order::OrderCountByStatus('Processing', $month_start, $month_end);
        $totalOrders = Order::boxValues();
        $currentMonthOnHold = Order::OrderCountByStatus('On Hold', $month_start, $month_end);
        $currentMonthCompleted = Order::OrderCountByStatus('Completed', $month_start, $month_end);
        $currentMonthCancelled = Order::OrderCountByStatus('Cancelled', $month_start, $month_end);
        $currentMonthRefunded = Order::OrderCountByStatus('Refunded', $month_start, $month_end);
        $currentMonthFailed = Order::OrderCountByStatus('Failed', $month_start, $month_end);
        $monthNetSales = Order::SalesByDate($month_start, $month_end, 0);
        $monthProducts = Order::ProductOrderCustomerCount($month_start, $month_end);
        $monthOrders = Order::ProductOrderCustomerCount($month_start, $month_end);
        $monthNewCustomers = Order::ProductOrderCustomerCount($month_start, $month_end);
        $latestMembers = Customer::with('user')->whereHas('user', function ($query) {
            return $query->active();
        })->latest()->take(8)->get();
        $totalProducts = Order::ProductOrderCustomerCount();
        $totalCustomers = Order::ProductOrderCustomerCount();
        $totalActiveCoupons = Coupon::where('status', 'Active')->count();
        $totalActiveOrders = Order::OrderCountByStatus('Processing');
        $latestOrders = Order::latest()->take(10)->get();
        $chartInfo = Order::ChartInfo($month_start, $month_end);

        return view('Admin.dashboard.admin_dashboard', compact('processingOrders', 'currentMonthOnHold',
            'latestProducts', 'latestOrders', 'chartInfo', 'totalOrders', 'totalActiveCoupons', 'totalActiveOrders',
            'latestMembers', 'totalProducts', 'totalCustomers', 'monthNetSales', 'monthProducts', 'monthOrders',
            'monthNewCustomers', 'currentMonthCompleted', 'currentMonthCancelled', 'currentMonthRefunded',
            'currentMonthFailed', 'currentMonthOnProcessing', 'ohHoldOrders', 'outOfStock', 'todaySales', 'monthSales',
            'yearSales'));

    }
    public function index()
    {
        $key = "Update";
        $title = "Home";
        $index = IndexBanner::first();
        return view('Admin.home.form', compact('key', 'title', 'index'));
    }
    public function store(Request $request)
    {
        if ($request->id == 0) {
            $validatedData = $request->validate([
                'main_banner' => 'required|image',
                'main_banner_attribute' => 'required|min:2|max:255',
                'left_side_banner' =>  'required|image',
                'left_second_banner' =>  'required|image',
                'bottom_first_image' =>  'required|image',
                'bottom_second_image' =>  'required|image',
                'bottom_third_image' =>  'required|image',
                'bottom_third_image' =>  'required|image',
            ]);
            $index = new   IndexBanner ;
        } else {
            $index = IndexBanner::find($request->id);
            $index->updated_at = now();
        }
        if ($request->hasFile('main_banner')) {
            Helper::deleteFile($index, 'main_banner');
            $index->main_banner = Helper::uploadFile($request->main_banner, 'uploads/image/', 'home');
        }
        if ($request->hasFile('left_side_banner')) {
            Helper::deleteFile($index, 'left_side_banner');
            $index->left_side_banner = Helper::uploadFile($request->left_side_banner, 'uploads/image/', 'home');
        }
        if ($request->hasFile('left_second_banner')) {
            Helper::deleteFile($index, 'left_second_banner');
            $index->left_second_banner = Helper::uploadFile($request->left_second_banner, 'uploads/image/', 'home');
        }
        if ($request->hasFile('bottom_first_image')) {
            Helper::deleteFile($index, 'bottom_first_image');
            $index->bottom_first_image = Helper::uploadFile($request->bottom_first_image, 'uploads/image/', 'home');
        }
        if ($request->hasFile('bottom_second_image')) {
            Helper::deleteFile($index, 'bottom_second_image');
            $index->bottom_second_image = Helper::uploadFile($request->bottom_second_image, 'uploads/image/', 'home');
        }
        if ($request->hasFile('bottom_fourth_image')) {
            Helper::deleteFile($index, 'bottom_fourth_image');
            $index->bottom_third_image = Helper::uploadFile($request->bottom_fourth_image, 'uploads/image/', 'home');
        }
        if ($request->hasFile('bottom_third_image')) {
            Helper::deleteFile($index, 'bottom_third_image');
            $index->bottom_fourth_image = Helper::uploadFile($request->bottom_third_image, 'uploads/image/', 'home');
        }

        $index->main_banner_attribute = $request->main_banner_attribute ?? '';
        $index->left_banner_attribute = $request->left_banner_attribute ?? '';
        $index->left_second_banner_attribute = $request->left_second_banner_attribute ?? '';
        $index->bottom_first_image_attribute = $request->bottom_first_image_attribute ?? '';
        $index->bottom_second_image_attribute = $request->bottom_second_image_attribute ?? '';
        $index->bottom_third_image_attribute = $request->bottom_third_image_attribute ?? '';
        $index->bottom_fourth_image_attribute = $request->bottom_fourth_image_attribute ?? '';
        if ($index->save()) {
            session()->flash('success', 'Home Page has been updated successfully');
            return redirect(Helper::sitePrefix() . 'home');
        } else {
            return back()->with('error', 'Error while updating the About details');
        }


    }
}
