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
    public function product_validate(){
       
        if(request()->copy != 'Copy'){
           
            $validatedData = request()->validate([
                'short_url' => 'required|unique:products,short_url,' . request()->id . ',id,deleted_at,NULL|min:2|max:255',
            ]);
        }
        else{
            $product = Product::where('id',request()->id)->first();
         
            if($product->product_type_id == request()->type){
                $validatedData = request()->validate([
                    'type' => 'required|unique:products,product_type_id,NULL,id,deleted_at,NULL',
                    'short_url' => 'required|unique:products,short_url,NULL,id,deleted_at,NULL|min:2|max:255',
                ]);
            }
            else{

                $validatedData = request()->validate([
                    'short_url' => 'required|unique:products,short_url,NULL,id,deleted_at,NULL|min:2|max:255',
                ]);
            }
        }
        // return the validated data
        return $validatedData;
        //
    }

    public function update_home_heading(Request $request)
    {


        if (isset($request->type)) {
             $home_heading = HomeHeading::type($request->type)->first();
            if (!$home_heading) {
                 $home_heading = new HomeHeading;
            }
            $home_heading->type = $request->type;
            $home_heading->title = $request->homeTitle;
            $home_heading->subtitle = $request->subtitle;
            $home_heading->description = $request->homeDescription;
            if ($home_heading->save()) {
                return response()->json(['status' => true, 'message' => 'Home heading for ' . $request->type . ' saved successfully']);
            } else {
                return response()->json(['status' => false, 'message' => 'Error while saving Home heading']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Empty value submitted']);
        }
    }

    public function ourcollection_create(Request $request)
    {
        $key = "Create";
        $title = "Create Our Collection";

        $collect = Homecollection::active()->first();
        return view('Admin.home.collection.form', compact('key', 'title','collect'));


    }

    public function ourselection_create(Request $request)
    {
            $key = "Create";
            $title = "Create Our Selection";
            $home_heading = HomeHeading::where('type','selection')->first();
            $firstSelection = DB::table('our_selection')->orderBy('sort_order','asc')->first();
            if($firstSelection != null){
                $secondSelection = DB::table('our_selection')->where('sort_order','!=',$firstSelection->sort_order)->orderBy('sort_order','asc')->first();
                $thirdSelection = DB::table('our_selection')->where('sort_order','!=',$firstSelection->sort_order)->where('sort_order','!=',$secondSelection->sort_order)->orderBy('sort_order','asc')->first();
                $fourthSelection = DB::table('our_selection')->where('sort_order','!=',$firstSelection->sort_order)->where('sort_order','!=',$secondSelection->sort_order)->where('sort_order','!=',$thirdSelection->sort_order)->orderBy('sort_order','asc')->first();
                $fifthSelection = DB::table('our_selection')->where('sort_order','!=',$firstSelection->sort_order)->where('sort_order','!=',$secondSelection->sort_order)->where('sort_order','!=',$thirdSelection->sort_order)->where('sort_order','!=',$fourthSelection->sort_order)->orderBy('sort_order','asc')->first();
                $sixthSelection = DB::table('our_selection')->where('sort_order','!=',$firstSelection->sort_order)->where('sort_order','!=',$secondSelection->sort_order)->where('sort_order','!=',$thirdSelection->sort_order)->where('sort_order','!=',$fourthSelection->sort_order)->where('sort_order','!=',$fifthSelection->sort_order)->orderBy('sort_order','asc')->first();
                $seventhSelection = DB::table('our_selection')->where('sort_order','!=',$firstSelection->sort_order)->where('sort_order','!=',$secondSelection->sort_order)->where('sort_order','!=',$thirdSelection->sort_order)->where('sort_order','!=',$fourthSelection->sort_order)->where('sort_order','!=',$fifthSelection->sort_order)->where('sort_order','!=',$sixthSelection->sort_order)->orderBy('sort_order','asc')->first();
                $eightSelection = DB::table('our_selection')->where('sort_order','!=',$firstSelection->sort_order)->where('sort_order','!=',$secondSelection->sort_order)->where('sort_order','!=',$thirdSelection->sort_order)->where('sort_order','!=',$fourthSelection->sort_order)->where('sort_order','!=',$fifthSelection->sort_order)->where('sort_order','!=',$sixthSelection->sort_order)->where('sort_order','!=',$seventhSelection->sort_order)->orderBy('sort_order','asc')->first();
            }
            else{
                $firstSelection = null;
                $secondSelection = null;
                $thirdSelection = null;
                $fourthSelection = null;
                $fifthSelection = null;
                $sixthSelection = null;
                $seventhSelection = null;
                $eightSelection = null;

            }

            $products = Product::where('parent_product_id',null)->where('copy','no')->active()->get();


        return view('Admin.selection.form', compact('key', 'title','home_heading','products','firstSelection','secondSelection','thirdSelection','fourthSelection','fifthSelection','sixthSelection','seventhSelection','eightSelection'));

    }

    public function selection_update(Request $request)
    {
        $validator = $request->validate([
            //max 8 products in array
            "product" => "required|max:8",
           

        ],
            [
                'product.required' => 'Please select at least one product',
                'product.max' => 'You can select maximum 8 products',
            ]
        );
        // dd($request->all());
        DB::table('our_selection')->delete();
        foreach($request->product as $key => $prd){
           
          DB::table('our_selection')
          ->insert([
            'product_id' => $prd,
            'sort_order' => $key+1,
          ]);
        }
        session()->flash('success', "selections  has been updated successfully");
        return redirect(Helper::sitePrefix() . 'home/our-selection/create');
    }
    public function ourcollection_store(Request $request)
    {

        // return $request->all();
        $this->validate($request, [
            'title' => 'required|min:2|max:255',
            'image_attribute' => 'required',
            'image_attribute2' => 'required',
            'image_attribute3' => 'required',
            'image_attribute4' => 'required',
            'image_attribute5' => 'required',
            'image_attribute6' => 'required',
            'description' => 'required|min:2|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg',
            'image4' => 'nullable|image|mimes:jpeg,png,jpg',
            'image5' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);
    //    return  $request->all();

        if ($request->id == 0) {
            $collection = new Homecollection;
        } else {
            $collection = Homecollection::find($request->id);
            $collection->updated_at = now();
        }
        if ($request->hasFile('image')) {
            Helper::deleteFile($collection, 'image');
            Helper::deleteFile($collection, 'image_webp');

            $collection->mobile_image_webp = Helper::uploadWebpImage($request->image, 'uploads/home/banner/desktop_image/webp/', $request->title);
            $collection->mobile_image = Helper::uploadFile($request->image, 'uploads/home/banner/mobile_image/', $request->title);
        }
        if ($request->hasFile('image1')) {
            Helper::deleteFile($collection, 'mobile_image1');
            Helper::deleteFile($collection, 'mobile_image_webp1');

            $collection->mobile_image_webp1 = Helper::uploadWebpImage($request->image1, 'uploads/home/banner/mobile_image/webp/', $request->title);
            $collection->mobile_image1 = Helper::uploadFile($request->image1, 'uploads/home/banner/mobile_image/', $request->title);
        }
        if ($request->hasFile('image2')) {
            Helper::deleteFile($collection, 'mobile_image2');
            Helper::deleteFile($collection, 'mobile_image_webp2');

            $collection->mobile_image_webp2 = Helper::uploadWebpImage($request->image2, 'uploads/home/banner/mobile_image/webp/', $request->title);
            $collection->mobile_image2 = Helper::uploadFile($request->image2, 'uploads/home/banner/mobile_image/', $request->title);
        }
        if ($request->hasFile('image3')) {
            Helper::deleteFile($collection, 'mobile_image3');
            Helper::deleteFile($collection, 'mobile_image_webp3');

            $collection->mobile_image_webp3 = Helper::uploadWebpImage($request->image3, 'uploads/home/banner/mobile_image/webp/', $request->title);
            $collection->mobile_image3 = Helper::uploadFile($request->image3, 'uploads/home/banner/mobile_image/', $request->title);
        }
        if ($request->hasFile('image4')) {
            Helper::deleteFile($collection, 'mobile_image4');
            Helper::deleteFile($collection, 'mobile_image_webp4');

            $collection->mobile_image_webp4 = Helper::uploadWebpImage($request->image4, 'uploads/home/banner/mobile_image/webp/', $request->title);
            $collection->mobile_image4 = Helper::uploadFile($request->image4, 'uploads/home/banner/mobile_image/', $request->title);
        }
        if ($request->hasFile('image5')) {
            Helper::deleteFile($collection, 'mobile_image5');
            Helper::deleteFile($collection, 'mobile_image_webp5');

            $collection->mobile_image_webp5 = Helper::uploadWebpImage($request->image5, 'uploads/home/banner/mobile_image/webp/', $request->title);
            $collection->mobile_image5 = Helper::uploadFile($request->image5, 'uploads/home/banner/mobile_image/', $request->title);
        }
        $collection->title = $request->title;
        $collection->description = $request->description;
        $collection->image_attribute6 = $request->image_attribute6;
        $collection->image_attribute5 = $request->image_attribute5;
        $collection->image_attribute4 = $request->image_attribute4;
        $collection->image_attribute3 = $request->image_attribute3;
        $collection->image_attribute2 = $request->image_attribute2;
        $collection->image_attribute = $request->image_attribute;
        $collection->title1 = $request->title1;
        $collection->title2 = $request->title2;
        $collection->title3 = $request->title3;
        $collection->title4 = $request->title4;
        $collection->title5 = $request->title5;
        $collection->title6 = $request->title6;
        $collection->description1 = $request->description1;
        $collection->description2 = $request->description2;
        $collection->description3 = $request->description3;
        $collection->description4 = $request->description4;
        $collection->description5 = $request->description5;
        $collection->description6 = $request->description6;
        $collection->short_url1 = $request->shorturl1;
        $collection->short_url2 = $request->shorturl2;
        $collection->short_url3 = $request->shorturl3;
        $collection->short_url4 = $request->shorturl4;
        $collection->short_url5 = $request->shorturl5;
        $collection->short_url6 = $request->shorturl6;




        if ($collection->save()) {
            session()->flash('success', "Our collection image has been updated successfully");
            return redirect(Helper::sitePrefix() . 'home/our-collection/create');
        } else {
            return back()->with('error', 'Error while updating the Our collection');
        }



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


    /*********************** Banners Starts here *******************************/
    public function banner()
    {
        $title = "Home Slider List";
        $bannerList = HomeBanner::get();
        return view('Admin.home.banner.list', compact('bannerList', 'title'));
    }


    public function banner_create()
    {
        $key = "Create";
        $title = "Create Home Slider";
        return view('Admin.home.banner.form', compact('key', 'title'));
    }

    public function banner_store(Request $request)
    {

        $validatedData = $request->validate([
//            'title' => 'required|min:2|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'image_attribute' => 'required|min:5',
        ]);
        $banner = new HomeBanner;
        if ($request->hasFile('image')) {
            $banner->desktop_image_webp = Helper::uploadWebpImage($request->image, 'uploads/home/banner/desktop_image/webp/', $request->title);
            $banner->desktop_image = Helper::uploadFile($request->image, 'uploads/home/banner/desktop_image/', $request->title);
        }

       $banner->title = $request->title;
       $banner->subtitle = $request->sub_title;
       $banner->button_text = $request->button_text;
       $banner->description= $request->description;
        $banner->image_attribute = $validatedData['image_attribute'];
        $banner->url = $request->url;
        $sort_order = HomeBanner::latest('sort_order')->first();
        if ($sort_order) {
            $sort_number = ($sort_order->sort_order + 1);
        } else {
            $sort_number = 1;
        }
        $banner->sort_order = $sort_number;

        if ($banner->save()) {
            session()->flash('success', "Home Slider image has been added successfully");
            return redirect(Helper::sitePrefix() . 'home/banner');
        } else {
            return back()->with('error', 'Error while creating the banner');
        }
    }


    public function banner_edit(Request $request, $id)
    {
        $key = "Update";
        $title = "Update Home Slider";
        $banner = HomeBanner::find($id);
        if ($banner) {
            return view('Admin.home.banner.form', compact('key', 'banner', 'title'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function banner_update(Request $request, $id)
    {
        $banner = HomeBanner::find($id);
        $validatedData = $request->validate([
//            'title' => 'required|min:2|max:255',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'mobile_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'image_attribute' => 'required|min:5',
        ]);
        if ($request->hasFile('image')) {
            Helper::deleteFile($banner, 'desktop_image');
            Helper::deleteFile($banner, 'desktop_image_webp');

            $banner->desktop_image_webp = Helper::uploadWebpImage($request->image, 'uploads/home/banner/desktop_image/webp/', $request->title);
            $banner->desktop_image = Helper::uploadFile($request->image, 'uploads/home/banner/desktop_image/', $request->title);
        }
        //        $banner->title = $request->title;
        $banner->title = $request->title;
        $banner->subtitle = $request->sub_title;
        $banner->button_text = $request->button_text;
        $banner->description= $request->description;
        $banner->image_attribute = $validatedData['image_attribute'];
        $banner->url = $request->url;
        $banner->updated_at = now();
        if ($banner->save()) {
            session()->flash('success', "Home Slider image has been updated successfully");
            return redirect(Helper::sitePrefix() . 'home/banner');
        } else {
            return back()->with('error', 'Error while updating the banner');
        }
    }
    public function banner_update2(Request $request, $id)
    {
        $banner = HomeBanner::find($id);
        $validatedData = $request->validate([
//            'title' => 'required|min:2|max:255',
            'desktop_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'mobile_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'image_attribute' => 'required|min:5',
        ]);
        if ($request->hasFile('desktop_image')) {
            Helper::deleteFile($banner, 'desktop_image');
            Helper::deleteFile($banner, 'desktop_image_webp');

            $banner->desktop_image_webp = Helper::uploadWebpImage($request->desktop_image, 'uploads/home/banner/desktop_image/webp/', $request->title);
            $banner->desktop_image = Helper::uploadFile($request->desktop_image, 'uploads/home/banner/desktop_image/', $request->title);
        }
        if ($request->hasFile('mobile_image')) {
            Helper::deleteFile($banner, 'mobile_image');
            Helper::deleteFile($banner, 'mobile_image_webp');

            $banner->mobile_image_webp = Helper::uploadWebpImage($request->mobile_image, 'uploads/home/banner/mobile_image/webp/', $request->title);
            $banner->mobile_image = Helper::uploadFile($request->mobile_image, 'uploads/home/banner/mobile_image/', $request->title);
        }
//        $banner->title = $request->title;
        $banner->image_attribute = $validatedData['image_attribute'];
        $banner->url = $request->url;

        $banner->updated_at = now();
        if ($banner->save()) {
            session()->flash('success', "Home Banner image has been updated successfully");
            return redirect(Helper::sitePrefix() . 'home-ecommerce/banner');
        } else {
            return back()->with('error', 'Error while updating the banner');
        }
    }

    public function delete_banner(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $banner = HomeBanner::find($request->id);
            if ($banner) {
                Helper::deleteFile($banner, 'desktop_image');
                Helper::deleteFile($banner, 'desktop_image_webp');
                Helper::deleteFile($banner, 'mobile_image');
                Helper::deleteFile($banner, 'mobile_image_webp');

                $banner->desktop_image = '';
                $banner->mobile_image = '';
                $banner->desktop_image_webp = '';
                $banner->mobile_image_webp = '';
                $banner->save();
                if ($banner->delete()) {
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
    public function delete_banner2(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $banner = HomeBanner::find($request->id);
            if ($banner) {
                Helper::deleteFile($banner, 'desktop_image');
                Helper::deleteFile($banner, 'desktop_image_webp');
                Helper::deleteFile($banner, 'mobile_image');
                Helper::deleteFile($banner, 'mobile_image_webp');

                $banner->desktop_image = '';
                $banner->mobile_image = '';
                $banner->desktop_image_webp = '';
                $banner->mobile_image_webp = '';
                $banner->save();
                if ($banner->delete()) {
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


    /***********************  Hot deals Starts here *******************************/
    public function hot_deals()
    {
        $title = "Hot Deal List";
        $hotDealList = HotDeal::latest()->get();
        return view('Admin.home.hot_deal.list', compact('hotDealList', 'title'));
    }

    public function hot_deal_create()
    {
        $key = "Create";
        $title = "Create Hot Deal";
        return view('Admin.home.hot_deal.form', compact('key', 'title'));
    }

    public function hot_deal_store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:512',
            'image_attribute' => 'required',
        ]);
        $hot_deal = new HotDeal;
        if ($request->hasFile('image')) {
            $hot_deal->image_webp = Helper::uploadWebpImage($request->image, 'uploads/home/hot_deal/webp/', $request->title);
            $hot_deal->image = Helper::uploadFile($request->image, 'uploads/home/hot_deal/', $request->title);
        }
        $hot_deal->title = $validatedData['title'];
        $hot_deal->image_attribute = $validatedData['image_attribute'];
        $hot_deal->url = $request->url ?? '';
        if ($hot_deal->save()) {
            session()->flash('success', "Hot deal  '" . $request->title . "' has been added successfully");
            return redirect(Helper::sitePrefix() . 'home/hot-deal');
        } else {
            return back()->with('error', 'Error while creating the hot deal');
        }
    }

    public function hot_deal_edit($id)
    {
        $key = "Update";
        $title = "Update Hot Deal";
        $hot_deal = HotDeal::find($id);
        if ($hot_deal) {
            return view('Admin.home.hot_deal.form', compact('key', 'hot_deal', 'title'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function hot_deal_update(Request $request, $id)
    {
        $hot_deal = HotDeal::find($id);
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:255',
            'image_attribute' => 'required',
        ]);
        if ($request->hasFile('image')) {
            if (File::exists(public_path($hot_deal->image))) {
                File::delete(public_path($hot_deal->image));
            }
            if (File::exists(public_path($hot_deal->image_webp))) {
                File::delete(public_path($hot_deal->image_webp));
            }
            $hot_deal->image_webp = Helper::uploadWebpImage($request->image, 'uploads/home/hot_deal/webp/', $request->title);
            $hot_deal->image = Helper::uploadFile($request->image, 'uploads/home/hot_deal/', $request->title);
        }
        $hot_deal->title = $validatedData['title'];
        $hot_deal->image_attribute = $validatedData['image_attribute'];
        $hot_deal->url = $request->url ?? '';
        $hot_deal->updated_at = now();
        if ($hot_deal->save()) {
            session()->flash('success', "Hot deal '" . $request->title . "' has been updated successfully");
            return redirect(Helper::sitePrefix() . 'home/hot-deal');
        } else {
            return back()->with('error', 'Error while updating the hot deal');
        }
    }

    public function delete_hot_deal(Request $request)
    {
        if (isset($request->id) && $request->id != NULL) {
            $hot_deal = HotDeal::find($request->id);
            if ($hot_deal) {
                if (File::exists(public_path($hot_deal->image))) {
                    File::delete(public_path($hot_deal->image));
                }
                if (File::exists(public_path($hot_deal->image_webp))) {
                    File::delete(public_path($hot_deal->image_webp));
                }
                if ($hot_deal->delete()) {
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


    /*********************** Key features Starts here *******************************/
    public function key_feature()
    {
        $title = "Key Feature List";
        $keyFeatureList = KeyFeature::latest()->get();
        return view('Admin.home.key_feature.list', compact('keyFeatureList', 'title'));
    }

    public function key_feature_create()
    {
        $key = "Create";
        $title = "Create Key Feature";
        return view('Admin.home.key_feature.form', compact('key', 'title'));
    }

    public function key_feature_store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|min:2|max:255',
            'image' => 'required|image|mimes:svg|max:512',
            'image_attribute' => 'required',
        ]);
        $keyFeature = new KeyFeature;
        if ($request->hasFile('image')) {
            $keyFeature->image = Helper::uploadFile($request->image, 'uploads/home/key_feature/', $request->title);
        }
        $keyFeature->title = $validatedData['title'];
        $keyFeature->image_attribute = $validatedData['image_attribute'];
        $sort_order = KeyFeature::latest('sort_order')->first();
        if ($sort_order) {
            $sort_number = ($sort_order->sort_order + 1);
        } else {
            $sort_number = 1;
        }
        $keyFeature->sort_order = $sort_number;
        if (KeyFeature::active()->count() >= 4) {
            $keyFeature->status = 'Inactive';
        }
        if ($keyFeature->save()) {
            session()->flash('success', "Key Feature '" . $request->title . "' has been added successfully");
            return redirect(Helper::sitePrefix() . 'home/key-feature');
        } else {
            return back()->with('error', 'Error while creating the key Feature');
        }
    }

    public function key_feature_edit(Request $request, $id)
    {
        $key = "Update";
        $title = "Update Key Feature";
        $keyFeature = KeyFeature::find($id);
        if ($keyFeature) {
            return view('Admin.home.key_feature.form', compact('key', 'keyFeature', 'title'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function key_feature_update(Request $request, $id)
    {
        $keyFeature = KeyFeature::find($id);
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:255',
            'image_attribute' => 'required',
        ]);
        if ($request->hasFile('image')) {
            if (File::exists(public_path($keyFeature->image))) {
                File::delete(public_path($keyFeature->image));
            }
            $keyFeature->image = Helper::uploadFile($request->image, 'uploads/home/key_feature/', $request->title);
        }
        $keyFeature->title = $validatedData['title'];
        $keyFeature->image_attribute = $validatedData['image_attribute'];
        $keyFeature->updated_at = now();
        if ($keyFeature->save()) {
            session()->flash('success', "Key Feature'" . $request->title . "' has been updated successfully");
            return redirect(Helper::sitePrefix() . 'home/key-feature');
        } else {
            return back()->with('error', 'Error while updating the Key Feature');
        }
    }

    public function delete_key_feature(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $keyFeature = KeyFeature::find($request->id);
            if ($keyFeature) {
                if (File::exists(public_path($keyFeature->image))) {
                    File::delete(public_path($keyFeature->image));
                }
                $keyFeature->image = '';
                $keyFeature->save();
                if ($keyFeature->delete()) {
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

    public function home_get_quote()
    {
        $key = "Update";
        $title = "Get A Quote";
        $quote = HomeGetQuote::where('type','=','corporate')->first();
        return view('Admin.home.home_get_quote_form', compact('key', 'title', 'quote'));
    }
    public function home_get_quote2()
    {
        $key = "Update";
        $title = "Get A Quote";
        $quote = HomeGetQuote::where('type','=','ecommerce')->first();
        return view('Admin.home.home_get_quote_form2', compact('key', 'title', 'quote'));
    }



    public function home_get_quote_store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:225',
            'description' => 'required|min:2',
            'image' => 'image|mimes:jpeg,png,jpg|max:512',
            'image_attribute' => 'required|min:5',
            'button_text' => 'required|min:2',
        ]);

        if ($request->id == 0) {
            $quote = new HomeGetQuote();
        } else {
            $quote = HomeGetQuote::find($request->id);
            $quote->updated_at = date('Y-m-d h:i:s');
        }
        if ($request->hasFile('image')) {
            Helper::deleteFile($quote, 'image');
            Helper::deleteFile($quote, 'image_webp');
            $quote->image_webp = Helper::uploadWebpImage($request->image, 'uploads/home/get_quote/image/', 'get-quote');
            $quote->image = Helper::uploadFile($request->image, 'uploads/home/get_quote/image_webp/', 'get-quote');
        }

        $quote->title = $request->title ?? '';
        $quote->type = "corporate";
        $quote->description = $request->description ?? '';
        $quote->image_attribute = $request->image_attribute ?? '';
        $quote->button_text = $request->button_text ?? '';
        if ($quote->save()) {
            session()->flash('success', 'Home-Get A Quote content has been updated successfully');
            return redirect(Helper::sitePrefix() . 'home-corporate/get-a-quote');
        } else {
            return back()->with('error', 'Error while updating the home-get a quote content');
        }
    }
    public function home_get_quote_store2(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:225',
            'description' => 'required|min:2',
            'image' => 'image|mimes:jpeg,png,jpg|max:512',
            'image_attribute' => 'required|min:5',
            'button_text' => 'required|min:2',
        ]);

        if ($request->id == 0) {
            $quote = new HomeGetQuote();
        } else {
            $quote = HomeGetQuote::find($request->id);
            $quote->updated_at = date('Y-m-d h:i:s');
        }
        if ($request->hasFile('image')) {
            Helper::deleteFile($quote, 'image');
            Helper::deleteFile($quote, 'image_webp');
            $quote->image_webp = Helper::uploadWebpImage($request->image, 'uploads/home/get_quote/image/', 'get-quote');
            $quote->image = Helper::uploadFile($request->image, 'uploads/home/get_quote/image_webp/', 'get-quote');
        }

        $quote->title = $request->title ?? '';
        $quote->type = "ecommerce";
        $quote->description = $request->description ?? '';
        $quote->image_attribute = $request->image_attribute ?? '';
        $quote->button_text = $request->button_text ?? '';
        if ($quote->save()) {
            session()->flash('success', 'Home-Get A Quote content has been updated successfully');
            return redirect(Helper::sitePrefix() . 'home-ecommerce/get-a-quote');
        } else {
            return back()->with('error', 'Error while updating the home-get a quote content');
        }
    }


    /*********************** Banners Starts here *******************************/
    public function advertisement()
    {
        $title = "Home Slider List";
    $advertisementList = HomeAdvertisement::orderBy('sort_order','desc')->where('type','=','corporate')->get();
        return view('Admin.home.advertisement.list', compact('advertisementList', 'title'));
    }
    public function latest_product()
    {
        $title = "latest product List";
       $productList = Product::active()->where('latest', 'Yes')->take(4)->get();
       $count = count($productList);
        return view('Admin.home.latest.list', compact('productList', 'title','count'));
    }

    public function latest_create()
    {
        $key = "Create";
        $title = "Create latest Product";
        // $measurement_units = MeasurementUnit::active()->get();
        // $brands = Brand::active()->get();
        // $tags = Tag::active()->get();
        // $categories = Category::active()->whereNull('parent_id')->get();
        // $colors = Color::active()->get();
        // $products = Product::active()->get();
       $latest = Latest::where('id', 1)->first();

        $products = Product::active()->get();
        return view('Admin.home.latest.form', compact('key', 'title', 'products','latest'));
    }

    // public function latest_store(Request $request)
    // {


    //     DB::beginTransaction();
    //     $validatedData = $request->validate([
    //         'product' => 'required|min:2|max:255',

    //     ]);

    //     if ($product->save()) {
    //         $similarProducts = [];
    //         $errorArray = $successArray = [];

    //         if (empty($errorArray)) {
    //             session()->flash('success', "Product '" . $product->title . "' has been added successfully");

    //         } else {
    //             session()->flash('error', "Error while added the product '" . $product->title . "'");

    //         }
    //         return redirect(Helper::sitePrefix() . 'home-ecommerce/latest');
    //     } else {

    //         return back()->withInput($request->input())->withErrors("Error while updating the product");
    //     }
    // }


    public function advertisement2()
    {
        $title = "Home Slider List";
        $advertisementList = HomeAdvertisement::orderBy('sort_order','desc')->where('type','=','ecommerce')->get();
        return view('Admin.home.advertisement.list2', compact('advertisementList', 'title'));
    }

    public function advertisement_create()
    {
        $key = "Create";
        $title = "Create Home Advertisement";
        return view('Admin.home.advertisement.form', compact('key', 'title'));
    }

    public function advertisement_create2()
    {
        $key = "Create";
        $title = "Create Home Advertisement";
        return view('Admin.home.advertisement.form2', compact('key', 'title'));
    }

    public function advertisement_store(Request $request)
    {
        $validatedData = $request->validate([
//            'title' => 'nullable|min:2|max:255',
            'desktop_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'mobile_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'image_attribute' => 'required|min:5',
        ]);
        $advertisement = new HomeAdvertisement();
        if ($request->hasFile('desktop_image')) {
            $advertisement->desktop_image_webp = Helper::uploadWebpImage($request->desktop_image, 'uploads/home/advertisement/desktop_image/webp/', $request->title);
            $advertisement->desktop_image = Helper::uploadFile($request->desktop_image, 'uploads/home/advertisement/desktop_image/', $request->title);
        }
        if ($request->hasFile('mobile_image')) {
            $advertisement->mobile_image_webp = Helper::uploadWebpImage($request->mobile_image, 'uploads/home/advertisement/mobile_image/webp/', $request->title);
            $advertisement->mobile_image = Helper::uploadFile($request->mobile_image, 'uploads/home/advertisement/mobile_image/', $request->title);
        }
//        $advertisement->title = $validatedData['title'];
        $advertisement->url = $request->url;
        $advertisement->image_attribute = $validatedData['image_attribute'];
        $sort_order = HomeAdvertisement::latest('sort_order')->first();
        if ($sort_order) {
            $sort_number = ($sort_order->sort_order + 1);
        } else {
            $sort_number = 1;
        }
        $advertisement->sort_order = $sort_number;
        $advertisement->type="corporate";
        if ($advertisement->save()) {
            session()->flash('success', "Home Advertisement has been added successfully");
            return redirect(Helper::sitePrefix() . 'home-corporate/advertisement');
        } else {
            return back()->with('error', 'Error while creating the Advertisement');
        }
    }
    public function advertisement_store2(Request $request)
    {
        $validatedData = $request->validate([
//            'title' => 'nullable|min:2|max:255',
            'desktop_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'mobile_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'image_attribute' => 'required|min:5',
        ]);
        $advertisement = new HomeAdvertisement();
        if ($request->hasFile('desktop_image')) {
            $advertisement->desktop_image_webp = Helper::uploadWebpImage($request->desktop_image, 'uploads/home/advertisement/desktop_image/webp/', $request->title);
            $advertisement->desktop_image = Helper::uploadFile($request->desktop_image, 'uploads/home/advertisement/desktop_image/', $request->title);
        }
        if ($request->hasFile('mobile_image')) {
            $advertisement->mobile_image_webp = Helper::uploadWebpImage($request->mobile_image, 'uploads/home/advertisement/mobile_image/webp/', $request->title);
            $advertisement->mobile_image = Helper::uploadFile($request->mobile_image, 'uploads/home/advertisement/mobile_image/', $request->title);
        }
//        $advertisement->title = $validatedData['title'];
        $advertisement->url = $request->url;
        $advertisement->image_attribute = $validatedData['image_attribute'];
        $sort_order = HomeAdvertisement::latest('sort_order')->first();
        if ($sort_order) {
            $sort_number = ($sort_order->sort_order + 1);
        } else {
            $sort_number = 1;
        }
        $advertisement->sort_order = $sort_number;
        $advertisement->type="ecommerce";
        if ($advertisement->save()) {
            session()->flash('success', "Home Advertisement has been added successfully");
            return redirect(Helper::sitePrefix() . 'home-ecommerce/advertisement');
        } else {
            return back()->with('error', 'Error while creating the Advertisement');
        }
    }

    public function advertisement_edit(Request $request, $id)
    {
        $key = "Update";
        $title = "Update Home Advertisement";
        $advertisement = HomeAdvertisement::find($id);
        if ($advertisement) {
            return view('Admin.home.advertisement.form', compact('key', 'advertisement', 'title'));
        } else {
            return view('Admin.error.404');
        }
    }
    public function advertisement_edit2(Request $request, $id)
    {
        $key = "Update";
        $title = "Update Home Advertisement";
        $advertisement = HomeAdvertisement::find($id);
        if ($advertisement) {
            return view('Admin.home.advertisement.form2', compact('key', 'advertisement', 'title'));
        } else {
            return view('Admin.error.404');
        }
    }
    public function latest_edit(Request $request, $id)
    {
        $key = "Update";
        $title = "Update Latest Product";
        $product = Product::find($id);
        if ($product) {
            $colors = Color::active()->get();
            $measurement_units = MeasurementUnit::active()->get();
            $brands = Brand::active()->get();
            $tags = Tag::active()->get();
            $categories = Category::active()->whereNull('parent_id')->get();
            $subCategories = Category::whereIn('parent_id', explode(',', $product->category_id))->active()->where('id', '!=', $id)->get();
            $products = Product::active()->get();
            return view('Admin.home.latest.form', compact('key', 'title', 'measurement_units', 'categories', 'products', 'product', 'subCategories', 'brands', 'tags', 'colors'));
        } else {
            return view('Admin.error.404');
        }
    }
    public function latest_update(Request $request, $id)
    {
        DB::beginTransaction();
        $productShortExist = Product::where([['short_url', '=', $request->short_url], ['id', '!=', $id]])->count();
        if ($productShortExist > 0) {
            return back()->withInput($request->input())->withErrors("Short url '" . $request->short_url . "' already exist");
        } else {
            $product = Product::find($id);
            $validatedData = $request->validate([
                'title' => 'required|min:2|max:255',
                'short_url' => 'required|unique:products,short_url,' . $id . ',id,deleted_at,NULL|min:2|max:255',
                'sku' => 'required',
//                'brand' => 'required',
                'category' => 'required',
                'availability' => 'required',
                'description' => 'required',
//                'measurement_unit' => 'required',
//                'quantity' => 'required',
                'price' => 'required',
                'thumbnail_image' => 'image|mimes:jpeg,png,jpg|max:10240',
            ]);
            if ($request->hasFile('thumbnail_image')) {
                if (File::exists(public_path($product->thumbnail_image))) {
                    File::delete(public_path($product->thumbnail_image));
                }
                if (File::exists(public_path($product->thumbnail_image_webp))) {
                    File::delete(public_path($product->thumbnail_image_webp));
                }
                $product->thumbnail_image_webp = Helper::uploadWebpImage($request->thumbnail_image, 'uploads/product/image/webp/', $request->short_url);
                $product->thumbnail_image = Helper::uploadFile($request->thumbnail_image, 'uploads/product/image/', $request->short_url);
            }
            if ($request->hasFile('desktop_banner')) {
                if (File::exists(public_path($product->desktop_banner))) {
                    File::delete(public_path($product->desktop_banner));
                }
                if (File::exists(public_path($product->desktop_banner_webp))) {
                    File::delete(public_path($product->desktop_banner_webp));
                }
                $product->desktop_banner_webp = Helper::uploadWebpImage($request->desktop_banner, 'uploads/product/desktop_banner/webp/', $request->short_url);
                $product->desktop_banner = Helper::uploadFile($request->desktop_banner, 'uploads/product/desktop_banner/', $request->short_url);
            }
            if ($request->hasFile('mobile_banner')) {
                if (File::exists(public_path($product->mobile_banner))) {
                    File::delete(public_path($product->mobile_banner));
                }
                if (File::exists(public_path($product->mobile_banner_webp))) {
                    File::delete(public_path($product->mobile_banner_webp));
                }
                $product->mobile_banner_webp = Helper::uploadWebpImage($request->mobile_banner, 'uploads/product/mobile_banner/webp/', $request->short_url);
                $product->mobile_banner = Helper::uploadFile($request->mobile_banner, 'uploads/product/mobile_banner/', $request->short_url);
            }
            if ($request->hasFile('featured_image')) {
                if (File::exists(public_path($product->featured_image))) {
                    File::delete(public_path($product->featured_image));
                }
                if (File::exists(public_path($product->featured_image_webp))) {
                    File::delete(public_path($product->featured_image_webp));
                }
                $product->featured_image = Helper::uploadWebpImage($request->featured_image, 'uploads/product/featured_image/webp/', $request->short_url);
                $product->featured_image_webp = Helper::uploadFile($request->featured_image, 'uploads/product/featured_image/', $request->short_url);
            }

            if ($request->hasFile('product_manual')) {
                if (File::exists(public_path($product->product_manual))) {
                    File::delete(public_path($product->product_manual));
                }
                $product->product_manual = Helper::uploadFile($request->product_manual, 'uploads/product/product_manual/', $request->short_url);
            }
            $product->title = $validatedData['title'];
            $product->short_url = $validatedData['short_url'];
            $product->sku = $request->sku ?? '';
            $product->category_id = ($request->category) ? implode(',', $request->category) : '';
            $product->sub_category_id = ($request->sub_category) ? implode(',', $request->sub_category) : '';
            $product->type = $request->product_type;
            $product->availability = $request->availability ?? '';
            if ($product->availability == "In Stock") {
                $product->stock = $request->stock;
                $product->alert_quantity = $request->alert_quantity;
            } else {
                $product->stock = 0;
                $product->alert_quantity = 0;
            }
            $product->featured_image_attribute = $request->featured_image_attribute ?? '';
            $product->featured_video_url = $request->featured_video_url ?? '';
            $product->featured_description = $request->featured_description ?? '';
            $product->latest ="Yes";
            $product->color_id = $request->color;
            $product->capacity = $request->capacity;
            $product->description = $validatedData['description'];
            $product->quantity = $request->quantity ?? '';
            $product->price = $request->price ?? '';
            $product->thumbnail_image_attribute = $request->image_meta_tag ?? '';
            $product->similar_product_id = ($request->similar_product_id) ? implode(',', $request->similar_product_id) : '';


//            $product->description = $validatedData['description'];
//            $product->measurement_unit_id = $request->measurement_unit ?? '';
//            $product->quantity = $request->quantity ?? '';
//            $product->brand_id = $request->brand ?? '';
//            $product->price = $request->price ?? '';
//            $product->tag_id = ($request->tag_id) ? implode(',', $request->tag_id) : '';
//            $product->thumbnail_image_attribute = $request->image_meta_tag ?? '';
//            $product->similar_product_id = ($request->similar_product_id) ? implode(',', $request->similar_product_id) : '';
//            $product->add_on_id = ($request->addon_id) ? implode(',', $request->addon_id) : '';
            $product->related_product_id = ($request->related_product_id) ? implode(',', $request->related_product_id) : '';
            $product->banner_title = $request->banner_title ?? '';
            $product->banner_attribute = $request->banner_attribute ?? '';
            $product->meta_title = $request->meta_title ?? '';
            $product->meta_description = $request->meta_description ?? '';
            $product->meta_keyword = $request->meta_keyword ?? '';
            $product->other_meta_tag = $request->other_meta_tag ?? '';
            $product->updated_at = now();
            if ($product->save()) {
                $similarProducts = [];
                $errorArray = $successArray = [];
                if ($product->similar_product_id != NULL) {
                    $similarProducts = explode(',', $product->similar_product_id);
                    $similarProducts[] = $id;
                    $combinedResult = $this->combinationArrays($similarProducts, 2);
                    foreach ($combinedResult as $combine => $value) {
                        $productData = Product::find($combine);
                        $productData->similar_product_id = implode(',', $value);
                        if ($productData->save()) {
                            $successArray[] = 1;
                        } else {
                            $errorArray[] = 1;
                        }
                    }
                }
                if (empty($errorArray)) {
                    session()->flash('success', "Product '" . $product->title . "' has been updated successfully");
                    DB::commit();
                } else {
                    session()->flash('error', "Error while updating the product '" . $product->title . "'");
                    DB::rollBack();
                }
                return redirect(Helper::sitePrefix() . 'home-ecommerce/latest');
            } else {
                DB::rollBack();
                return back()->withInput($request->input())->withErrors("Error while updating the product");
            }
        }
    }
    public function latest_update2(Request $request)
    {

        $validator = $request->validate([
            "title"    => "required",
            "description"    => "required",
            "product"    => "required|array|max:4",
            "product.*"  => "required|string|distinct|min:0",
        ]);
      $title =  $request->title;
    $description =  $request->description;


     $updatelatest = Latest::where('id',1)
     ->update(['title' => $title,
    'description' => $description]);

     $all = $request->product;

    if(!empty($all))
    {
       $updateProduct = Product::whereIn('id',$all)
                  ->update(['latest' => 'Yes']);

                  $updateProduct = Product::whereNotIn('id',$all)
                  ->update(['latest' => 'No']);

    }
    else
    {
        $updateProduct = Product::where('id', '>', 0)->update(['latest' => 'No']);
    }

        session()->flash('success', "latest Product  has been updated successfully");
        return redirect(Helper::sitePrefix() . 'home-ecommerce/latest');

    }
    public function advertisement_update(Request $request, $id)
    {
        $advertisement = HomeAdvertisement::find($id);
        $validatedData = $request->validate([
//            'title' => 'nullable|min:2|max:255',
            'desktop_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'mobile_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'image_attribute' => 'required|min:5',        ]);
        if ($request->hasFile('desktop_image')) {
            Helper::deleteFile($advertisement, 'desktop_image');
            Helper::deleteFile($advertisement, 'desktop_image_webp');

            $advertisement->desktop_image_webp = Helper::uploadWebpImage($request->desktop_image, 'uploads/home/advertisement/desktop_image/webp/', $request->title);
            $advertisement->desktop_image = Helper::uploadFile($request->desktop_image, 'uploads/home/advertisement/desktop_image/', $request->title);
        }
        if ($request->hasFile('mobile_image')) {
            Helper::deleteFile($advertisement, 'mobile_image');
            Helper::deleteFile($advertisement, 'mobile_image_webp');

            $advertisement->mobile_image_webp = Helper::uploadWebpImage($request->mobile_image, 'uploads/home/advertisement/mobile_image/webp/', $request->title);
            $advertisement->mobile_image = Helper::uploadFile($request->mobile_image, 'uploads/home/advertisement/mobile_image/', $request->title);
        }
        $advertisement->url = $request->url;
        $advertisement->type = "corporate";
        $advertisement->image_attribute = $validatedData['image_attribute'];
        $advertisement->updated_at = now();
        if ($advertisement->save()) {
            session()->flash('success', "Home Advertisement has been updated successfully");
            return redirect(Helper::sitePrefix() . 'home-corporate/advertisement');
        } else {
            return back()->with('error', 'Error while updating the advertisement');
        }
    }
    public function advertisement_update2(Request $request, $id)
    {
        $advertisement = HomeAdvertisement::find($id);
        $validatedData = $request->validate([
//            'title' => 'nullable|min:2|max:255',
            'desktop_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'mobile_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'image_attribute' => 'required|min:5',        ]);
        if ($request->hasFile('desktop_image')) {
            Helper::deleteFile($advertisement, 'desktop_image');
            Helper::deleteFile($advertisement, 'desktop_image_webp');

            $advertisement->desktop_image_webp = Helper::uploadWebpImage($request->desktop_image, 'uploads/home/advertisement/desktop_image/webp/', $request->title);
            $advertisement->desktop_image = Helper::uploadFile($request->desktop_image, 'uploads/home/advertisement/desktop_image/', $request->title);
        }
        if ($request->hasFile('mobile_image')) {
            Helper::deleteFile($advertisement, 'mobile_image');
            Helper::deleteFile($advertisement, 'mobile_image_webp');

            $advertisement->mobile_image_webp = Helper::uploadWebpImage($request->mobile_image, 'uploads/home/advertisement/mobile_image/webp/', $request->title);
            $advertisement->mobile_image = Helper::uploadFile($request->mobile_image, 'uploads/home/advertisement/mobile_image/', $request->title);
        }
        $advertisement->url = $request->url;
        $advertisement->type = "ecommerce";
        $advertisement->image_attribute = $validatedData['image_attribute'];
        $advertisement->updated_at = now();
        if ($advertisement->save()) {
            session()->flash('success', "Home Advertisement has been updated successfully");
            return redirect(Helper::sitePrefix() . 'home-ecommerce/advertisement');
        } else {
            return back()->with('error', 'Error while updating the advertisement');
        }
    }

    public function delete_advertisement(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $advertisement = HomeAdvertisement::find($request->id);
            if ($advertisement) {
                Helper::deleteFile($advertisement, 'desktop_image');
                Helper::deleteFile($advertisement, 'desktop_image_webp');
                Helper::deleteFile($advertisement, 'mobile_image');
                Helper::deleteFile($advertisement, 'mobile_image_webp');

                $advertisement->save();
                if ($advertisement->delete()) {
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
    public function delete_latest(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $product = Product::find($request->id);
            if ($product) {
                if (File::exists(public_path($product->thumbnail_image))) {
                    File::delete(public_path($product->thumbnail_image));
                }
                if (File::exists(public_path($product->thumbnail_image_webp))) {
                    File::delete(public_path($product->thumbnail_image_webp));
                }
                if (File::exists(public_path($product->desktop_banner))) {
                    File::delete(public_path($product->desktop_banner));
                }
                if (File::exists(public_path($product->desktop_banner_webp))) {
                    File::delete(public_path($product->desktop_banner_webp));
                }
                if (File::exists(public_path($product->mobile_banner))) {
                    File::delete(public_path($product->mobile_banner));
                }
                if (File::exists(public_path($product->mobile_banner_webp))) {
                    File::delete(public_path($product->mobile_banner_webp));
                }
                if (File::exists(public_path($product->product_manual))) {
                    File::delete(public_path($product->product_manual));
                }
                if ($product->delete()) {
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
    public function delete_advertisement2(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $advertisement = HomeAdvertisement::find($request->id);
            if ($advertisement) {
                Helper::deleteFile($advertisement, 'desktop_image');
                Helper::deleteFile($advertisement, 'desktop_image_webp');
                Helper::deleteFile($advertisement, 'mobile_image');
                Helper::deleteFile($advertisement, 'mobile_image_webp');

                $advertisement->save();
                if ($advertisement->delete()) {
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



    public function sort_order_with_field(Request $request)
    {
        if (isset($request->id) && $request->id != NULL) {
            $table = $request->table;
            $field = $request->field;
            $field_value = $request->field_value;
            $model = 'App\\Models\\' . $table;
            $sortOrder = $model::where([['sort_order', '=', $request->sort_order], [$field, '=', $field_value], ['id', '!=', $request->id]])->count();
            if ($sortOrder) {
                return response()->json(['status' => false, 'message' => 'Sort order "' . $request->sort_order . '" has been already taken']);
            } else {
                $data = $model::find($request->id);
                $data->sort_order = $request->sort_order;
                if ($data->save()) {
                    return response()->json(['status' => true, 'message' => 'Sort order updated successfully']);
                } else {
                    return response()->json(['status' => false, 'message' => 'Error while updating the sort order']);
                }
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Empty value submitted']);
        }
    }

    public function delete_file(Request $request)
    {
        $filetype = explode('/', $request->type);
        $table = $filetype[0];
        $field = $filetype[1];
        $id = $filetype[2];
        $webp_field = isset($filetype[3]) ? $filetype[3] : '';
        $model = 'App\\Models\\' . $table;
        $data = $model::find($id);
        // dd($filetype);
        if ($data) {
            if (File::exists(public_path($data->$field))) {
                File::delete(public_path($data->$field));
            }
            if ($webp_field != '') {
                if (File::exists(public_path($data->$webp_field))) {
                    File::delete(public_path($data->$webp_field));
                }
                $data->$webp_field = NULL;
            }
            $data->$field = NULL;
            if ($data->save()) {
                return response()->json(['status' => true, 'message' => 'File has been removed']);
            } else {
                return response()->json(['status' => false, 'message' => 'Unable to remove the file']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Unable to find the file']);
        }
    }


    public function combinationArrays($chars, $size, $combinations = array())
    {
        if (empty($combinations)) {
            $combinations = $chars;
        }
        if ($size == 1) {
            return $combinations;
        }
        $new_combinations = array();
        foreach ($combinations as $combination) {
            foreach ($chars as $char) {
                if ($combination != $char) {
                    $new_combinations[$combination][] = $char;
                }
            }
        }
        return $this->combinationArrays($chars, $size - 1, $new_combinations);
    }


}
