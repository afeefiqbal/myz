<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Banner;
use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\OrderCustomer;
use App\Models\Product;
use App\Models\SeoData;
use App\Models\ShippingCharge;
use App\Models\State;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Termwind\Components\Dd;

class CustomerController extends Controller
{
    public function __construct()
    {
        return Helper::commonData();
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }

    public function seo_content($page)
    {
        $seo_data = SeoData::page($page)->first();
        return $seo_data;
    }

    public function account($tab)
    {

  
        if (Auth::guard('customer')->check()) {
            $seo_data = $this->seo_content('My Account');
            if($tab == 'wishlist'){
                $seo_data = $this->seo_content('wishlist');
            }
            $banner = Banner::type('my-account')->first();
            $user = Auth::guard('customer')->user();
            $customer = $user->customer;
            $customerAddresses = Auth::guard('customer')->user()->customer->activeCustomerAddresses;
            $countries = Country::active()->get();
            $coutryIDS = $countries->map(function($q){
                return $q->id;
            })->toArray();
            $shipping_charge =
            $shipping_charge = ShippingCharge::active()->pluck('state_id')->toArray();
            $statesData = State::active()->whereIn('id',$shipping_charge)->whereIn('country_id', $coutryIDS);
            $cid =  $statesData->pluck('country_id')->toArray();
            $countries = Country::whereIn('id',$cid)->get();
       
        //    return $states = State::where('status', 'Active')->get();
            $latestProducts = Product::where('status', 'Active')->take(5)->latest()->get();
            $orders = OrderCustomer::with(['orderData' => function ($q) {
                $q->with(['orderProducts' => function ($t) {
                    $t->with('productData');
                    $t->with('colorData');
                }]);
            }])->where('customer_id', Auth::guard('customer')->user()->customer->id)->latest()->get();
            return view('web.profile', compact('customer', 'customerAddresses', 'countries',
                'tab', 'latestProducts', 'orders', 'seo_data', 'banner', 'user', 'customer'));
        } else {
            abort(403, 'You are not authorised');
        }
    }

   
    public function update_profile(Request $request)
    {
        
        if (Auth::guard('customer')->check()) {
            $user = Auth::guard('customer')->user();
            $customer = $user->customer;
            $request->validate([
                // 'first_name' => 'required|string|min:2|max:30',
                'first_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255|unique:customers,first_name,'.$customer->id,
               
                'last_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255|unique:customers,last_name,'.$customer->id,
//                'username' => 'required|min:2|max:60|unique:users,username,' . $user->id,
                'phone_number' => 'required|regex:/^([0-9\+]*)$/|min:7|max:20|unique:users,phone,' . $user->id,
            ]);
            DB::beginTransaction();
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->updated_at = now();
            if ($customer->save()) {
                $user->phone = $request->phone_number;
//                $user->username = $request->username;
                $user->updated_at = now();
                if ($user->save()) {
                    DB::commit();
                    return response()->json(['status' => 'true', 'message' => 'Profile has been updated successfully']);
                } else {
                    DB::rollBack();
                    return response()->json(['status' => 'error', 'message' => "Error while updating the profile, Please try after sometime"]);
                }
            } else {
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => "Error while updating the profile, Please try after sometime"]);
            }
        } else {
            abort(403, 'You are not authorised');
        }
    }

    public function address_form(Request $request)
    {
        $states = $customerAddress = '';
        $countries = Country::active()->get();
        if (Auth::guard('customer')->check()) {
            if ($request->id != 0) {
                $customerAddress = CustomerAddress::find($request->id);
                $states = State::active()->where('country_id', $customerAddress->state->country_id)->get();
            }
        }
    
        return view('web.includes.customer_address_form', compact('customerAddress', 'countries', 'states'));
    }

    public function createAddress(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|min:2|max:30',
            'last_name' => 'required|string|max:30',
            'address' => 'required|string',
            'email' => 'required|email|max:70',
            'phone' => 'required|regex:/^([0-9\+]*)$/|min:7|max:20',
//            'zipcode' => 'required',
            'country' => 'required',
            // 'state' => 'required',
        ]);

        if (Auth::guard('customer')->check()) {
            if ($request->id != '0') {
                $customer_address = CustomerAddress::find($request->id);
                $text = 'updat';
            } else {
                $customer_address = new CustomerAddress;
                $text = 'add';
                $customer_address->customer_id = Auth::guard('customer')->user()->customer->id;
            }
            $customer_address->first_name = $request->first_name;
            $customer_address->last_name = $request->last_name;
            $customer_address->phone = $request->phone;
            $customer_address->email = $request->email;
            $customer_address->country_id = $request->country;
            $customer_address->address = $request->address;
            $customer_address->address_type = $request->address_type ?? 'Home';
           $customer_address->zipcode = $request->zipcode ?? null;
    
            $customer_address->state_id = $request->state;
            $customer_address->is_default = isset($request->is_default) ? 'Yes' : 'No';
            if ($customer_address->save()) {
                $redirect = '';
                if ($customer_address->is_default == 'Yes') {
                    CustomerAddress::where([['customer_id', $customer_address->customer_id], ['id', '!=', $customer_address->id]])->update(['is_default' => 'No']);
                }
                if (isset($request->set_session) && $request->set_session == 1) {
                    session(['selected_' . $request->address_type . '_address' => $customer_address->id]);
                }
                if (isset($request->show_page) && $request->show_page == 1) {
                    $redirect = url('customer/account/address');
                }
                echo json_encode(array('status' => 'success-reload', 'message' => 'Address has been ' . $text . 'ed successfully', 'redirect' => $redirect));
            } else {
                echo json_encode(array('status' => 'false', 'message' => "Error while " . $text . "ing the address, Please try after sometime"));
            }
        } else {
            $account_type = $request->account_type;
            $address_type = $request->address_type;
            if ($account_type == "0") {
                session([$address_type . '_first_name' => $request->first_name]);
                session([$address_type . '_last_name' => $request->last_name]);
                session([$address_type . '_phone' => $request->phone]);
                session([$address_type . '_country' => $request->country]);
                $countryData = Country::find($request->country);
                session([$address_type . '_country_name' => $countryData->title]);
                session([$address_type . '_state' => $request->state]);
                $stateData = State::find($request->state);
                session([$address_type . '_state_name' => $stateData->title]);
                session([$address_type . '_email' => $request->email]);
                session([$address_type . '_address' => $request->address]);
//                session([$address_type . '_zipcode' => $request->zipcode]);
                echo json_encode(array('status' => 'success-reload', 'message' => 'Address has been added successfully'));
            } else {
                abort(403, 'You are not authorised');
            }
        }
    }

    public function profile_image_upload(Request $request)
    {
        if (Auth::guard('customer')->check()) {
            $request->validate([
                'profile_image' => 'required|image|mimes:jpeg,png,jpg|max:512',
            ]);
            if ($request->hasFile('profile_image')) {
                $user = Auth::guard('customer')->user();
                if (File::exists(public_path($user->profile_image))) {
                    File::delete(public_path($user->profile_image));
                }
                if (File::exists(public_path($user->profile_image_webp))) {
                    File::delete(public_path($user->profile_image_webp));
                }
                $user->profile_image_webp = Helper::uploadWebpImage($request->profile_image, 'uploads/customer/profile_image/webp/', $user->email);
                $user->profile_image = Helper::uploadFile($request->profile_image, 'uploads/customer/profile_image/', $user->email);
                if ($user->save()) {
                    return response()->json(['status' => 'success', 'message' => 'Profile Image has been updated successfully']);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Error while updating the profile image']);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => 'Image is Required']);
            }
        } else {
            abort(403, 'You are not authorised');
        }
    }

    public function delete_address(Request $request)
    {
        if (Auth::guard('customer')->check()) {
            $customerAddress = CustomerAddress::find($request->address_id);
            $customerAddress->status = "Inactive";
            if ($customerAddress->save()) {
                return response()->json(['status' => 'success', 'message' => 'Address has been disabled successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => "Error while disabling the address, Please try after sometime"]);
            }
        } else {
            abort(403, 'You are not authorised');
        }
    }
    public function set_default_address(Request $request)
    {
        $user = Auth::guard('customer')->user();
        $customer = $user->customer;
        $address = CustomerAddress::find($request->id);
        
        if ($address) {
            CustomerAddress::where('customer_id', $customer->id)->update(['is_default'=>'No']);
            $address->is_default = 'Yes';
            if ($address->save()) {
                return response()->json(['status' => 'success', 'message' => 'Default Address has been changed successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => "Error while changing the default Address, Please try after sometime"]);
            }
        }else{
            return response()->json(['status' => 'error', 'message' => "Error while changing the default Address, Please try after sometime"]);
        }

    }
    public function change_password_store(Request $request)
    {
       
        
        if (Auth::guard('customer')->check()) {
            $request->validate([
                'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
             
                'password_confirmation' => 'required_if:password,!=,null|same:password',
            ]);

            $user = Auth::guard('customer')->user();
            $user->password = Hash::make($request->password_confirmation);
            $user->updated_at = now();
            if ($user->save()) {
              
                if (Helper::sendCustomerNewpassword($user, $request->password)) {
                    return response()->json(['status' => 'success', 'message' => 'Password has been changed successfully']);
                } else {
                    return response()->json(['status' => 'success', 'message' => "Password has been changed successfully,Can't send the credentials mail right now"]);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => "Error while changing the password, Please try after sometime"]);
            }
        } else {
            abort(403, 'You are not authorised');
        }
    }
    
}
