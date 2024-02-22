<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Category;
use App\Models\Color;
use App\Models\Menu;
use App\Models\Tag;
use App\Models\Shape;
use App\Models\MenuDetail;
use App\Models\SideMenu;
use App\Models\SideMenuDetail;
use App\Models\SiteInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    }

    public function menu()
    {
        $title = "Menu List";
        $menuList = Menu::get();
        return view('Admin.menu.list', compact('menuList', 'title'));
    }

    public function menu_create()
    {
        $key = "Create";
        $title = "Create Menu";
        $categories = Category::active()->whereNull('parent_id')->get();
        $colors = Color::active()->get();
        $shapes = Shape::active()->get();
        $tags = Tag::active()->get();
        return view('Admin.menu.form', compact('key', 'title', 'categories','tags','colors','shapes'));
    }

    public function menu_store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required',
            'menu_type' => 'required',
            // 'url' => 'required'
        ]);
        $menu = new Menu;
        $menu->title = $validatedData['title'];
        $menu->menu_type = $validatedData['menu_type'];
        $exist = 0;
        if ($request->menu_type == "static") {
            $menu->url = $request->url ?? '';
    
        }
        if ($request->menu_type == "category" || "tag" || "shape" || "color") {
            $menu->url = ($request->url) ? $request->url : '';

            $menu->shape_id = ($request->menu_shape_id) ? implode(',', $request->menu_shape_id) : '';
            $menu->color_id = ($request->color_id) ? implode(',', $request->color_id) : '';

        } if ($request->hasFile('image')) {
            $menu->image_webp = Helper::uploadWebpImage($request->image, 'uploads/menu/image/webp/', $request->menu_type);
            $menu->image = Helper::uploadFile($request->image, 'uploads/product/image/', $request->menu_type);
        }
       
        if ($exist == 0) {
            $sort_order = Menu::orderBy('id', 'DESC')->first();
            if ($sort_order) {
                $sort_number = ($sort_order->sort_order + 1);
            } else {
                $sort_number = 1;
            }

            $menu->sort_order = $sort_number;
            if ($menu->save()) {

                if($request->menu_category_id != null){
                    foreach($request->menu_category_id as $category){
                        $menu_detail = new MenuDetail;
                        $menu_detail->menu_id = $menu->id;
                        $menu_detail->category_id = $category;
                        $menu_detail->save();
                    }
                }
                if($request->menu_shape_id != null){
                    foreach($request->menu_shape_id as $shape){
                        $menu_detail = new MenuDetail;
                        $menu_detail->menu_id = $menu->id;
                        $menu_detail->shape_id = $shape;
                        $menu_detail->save();
                    }
                }
                if($request->menu_color_id != null){
                    foreach($request->menu_color_id as $color){
                        $menu_detail = new MenuDetail;
                        $menu_detail->menu_id = $menu->id;
                        $menu_detail->color_id = $color;
                        $menu_detail->save();
                    }
                }
                session()->flash('success', 'Menu has been added successfully');
                return redirect(Helper::sitePrefix() . 'menu');
            } else {
                return back()->withInput($request->input())->withErrors("Error while updating the menu");
            }
        } else {
            return back()->withInput($request->input())->withErrors($category_name . "' already tagged with another page");
        }
    }

    public function menu_edit(Request $request, $id)
    {
        $key = "Update";
        $title = "Update menu";
        $menu = Menu::find($id);
        if ($menu) {
            $categories = Category::active()->whereNull('parent_id')->get();
            $colors = Color::active()->get();
            $shapes = Shape::active()->get();
            $tags = Tag::active()->get();
            $sideMenuColors = MenuDetail::where('menu_id',$id)->where('color_id','!=',null)->pluck('color_id')->toArray();
      
            $sideMenuShapes = MenuDetail::where('menu_id',$id)->where('shape_id','!=',null)->pluck('shape_id')->toArray();
            $sideMenuCategories = MenuDetail::where('menu_id',$id)->where('category_id','!=',null)->pluck('category_id')->toArray();
            return view('Admin.menu.form', compact('key', 'menu', 'title', 'categories','tags','shapes','colors','sideMenuColors','sideMenuShapes','sideMenuCategories'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function menu_update(Request $request, $id)
    {
        $menu = Menu::find($id);
        $validatedData = $request->validate([
            'title' => 'required',
            'menu_type' => 'required',
        ]);
        $menu->title = $validatedData['title'];
        $menu->menu_type = $validatedData['menu_type'];
        $exist = 0;
        if ($request->menu_type == "static") {
            if ($request->static_link == "custom") {
                $menu->url = $request->url ?? '';
            } else {
                $menu->url = $request->static_link;
            }
            $menu->static_link = $request->static_link;
            $menu->category_id = NULL;
            /*if($request->url!=NULL){
            	$exist = Menu::where([['url','=',$menu->url],['id','!=',$id]])->count();
            	$category_name = "Menu '".$menu->url;
            }else{
                $exist = 0;
                $category_name = "Menu";
            }*/
        }
        if ($request->menu_type == "category" || "shape" || "color" || "tag") {
            $menu->category_id = $request->menu_category_id;
            $menu->url = ($request->url) ? $request->url : '';

            $menu->tag_id = $request->menu_tag_id;
            $menu->shape_id = $request->menu_shape_id;
            $menu->color_id = $request->menu_color_id;
        }
        $menu->updated_at = date('Y-m-d h:i:s');
        
        if ($request->hasFile('image')) {
            if (File::exists(public_path($menu->image))) {
              
                File::delete(public_path($menu->image));
            }
            if (File::exists(public_path($menu->image_webp))) {
                File::delete(public_path($menu->image_webp));
            }
            $menu->image_webp = Helper::uploadWebpImage($request->image, 'uploads/menu/image/webp/', $request->menu_type);
            $menu->image = Helper::uploadFile($request->image, 'uploads/menu/image/', $request->menu_type);
        }
        if ($exist == 0) {

            if ($menu->save()) {
                if($request->menu_category_id != null){
                    MenuDetail::where('menu_id',$id)->whereNotNull('category_id')->delete();
                    foreach($request->menu_category_id as $category){
                        $menu_detail = new MenuDetail;
                        $menu_detail->menu_id = $menu->id;
                        $menu_detail->category_id = $category;
                        $menu_detail->save();
                    }
                }
                if($request->menu_shape_id != null){
                    $delete=  MenuDetail::where('menu_id',$id)->whereNotNull('shape_id')->delete();
                    
        
                    foreach($request->menu_shape_id as $shape){
                        $menu_detail = new MenuDetail;
                        $menu_detail->menu_id = $menu->id;
                        $menu_detail->shape_id = $shape;
                        $menu_detail->save();
                    }
                }
                if($request->menu_color_id != null){
                    MenuDetail::where('menu_id',$id)->whereNotNull('color_id')->delete();
                    foreach($request->menu_color_id as $color){
                        $menu_detail = new MenuDetail;
                        $menu_detail->menu_id = $menu->id;
                        $menu_detail->color_id = $color;
                        $menu_detail->save();
                    }
                }
                session()->flash('success', 'Menu has been updated successfully');
                return redirect(Helper::sitePrefix() . 'menu');
            } else {
                return back()->withInput($request->input())->withErrors("Error while updating the menu");
            }
        } else {
            return back()->withInput($request->input())->withErrors($category_name . "' already tagged with another page");
        }
    }

    public function delete_menu(Request $request)
    {
        if (isset($request->id) && $request->id != NULL) {
            $menu = Menu::find($request->id);
            if ($menu) {
              $delete_menu_details = MenuDetail::where('menu_id',$request->id)->delete();
                $deleted = $menu->delete();
                if ($deleted == true) {
                    echo(json_encode(array('status' => true)));
                } else {
                    echo(json_encode(array('status' => false, 'message' => 'Some error occured,please try after sometime')));
                }
            } else {
                echo(json_encode(array('status' => false, 'message' => 'Model class not found')));
            }
        } else {
            echo(json_encode(array('status' => false, 'message' => 'Empty value submitted')));
        }
    }

    public function sub_category_by_menu(Request $request)
    {
      
        $menu = Menu::find($request->id);
       
        if ($menu) {
            $subCategories = Category::active()->where('parent_id', $menu->category_id)->get();
            return response()->json(['status' => true, 'message' => $subCategories]);
        } else {
            return view('Admin.error.404');
        }
    }
    public function side_menu()
    {
        $title = "Side Menu List";
        $menuList = SideMenu::get();
        $colors = Color::active()->get();
        $shapes = Shape::active()->get();
        $tags = Tag::active()->get();
        return view('Admin.side_menu.list', compact('menuList', 'title','tags','shapes','colors'));
    }

    public function side_menu_create()
    {
        $key = "Create";
        $title = "Create Side Menu";
        $colors = Color::active()->get();
        $shapes = Shape::active()->get();
        $tags = Tag::active()->get();
        $categories = Category::active()->whereNull('parent_id')->get();
        return view('Admin.side_menu.form', compact('key', 'title', 'categories','tags','shapes','colors'));
    }

    public function side_menu_store(Request $request)
    {
       
        $validatedData = $request->validate([
            'title' => 'required',
            'menu_type' => 'required',
            // 'url' => 'required'
        ]);
        $menu = new SideMenu;
        $menu->title = $validatedData['title'];
        $menu->menu_type = $validatedData['menu_type'];
        $menu->url = $request->url ?? '';
        $exist = 0;
        
        if ($exist == 0) {
            $sort_order = SideMenu::orderBy('id', 'DESC')->first();
            if ($sort_order) {
                $sort_number = ($sort_order->sort_order + 1);
            } else {
                $sort_number = 1;
            }
            // $menu->tag_id = $request->menu_tag_id;
            if ($request->hasFile('image')) {
                $menu->image_webp = Helper::uploadWebpImage($request->image, 'uploads/menu/image/webp/', $request->menu_type);
                $menu->image = Helper::uploadFile($request->image, 'uploads/product/image/', $request->menu_type);
            }
            $menu->sort_order = $sort_number;
           
            if ($menu->save()) {
                if($request->menu_color_id != null){
                    foreach($request->menu_color_id as $color){
                        $menu_detail = new SideMenuDetail;
                        $menu_detail->menu_id = $menu->id;
                        $menu_detail->color_id = $color;
                        $menu_detail->save();
                    }
                }
                if($request->menu_shape_id != null){
                    foreach($request->menu_shape_id as $shape){
                        $menu_detail = new SideMenuDetail;
                        $menu_detail->menu_id = $menu->id;
                        $menu_detail->shape_id = $shape;
                        $menu_detail->save();
                    }
                }
                session()->flash('success', 'Menu has been added successfully');
                return redirect(Helper::sitePrefix() . 'side-menu');
            } else {
                return back()->withInput($request->input())->withErrors("Error while updating the menu");
            }
        } else {
            return back()->withInput($request->input())->withErrors($category_name . "' already tagged with another page");
        }
    }

    public function side_menu_edit(Request $request, $id)
    {
        $key = "Update";
        $title = "Update menu";
        $menu = SideMenu::find($id);
        $colors = Color::active()->get();
        $sideMenuColors = SideMenuDetail::where('menu_id',$id)->where('color_id','!=',null)->pluck('color_id')->toArray();
      
        $sideMenuShapes = SideMenuDetail::where('menu_id',$id)->where('shape_id','!=',null)->pluck('shape_id')->toArray();
        $shapes = Shape::active()->get();
        $tags = Tag::active()->get();
        if ($menu) {
            $categories = Category::active()->whereNull('parent_id')->get();
            return view('Admin.side_menu.form', compact('key', 'menu', 'title', 'categories','tags','shapes','colors','sideMenuColors','sideMenuShapes'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function side_menu_update(Request $request, $id)
    {
      
        $menu = SideMenu::find($id);
        $validatedData = $request->validate([
            'title' => 'required',
            'menu_type' => 'required',
        ]);
        $menu->title = $validatedData['title'];
        $menu->menu_type = $validatedData['menu_type'];
        $menu->url = $request->url ?? '';
        $exist = 0;

        $menu->updated_at = date('Y-m-d h:i:s');
    
        if ($request->hasFile('image')) {
            if (File::exists(public_path($menu->image))) {
              
                File::delete(public_path($menu->image));
            }
            if (File::exists(public_path($menu->image_webp))) {
                File::delete(public_path($menu->image_webp));
            }
            $menu->image_webp = Helper::uploadWebpImage($request->image, 'uploads/menu/image/webp/', $request->menu_type);
            $menu->image = Helper::uploadFile($request->image, 'uploads/menu/image/', $request->menu_type);
        }
        if ($exist == 0) {

            if ($menu->save()) {
                if($request->menu_shape_id != null){
                    $delete=  SideMenuDetail::where('menu_id',$id)->whereNotNull('shape_id')->delete();
                    
        
                    foreach($request->menu_shape_id as $shape){
                        $menu_detail = new SideMenuDetail;
                        $menu_detail->menu_id = $menu->id;
                        $menu_detail->shape_id = $shape;
                        $menu_detail->save();
                    }
                }
                if($request->menu_color_id != null){
                    SideMenuDetail::where('menu_id',$id)->whereNotNull('color_id')->delete();
                    foreach($request->menu_color_id as $color){
                        $menu_detail = new SideMenuDetail;
                        $menu_detail->menu_id = $menu->id;
                        $menu_detail->color_id = $color;
                        $menu_detail->save();
                    }
                }
                session()->flash('success', 'Menu has been updated successfully');
                return redirect(Helper::sitePrefix() . 'side-menu');
            } else {
                return back()->withInput($request->input())->withErrors("Error while updating the menu");
            }
        } else {
            return back()->withInput($request->input())->withErrors($category_name . "' already tagged with another page");
        }
    }

    public function side_delete_menu(Request $request)
    {
       
        if (isset($request->id) && $request->id != NULL) {
            $menu = SideMenu::find($request->id);
            if ($menu) {
              $delete_menu_details = SideMenuDetail::where('menu_id',$request->id)->delete();
                $deleted = $menu->delete();
                if ($deleted == true) {
                    echo(json_encode(array('status' => true)));
                } else {
                    echo(json_encode(array('status' => false, 'message' => 'Some error occured,please try after sometime')));
                }
            } else {
                echo(json_encode(array('status' => false, 'message' => 'Model class not found')));
            }
        } else {
            echo(json_encode(array('status' => false, 'message' => 'Empty value submitted')));
        }
    }



    public function menu_detail()
    {
        $title = "Menu Detail List";
        $menuList = MenuDetail::get();
   
        return view('Admin.menu.detail.list', compact('menuList', 'title'));
    }

    public function menu_detail_create()
    {
        $key = "Create";
        $title = "Create Menu Detail";
        $menus = Menu::active()->where('menu_type', 'category')->get();
        return view('Admin.menu.detail.form', compact('key', 'title', 'menus'));
    }

    public function menu_detail_store(Request $request)
    {
        
        $validatedData = $request->validate([
            'menu_id' => 'required',
        ]);
        $menuDetail = new MenuDetail;
        $menuDetail->menu_id = $validatedData['menu_id'];
        $menuDetail->category_id = implode(',', $request->category_id) ?? '';
        if ($menuDetail->save()) {
            session()->flash('success', 'Menu Detail has been added successfully');
            return redirect(Helper::sitePrefix() . 'menu/detail');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the menu detail");
        }
    }

    public function menu_detail_edit(Request $request, $id)
    {
        $key = "Update";
        $title = "Update Menu Details";
        $menuDetail = MenuDetail::find($id);
        if ($menuDetail) {
            $menus = Menu::where('menu_type', 'category')->get();
            $categories = Category::active()->where('parent_id', $menuDetail->menu->category_id)->get();
            return view('Admin.menu.detail.form', compact('key', 'menuDetail', 'title', 'menus', 'categories'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function menu_detail_update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'menu_id' => 'required',
        ]);
        $menu = MenuDetail::find($id);
        if ($menu) {
            $menu->menu_id = $validatedData['menu_id'];
            $menu->category_id = ($request->category_id) ? implode(',', $request->category_id) : '';
            if ($menu->save()) {
                session()->flash('success', 'Menu details has been added successfully');
                return redirect(Helper::sitePrefix() . 'menu/detail');
            } else {
                return back()->withInput($request->input())->withErrors("Error while updating the menu details");
            }
        } else {
            return view('errors.404');
        }
    }

    public function delete_detail_menu(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $detail = MenuDetail::find($request->id);
            if ($detail) {
                if ($detail->delete()) {
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
    
    public function side_menu_detail()
    {
        $title = "Side Menu Detail List";
        $menuList = SideMenuDetail::get();
   
        return view('Admin.side_menu.detail.list', compact('menuList', 'title'));
    }

    public function side_menu_detail_create()
    {
        $key = "Create";
        $title = "Create Side Menu Detail";
        $menus = SideMenu::active()->where('menu_type','!=', 'static')->get();
        $colors = Color::active()->get();
        $shapes = Shape::active()->get();
        $tags = Tag::active()->get();
        return view('Admin.side_menu.detail.form', compact('key', 'title', 'menus','colors','shapes','tags'));
    }

    public function side_menu_detail_store(Request $request)
    {
       
        $validatedData = $request->validate([
            'menu_id' => 'required',
        ]);
        $menuDetail = new SideMenuDetail;
        $menuDetail->menu_id = $validatedData['menu_id'];
        $menuDetail->color_id = $request->menu_color_id ?? null;
        $menuDetail->shape_id = $request->menu_shape_id ?? null;
        if ($request->hasFile('image')) {
        
            $menuDetail->image_webp = Helper::uploadWebpImage($request->image, 'uploads/side_menu/image/webp/', $request->menu_id);
            $menuDetail->image = Helper::uploadFile($request->image, 'uploads/side_menu/image/', $request->menu_id);
        }
        if($request->menu_color_id != null){
            $menuDetail->menu_type = 'color';
        }
        if($request->menu_shape_id != null){
            $menuDetail->menu_type = 'shape';
        }
        if ($menuDetail->save()) {
            session()->flash('success', 'Menu Detail has been added successfully');
            return redirect(Helper::sitePrefix() . 'side-menu/detail');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the menu detail");
        }
    }

    public function side_menu_detail_edit(Request $request, $id)
    {
        $key = "Update";
        $title = "Update Side Menu Details";
        $menuDetail = SideMenuDetail::find($id);
        if ($menuDetail) {
            $menus = SideMenu::where('menu_type','!=', 'static')->get();
         
            // $categories = Category::active()->where('parent_id', $menuDetail->menu->category_id)->get();
            $shapes = Shape::active()->get();
            $colors = Color::active()->get();
            if($menuDetail->menu_type == 'shape'){

                $shapes = Shape::active()->where('id', $menuDetail->menu->shape_id)->get();
            }
            if($menuDetail->menu_type == 'colors'){

                $colors = Color::active()->where('id', $menuDetail->menu->color_id)->get();
            }
     
            return view('Admin.side_menu.detail.form', compact('key', 'menuDetail', 'title', 'menus', 'colors', 'shapes'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function side_menu_detail_update(Request $request, $id)
    {
     
        $validatedData = $request->validate([
            'menu_id' => 'required',
        ]);
        $menu = SideMenuDetail::find($id);
        if ($request->hasFile('image')) {
            if (File::exists(public_path($menu->image))) {
              
                File::delete(public_path($menu->image));
            }
            if (File::exists(public_path($menu->image_webp))) {
                File::delete(public_path($menu->image_webp));
            }
            $menu->image_webp = Helper::uploadWebpImage($request->image, 'uploads/side_menu/image/webp/', $request->menu_id);
            $menu->image = Helper::uploadFile($request->image, 'uploads/side_menu/image/', $request->menu_id);
        }
        if ($menu) {
            $menu->menu_id = $validatedData['menu_id'];
          
            if($request->menu_color_id != null){
                $menu->menu_type = 'color';
            }
            if($request->menu_shape_id != null){
                $menu->menu_type = 'shape';
            }
            $menu->color_id = $request->menu_color_id ?? null;
            $menu->shape_id = $request->menu_shape_id ?? null;
            // $menu->category_id = ($request->category_id) ? implode(',', $request->category_id) : '';
            if ($menu->save()) {
                session()->flash('success', 'Menu details has been added successfully');
                return redirect(Helper::sitePrefix() . 'side-menu/detail');
            } else {
                return back()->withInput($request->input())->withErrors("Error while updating the menu details");
            }
        } else {
            return view('errors.404');
        }
    }

    public function side_delete_detail_menu(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $detail = SideMenuDetail::find($request->id);
            if ($detail) {
                if ($detail->delete()) {
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
