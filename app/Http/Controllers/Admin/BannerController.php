<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Banner;
use App\Models\SiteInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    }

    public function banner($type)
    {
        $type = trim($type);
        $key = "Update";
        $title = "Update " . $type . ' Banner';
        $banner = Banner::where('type', $type)->first();
      
        return view('Admin.banner.form', compact('key', 'title', 'banner', 'type'));
    }

    public function banner_store(Request $request)
    {


        $type_array = array('about', 'return-policy','blogs', 'cart', 'checkout', 'contact', 'my-account', 'privacy-policy', 'product', '404','terms-and-conditions','faq','shipping-policy','disclaimer' ,'payment-policy');
    //    dd($request->all());
        if (in_array($request->type, $type_array)) {

            if ($request->id == 0) {


                 $banner = new Banner;
//                 $validatedData = $request->validate([
// //                    'banner_title' => 'required',
//                     'type' => 'required',
//                     'desktop_banner' => 'required|image|mimes:jpeg,png,jpg|max:512',
//                     'mobile_banner' => 'required|image|mimes:jpeg,png,jpg|max:512',
//                     'banner_attribute' => 'required|min:2'
//                 ]);


            } else {
                // $validatedData = $request->validate([
                //     // 'banner_title' => 'required',
                //     'type' => 'required',
                //     'desktop_banner' => 'image|mimes:jpeg,png,jpg|max:512',
                //     'mobile_banner' => 'image|mimes:jpeg,png,jpg|max:512',
                //     'banner_attribute' => 'min:2'
                // ]);
                $banner = Banner::find($request->id);
                $banner->updated_at = now();

            }

            if ($request->hasFile('desktop_banner')) {

                if (File::exists(public_path($banner->desktop_banner))) {
                    File::delete(public_path($banner->desktop_banner));
                }
                if (File::exists(public_path($banner->desktop_banner_webp))) {
                    File::delete(public_path($banner->desktop_banner_webp));
                }
                $banner->desktop_banner_webp = Helper::uploadWebpImage($request->desktop_banner, 'uploads/banner/desktop_banner/webp/', $request->banner_title);
                $banner->desktop_banner = Helper::uploadFile($request->desktop_banner, 'uploads/banner/desktop_banner/', $request->banner_title);
            }
            if ($request->hasFile('mobile_banner')) {
                if (File::exists(public_path($banner->mobile_banner))) {
                    File::delete(public_path($banner->mobile_banner));
                }
                if (File::exists(public_path($banner->mobile_banner_webp))) {
                    File::delete(public_path($banner->mobile_banner_webp));
                }
                $banner->mobile_banner_webp = Helper::uploadWebpImage($request->mobile_banner, 'uploads/banner/mobile_banner/webp/', $request->banner_title);
                $banner->mobile_banner = Helper::uploadFile($request->mobile_banner, 'uploads/banner/mobile_banner/', $request->banner_title);
            }
//            $banner->banner_title = $validatedData['banner_title'];
//            $banner->banner_sub_title = $request->banner_sub_title;
            $banner->type = $request->type;
            $banner->banner_attribute =$request->banner_attribute;

            if ($banner->save()) {
                session()->flash('success', $request->type . ' banner has been updated successfully');
                return redirect(Helper::sitePrefix() . 'banner/' . strtolower($request->type));
            } else {
                return back()->with('error', 'Error while updating the ' . $request->type);
            }
        } else {
            abort(403, 'Your requested type ' . $request->type . ' does not exist');
        }
    }
}
