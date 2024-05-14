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
                'deal_image' => 'required|image'
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
        if ($request->hasFile('deal_image')) {
            Helper::deleteFile($index, 'deal_image');
            $index->deal_image = Helper::uploadFile($request->deal_image, 'uploads/image/', 'home');
        }
        $index->main_banner_attribute = $request->main_banner_attribute ?? '';
        $index->left_banner_attribute = $request->left_banner_attribute ?? '';
        $index->left_second_banner_attribute = $request->left_second_banner_attribute ?? '';
        $index->bottom_first_image_attribute = $request->bottom_first_image_attribute ?? '';
        $index->bottom_second_image_attribute = $request->bottom_second_image_attribute ?? '';
        $index->bottom_third_image_attribute = $request->bottom_third_image_attribute ?? '';
        $index->bottom_third_image_attribute = $request->bottom_third_image_attribute ?? '';
        $index->deal_image_attribute = $request->deal_image_attribute ?? '';
        if ($index->save()) {
            session()->flash('success', 'Home Page has been updated successfully');
            return redirect(Helper::sitePrefix() . 'home');
        } else {
            return back()->with('error', 'Error while updating the About details');
        }


    }

    public function imageProcess(Request $request){
        if ($request->hasFile('upload') && $request->file('upload')->isValid()) {
            $image = $request->file('upload');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'public/uploads/' . $imageName;
            $storedImagePath = $image->storeAs('public/uploads', $imageName);
         
            $imageUrl = asset(str_replace('public', 'storage', $storedImagePath));
            return response()->json(['location' => $imageUrl]);
        }

        // If something goes wrong, return an error response
        return response()->json(['error' => 'Invalid image'], 400);

    }
        /*********************** Testimonial Starts here *******************************/
        public function testimonial()
        {
            $title = "Testimonial List";
            $testimonialList = Testimonial::where('user_type','Admin')->get();
            $home_heading = HomeHeading::where('type','testimonial')->first();
            return view('Admin.home.testimonial.list', compact('testimonialList', 'title','home_heading'));
        }
    
        public function testimonial_create()
        {
            $key = "Create";
            $title = "Create Testimonial";
        
     
            return view('Admin.home.testimonial.form', compact('key', 'title'));
        }
    
        public function testimonial_store(Request $request)
        {
            $validatedData = $request->validate([
                'name' => 'required',
                'message' => 'required',
                'image_attribute' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:512',
                'rating' => 'integer|between:0,5',
                'review_type' => 'required',
            ]);
    
            $testimonial = new Testimonial;
            if ($request->hasFile('image')) {
               $testimonial->image_webp = Helper::uploadWebpImage($request->image, 'uploads/testimonial/image/webp/', $request->title);
                $testimonial->image = Helper::uploadFile($request->image, 'uploads/testimonial/image/', $request->title);
            }
            $testimonial->name = $validatedData['name'];
            $testimonial->message = $validatedData['message'];
            $testimonial->designation = $request->designation;
            $testimonial->rating = $request->rating;
            $testimonial->user_type = "Admin";
            $testimonial->image_attribute = $request->image_attribute ?? '';
            $testimonial->review_type = $request->review_type;
    
    
            if ($testimonial->save()) {
                session()->flash('success', 'Testimonial has been added successfully');
                return redirect(Helper::sitePrefix() . 'home/testimonial');
            } else {
                return back()->withInput($request->input())->withErrors("Error while updating the content");
            }
        }
    
        public function testimonial_edit(Request $request, $id)
        {
    
            $key = "Update";
            $title = "Update Testimonial";
            $testimonial = Testimonial::find($id);
            if ($testimonial) {
                return view('Admin.home.testimonial.form', compact('testimonial', 'title', 'key'));
            } else {
                return view('Admin/errors/404');
            }
        }
    
        public function testimonial_update(Request $request, $id)
        {
            $testimonial = Testimonial::find($id);
            $validatedData = $request->validate([
                'name' => 'required',
                'message' => 'required',
                'image_attribute' => 'required',
                'rating' => 'integer|between:0,5',
            ]);
            if ($request->hasFile('image')) {
                if (File::exists(public_path($testimonial->image))) {
                    File::delete(public_path($testimonial->image));
                }
                if (File::exists(public_path($testimonial->image_webp))) {
                    File::delete(public_path($testimonial->image_webp));
                }
                $testimonial->image_webp = Helper::uploadWebpImage($request->image, 'uploads/testimonial/image/webp/', $request->name);
                $testimonial->image = Helper::uploadFile($request->image, 'uploads/testimonial/image/', $request->name);
            }
            $testimonial->name = $validatedData['name'];
            $testimonial->message = $validatedData['message'];
            $testimonial->designation = $request->designation;
            $testimonial->rating = $request->rating;
            $testimonial->image_attribute = $request->image_attribute ?? '';
            $testimonial->review_type = $request->review_type;
            $testimonial->updated_at = now();
            if ($testimonial->save()) {
                session()->flash('success', 'Testimonial has been updated successfully');
                return redirect(Helper::sitePrefix() . 'home/testimonial');
            } else {
                return back()->withInput($request->input())->withErrors("Error while updating the content");
            }
        }
    
        public function delete_testimonial(Request $request)
        {
            if (isset($request->id) && $request->id != NULL) {
                $testimonial = Testimonial::find($request->id);
                if ($testimonial) {
                    if (File::exists(public_path($testimonial->image))) {
                        File::delete(public_path($testimonial->image));
                    }
                    if (File::exists(public_path($testimonial->image_webp))) {
                        File::delete(public_path($testimonial->image_webp));
                    }
                    if ($testimonial->delete()) {
                        return response()->json(['status' => true]);
                    } else {
                        return response()->json(['status' => false, 'message' => 'Some error occurred,please try after sometime']);
                    }
                } else {
                    return response()->json(['status' => false, 'message' => 'Model class not found']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Empty value submitted']);
            }
        }
        public function usertestimonial()
        {
            $title = "User Testimonial List";
            $testimonialList = Testimonial::where('user_type','Customer')->latest()->get();
            return view('Admin.home.user_testimonial.list', compact('testimonialList', 'title'));
        }
        public function status_change(Request $request)
    {

         $table = $request->table;
         if($table == 'Category'){
           $category = Category::find($request->primary_key);
        $category_products = Product::whereRaw("FIND_IN_SET('" . $request->primary_key . "',category_id)")->orWhereRaw("FIND_IN_SET('" . $request->primary_key . "',sub_category_id)")->count();
        
              if($category_products > 0 && $request->state == 'false'){
                 return response()->json(['status' => false, 'message' => 'This category has products. So you can not change the status.']);
              }
              else{
               
             $state = $request->state;
    
             $primary_key = $request->primary_key;
             $field = $request->field ?? 'status';
             $limit = $request->limit;
             $limit_field = $request->limit_field;
             $limit_field_value = $request->limit_field_value;
             if ($state == 'true') {
                 $status = "Active";
             } else {
                 $status = "Inactive";
             }
             $model = 'App\\Models\\' . $table;
             $data = $model::find($primary_key);
     
             if ($limit && $status == "Active") {
                 if ($limit_field && $limit_field_value) {
                     $active_data = $model::where($limit_field, $limit_field_value)->Where($field, 'Active');
                 } else {
                     $active_data = $model::Where($field, 'Active');
                 }
                 if ($active_data->count() >= $limit) {
                     return response()->json([
                         'status' => false,
                         'message' => 'Only ' . $limit . ' active items is possible.'
                     ]);
                 }
             }
             $data->$field = $status;
             if ($data->save()) {
     
                 if($table=="Category"){
                     if($state !=="true")
                         {
                             $products = Product::whereIn('category_id', explode(',', $primary_key))->get();
                             $productIds = $products->pluck('id')->toArray();
                             $updateProduct = Product::whereIn('id',$productIds)
                             ->update(['status' => 'Inactive'
                         ]);
                         }
                 }
                 return response()->json([
                     'status' => true,
                     'message' => 'Status has been changed successfully.'
                 ]);
     
     
     
     
             } else {
                 return response()->json([
                     'status' => false,
                     'message' => 'Error while changing the status.'
                 ]);
             }
              }
         }
         else{

             $state = $request->state;
    
            $primary_key = $request->primary_key;
            $field = $request->field ?? 'status';
            $limit = $request->limit;
            $limit_field = $request->limit_field;
            $limit_field_value = $request->limit_field_value;
            if ($state == 'true') {
                $status = "Active";
            } else {
                $status = "Inactive";
            }
            $model = 'App\\Models\\' . $table;
            $data = $model::find($primary_key);
    
            if ($limit && $status == "Active") {
                if ($limit_field && $limit_field_value) {
                    $active_data = $model::where($limit_field, $limit_field_value)->Where($field, 'Active');
                } else {
                    $active_data = $model::Where($field, 'Active');
                }
                if ($active_data->count() >= $limit) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Only ' . $limit . ' active items is possible.'
                    ]);
                }
            }
            $data->$field = $status;
            if ($data->save()) {
    
                if($table=="Category"){
                    if($state !=="true")
                        {
                            $products = Product::whereIn('category_id', explode(',', $primary_key))->get();
                            $productIds = $products->pluck('id')->toArray();
                            $updateProduct = Product::whereIn('id',$productIds)
                            ->update(['status' => 'Inactive'
                        ]);
                        }
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Status has been changed successfully.'
                ]);
    
    
    
    
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Error while changing the status.'
                ]);
            }
         }

    }

    public function change_bool_status(Request $request)
    {
        $table = $request->table;
        $state = $request->state;
        $primary_key = $request->id;
        $field = $request->field;
        if ($state == 'true') {
            $status = "Yes";
        } else {
            $status = "No";
        }
        $model = 'App\\Models\\' . $table;
        $data = $model::find($primary_key);
        if ($data != NULL) {
            $data->$field = $status;
            if ($data->save()) {
                return response()->json(['status' => true, 'message' => Str::title(Str::replace('_', ' ', $field)) . ' status has been changed']);
            } else {
                return response()->json(['status' => false, 'message' => 'Error while changing the display to home option']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Error! Data not found']);
        }
    }
    public function change_order_status(Request $request)
    {
        if($request->order_id){
            $order = Order::find($request->order_id);
           
            if($order){
                $order->status = $request->order_status;
                if ($order->save()) {
                    return response()->json([
                       'status' => true,
                        'message' => 'Order has has been changed successfully'
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Error while changing the status'
                    ]);
                }
            }
            else {
                return response()->json([
                    'status' => false,
                    'message' => 'Couldn\'t find the order'
                ]);
            }
        }
        else {
            return response()->json([
                'status' => false,
                'message' => 'Couldn\'t find the order'
            ]);
        }
    
    }
    public function sort_order(Request $request)
    {
        if (isset($request->id) && $request->id != NULL) {
            $table = $request->table;
            $field = $request->field;
            $field_value = $request->field_value;
            $model = 'App\\Models\\' . $table;
            if ($field && $field_value) {
                $sortOrder = $model::where([['sort_order', '=', $request->sort_order], [$field, '=', $field_value], ['id', '!=', $request->id]])->count();
            } else {
                $sortOrder = $model::where([['sort_order', '=', $request->sort_order], ['id', '!=', $request->id]])->count();
            }
            // if ($sortOrder) {
            //     return response()->json(['status' => false, 'message' => 'Sort order "' . $request->sort_order . '" has been already taken']);
            // } else {
            // }
            $data = $model::find($request->id);
            $data->sort_order = $request->sort_order;
            if ($data->save()) {
                return response()->json(['status' => true, 'message' => 'Sort order updated successfully']);
            } else {
                return response()->json(['status' => false, 'message' => 'Error while updating the sort order']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Empty value submitted']);
        }
    }

    public function sub_categories(Request $request)
    {
        $subCategories = Category::whereIn('parent_id', $request->parentId)->orderBy('sort_order')->get();
        $subData = array();
        foreach ($subCategories as $sub) {
            $subData[] = array("id" => $sub->id, "title" => $sub->title);
        }
        return response()->json(['status' => true, 'message' => $subData]);
    }

        public function delete_usertestimonial(Request $request)
        {
            if (isset($request->id) && $request->id != NULL) {
                $testimonial = Testimonial::find($request->id);
                if ($testimonial) {
                    if (File::exists(public_path($testimonial->image))) {
                        File::delete(public_path($testimonial->image));
                    }
                    if (File::exists(public_path($testimonial->image_webp))) {
                        File::delete(public_path($testimonial->image_webp));
                    }
                    if ($testimonial->delete()) {
                        return response()->json(['status' => true]);
                    } else {
                        return response()->json(['status' => false, 'message' => 'Some error occurred,please try after sometime']);
                    }
                } else {
                    return response()->json(['status' => false, 'message' => 'Model class not found']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Empty value submitted']);
            }
        }
}
