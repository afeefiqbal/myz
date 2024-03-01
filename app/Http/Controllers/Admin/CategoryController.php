<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Category;
use App\Models\HomeHeading;
use App\Models\Product;
use App\Models\SiteInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    }

    public function category_list()
    {
        $title = "Category List";
        $categoryList = Category::whereNull('parent_id')->get();
        $home_heading = HomeHeading::type('category')->first();
        $type = 'Category';
        $urlType = 'category';
        return view('Admin.product.category.list', compact('categoryList', 'title', 'type', 'urlType', 'home_heading'));
    }

    public function category_create()
    {
        $key = "Create";
        $title = "Create Category";
        $type = 'Category';
        $urlType = 'category';
        $typeFlag = 'category';
        return view('Admin.product.category.form', compact('key', 'title', 'type', 'urlType', 'typeFlag'));
    }

    public function category_store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:255',
            'short_url' => 'required|unique:categories,short_url,NULL,id,deleted_at,NULL',
            'icon' => 'required|image|mimes:png|max:512',
            'image_attribute' => 'required',
        ]);
        $category = new Category;
        if ($request->hasFile('icon')) {
            $category->icon_webp = Helper::uploadWebpImage($request->icon, 'uploads/category/icon/webp/', $request->short_url);
            $category->icon = Helper::uploadFile($request->icon, 'uploads/category/icon/', $request->short_url);
        }
  
      
        $category->title = $validatedData['title'];
        $category->short_url = $validatedData['short_url'];
        $category->parent_id = null;
        $category->image_attribute = $request->image_attribute ?? '';
        $category->banner_attribute = $request->banner_attribute ?? '';
        $category->banner_title = $request->banner_title ?? '';
        $category->banner_sub_title = $request->banner_sub_title ?? '';
        $meta_title =  $category->meta_title = $request->meta_title ?? '';
        //max id of category
        $maxId = Category::max('id');
        $category->sort_order = $maxId + 1;
        $meta_description = $category->meta_description = $request->meta_description ?? '';
        $meta_keyword=  $category->meta_keyword = $request->meta_keyword ?? '';
        $other_meta_tag = $category->other_meta_tag = $request->other_meta_tag ?? '';
        if($meta_title==''){
            $category->meta_title = strtoupper($validatedData['title']) ;
         }
         else{
            $category->meta_title = $request->meta_title ?? '';
         }
         if($meta_description==''){
            $category->meta_description = strtoupper($validatedData['title']) ;
         }
         else{
            $category->meta_description = $request->meta_description ?? '';
         }
         if($meta_keyword==''){
            $category->meta_keyword = strtoupper($validatedData['title']) ;
         }
         else{
            $category->meta_keyword = $request->meta_keyword ?? '';
         }
     



        if ($category->save()) {
           session()->flash('success', "Category '" . $category->title . "' has been added successfully");
            return redirect(Helper::sitePrefix() . 'product/category');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the content");
        }
    }

    public function category_edit(Request $request, $id)
    {
        $key = "Update";
        $title = "Update category";
        $category = Category::find($id);
        $type = 'Category';
        $urlType = 'category';
        $typeFlag = 'category';
        if ($category) {
            return view('Admin.product.category.form', compact('key', 'category', 'title', 'type', 'urlType', 'typeFlag'));
        } else {
            return view('backend.error.404');
        }
    }

    public function category_update(Request $request, $id)
    {
        $category = Category::find($id);
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:255',
            'short_url' => 'required|unique:categories,short_url,' . $id,
            'icon' => 'image|mimes:png|max:512',
            'image' => 'image|mimes:jpeg,png,jpg|max:512',
            'image_attribute' => 'required',
        ]);
        if ($request->hasFile('icon')) {
            if (File::exists(public_path($category->icon))) {
                File::delete(public_path($category->icon));
            }
            if (File::exists(public_path($category->icon_webp))) {
                File::delete(public_path($category->icon_webp));
            }
            $category->icon_webp = Helper::uploadWebpImage($request->icon, 'uploads/category/icon/webp/', $request->short_url);
            $category->icon = Helper::uploadFile($request->icon, 'uploads/category/icon/', $request->short_url);
        }
        if ($request->hasFile('image')) {
            if (File::exists(public_path($category->image))) {
                File::delete(public_path($category->image));
            }
            if (File::exists(public_path($category->image_webp))) {
                File::delete(public_path($category->image_webp));
            }
            $category->image_webp = Helper::uploadWebpImage($request->image, 'uploads/category/image/webp/', $request->short_url);
            $category->image = Helper::uploadFile($request->image, 'uploads/category/image/', $request->short_url);
        }
        if ($request->hasFile('desktop_banner')) {
            if (File::exists(public_path($category->desktop_banner))) {
                File::delete(public_path($category->desktop_banner));
            }
            if (File::exists(public_path($category->desktop_banner_webp))) {
                File::delete(public_path($category->desktop_banner_webp));
            }
            $category->desktop_banner_webp = Helper::uploadWebpImage($request->desktop_banner, 'uploads/category/desktop_banner/webp/', $request->short_url);
            $category->desktop_banner = Helper::uploadFile($request->desktop_banner, 'uploads/category/desktop_banner/', $request->short_url);
        }
        if ($request->hasFile('mobile_banner')) {
            if (File::exists(public_path($category->mobile_banner))) {
                File::delete(public_path($category->mobile_banner));
            }
            if (File::exists(public_path($category->mobile_banner_webp))) {
                File::delete(public_path($category->mobile_banner_webp));
            }
            $category->mobile_banner_webp = Helper::uploadWebpImage($request->mobile_banner, 'uploads/category/mobile_banner/webp/', $request->short_url);
            $category->mobile_banner = Helper::uploadFile($request->mobile_banner, 'uploads/category/mobile_banner/', $request->short_url);
        }
        $category->title = $validatedData['title'];
        $category->short_url = $validatedData['short_url'];
        $category->parent_id = null;
        $category->image_attribute = $request->image_attribute ?? '';
        $category->banner_attribute = $request->banner_attribute ?? '';
        $category->banner_title = $request->banner_title ?? '';
        $category->banner_sub_title = $request->banner_sub_title ?? '';
        $meta_title =  $category->meta_title = $request->meta_title ?? '';
        $meta_description =  $category->meta_description = $request->meta_description ?? '';
        $meta_keyword = $category->meta_keyword = $request->meta_keyword ?? '';
        $other_meta_tag = $category->other_meta_tag = $request->other_meta_tag ?? '';
        $category->updated_at = now();

        if($meta_title==''){
            $category->meta_title = strtoupper($validatedData['title']) ;
         }
         else{
            $category->meta_title = $request->meta_title ?? '';
         }
         if($meta_description==''){
            $category->meta_description = strtoupper($validatedData['title']) ;
         }
         else{
            $category->meta_description = $request->meta_description ?? '';
         }
         if($meta_keyword==''){
            $category->meta_keyword = strtoupper($validatedData['title']) ;
         }
         else{
            $category->meta_keyword = $request->meta_keyword ?? '';
         }
   

        if ($category->save()) {
           session()->flash('success', "Category '" . $category->title . "' has been updated successfully");
            return redirect(Helper::sitePrefix() . 'product/category');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the content");
        }
    }

    public function delete_category(Request $request)
    {
        if (isset($request->id) && $request->id != NULL) {
            $category = Category::find($request->id);
            if ($category) {
                $childCategory = Category::where('parent_id', $request->id)->count();
                if ($childCategory > 0) {
                    return response()->json(['status' => false, 'message' => 'Error : Category "' . $category->title . '" has child entries']);
                } else {
                    $sub_category_products = Product::whereRaw("FIND_IN_SET('" . $request->id . "',category_id)")->count();
                if($sub_category_products>0){
                    return response()->json(['status' => false, 'message' => 'Error : Products with Category "' . $category->title . '" exists']);
                }
                else{
                    if (File::exists(public_path($category->image))) {
                        File::delete(public_path($category->image));
                    }
                    if (File::exists(public_path($category->image_webp))) {
                        File::delete(public_path($category->image_webp));
                    }
                    if (File::exists(public_path($category->desktop_banner))) {
                        File::delete(public_path($category->desktop_banner));
                    }
                    if (File::exists(public_path($category->desktop_banner_webp))) {
                        File::delete(public_path($category->desktop_banner_webp));
                    }
                    if (File::exists(public_path($category->mobile_banner))) {
                        File::delete(public_path($category->mobile_banner));
                    }
                    if (File::exists(public_path($category->mobile_banner_webp))) {
                        File::delete(public_path($category->mobile_banner_webp));
                    }
                    if ($category->delete()) {
                        return response()->json(['status' => true]);
                    } else {
                        return response()->json(['status' => false, 'message' => 'Some error occurred,please try after sometime']);
                    }

                }
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Model class not found']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Empty value submitted']);
        }
    }

    /********************** Sub-category ********************************/

    public function sub_category_list()
    {
        $title = "Sub Category List";
        $type = 'Sub Category';
        $urlType = 'sub-category';
        $heading = HomeHeading::first();
        $categoryList = Category::whereNotNull('parent_id')->get();
        return view('Admin.product.category.list', compact('categoryList', 'title', 'type', 'urlType', 'heading'));
    }

    public function sub_category_create()
    {
        $key = "Create";
        $title = "Create sub category";
        $type = "Sub Category";
        $urlType = 'sub-category';
        $typeFlag = 'sub_category';
        $parentCategories = Category::active()->whereNull('parent_id')->get();
        return view('Admin.product.category.form', compact('key', 'title', 'type', 'parentCategories', 'urlType', 'typeFlag'));
    }

    public function sub_category_store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:255',
            'parent_id' => 'required',
            'short_url' => 'required|unique:categories,short_url',
        ]);
        $sub_category = new Category;
        if ($request->hasFile('icon')) {
            $sub_category->icon_webp = Helper::uploadWebpImage($request->icon, 'uploads/sub_category/icon/webp/', $request->short_url);
            $sub_category->icon = Helper::uploadFile($request->icon, 'uploads/sub_category/icon/', $request->short_url);
        }

        if ($request->hasFile('desktop_banner')) {
            $sub_category->desktop_banner_webp = Helper::uploadWebpImage($request->desktop_banner, 'uploads/sub_category/desktop_banner/webp/', $request->short_url);
            $sub_category->desktop_banner = Helper::uploadFile($request->desktop_banner, 'uploads/sub_category/desktop_banner/', $request->short_url);
        }
        if ($request->hasFile('mobile_banner')) {
            $sub_category->mobile_banner_webp = Helper::uploadWebpImage($request->mobile_banner, 'uploads/sub_category/mobile_banner/webp/', $request->short_url);
            $sub_category->mobile_banner = Helper::uploadFile($request->mobile_banner, 'uploads/sub_category/mobile_banner/', $request->short_url);
        }
        $sub_category->title = $validatedData['title'];
        $sub_category->parent_id = $validatedData['parent_id'];
        $sub_category->short_url = $validatedData['short_url'];
        $sub_category->image_attribute = $request->image_attribute ?? '';
        $sub_category->banner_attribute = $request->banner_attribute ?? '';
        $sub_category->banner_title = $request->banner_title ?? '';
        $sub_category->banner_sub_title = $request->banner_sub_title ?? '';
        $meta_title = $sub_category->meta_title = ($request->meta_title) ? $request->meta_title : '';
        $meta_description =  $sub_category->meta_description = ($request->meta_description) ? $request->meta_description : '';
        $meta_keyword = $sub_category->meta_keyword = ($request->meta_keyword) ? $request->meta_keyword : '';
        $other_meta_tag =  $sub_category->other_meta_tag = ($request->other_meta_tag) ? $request->other_meta_tag : '';

        if($meta_title==''){
            $sub_category->meta_title = strtoupper($validatedData['title']) ;
         }
         else{
            $sub_category->meta_title = $request->meta_title ?? '';
         }
         if($meta_description==''){
            $sub_category->meta_description = strtoupper($validatedData['title']) ;
         }
         else{
            $sub_category->meta_description = $request->meta_description ?? '';
         }
         if($meta_keyword==''){
            $sub_category->meta_keyword = strtoupper($validatedData['title']) ;
         }
         else{
            $sub_category->meta_keyword = $request->meta_keyword ?? '';
         }
       
        if ($sub_category->save()) {
           session()->flash('success', "Sub-category '" . $sub_category->title . "' has been added successfully");
            return redirect(Helper::sitePrefix() . 'product/sub-category/');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the content");
        }
    }

    public function sub_category_edit(Request $request, $id)
    {
        $key = "Update";
        $title = "Update Sub-category";
        $type = 'Sub Category';
        $urlType = 'sub-category';
        $typeFlag = 'sub_category';
        $category = Category::find($id);
        if ($category) {
            $parentCategories = Category::active()->whereNull('parent_id')->get();
            return view('Admin.product.category.form', compact('key', 'parentCategories', 'title', 'type', 'category', 'urlType', 'typeFlag'));
        } else {
            return view('backend.error.404');
        }
    }

    public function sub_category_update(Request $request, $id)
    {
        $sub_category = Category::find($id);
        $validatedData = $request->validate([
            'parent_id' => 'required',
            'title' => 'required|min:2|max:255',
            'short_url' => 'required|unique:categories,short_url,' . $id,
        ]);
        if ($request->hasFile('icon')) {
            if (File::exists(public_path($sub_category->icon))) {
                File::delete(public_path($sub_category->icon));
            }
            if (File::exists(public_path($sub_category->icon_webp))) {
                File::delete(public_path($sub_category->icon_webp));
            }
            $sub_category->icon_webp = Helper::uploadWebpImage($request->icon, 'uploads/sub_category/icon/webp/', $request->short_url);
            $sub_category->icon = Helper::uploadFile($request->icon, 'uploads/sub_category/icon/', $request->short_url);
        }
        if ($request->hasFile('image')) {
            if (File::exists(public_path($sub_category->image))) {
                File::delete(public_path($sub_category->image));
            }
            if (File::exists(public_path($sub_category->image_webp))) {
                File::delete(public_path($sub_category->image_webp));
            }
            $sub_category->image_webp = Helper::uploadWebpImage($request->image, 'uploads/sub_category/image/webp/', $request->short_url);
            $sub_category->image = Helper::uploadFile($request->image, 'uploads/sub_category/image/', $request->short_url);
        }
        if ($request->hasFile('desktop_banner')) {
            if (File::exists(public_path($sub_category->desktop_banner))) {
                File::delete(public_path($sub_category->desktop_banner));
            }
            if (File::exists(public_path($sub_category->desktop_banner_webp))) {
                File::delete(public_path($sub_category->desktop_banner_webp));
            }
            $sub_category->desktop_banner_webp = Helper::uploadWebpImage($request->desktop_banner, 'uploads/sub_category/desktop_banner/webp/', $request->short_url);
            $sub_category->desktop_banner = Helper::uploadFile($request->desktop_banner, 'uploads/sub_category/desktop_banner/', $request->short_url);
        }
        if ($request->hasFile('mobile_banner')) {
            if (File::exists(public_path($sub_category->mobile_banner))) {
                File::delete(public_path($sub_category->mobile_banner));
            }
            if (File::exists(public_path($sub_category->mobile_banner_webp))) {
                File::delete(public_path($sub_category->mobile_banner_webp));
            }
            $sub_category->mobile_banner_webp = Helper::uploadWebpImage($request->mobile_banner, 'uploads/sub_category/mobile_banner/webp/', $request->short_url);
            $sub_category->mobile_banner = Helper::uploadFile($request->mobile_banner, 'uploads/sub_category/mobile_banner/', $request->short_url);
        }
        $sub_category->title = $validatedData['title'];
        $sub_category->short_url = $validatedData['short_url'];
        $sub_category->parent_id = $validatedData['parent_id'];
        $sub_category->image_attribute = $request->image_attribute ?? '';
        $sub_category->banner_attribute = $request->banner_attribute ?? '';
        $sub_category->banner_title = $request->banner_title ?? '';
        $sub_category->banner_sub_title = $request->banner_sub_title ?? '';
        $meta_title =  $sub_category->meta_title = ($request->meta_title) ? $request->meta_title : '';
        $meta_description = $sub_category->meta_description = ($request->meta_description) ? $request->meta_description : '';
        $meta_keyword =  $sub_category->meta_keyword = ($request->meta_keyword) ? $request->meta_keyword : '';
        $other_meta_tag = $sub_category->other_meta_tag = ($request->other_meta_tag) ? $request->other_meta_tag : '';
        $sub_category->updated_at = now();

        if($meta_title==''){
            $sub_category->meta_title = strtoupper($validatedData['title']) ;
         }
         else{
            $sub_category->meta_title = $request->meta_title ?? '';
         }
         if($meta_description==''){
            $sub_category->meta_description = strtoupper($validatedData['title']) ;
         }
         else{
            $sub_category->meta_description = $request->meta_description ?? '';
         }
         if($meta_keyword==''){
            $sub_category->meta_keyword = strtoupper($validatedData['title']) ;
         }
         else{
            $sub_category->meta_keyword = $request->meta_keyword ?? '';
         }
         if($other_meta_tag==''){
            $sub_category->other_meta_tag = strtoupper($validatedData['title']) ;
         }
         else{
            $sub_category->other_meta_tag = $request->other_meta_tag ?? '';
         }
        if ($sub_category->save()) {
           session()->flash('success', "Sub-category '" . $sub_category->title . "' has been updated successfully");
            return redirect(Helper::sitePrefix() . 'product/sub-category');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the content");
        }
    }

    public function delete_sub_category(Request $request)
    {
        if (isset($request->id) && $request->id != NULL) {
            $sub_category = Category::find($request->id);
            if ($sub_category) {
                $sub_category_products = Product::whereRaw("FIND_IN_SET('" . $request->id . "',sub_category_id)")->count();
                if($sub_category_products>0){
                    return response()->json(['status' => false, 'message' => 'Error : Products with Sub Category "' . $sub_category->title . '" exists']);
                }
                else{

                    if (File::exists(public_path($sub_category->image))) {
                        File::delete(public_path($sub_category->image));
                    }
                    if (File::exists(public_path($sub_category->image_webp))) {
                        File::delete(public_path($sub_category->image_webp));
                    }
                    if (File::exists(public_path($sub_category->desktop_banner))) {
                        File::delete(public_path($sub_category->desktop_banner));
                    }
                    if (File::exists(public_path($sub_category->desktop_banner_webp))) {
                        File::delete(public_path($sub_category->desktop_banner_webp));
                    }
                    if (File::exists(public_path($sub_category->mobile_banner))) {
                        File::delete(public_path($sub_category->mobile_banner));
                    }
                    if (File::exists(public_path($sub_category->mobile_banner_webp))) {
                        File::delete(public_path($sub_category->mobile_banner_webp));
                    }
                    if ($sub_category->delete()) {
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
