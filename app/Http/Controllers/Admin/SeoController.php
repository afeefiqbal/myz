<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\SeoData;
use App\Models\SiteInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class SeoController extends Controller
{
    public function __construct()
    {
        $this->type_array = array('Home', 'About', 'Blogs', 'Contact', 'Products', 'Privacy Policy', 'Return Policy',
            'Shipping Policy', 'Disclaimer', 'Terms And Conditions', 'My Account', 'Login', 'Checkout', 'Cart',
            'Wishlist', 'Thank You','Compare');
        $this->middleware('auth:admin');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    }

    public function seo($type)
    {
        $type = Str::title(Str::replace('-', ' ', $type));
        if (in_array($type, $this->type_array)) {
            $key = "Update";
            $title = "Update '" . $type . "'";
            $seo_data = SeoData::page($type)->first();
            return view('Admin.seo.form', compact('key', 'title', 'seo_data', 'type'));
        } else {
            abort(403, 'The requested type ' . $type . ' does not exist');
        }
    }

    public function seo_store(Request $request, $type)
    {
 
        $type = Str::title(Str::replace('-', ' ', $type));
        if (in_array($type, $this->type_array)) {
            if ($request->id == 0) {
                $seo_data = new SeoData;
            } else {
                $seo_data = SeoData::find($request->id);
                $seo_data->updated_at = now();
            }
            $seo_data->page = $type;
            $seo_data->meta_title = $request->meta_title;
            $seo_data->meta_description = $request->meta_description;
            $seo_data->meta_keyword = $request->meta_keyword;
            $seo_data->other_meta_tag = $request->other_meta_tag;

            if ($seo_data->save()) {
                session()->flash('success', 'Seo Data content ' . $type . ' has been updated successfully');
                return redirect(Helper::sitePrefix() . 'seo/' .str_replace(' ', '-', strtolower($type)) );
            } else {
                return back()->with('error', 'Error while updating the Seo Data content');
            }
        } else {
            abort(403, 'The requested type ' . $type . ' does not exist');
        }
    }

    public function extra_seo()
    {
        $key = "Update";
        $title = "Update Extra SEO Data";
        $seo_data = SiteInformation::first();
        return view('Admin.seo.extra.form', compact('key', 'title', 'seo_data'));
    }

    public function extra_seo_store(Request $request)
    {
        $validatedData = $request->validate([
            'header_tag' => 'nullable|min:2',
            'body_tag' => 'nullable|min:2',
            'footer_tag' => 'nullable|min:2',
        ]);
        if ($request->id == 0) {
            $seo_data = new SiteInformation;
        } else {
            $seo_data = SiteInformation::find($request->id);
            $seo_data->updated_at = now();
        }
        $seo_data->header_tag = $request->header_tag;
        $seo_data->body_tag = $request->body_tag;
        $seo_data->footer_tag = $request->footer_tag;
        if ($seo_data->save()) {
            session()->flash('success', 'Extra Seo content has been updated successfully');
            return redirect(Helper::sitePrefix() . 'seo/extra/');
        } else {
            return back()->with('message', 'Error while updating the extra seo content');
        }
    }
}
