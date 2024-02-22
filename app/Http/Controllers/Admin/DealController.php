<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Deal;
use App\Models\Offer;
use App\Models\Product;
use App\Models\SiteInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class DealController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    }

    public function deal()
    {
        $title = "Deal List";
        $dealList = Deal::get();
        return view('Admin.deal.list', compact('dealList', 'title'));
    }

    public function deal_create()
    {
        $key = "Create";
        $title = "Add Deal";
        $brands = Brand::active()->get();
        $categories = Category::active()->whereNull('parent_id')->get();
        return view('Admin.deal.form', compact('key', 'title', 'brands', 'categories'));
    }

    public function deal_store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'short_url' => 'required|unique:deals,short_url',
            'product_list_type' => 'required',
            'offer_type' => 'required',
            'offer_value' => 'required|exclude_unless:offer_type,==,Fixed|lte:min_price',
            'offer_option' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'products' => 'required',
        ]);
        $deal = new Deal;
        if ($request->hasFile('desktop_banner')) {
            $deal->desktop_banner_webp = Helper::uploadWebpImage($request->desktop_banner, 'uploads/deal/desktop_banner_webp/', $request->title);
            $deal->desktop_banner = Helper::uploadFile($request->desktop_banner, 'uploads/deal/desktop_banner/', $request->title);
        }
        if ($request->hasFile('mobile_banner')) {
            $deal->mobile_banner_webp = Helper::uploadWebpImage($request->mobile_banner, 'uploads/deal/mobile_banner_webp/', $request->title);
            $deal->mobile_banner = Helper::uploadFile($request->mobile_banner, 'uploads/deal/mobile_banner/', $request->title);
        }

        $deal->title = $validatedData['title'];
        $deal->short_url = $validatedData['short_url'];
        $deal->offer_type = $validatedData['offer_type'];
        $deal->offer_option = $validatedData['offer_option'];
        $deal->start_date = $validatedData['start_date'];
        $deal->end_date = $validatedData['end_date'];
        $deal->products = implode(',', $validatedData['products']);
        $deal->banner_title = $request->banner_title ?? '';
        $deal->banner_attribute = $request->banner_attribute ?? '';
        $deal->meta_title = $request->meta_title ?? '';
        $deal->meta_description = $request->meta_description ?? '';
        $deal->meta_keyword = $request->meta_keyword ?? '';
        $deal->other_meta_tag = $request->other_meta_tag ?? '';

        $deal->product_list_type = $validatedData['product_list_type'];
        if ($deal->product_list_type == "Brand") {
            $type_value = ($request->brand_id) ? implode(',', $request->brand_id) : '';
        } else if ($deal->product_list_type == "Category") {
            $type_value = ($request->deal_category_id) ? implode(',', $request->deal_category_id) : '';
        } else {
            $type_value = ($request->deal_sub_category_id) ? implode(',', $request->deal_sub_category_id) : '';
        }
        $deal->type_value = $type_value;
        if ($deal->offer_type == "Normal") {
            $deal->offer_value = 0;
        } else {
            $deal->offer_value = isset($request->offer_value) ? $request->offer_value : '';
        }

        if ($deal->save()) {
            session()->flash('success', "Deal '" . $request->title . "' has been created successfully");
            return redirect(Helper::sitePrefix() . 'deal');
        } else {
            return back()->with('success', 'Error while creating deal');
        }
    }

    public function deal_edit($id)
    {
        $key = "Update";
        $title = "Deal Update";
        $deal = Deal::find($id);
        if ($deal != null) {
            if (strpos($deal->product_id, ',') !== false) {
                $values = explode(',', $deal->product_id);
            } else {
                $values = $deal->product_id;
            }
            $brands = Brand::active()->get();
            $categories = Category::active()->whereNull('parent_id')->get();
            $subCategories = [];
            $selectedCategories = [];
            if ($deal->product_list_type == "Sub-category") {
                $selectedCategories = Category::with('activeParent')->active()->whereIn('id', explode(',', $deal->type_value))->get()->pluck('activeParent.id')->toArray();
                $subCategories = Category::active()->whereIn('parent_id', $selectedCategories)->where('id', '!=', $id)->get();
            }
            if ($deal->product_list_type == "Category") {
                $condition = Product::where(function ($query) use ($values) {
                    if (!empty($values)) {
                        foreach ($values as $input) {
                            $query->OrwhereRaw("find_in_set('" . $input . "',category_id)");
                        }
                    }
                })->active();
            } else {
                $condition = Product::where(function ($query) use ($values) {
                    if (!empty($values)) {
                        foreach ($values as $input) {
                            $query->OrwhereRaw("find_in_set('" . $input . "',sub_category_id)");
                        }
                    }
                })->active();
            }
            $condition = $condition->whereNotIn('id', Helper::dealProducts($deal->id));
            if ($deal->offer_option == 'Offer') {
                $offers = Offer::where([['status', 'Active'], ['start_date', '<=', date('Y-m-d')], ['end_date', '>=', date('Y-m-d')]])->get();
                $condition = $condition->whereIn('id', $offers->pluck('product_id')->toArray());
            } else if ($deal->offer_option == 'No Offer') {
                $offers = Offer::where([['status', 'Active'], ['start_date', '<=', date('Y-m-d')], ['end_date', '>=', date('Y-m-d')]])->get();
                $condition = $condition->whereNotIn('id', $offers->pluck('product_id')->toArray());
            }
            $products = $condition->get();
            $min_price = $products->min('price');
            return view('Admin.deal.form', compact('key', 'deal', 'title', 'products', 'subCategories', 'categories', 'selectedCategories', 'brands', 'products', 'min_price'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function deal_update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'short_url' => 'required|unique:deals,short_url,' . $id,
            'product_list_type' => 'required',
            'offer_type' => 'required',
            'offer_value' => 'required|exclude_unless:offer_type,==,Fixed|lte:min_price',
            'offer_option' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'products' => 'required',
        ]);
        $deal = Deal::find($id);
        if ($request->hasFile('desktop_banner')) {
            if (File::exists(public_path($deal->desktop_banner))) {
                File::delete(public_path($deal->desktop_banner));
            }
            if (File::exists(public_path($deal->desktop_banner_webp))) {
                File::delete(public_path($deal->desktop_banner_webp));
            }
            $deal->desktop_banner_webp = Helper::uploadWebpImage($request->desktop_banner, 'uploads/deal/desktop_banner_webp/', $request->title);
            $deal->desktop_banner = Helper::uploadFile($request->desktop_banner, 'uploads/deal/desktop_banner/', $request->title);
        }

        if ($request->hasFile('mobile_banner')) {
            if (File::exists(public_path($deal->mobile_banner))) {
                File::delete(public_path($deal->mobile_banner));
            }
            if (File::exists(public_path($deal->mobile_banner_webp))) {
                File::delete(public_path($deal->mobile_banner_webp));
            }
            $deal->mobile_banner_webp = Helper::uploadWebpImage($request->mobile_banner, 'uploads/deal/mobile_banner_webp/', $request->title);
            $deal->mobile_banner = Helper::uploadFile($request->mobile_banner, 'uploads/deal/mobile_banner/', $request->title);
        }

        $deal->title = $validatedData['title'];
        $deal->short_url = $validatedData['short_url'];
        $deal->offer_type = $validatedData['offer_type'];
        $deal->offer_option = $validatedData['offer_option'];
        $deal->start_date = $validatedData['start_date'];
        $deal->end_date = $validatedData['end_date'];
        $deal->products = implode(',', $validatedData['products']);
        $deal->banner_title = $request->banner_title ?? '';
        $deal->banner_attribute = $request->banner_attribute ?? '';
        $deal->meta_title = $request->meta_title ?? '';
        $deal->meta_description = $request->meta_description ?? '';
        $deal->meta_keyword = $request->meta_keyword ?? '';
        $deal->other_meta_tag = $request->other_meta_tag ?? '';

        $deal->product_list_type = $validatedData['product_list_type'];
        if ($deal->product_list_type == "Brand") {
            $type_value = ($request->brand_id) ? implode(',', $request->brand_id) : '';
        } else if ($deal->product_list_type == "Category") {
            $type_value = ($request->deal_category_id) ? implode(',', $request->deal_category_id) : '';
        } else {
            $type_value = ($request->deal_sub_category_id) ? implode(',', $request->deal_sub_category_id) : '';
        }
        $deal->type_value = $type_value;
        if ($deal->offer_type == "Normal") {
            $deal->offer_value = 0;
        } else {
            $deal->offer_value = isset($request->offer_value) ? $request->offer_value : '';
        }
        $deal->updated_at = date('Y-m-d h:i:s');
        if ($deal->save()) {
           session()->flash('success', "Deal '" . $request->title . "' has been updated successfully");
            return redirect(Helper::sitePrefix() . 'deal');
        } else {
            return back()->with('message', 'Error while updating deal');
        }
    }

    public function delete_deal(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $deal = Deal::find($request->id);
            if ($deal) {
                if (File::exists(public_path($deal->desktop_banner))) {
                    File::delete(public_path($deal->desktop_banner));
                }
                if (File::exists(public_path($deal->desktop_banner_webp))) {
                    File::delete(public_path($deal->desktop_banner_webp));
                }
                if (File::exists(public_path($deal->mobile_banner))) {
                    File::delete(public_path($deal->mobile_banner));
                }
                if (File::exists(public_path($deal->mobile_banner_webp))) {
                    File::delete(public_path($deal->mobile_banner_webp));
                }
                $deleted = $deal->delete();
                if ($deleted == true) {
                    return response()->json(['status' => true]);
                } else {
                    return response()->json(['status' => false, 'message' => 'Some error occurred,please try after sometime']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Model class not found']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Invalid Id']);
        }
    }


    public function sub_categories(Request $request)
    {
        $subCategories = Category::active()->whereIn('parent_id', $request->parentId)->get(['id', 'title']);
        return response()->json([
            'status' => true,
            'message' => $subCategories
        ]);
    }

    public function product_by_type(Request $request)
    {
        $values = $request->value;
        if ($request->product_list_type == "Brand") {
            $condition = Product::where(function ($query) use ($values) {
                if (!empty($values)) {
                    foreach ($values as $input) {
                        $query->OrwhereRaw("find_in_set('" . $input . "',brand_id)");
                    }
                }
            })->active();
        } else if ($request->product_list_type == "Category") {
            $condition = Product::where(function ($query) use ($values) {
                if (!empty($values)) {
                    foreach ($values as $input) {
                        $query->OrwhereRaw("find_in_set('" . $input . "',category_id)");
                    }
                }
            })->active();
        } else {
            $condition = Product::where(function ($query) use ($values) {
                if (!empty($values)) {
                    foreach ($values as $input) {
                        $query->OrwhereRaw("find_in_set('" . $input . "',sub_category_id)");
                    }
                }
            })->active();
        }
        $products = [];
        $min_price = 0;
        if (!empty($values)) {
            $condition = $condition->whereNotIn('id', Helper::dealProducts($request->deal_id));
            if ($request->offer_option == 'Offer') {
                $offers = Offer::where([['status', 'Active'], ['start_date', '<=', date('Y-m-d')], ['end_date', '>=', date('Y-m-d')]])->get();
                $condition = $condition->whereIn('id', $offers->pluck('product_id')->toArray());
            } else if ($request->offer_option == 'No Offer') {
                $offers = Offer::where([['status', 'Active'], ['start_date', '<=', date('Y-m-d')], ['end_date', '>=', date('Y-m-d')]])->get();
                $condition = $condition->whereNotIn('id', $offers->pluck('product_id')->toArray());
            }
            $products = $condition->get(['id', 'title', 'price']);
            $min_price = $products->min('price');
        }
        return response()->json(['status' => true, 'message' => $products, 'min_price' => $min_price]);
    }
}
