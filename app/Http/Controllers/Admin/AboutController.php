<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\About;
use App\Models\AboutFeature;
use App\Models\History;
use App\Models\SiteInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Termwind\Components\Dd;

class AboutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    }

    public function about()
    {
        $key = "Update";
        $title = "About";
        $about = About::first();
        return view('Admin.about.form', compact('key', 'title', 'about'));
    }

    public function about_store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|min:2|max:255',
            'subtitle' => 'required|min:2|max:255',
            'description' => 'required',
        ]);
        if ($request->id == 0) {
            $about = new About; 
        } else {
            $about = About::find($request->id);
            $about->updated_at = now();
        }
        if ($request->hasFile('image')) {
            Helper::deleteFile($about, 'image');
            Helper::deleteFile($about, 'image_webp');

            $about->image_webp = Helper::uploadWebpImage($request->image, 'uploads/image/webp/', $request->title);
            $about->image = Helper::uploadFile($request->image, 'uploads/image/', $request->title);
        }
        if ($request->hasFile('banner_image')) {
            Helper::deleteFile($about, 'banner_image');
            Helper::deleteFile($about, 'banner_image_webp');

            $about->banner_image_webp = Helper::uploadWebpImage($request->banner_image, 'uploads/image/webp/', $request->title);
            $about->banner_image = Helper::uploadFile($request->banner_image, 'uploads/image/', $request->title);
        }

        if ($request->hasFile('feature_image')) {
            Helper::deleteFile($about, 'feature_image');
            Helper::deleteFile($about, 'feature_image_webp');

            $about->feature_image_webp = Helper::uploadWebpImage($request->feature_image, 'uploads/about/feature_image/webp/', $request->title);
            $about->feature_image = Helper::uploadFile($request->feature_image, 'uploads/about/feature_image/', $request->title);
        }

        if ($request->hasFile('products_available_image')) {
            Helper::deleteFile($about, 'products_available_image');

            $about->products_available_image = Helper::uploadFile($request->products_available_image, 'uploads/about/products_available_image/', $request->title);
        }

        // if ($request->hasFile('image')) {
        //     $about->image_webp = Helper::uploadWebpImage($request->image, 'uploads/about/image/webp/', $request->title);
        //     $about->image = Helper::uploadFile($request->image, 'uploads/about/image/', $request->title);
        // }
        $about->title = $validatedData['title'];
        $about->subtitle = $validatedData['subtitle'];
        $about->description = $validatedData['description'];
        // $about->alternative_description = $validatedData['alternative_description'];
        $about->image_attribute = $request->image_attribute ?? '';
        $about->banner_image_attribute = $request->banner_image_attribute ?? '';
        $about->video_url = $request->video_url ?? '';
        $about->feature_title = $request->feature_title ?? '';
        $about->feature_description = $request->feature_description ?? '';
        $about->feature_image_attribute = $request->feature_image_attribute ?? '';
        $about->history_title = $request->history_title ?? '';
        $about->history_description = $request->history_description ?? '';
        $about->products_available_title = $request->products_available_title ?? '';
        $about->products_available_description = $request->products_available_description ?? '';
        if ($about->save()) {
            session()->flash('success', 'About details has been updated successfully');
            return redirect(Helper::sitePrefix() . 'about');
        } else {
            return back()->with('error', 'Error while updating the About details');
        }
    }


    /*********************** About features Starts here *******************************/
    public function feature()
    {
        $title = "About Feature List";
        $aboutFeatureList = AboutFeature::orderBy('sort_order','asc')->get();
        return view('Admin.about.feature.list', compact('aboutFeatureList', 'title'));
    }

    public function feature_create()
    {
        $about = "Create";
        $title = "Create About Feature";
        return view('Admin.about.feature.form', compact('about', 'title'));
    }

    public function feature_store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:255',
            'image' => 'required',
        ]);
        $aboutFeature = new AboutFeature;
        if ($request->hasFile('image')) {
            $aboutFeature->image = Helper::uploadFile($request->image, 'uploads/about/feature/', $request->title);
        }
        $aboutFeature->title = $validatedData['title'];
        $sort_order = AboutFeature::latest('sort_order')->first();
        if ($sort_order) {
            $sort_number = ($sort_order->sort_order + 1);
        } else {
            $sort_number = 1;
        }
        $aboutFeature->sort_order = $sort_number;
        if (AboutFeature::active()->count() >= 4) {
            $aboutFeature->status = 'Inactive';
        }
        if ($aboutFeature->save()) {
            session()->flash('success', "About Feature '" . $request->title . "' has been added successfully");
            return redirect(Helper::sitePrefix() . 'about/feature');
        } else {
            return back()->with('error', 'Error while creating the about Feature');
        }
    }

    public function feature_edit(Request $request, $id)
    {
        $about = "Update";
        $title = "Update About Feature";
        $aboutFeature = AboutFeature::find($id);
        if ($aboutFeature) {
            return view('Admin.about.feature.form', compact('about', 'aboutFeature', 'title'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function feature_update(Request $request, $id)
    {
        $aboutFeature = AboutFeature::find($id);
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:255',
            // 'image' => 'required',
        ]);
        if ($request->hasFile('image')) {
            Helper::deleteFile($aboutFeature, 'image');
            $aboutFeature->image = Helper::uploadFile($request->image, 'uploads/about/feature/', $request->title);
        }
        $aboutFeature->title = $validatedData['title'];
        $aboutFeature->updated_at = now();
        if ($aboutFeature->save()) {
            session()->flash('success', "About Feature'" . $request->title . "' has been updated successfully");
            return redirect(Helper::sitePrefix() . 'about/feature');
        } else {
            return back()->with('error', 'Error while updating the About Feature');
        }
    }

    public function delete_feature(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $aboutFeature = AboutFeature::find($request->id);
            if ($aboutFeature) {
                if ($aboutFeature->delete()) {
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

    /*********************** About histories Starts here *******************************/
    public function history()
    {
        $title = "History";
        $histories = History::orderBy('sort_order','asc')->get();
        return view('Admin.about.history.list', compact('histories','title'));
    }

    public function history_create()
    {
        $key = "Create";
        $title = "Add History";
        return view('Admin.about.history.form', compact('key', 'title'));
    }

    public function history_store(Request $request){
        DB::beginTransaction();
        $valid = $third_valid = true;
        $validatedData = $request->validate([
            'year' => 'required|max:4|min:0',
            'image' => 'required',
        ]);
        $history = new History;
        $history->year = $validatedData['year'];
        $history->image_attribute=$request->image_attribute??'';
        $history->description=$request->description??'';
        if ($request->hasFile('image')) {
            $history->image_webp = Helper::uploadWebpImage($request->image, 'uploads/about/history/webp/', $request->year);
            $history->image = Helper::uploadFile($request->image, 'uploads/about/history/', $request->year);
        }
        $sort_order = History::orderBy('sort_order', 'DESC')->first();
        if ($sort_order) {
            $sort_number = ($sort_order->sort_order + 1);
        } else {
            $sort_number = 1;
        }
        $history->sort_order = $sort_number;
        if($history->save()){
            session()->flash('success', "History '".$history->year."' has been added successfully");
            DB::commit();
            return redirect(Helper::sitePrefix().'about/history');
        }else{
            DB::rollBack();
            return back()->withInput($request->input())->withErrors("Error while updating the History");
        }
    }

    public function history_edit(Request $request,$id){
        $key="Update";
        $title="Update History";
        $history=History::find($id);
        if($history){
            return view('Admin.about.history.form',compact('key','title','history'));
        }else{
            return view('Admin.error.404');
        }

    }

    public function history_update(Request $request,$id){
        DB::beginTransaction();
        $history =  History::find($id);
        $valid = $second_valid = true;
        $validatedData = $request->validate([
            'year' => 'required|max:4|min:0',
        ]);
        $history->year = $validatedData['year'];
        $history->image_attribute=$request->image_attribute??'';
        $history->description=$request->description??'';
        if ($request->hasFile('image')) {
            Helper::deleteFile($history, 'image');
            Helper::deleteFile($history, 'image_webp');
            $history->image_webp = Helper::uploadWebpImage($request->image, 'uploads/about/history/webp/', $request->year);
            $history->image = Helper::uploadFile($request->image, 'uploads/about/history/', $request->year);
        }
        $history->updated_at = date('Y-m-d h:i:s');
        if($history->save()){
            session()->flash('success', "History '".$history->year."' has been updated successfully");
            DB::commit();
            return redirect(Helper::sitePrefix().'about/history');
        }else{
            DB::rollBack();
            return back()->withInput($request->input())->withErrors("Error while updating the History");
        }

    }

    public function delete_history(Request $request){
        if (isset($request->id) && $request->id != null) {
            $history = History::find($request->id);
            if ($history) {

                $deleted = $history->delete();
                if ($deleted == true) {
                    echo (json_encode(array('status' => true)));
                } else {
                    echo (json_encode(array('status' => false, 'message' => 'Some error occured,please try after sometime')));
                }
            } else {
                echo (json_encode(array('status' => false, 'message' => 'Model class not found')));
            }
        } else {
            echo (json_encode(array('status' => false, 'message' => 'Empty value submitted')));
        }
    }
}
