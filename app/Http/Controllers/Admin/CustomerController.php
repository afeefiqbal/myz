<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\OrderCustomer;
use App\Models\SiteInformation;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rules\Password;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    }

    public function customer()
    {
        $title = "Customer List";
        $customerList = Customer::with('user')->latest()->get();
        return view('Admin.customer.list', compact('customerList', 'title'));
    }

    public function customer_create()
    {
        $key = "Create";
        $title = "Add Customer";
        return view('Admin.customer.form', compact('key', 'title'));
    }

    public function customer_store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|min:2|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
//            'username' => 'required|string|max:255|unique:users,username',
            'phone' => 'required|min:7|max:15|unique:users,phone',
            'profile_image' => 'image|mimes:jpeg,png,jpg|max:512',
            'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ]);
//        try {
        DB::beginTransaction();
        $user = new User;
        $user->user_type = 'Customer';
        $user->email = $request->email;
//        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->created_by = Auth::id();
        if ($request->hasFile('profile_image')) {
            $user->profile_image_webp = Helper::uploadWebpImage($request->profile_image, 'uploads/customer/profile_image/webp/', $request->email);
            $user->profile_image = Helper::uploadFile($request->profile_image, 'uploads/customer/profile_image/', $request->email);
        }
        $user->image_attribute = $request->image_attribute;
        if ($user->save()) {
            $customer = new Customer;
            $customer->first_name = $validatedData['first_name'];
            $customer->last_name = $request->last_name ?? '';
            $customer->user_id = $user->id;
            if ($customer->save()) {
                DB::commit();
                session()->flash('success', 'Customer has been added successfully');
                return redirect(Helper::sitePrefix() . 'customer');
            } else {
                DB::rollBack();
                return back()->with('message', 'Error while creating customer');
            }
        } else {
            DB::rollBack();
            return back()->with('message', 'Error while creating customer');
        }
