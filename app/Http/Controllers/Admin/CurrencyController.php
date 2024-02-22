<?php

namespace App\Http\Controllers\Admin;

use App\Models\Currency;
use App\Http\Helpers\Helper;
use App\Models\CurrencyRate;
use Illuminate\Http\Request;
use App\Models\SiteInformation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class CurrencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    }

    public function currency()
    {
        $title = "Currency List";
        $currencyList = Currency::get();
        return view('Admin.currency.list', compact('currencyList', 'title'));
    }

    public function currency_create()
    {
        $key = "Create";
        $title = "Create Currency";
        return view('Admin.currency.form', compact('key', 'title'));
    }

    public function currency_store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:currencies,title',
            'code' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:512'

        ]);
        $currency = new Currency;

        if ($request->hasFile('image')) {
            $currency->image_webp = Helper::uploadWebpImage($request->image, 'uploads/currency/image/webp/', $request->title);
            $currency->image = Helper::uploadFile($request->image, 'uploads/currency/image/', $request->title);
        }
        $currency->title = $validatedData['title'];
        $currency->code = $validatedData['code'];
        $currency->symbol = $request->symbol ?? '';
        if ($currency->save()) {
            session()->flash('success', "Currency '" . $currency->title . "' has been added successfully");
            return redirect(Helper::sitePrefix() . 'currency');
        } else {
            return back()->withInput($request->input())->withErrors("Error while creating the currency");
        }
    }

    public function currency_edit(Request $request, $id)
    {
        $key = "Update";
        $title = "Update Currency";
        $currency = Currency::find($id);
        if ($currency) {
            return view('Admin.currency.form', compact('key', 'currency', 'title'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function currency_update(Request $request, $id)
    {
        $currency = Currency::find($id);
        $validatedData = $request->validate([
            'title' => 'required|unique:currencies,title,' . $id,
            'code' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:512',
        ]);
        if ($request->hasFile('image')) {
            if (File::exists(public_path($currency->image))) {
                File::delete(public_path($currency->image));
            }
            if (File::exists(public_path($currency->image_webp))) {
                File::delete(public_path($currency->image_webp));
            }
            $currency->image_webp = Helper::uploadWebpImage($request->image, 'uploads/currenc/image/webp/', $request->title);
            $currency->image = Helper::uploadFile($request->image, 'uploads/currency/image/', $request->title);
        }
       
        $currency->title = $validatedData['title'];
        $currency->code = $validatedData['code'];
        $currency->symbol = $request->symbol ?? '';
        $currency->updated_at = date('Y-m-d h:i:s');
        if ($currency->save()) {
            session()->flash('success', "Currency '" . $currency->title . "' has been updated successfully");
            return redirect(Helper::sitePrefix() . 'currency');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the currency");
        }
    }

    public function delete_currency(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $currency = Currency::find($request->id);
            if ($currency) {
                $currencyTagged = CurrencyRate::where('currency_id', '=', $request->id)->count();
                if ($currencyTagged > 0) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Error : Currency "' . $currency->title . '" has tagged with currency rate'
                    ]);
                } else {
                    $deleted = $currency->delete();
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

    public function currency_rate_create($currency_id)
    {
        $key = "Create";
        $currency = Currency::find($currency_id);
        if ($currency) {
            $title = "Update Currency Rate - " . $currency->code;
            $otherCurrencyList = Currency::where('id', '!=', $currency_id)->get();
            return view('Admin.currency.rate.form', compact('key', 'title', 'currency', 'otherCurrencyList'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function currency_rate_store(Request $request)
    {
        $request->validate([
            'currency_id' => 'required',
            'other_currency_id' => 'required',
            'conversion_rate' => 'required',
        ]);
        $otherCurrencyId = $request->other_currency_id;
        $conversion_rate = $request->conversion_rate;
        $rateId = $request->rate_id;
        $success = [];
        for ($i = 0; $i < count($otherCurrencyId); $i++) {
            if ($rateId[$i] == 0) {
                $rate = new CurrencyRate;
            } else {
                $rate = CurrencyRate::find($rateId[$i]);
            }
            $rate->currency_id = $request->currency_id;
            $rate->other_currency_id = $otherCurrencyId[$i];
            $rate->conversion_rate = $conversion_rate[$i] ?? '1.00';
            if ($rate->save()) {
                $success[] = $rate->id;
            }
        }
        if (count($success) > 0) {
            session()->flash('success', "Currency rate has been updated successfully");
        } else {
            return back()->with('error', 'Error while updating the content');
        }
        return redirect(Helper::sitePrefix() . 'currency/rate/create/' . $request->currency_id);
    }
}
