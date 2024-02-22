<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Product;
use App\Models\SiteInformation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    }

    public function coupon()
    {
        $title = "Coupon List";
        $couponList = Coupon::latest()->get();
        return view('Admin.coupon.list', compact('couponList', 'title'));
    }

    public function coupon_create()
    {
        $key = "Create";
        $title = "Add Coupon";
        $categories = Category::active()->get();
    
        $products = Product::where('copy','no')->active()->get(['id', 'title']);
        $customerMails = User::active()->type('Customer')->get();
        return view('Admin.coupon.form', compact('key', 'title', 'categories', 'products', 'customerMails'));
    }

    public function coupon_store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:coupons,title,NULL,id,deleted_at,NULL',
            'code' => 'required|unique:coupons,code,NULL,id,deleted_at,NULL',
            'type' => 'required',
            'coupon_value' => 'required',
            'is_free_shipping' => 'required',
            'expiry_date' => 'required',
            // 'individual_use' => 'required',
            'minimum_spend' => 'exclude_unless:type,==,Fixed|required|gt:coupon_value',
            'coupon_value_limit' => 'exclude_unless:type,==,Percentage|required|gt:coupon_value',
        ]);
        $coupon = new Coupon;
        $coupon->title = $validatedData['title'];
        $coupon->code = $validatedData['code'];
        $coupon->type = $validatedData['type'];
        $coupon->coupon_value = $validatedData['coupon_value'];
        $coupon->is_free_shipping = $validatedData['is_free_shipping'];
        $coupon->expiry_date = $validatedData['expiry_date'];
        $coupon->minimum_spend = $request->minimum_spend ?? 0.00;
        $coupon->maximum_spend = $request->maximum_spend ?? 0.00;
        $coupon->coupon_value_limit = $request->coupon_value_limit ?? null;
        // $coupon->individual_use = $validatedData['individual_use'];
        $coupon->included_categories = ($request->included_categories) ? implode(',', $request->included_categories) : null;
        $coupon->excluded_categories = ($request->excluded_categories) ? implode(',', $request->excluded_categories) : null;
        $coupon->included_products = ($request->included_products) ? implode(',', $request->included_products) : null;
        $coupon->excluded_products = ($request->excluded_products) ? implode(',', $request->excluded_products) : null;
        $coupon->allow_public = $request->allow_public;
        if ($request->allow_public == "Yes") {
            $coupon->allowed_mails = NULL;
        } else {
            $coupon->allowed_mails = ($request->allowed_mails) ? implode(',', $request->allowed_mails) : NULL;
        }
        $coupon->usage_per_coupon = $request->usage_per_coupon;
        $coupon->usage_per_person = $request->usage_per_person;
        $coupon->applicable_only_if_sale_price = $request->applicable_only_if_sale_price;
        if ($coupon->save()) {
            session()->flash('success', 'New coupon has been added successfully');
            return redirect(Helper::sitePrefix() . 'coupon');
        } else {
            return back()->with('message', 'Error while creating coupon');
        }
    }

    public function coupon_edit(Request $request, $id)
    {
        $key = "Update";
        $title = "Coupon Update";
        $coupon = Coupon::find($id);
        if ($coupon != NULL) {
            $excluded_product_list = $included_product_list = [];
            $categories = Category::active()->whereNotNull('parent_id')->get();
            if ($coupon->included_categories) {
                $category_request = new Request();
                $category_request->setMethod('POST');
                $category_request->request->add(['categories' => explode(',', $coupon->included_categories)]);
                $excluded_product_list = $this->category_products($category_request, 1)['products'];
            }
            if ($coupon->excluded_categories) {
                $category_request = new Request();
                $category_request->setMethod('POST');
                $category_request->request->add(['categories' => explode(',', $coupon->excluded_categories)]);
                $included_product_list = $this->category_products($category_request, 1)['products'];
            }
            $products = Product::active()->get(['id', 'title']);
            $customerMails = User::active()->type('Customer')->get();
            return view('Admin.coupon.form', compact('key', 'coupon', 'title', 'categories',
                'products', 'customerMails', 'excluded_product_list', 'included_product_list'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function coupon_update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:coupons,title,' . $id . ',id,deleted_at,NULL',
            'code' => 'required|unique:coupons,code,' . $id . ',id,deleted_at,NULL',
            'type' => 'required',
            'coupon_value' => 'required',
            'is_free_shipping' => 'required',
            'expiry_date' => 'required',
            // 'individual_use' => 'required',
            'minimum_spend' => 'exclude_unless:type,==,Fixed|required|gt:coupon_value',
            'coupon_value_limit' => 'exclude_unless:type,==,Percentage|required|gt:coupon_value',
        ]);
        $coupon = Coupon::find($id);
        $coupon->title = $validatedData['title'];
        $coupon->code = $validatedData['code'];
        $coupon->type = $validatedData['type'];
        $coupon->coupon_value = $validatedData['coupon_value'];
        $coupon->is_free_shipping = $validatedData['is_free_shipping'];
        $coupon->expiry_date = $validatedData['expiry_date'];
        $coupon->minimum_spend = $request->minimum_spend ?? 0.00;
        $coupon->maximum_spend = $request->maximum_spend ?? 0.00;
        $coupon->coupon_value_limit = $request->coupon_value_limit ?? null;
        // $coupon->individual_use = $validatedData['individual_use'];
        $coupon->included_categories = ($request->included_categories) ? implode(',', $request->included_categories) : null;
        $coupon->excluded_categories = ($request->excluded_categories) ? implode(',', $request->excluded_categories) : null;
        $coupon->included_products = ($request->included_products) ? implode(',', $request->included_products) : null;
        $coupon->excluded_products = ($request->excluded_products) ? implode(',', $request->excluded_products) : null;
        $coupon->allow_public = $request->allow_public;
        if ($request->allow_public == "Yes") {
            $coupon->allowed_mails = NULL;
        } else {
            $coupon->allowed_mails = ($request->allowed_mails) ? implode(',', $request->allowed_mails) : NULL;
        }
        $coupon->usage_per_coupon = $request->usage_per_coupon;
        $coupon->usage_per_person = $request->usage_per_person;
        $coupon->applicable_only_if_sale_price = $request->applicable_only_if_sale_price;
        $coupon->updated_at = date('Y-m-d h:i:s');
        if ($coupon->save()) {
            session()->flash('success', 'Coupon "' . $request->code . '" has been updated successfully');
            return redirect(Helper::sitePrefix() . 'coupon');
        } else {
            return back()->with('message', 'Error while updating coupon');
        }
    }

    public function delete_coupon(Request $request)
    {
        if (isset($request->id) && $request->id != NULL) {
            $coupon = Coupon::find($request->id);
            if ($coupon) {
                if ($coupon->delete()) {
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

    public function category_products(Request $request, $withoutResponse = 0)
    {
        $categories = $request->categories;
        $category_products = Product::active()->get(['id', 'title']);
        if ($categories) {
            $category_products = Product::active()->where(function ($query) use ($categories) {
                foreach ($categories as $key => $category) {
                    $query->orWhereRaw("FIND_IN_SET('" . $category . "',sub_category_id)");
                }
            })->get(['id', 'title']);
        }
        if ($withoutResponse) {
            return array('status' => true, 'products' => $category_products,);
        } else {
            return response(array('status' => true, 'products' => $category_products,), 200, []);
        }
    }
}