//        } catch (Exception $e) {
//            return redirect(Helper::sitePrefix() . 'customer')->with('error', "operation failed");
//        }
    }

    public function customer_edit(Request $request, $id)
    {
        $key = "Update";
        $title = "Customer Update";
        $customer = customer::find($id);
        if ($customer != null) {
            return view('Admin.customer.form', compact('key', 'customer', 'title'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function customer_update(Request $request, $id)
    {
        $customer = Customer::find($id);
        $user = $customer->user;
        $validatedData = $request->validate([
            'first_name' => 'required|min:2|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|min:7|max:15|unique:users,phone,' . $user->id,
            'profile_image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        DB::beginTransaction();
        $customer->first_name = $validatedData['first_name'];
        $customer->last_name = $request->last_name ?? '';
        $customer->updated_at = now();
        if ($customer->save()) {
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->updated_by = Auth::id();
            $user->image_attribute = $request->image_attribute;
            $user->updated_at = now();
            if ($request->hasFile('profile_image')) {
                if (File::exists(public_path($user->profile_image))) {
                    File::delete(public_path($user->profile_image));
                }
                if (File::exists(public_path($user->profile_image_webp))) {
                    File::delete(public_path($user->profile_image_webp));
                }
                $user->profile_image_webp = Helper::uploadWebpImage($request->profile_image, 'uploads/customer/profile_image/webp/', $request->email);
                $user->profile_image = Helper::uploadFile($request->profile_image, 'uploads/customer/profile_image/', $request->email);
            }
            if ($user->save()) {
                DB::commit();
                session()->flash('success', 'Customer has been updated successfully');
                return redirect(Helper::sitePrefix() . 'customer');
            } else {
                DB::rollBack();
                return back()->with('message', 'Error while updating customer');
            }
        } else {
            DB::rollBack();
            return back()->with('error', 'Error while updating customer');
        }
    }

    public function delete_customer(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $customer = Customer::find($request->id);
            if ($customer) {
                $user = $customer->user;
                if ($user) {
                    $customerAddress = CustomerAddress::where('customer_id', $request->id)->count();
                    $orderTagged = OrderCustomer::where('customer_id', $request->id)->count();
                    if ($customerAddress != 0) {
                        return response()->json(['status' => false, 'message' => 'Error : Customer "' . $customer->first_name . '" has tagged with address']);
                    } elseif ($orderTagged != 0) {
                        return response()->json(['status' => false, 'message' => 'Error : Customer "' . $customer->first_name . '" has tagged with Orders']);
                    } else {
                        DB::beginTransaction();
                        if (File::exists(public_path($user->profile_image))) {
                            File::delete(public_path($user->profile_image));
                        }
                        if (File::exists(public_path($user->profile_image_webp))) {
                            File::delete(public_path($user->profile_image_webp));
                        }
                        $user->profile_image = null;
                        $user->profile_image_webp = null;
                        $user->save();
                        if ($user->delete() && $customer->delete()) {
                            DB::commit();
                            return response()->json(['status' => true,]);
                        } else {
                            DB::rollBack();
                            return response()->json(['status' => false, 'message' => 'Error while deleting customer']);
                        }
                    }
                } else {
                    return response()->json(['status' => false, 'message' => 'Record not found']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Model class not found']);
            }

        } else {
            return response()->json(['status' => false, 'message' => 'Empty value submitted']);
        }
    }

    public function address($customer_id)
    {
        $customer = Customer::find($customer_id);
        $title = "Address List - " . $customer->first_name;
        $addressList = CustomerAddress::where('customer_id', $customer_id)->get();
        return view('Admin.customer_address.list', compact('addressList', 'title', 'customer_id'));

    }

    public function address_create($customer_id)
    {
        $customer = Customer::find($customer_id);
        $key = "Create";
        $title = "Create Address - " . $customer->first_name;
        $countries = Country::where('status', 'Active')->get();
        return view('Admin.customer_address.form', compact('key', 'title', 'customer_id', 'countries'));

    }

    public function address_store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required',
            'first_name' => 'required',
            'address' => 'required|min:2|max:255',
            'phone' => 'required',
            'email' => 'required|email',
            'country' => 'required',
            'state' => 'required',
        ]);
        $address = new CustomerAddress;
        $address->customer_id = $validatedData['customer_id'];
        $address->first_name = $validatedData['first_name'];
        $address->last_name = $request->last_name;
        $address->address = $validatedData['address'];
        $address->phone = $validatedData['phone'];
        $address->email = $validatedData['email'];
        $address->state_id = $validatedData['state'];
        if ($address->save()) {
            session()->flash('success', "Address has been added successfully");
            return redirect(Helper::sitePrefix() . 'customer/address/' . $request->customer_id);
        } else {
            return back()->with('error', 'Error while creating the address');
        }
    }

    public function address_edit(Request $request, $id)
    {
        $key = "Update";
        $address = CustomerAddress::find($id);
        $title = "Update Address - " . $address->customer->first_name;
        if ($address) {
            $countries = Country::active()->get();
            $states = State::active()->where('country_id', '=', $address->state->country->id)->get();
            $customer_id = $address->customer_id;
            return view('Admin.customer_address.form', compact('key', 'address', 'title', 'customer_id', 'countries', 'states'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function address_update(Request $request, $id)
    {
        $address = CustomerAddress::find($id);
        $validatedData = $request->validate([
            'customer_id' => 'required',
            'first_name' => 'required',
            'address' => 'required|min:2|max:255',
            'phone' => 'required',
            'email' => 'required|email',
            'country' => 'required',
            'state' => 'required',
        ]);
        $address->customer_id = $validatedData['customer_id'];
        $address->first_name = $validatedData['first_name'];
        $address->last_name = $request->last_name;
        $address->address = $validatedData['address'];
        $address->phone = $validatedData['phone'];
        $address->email = $validatedData['email'];
        $address->state_id = $validatedData['state'];
        $address->updated_at = now();
        if ($address->save()) {
            session()->flash('success', "Customer address has been updated successfully");
            return redirect(Helper::sitePrefix() . 'customer/address/' . $request->customer_id);
        } else {
            return back()->with('error', 'Error while updating the address');
        }
    }

    public function delete_address(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $address = CustomerAddress::find($request->id);
            if ($address) {
                $addressTagged = OrderCustomer::where('billing_address', $request->id)->orWhere('shipping_address', $request->id)->count();
                if ($addressTagged > 0) {
                    return response()->json(['status' => false, 'message' => 'Error : "Address has connected with orders']);
                } else {
                    if ($address->delete()) {
                        return response()->json(['status' => true]);
                    } else {
                        return response()->json(['status' => false, 'message' => 'Some error occurred,please try after sometime']);
                    }
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Model class not found']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Empty value submitted']);
        }
    }
}
