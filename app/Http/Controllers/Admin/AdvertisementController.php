<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Advertisement;
use App\Models\SiteInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class AdvertisementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    }

    public function advertisement($type)
    {
        $type = trim($type);
        $key = "Manage";
        $title = "Manage " . $type . ' Advertisement';
        $adsList = Advertisement::where('type', $type)->get();
        return view('Admin.advertisement.list', compact('key', 'title', 'adsList', 'type'));
    }

    public function advertisement_create($type)
    {
        $key = "Create";
        $title = "Create " . ucfirst($type) . " Advertisement";
        $imageDimension = Helper::imageDimension($type);
        return view('Admin.advertisement.form', compact('key', 'title', 'type', 'imageDimension'));
    }

    public function advertisement_store(Request $request)
    {
        $type_array = array('blog', 'blog-detail', 'cart', 'checkout', 'home', 'product', 'product-detail', 'product-listing-one', 'product-listing-two', 'product-listing-three', 'wishlist');
        if (in_array($request->type, $type_array)) {
            $validatedData = $request->validate([
                'title' => 'required|min:2|max:230',
                'type' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:512',
                'image_attribute' => 'required|min:2'
            ]);
            $advertisement = new Advertisement;
            if ($request->hasFile('image')) {
                $advertisement->image_webp = Helper::uploadWebpImage($request->image, 'uploads/advertisement/' . strtolower($request->type) . '/image/webp/', $request->title);
                $advertisement->image = Helper::uploadFile($request->image, 'uploads/advertisement/' . strtolower($request->type) . '/image/', $request->title);
            }
            $advertisement->title = $validatedData['title'];
            $advertisement->type = $validatedData['type'];
            $advertisement->url = $request->url ?? '';
            $advertisement->image_attribute = $validatedData['image_attribute'];
            if ($advertisement->save()) {
                session()->flash('success', $request->type . ' Advertisement has been updated successfully');
                return redirect(Helper::sitePrefix() . 'advertisement/' . $request->type);
            } else {
                return back()->with('error', 'Error while updating the ' . $request->type);
            }
        } else {
            abort(403, 'Your requested type ' . $request->type . ' does not exist');
        }
    }

    public function advertisement_edit($id)
    {
        $key = "Update";
        $advertisement = Advertisement::find($id);
        if ($advertisement != null) {
            $title = "Update " . ucfirst($advertisement->type) . " Advertisement";
            $type = $advertisement->type;
            return view('Admin.advertisement.form', compact('key', 'advertisement', 'title', 'type'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function advertisement_update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:230',
            'type' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:512',
            'image_attribute' => 'required|min:2'
        ]);
        $advertisement = Advertisement::find($id);
        if ($request->hasFile('image')) {
            if (File::exists(public_path($advertisement->image))) {
                File::delete(public_path($advertisement->image));
            }
            if (File::exists(public_path($advertisement->image_webp))) {
                File::delete(public_path($advertisement->image_webp));
            }
            $advertisement->image_webp = Helper::uploadWebpImage($request->image, 'uploads/advertisement/' . strtolower($request->type) . '/image/webp/', $request->title);
            $advertisement->image = Helper::uploadFile($request->image, 'uploads/advertisement/' . strtolower($request->type) . '/image/', $request->title);
        }
        $advertisement->title = $validatedData['title'];
        $advertisement->url = $request->url ?? '';
        $advertisement->image_attribute = $validatedData['image_attribute'];

        $advertisement->updated_at = now();
        if ($advertisement->save()) {
            session()->flash('success', 'Advertisement "' . $request->title . '" has been updated successfully');
            return redirect(Helper::sitePrefix() . 'advertisement/' . $request->type);
        } else {
            return back()->with('message', 'Error while updating Advertisement');
        }
    }

    public function delete_advertisement(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $advertisement = Advertisement::find($request->id);
            if ($advertisement) {
                if (File::exists(public_path($advertisement->image))) {
                    File::delete(public_path($advertisement->image));
                }
                if (File::exists(public_path($advertisement->image_webp))) {
                    File::delete(public_path($advertisement->image_webp));
                }
                if ($advertisement->delete()) {
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
