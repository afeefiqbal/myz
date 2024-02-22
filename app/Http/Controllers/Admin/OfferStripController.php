<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\OfferStrip;
use App\Models\SiteInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class OfferStripController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    }

    public function offer_strip()
    {
        $title = "Offer Strip List";
        $offer_strip_list = OfferStrip::get();
        return view('Admin.offer_strip.list', compact('offer_strip_list', 'title'));
    }

    public function offer_strip_create()
    {
        $key = "Create";
        $title = "Create Offer Strip";
        return view('Admin.offer_strip.form', compact('key', 'title'));
    }

    public function offer_strip_store(Request $request)
    {
        $validatedData = $request->validate([
            'banner_title' => 'required',
            'banner_sub_title' => 'required',
            'is_timer_available' => 'required',
        ]);
        $offer_strip = new OfferStrip;
        if ($request->hasFile('desktop_banner')) {
            $offer_strip->desktop_banner_webp = Helper::uploadWebpImage($request->desktop_banner, 'uploads/offer_strip/desktop_banner/webp/', $request->short_url);
            $offer_strip->desktop_banner = Helper::uploadFile($request->desktop_banner, 'uploads/offer_strip/desktop_banner/', $request->short_url);
        }
        if ($request->hasFile('mobile_banner')) {
            $offer_strip->mobile_banner_webp = Helper::uploadWebpImage($request->mobile_banner, 'uploads/offer_strip/mobile_banner/webp/', $request->short_url);
            $offer_strip->mobile_banner = Helper::uploadFile($request->mobile_banner, 'uploads/offer_strip/mobile_banner/', $request->short_url);
        }
        $offer_strip->banner_title = $request->banner_title ?? '';
        $offer_strip->banner_sub_title = $request->banner_sub_title ?? '';
        $offer_strip->banner_attribute = $request->banner_attribute ?? '';
        $offer_strip->is_timer_available = $request->is_timer_available ?? '';
        if ($request->is_timer_available == "Yes") {
            $offer_strip->date = $request->date;
        }
        if (OfferStrip::active()->count() >= 1) {
            $offer_strip->status = 'Inactive';
        }
        if ($offer_strip->save()) {
           session()->flash('success', 'Offer strip has been added successfully');
            return redirect(Helper::sitePrefix() . 'offer-strip');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the offer strip");
        }
    }

    public function offer_strip_edit(Request $request, $id)
    {
        $key = "Update";
        $title = "Update offer_strip";
        $offer_strip = OfferStrip::find($id);
        if ($offer_strip) {
            return view('Admin.offer_strip.form', compact('key', 'offer_strip', 'title'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function offer_strip_update(Request $request, $id)
    {
        $offer_strip = OfferStrip::find($id);
        $validatedData = $request->validate([
            'banner_title' => 'required',
            'banner_sub_title' => 'required',
            'is_timer_available' => 'required',
        ]);
        if ($request->hasFile('desktop_banner')) {
            if (File::exists(public_path($offer_strip->desktop_banner))) {
                File::delete(public_path($offer_strip->desktop_banner));
            }
            if (File::exists(public_path($offer_strip->desktop_banner_webp))) {
                File::delete(public_path($offer_strip->desktop_banner_webp));
            }
            $offer_strip->desktop_banner_webp = Helper::uploadWebpImage($request->desktop_banner, 'uploads/offer_strip/desktop_banner/webp/', $request->short_url);
            $offer_strip->desktop_banner = Helper::uploadFile($request->desktop_banner, 'uploads/offer_strip/desktop_banner/', $request->short_url);
        }
        if ($request->hasFile('mobile_banner')) {
            if (File::exists(public_path($offer_strip->mobile_banner))) {
                File::delete(public_path($offer_strip->mobile_banner));
            }
            if (File::exists(public_path($offer_strip->mobile_banner_webp))) {
                File::delete(public_path($offer_strip->mobile_banner_webp));
            }
            $offer_strip->mobile_banner_webp = Helper::uploadWebpImage($request->mobile_banner, 'uploads/offer_strip/mobile_banner/webp/', $request->short_url);
            $offer_strip->mobile_banner = Helper::uploadFile($request->mobile_banner, 'uploads/offer_strip/mobile_banner/', $request->short_url);
        }
        $offer_strip->banner_title = $request->banner_title ?? '';
        $offer_strip->banner_sub_title = $request->banner_sub_title ?? '';
        $offer_strip->banner_attribute = $request->banner_attribute ?? '';
        $offer_strip->is_timer_available = $request->is_timer_available ?? '';
        if ($request->is_timer_available == "Yes") {
            $offer_strip->date = $request->date;
        }
        $offer_strip->updated_at = now();
        if ($offer_strip->save()) {
           session()->flash('success', 'Offer strip has been updated successfully');
            return redirect(Helper::sitePrefix() . 'offer-strip');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the offer strip");
        }
    }

    public function delete_offer_strip(Request $request)
    {
        if (isset($request->id) && $request->id != NULL) {
            $offer_strip = OfferStrip::find($request->id);
            if ($offer_strip) {
                if (File::exists(public_path($offer_strip->desktop_banner))) {
                    File::delete(public_path($offer_strip->desktop_banner));
                }
                if (File::exists(public_path($offer_strip->desktop_banner_webp))) {
                    File::delete(public_path($offer_strip->desktop_banner_webp));
                }
                if (File::exists(public_path($offer_strip->mobile_banner))) {
                    File::delete(public_path($offer_strip->mobile_banner));
                }
                if (File::exists(public_path($offer_strip->mobile_banner_webp))) {
                    File::delete(public_path($offer_strip->mobile_banner_webp));
                }
                if ($offer_strip->delete()) {
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
