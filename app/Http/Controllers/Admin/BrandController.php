<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Brand;
use App\Models\HomeHeading;
use App\Models\SiteInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    }

    public function brand()
    {
        $title = "Brand List";
        $brandList = Brand::latest()->get();
        $home_heading = HomeHeading::type('brand')->first();
        return view('Admin.brand.list', compact('brandList', 'title', 'home_heading'));
    }

    public function brand_create()
    {
        $key = "Create";
        $title = "Create Brand";
        return view('Admin.brand.form', compact('key', 'title'));
    }

    public function brand_store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:255',
            'short_url' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'image_meta_tag' => 'required',
        ]);
        $brand = new Brand;
        if ($request->hasFile('image')) {
            $brand->webp_image = Helper::uploadWebpImage($request->image, 'uploads/brand/webp/', $request->short_url);
            $brand->image = Helper::uploadFile($request->image, 'uploads/brand/', $request->short_url);
        }
        if ($request->hasFile('desktop_banner')) {
            $brand->desktop_banner_webp = Helper::uploadWebpImage($request->desktop_banner, 'uploads/brand/desktop_banner/webp/', $request->short_url);
            $brand->desktop_banner = Helper::uploadFile($request->desktop_banner, 'uploads/brand/desktop_banner/', $request->short_url);
        }
        if ($request->hasFile('mobile_banner')) {
            $brand->mobile_banner_webp = Helper::uploadWebpImage($request->mobile_banner, 'uploads/brand/mobile_banner/webp/', $request->short_url);
            $brand->mobile_banner = Helper::uploadFile($request->mobile_banner, 'uploads/brand/mobile_banner/', $request->short_url);
        }
        $brand->title = $validatedData['title'];
        $brand->short_url = $validatedData['short_url'];
        $brand->image_meta_tag = ($request->image_meta_tag) ? $request->image_meta_tag : '';
        $brand->banner_title = ($request->banner_title) ? $request->banner_title : '';
        $brand->banner_sub_title = ($request->banner_sub_title) ? $request->banner_sub_title : '';
        $brand->banner_attribute = $request->banner_attribute ?? '';
        $brand->meta_title = ($request->meta_title) ? $request->meta_title : '';
        $brand->meta_description = ($request->meta_description) ? $request->meta_description : '';
        $brand->meta_keyword = ($request->meta_keyword) ? $request->meta_keyword : '';
        $brand->other_meta_tag = ($request->other_meta_tag) ? $request->other_meta_tag : '';
        if ($brand->save()) {
            session()->flash('success', "Brand '" . $request->title . "' has been added successfully");
            return redirect(Helper::sitePrefix() . 'product/brand');
        } else {
            return back()->with('error', 'Error while creating the brand');
        }
    }

    public function brand_edit(Request $request, $id)
    {
        $key = "Update";
        $title = "Update Brand";
        $brand = Brand::find($id);
        if ($brand) {
            return view('Admin.brand.form', compact('key', 'brand', 'title'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function brand_update(Request $request, $id)
    {
        $brand = Brand::find($id);
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:255',
            'short_url' => 'required',
        ]);
        if ($request->hasFile('image')) {
            if (File::exists(public_path($brand->image))) {
                File::delete(public_path($brand->image));
            }
            if (File::exists(public_path($brand->webp_image))) {
                File::delete(public_path($brand->webp_image));
            }
            $brand->webp_image = Helper::uploadWebpImage($request->image, 'uploads/brand/webp/', $request->short_url);
            $brand->image = Helper::uploadFile($request->image, 'uploads/brand/', $request->short_url);
        }
        if ($request->hasFile('desktop_banner')) {
            if (File::exists(public_path($brand->desktop_banner))) {
                File::delete(public_path($brand->desktop_banner));
            }
            if (File::exists(public_path($brand->desktop_banner_webp))) {
                File::delete(public_path($brand->desktop_banner_webp));
            }
            $brand->desktop_banner_webp = Helper::uploadWebpImage($request->desktop_banner, 'uploads/brand/desktop_banner/webp/', $request->short_url);
            $brand->desktop_banner = Helper::uploadFile($request->desktop_banner, 'uploads/brand/desktop_banner/', $request->short_url);
        }
        if ($request->hasFile('mobile_banner')) {
            if (File::exists(public_path($brand->mobile_banner))) {
                File::delete(public_path($brand->mobile_banner));
            }
            if (File::exists(public_path($brand->mobile_banner_webp))) {
                File::delete(public_path($brand->mobile_banner_webp));
            }
            $brand->mobile_banner_webp = Helper::uploadWebpImage($request->mobile_banner, 'uploads/brand/mobile_banner/webp/', $request->short_url);
            $brand->mobile_banner = Helper::uploadFile($request->mobile_banner, 'uploads/brand/mobile_banner/', $request->short_url);
        }
        $brand->title = $validatedData['title'];
        $brand->short_url = $validatedData['short_url'];
        $brand->image_meta_tag = ($request->image_meta_tag) ? $request->image_meta_tag : '';
        $brand->banner_attribute = $request->banner_attribute ?? '';
        $brand->meta_title = ($request->meta_title) ? $request->meta_title : '';
        $brand->meta_description = ($request->meta_description) ? $request->meta_description : '';
        $brand->meta_keyword = ($request->meta_keyword) ? $request->meta_keyword : '';
        $brand->other_meta_tag = ($request->other_meta_tag) ? $request->other_meta_tag : '';
        $brand->updated_at = now();
        if ($brand->save()) {
            session()->flash('success', "Brand '" . $request->title . "' has been updated successfully");
            return redirect(Helper::sitePrefix() . 'product/brand');
        } else {
            return back()->with('error', 'Error while updating the brand');
        }
    }

    public function delete_brand(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $brand = Brand::find($request->id);
            if ($brand) {
                if (File::exists(public_path($brand->image))) {
                    File::delete(public_path($brand->image));
                }
                if (File::exists(public_path($brand->webp_image))) {
                    File::delete(public_path($brand->webp_image));
                }
                if (File::exists(public_path($brand->desktop_banner))) {
                    File::delete(public_path($brand->desktop_banner));
                }
                if (File::exists(public_path($brand->desktop_banner_webp))) {
                    File::delete(public_path($brand->desktop_banner_webp));
                }
                if (File::exists(public_path($brand->mobile_banner))) {
                    File::delete(public_path($brand->mobile_banner));
                }
                if (File::exists(public_path($brand->mobile_banner_webp))) {
                    File::delete(public_path($brand->mobile_banner_webp));
                }
                $deleted = $brand->delete();
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
