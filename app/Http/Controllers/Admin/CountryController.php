<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\ShippingCharge;
use App\Models\SiteInformation;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    }

    public function country()
    {
        $title = "Country List";
        $countryList = Country::get();
        return view('Admin.country.list', compact('countryList', 'title'));

    }

    public function country_create()
    {
        // $country = '';
        $key = "Create";
        $title = "Add Country";
        return view('Admin.country.form', compact('key', 'title'));

    }

    public function country_store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:255|unique:countries,title',
        ]);
        $country = new Country;
        $country->title = $validatedData['title'];
        if ($country->save()) {
            session()->flash('success', 'Country has been added successfully');
            return redirect(Helper::sitePrefix() . 'country');
        } else {
            return back()->with('error', 'Error while creating country');
        }
    }

    public function country_edit(Request $request, $id)
    {
        $key = "Update";
        $title = "Country Update";
        $country = country::find($id);
        if ($country) {
            return view('Admin.country.form', compact('key', 'country', 'title'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function country_update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:255|unique:countries,title,' . $id,
        ]);
        $country = Country::find($id);
        $country->title = $validatedData['title'];
        $country->updated_at = now();
        if ($country->save()) {
            session()->flash('success', 'Country has been updated successfully');
            return redirect(Helper::sitePrefix() . 'country');
        } else {
            return back()->with('error', 'Error while updating country');
        }
    }

    public function delete_country(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $country = Country::find($request->id);
            if ($country) {
                $state = State::where('country_id', '=', $request->id)->count();
                if ($state == 0) {
                    $deleted = $country->delete();
                    if ($deleted == true) {
                        return response()->json(['status' => true]);
                    } else {
                        return response()->json(['status' => false, 'message' => 'Some error occurred,please try after sometime']);
                    }
                } else {
                    return response()->json(['status' => false, 'message' => 'Error : Country "' . $country->title . '" has tagged with orders']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Model class not found']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Empty value submitted']);
        }
    }

    public function state($country_id)
    {
        $country = Country::find($country_id);
        $title = "State List - " . $country->title;
        $stateList = State::where('country_id', '=', $country_id)->get();
        return view('Admin.state.list', compact('stateList', 'title', 'country_id'));

    }

    public function state_create($country_id)
    {
        $country = Country::find($country_id);
        $key = "Create";
        $title = "Create State - " . $country->title;
        return view('Admin.state.form', compact('key', 'title', 'country_id'));

    }

    public function state_store(Request $request)
    {
        $validatedData = $request->validate([
            'country_id' => 'required',
            'title' => 'required',
        ]);
        $state = new State;
        $state->country_id = $validatedData['country_id'];
        $state->title = $validatedData['title'];
        if ($state->save()) {
            session()->flash('success', "State '" . $state->title . "' has been added successfully");
            return redirect(Helper::sitePrefix() . 'country/state/' . $request->country_id);
        } else {
            return back()->with('error', 'Error while creating the state');
        }
    }

    public function state_edit(Request $request, $id)
    {
        $key = "Update";
        $state = State::find($id);
        $title = "Update State - " . $state->country->title;
        if ($state) {
            $country_id = $state->country_id;
            return view('Admin.state.form', compact('key', 'state', 'title', 'country_id'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function state_update(Request $request, $id)
    {
        $state = State::find($id);
        $validatedData = $request->validate([
            'country_id' => 'required',
            'title' => 'required',
        ]);
        $state->country_id = $validatedData['country_id'];
        $state->title = $validatedData['title'];
        $state->updated_at = now();
        if ($state->save()) {
            session()->flash('success', "State '" . $state->title . "' has been updated successfully");
            return redirect(Helper::sitePrefix() . 'country/state/' . $request->country_id);
        } else {
            return back()->with('error', 'Error while updating the state');
        }
    }

    public function delete_state(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $state = State::find($request->id);
            if ($state) {
                $stateTagged = CustomerAddress::where('state_id', '=', $request->id)->count();
                if ($stateTagged > 0) {
                    return response()->json(['status' => false, 'message' => 'Error : "State has connected with customer address']);
                } else {
                    $deleted = $state->delete();
                    if ($deleted == true) {
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

    public function state_list(Request $request)
    {
        $states = State::active()->where('country_id', $request->country_id)->get(['id', 'title']);
        return response()->json(['status' => 'true', 'states' => $states]);
    }

    public function shipping_list()
    {
        $title = "Shipping charge List";
        $shippingList = ShippingCharge::get();
        return view('Admin.shipping_charge.list', compact('shippingList', 'title'));
    }

    public function shipping_create()
    {
        $key = "Create";
        $title = "Create Shipping Charge";
        $countries = Country::get();
        return view('Admin.shipping_charge.form', compact('key', 'title', 'countries'));
    }

    public function shipping_store(Request $request)
    {
        $validatedData = $request->validate([
            'country' => 'required',
            'state' => 'required|unique:shipping_charges,state_id',
            'type' => 'required'
        ]);
        $shipping = new ShippingCharge;
        $shipping->state_id = $validatedData['state'];
        $shipping->type = $validatedData['type'];
        if ($request->type == "free") {
            $shipping->free_shipping_type = $request->free_shipping_type;
            if ($request->free_shipping_type == "min") {
                $shipping->min_amount = $request->min_amount;
                $shipping->fixed_price = $request->fixed_price_min;
            }
        } else {
            $shipping->fixed_price = $request->fixed_price;
        }
        if ($shipping->save()) {
            session()->flash('success', "Shipping charge has been added successfully");
            return redirect(Helper::sitePrefix() . 'country/shipping-charge');
        } else {
            return back()->with('error', 'Error while creating the shipping charge');
        }
    }

    public function shipping_edit(Request $request, $id)
    {
        $key = "Update";
        $shipping = ShippingCharge::find($id);
        $title = "Update Shipping Charge";
        if ($shipping) {
            $countries = Country::get();
            $states = State::active()->where('country_id', '=', $shipping->state->country->id)->get();
            return view('Admin.shipping_charge.form', compact('key', 'shipping', 'title', 'countries', 'states'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function shipping_update(Request $request, $id)
    {
        $shipping = ShippingCharge::find($id);
        $validatedData = $request->validate([
            'country' => 'required',
            'state' => 'required|unique:shipping_charges,state_id,' . $id,
            'type' => 'required',
        ]);
        $shipping->state_id = $validatedData['state'];
        $shipping->type = $validatedData['type'];
        if ($request->type == "free") {
            $shipping->free_shipping_type = $request->free_shipping_type;
            if ($request->free_shipping_type == "min") {
                $shipping->min_amount = $request->min_amount;
                $shipping->fixed_price = $request->fixed_price_min;
            } else {
                $shipping->min_amount = '0.00';
                $shipping->fixed_price = '0.00';
            }
        } else {
            $shipping->fixed_price = $request->fixed_price;
        }
        $shipping->updated_at = date('Y-m-d h:i:s');
        if ($shipping->save()) {
            session()->flash('success', "Shipping charge has been updated successfully");
            return redirect(Helper::sitePrefix() . 'country/shipping-charge');
        } else {
            return back()->with('error', 'Error while updating the Shipping Charge');
        }
    }

    public function delete_shipping(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $shipping = ShippingCharge::find($request->id);
            if ($shipping) {
                $deleted = $shipping->delete();
                if ($deleted == true) {
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
