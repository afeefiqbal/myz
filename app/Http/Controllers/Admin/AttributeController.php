<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Size;
use App\Models\Color;

use App\Models\Shape;
use App\Models\ProductType;
use App\Http\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\MeasurementUnit;
use App\Models\SiteInformation;
use App\Http\Controllers\Controller;
use App\Models\Frame;
use App\Models\Mount;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class AttributeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    }

    /************************************* Color starts ****************************************/
    public function color()
    {
        $title = "Color List";
        $colorList = Color::get();
        return view('Admin.product.color.list', compact('colorList', 'title'));
    }

    public function color_create()
    {
        $key = "Create";
        $title = "Create Color";
        return view('Admin.product.color.form', compact('key', 'title'));
    }

    public function color_store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:colors,title,NULL,id,deleted_at,NULL',
            'code' => 'required|unique:colors,code,NULL,id,deleted_at,NULL',
        ]);
        $color = new Color;
        $color->title = $validatedData['title'];
        $color->code = $validatedData['code'];
        if ($color->save()) {
           session()->flash('success', "Color '" . $color->title . "' has been added successfully");
            return redirect(Helper::sitePrefix() . 'product/color');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the color");
        }
    }

    public function color_edit(Request $request, $id)
    {
        $key = "Update";
        $title = "Update Color";
        $color = Color::find($id);
        if ($color) {
            return view('Admin.product.color.form', compact('key', 'color', 'title'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function color_update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:colors,title,' . $id,
            'code' => 'required|unique:colors,code,' . $id,
        ]);
        $color = Color::find($id);
        $color->title = $validatedData['title'];
        $color->code = $validatedData['code'];
        $color->updated_at = now();
        if ($color->save()) {
           session()->flash('success', "Color '" . $color->title . "' has been updated successfully");
            return redirect(Helper::sitePrefix() . 'product/color');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the color");
        }
    }

    public function delete_color(Request $request)
    {
        if (isset($request->id) && $request->id != NULL) {
            $color = Color::find($request->id);
            if ($color) {
                $color_product = Product::whereRaw("FIND_IN_SET('" . $request->id . "',color_id)")->count();
                if($color_product>0){
                    return response()->json(['status' => false, 'message' => 'Error : Products with Colour "' . $color->title . '" exists']);
                }
                else{

                    $deleted = $color->delete();
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


    /************************************* Tag starts ****************************************/
    public function tag()
    {
        $title = "Tag List";
        $tagList = Tag::get();
        return view('Admin.product.tag.list', compact('tagList', 'title'));
    }

    public function tag_create()
    {
        $key = "Create";
        $title = "Create Tag";
        return view('Admin.product.tag.form', compact('key', 'title'));
    }

    public function tag_store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:tags,title',
        ]);
        $tag = new Tag;
        $tag->title = $validatedData['title'];
        if ($tag->save()) {
            session()->flash('success', "Tag '" . $tag->title . "' has been added successfully");
            return redirect(Helper::sitePrefix() . 'product/tag');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the tag");
        }
    }

    public function tag_edit(Request $request, $id)
    {
        $key = "Update";
        $title = "Update Tag";
        $tag = Tag::find($id);
        if ($tag) {
            return view('Admin.product.tag.form', compact('key', 'tag', 'title'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function tag_update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:tags,title,' . $id,
        ]);
        $tag = Tag::find($id);
        $tag->title = $validatedData['title'];
        $tag->updated_at = now();
        if ($tag->save()) {
            session()->flash('success', "Tag '" . $tag->title . "' has been updated successfully");
            return redirect(Helper::sitePrefix() . 'product/tag');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the tag");
        }
    }

    public function delete_tag(Request $request)
    {
        if (isset($request->id) && $request->id != NULL) {
            $tag = Tag::find($request->id);
            if ($tag) {
                $tag_product = Product::whereRaw("FIND_IN_SET('" . $request->id . "',tag_id)")->count();
                if($tag_product>0){
                    return response()->json(['status' => false, 'message' => 'Error : Products with Tag "' . $tag->title . '" exists']);
                }
                else{

                    if ($tag->delete()) {
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

    /************************************* Measurement Unit starts ****************************************/
    public function measurement_unit()
    {
        $title = "Measurement Unit List";
        $measurementUnitList = MeasurementUnit::get();
        return view('Admin.product.measurement_unit.list', compact('measurementUnitList', 'title'));
    }

    public function measurement_unit_create()
    {
        $key = "Create";
        $title = "Create Measurement Unit";
        return view('Admin.product.measurement_unit.form', compact('key', 'title'));
    }

    public function measurement_unit_store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:measurement_units,title',
            'symbol' => 'required|unique:measurement_units,symbol',
        ]);
        $measurement_unit = new MeasurementUnit;
        $measurement_unit->title = $validatedData['title'];
        $measurement_unit->symbol = $validatedData['symbol'];
        if ($measurement_unit->save()) {
            session()->flash('success', "Measurement Unit '" . $measurement_unit->title . "' has been added successfully");
            return redirect(Helper::sitePrefix() . 'product/measurement-unit');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the measurement unit");
        }
    }

    public function measurement_unit_edit($id)
    {
        $key = "Update";
        $title = "Update Measurement Unit";
        $measurement_unit = MeasurementUnit::find($id);
        if ($measurement_unit) {
            return view('Admin.product.measurement_unit.form', compact('key', 'measurement_unit', 'title'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function measurement_unit_update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:measurement_units,title,' . $id,
            'symbol' => 'required|unique:measurement_units,symbol,' . $id,
        ]);
        $measurement_unit = MeasurementUnit::find($id);
        $measurement_unit->title = $validatedData['title'];
        $measurement_unit->symbol = $validatedData['symbol'];
        $measurement_unit->updated_at = now();
        if ($measurement_unit->save()) {
            session()->flash('success', "Measurement Unit '" . $measurement_unit->title . "' has been updated successfully");
            return redirect(Helper::sitePrefix() . 'product/measurement-unit');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the measurement unit");
        }
    }

    public function delete_measurement_unit(Request $request)
    {
        if (isset($request->id) && $request->id != NULL) {
            $measurement_unit = MeasurementUnit::find($request->id);
            if ($measurement_unit) {
                if ($measurement_unit->delete()) {
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

    /************************************* Product Type starts ****************************************/
    public function product_type()
    {
        $title = "Product Type List";
        $productTypeList = ProductType::get();
        return view('Admin.product.product_type.list', compact('productTypeList', 'title'));
    }

    public function product_type_create()
    {
        $key = "Create";
        $title = "Create Product Type";
        return view('Admin.product.product_type.form', compact('key', 'title'));
    }

    public function product_type_store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:product_types,title',
            'image' => 'image|mimes:jpeg,png,jpg|max:512',
            'alternate_image' => 'image|mimes:jpeg,png,jpg|max:512'
        ]);
        $product_type = new ProductType;

        if ($request->hasFile('image')) {
            $product_type->image_webp = Helper::uploadWebpImage($request->image, 'uploads/product/image/webp/', $request->title);
            $product_type->image = Helper::uploadFile($request->image, 'uploads/product/image/', $request->title);
        }
        if ($request->hasFile('alternate_image')) {
            $product_type->alternate_image_webp = Helper::uploadWebpImage($request->alternate_image, 'uploads/product/image/webp/', $request->title);
            $product_type->alternate_image = Helper::uploadFile($request->alternate_image, 'uploads/product/image/', $request->title);
        }
        $product_type->title = $validatedData['title'];
        if ($product_type->save()) {
            session()->flash('success', "Product Type'" . $product_type->title . "' has been added successfully");
            return redirect(Helper::sitePrefix() . 'product/product-type');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the Product Type");
        }
    }

    public function product_type_edit($id)
    {
        $key = "Update";
        $title = "Update Product Type";
        $product_type = ProductType::find($id);
        if ($product_type) {
            return view('Admin.product.product_type.form', compact('key', 'product_type', 'title'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function product_type_update(Request $request, $id)
    {
        $product_type = ProductType::find($id);
        $validatedData = $request->validate([
            'title' => 'required|unique:product_types,title,' . $id,
            'image' => 'image|mimes:jpeg,png,jpg|max:512',
        ]);
        if ($request->hasFile('image')) {
            if (File::exists(public_path($product_type->image))) {
                File::delete(public_path($product_type->image));
            }
            if (File::exists(public_path($product_type->image_webp))) {
                File::delete(public_path($product_type->image_webp));
            }
            $product_type->image_webp = Helper::uploadWebpImage($request->image, 'uploads/product/image/webp/', $request->title);
            $product_type->image = Helper::uploadFile($request->image, 'uploads/product/image/', $request->title);
        }
        if ($request->hasFile('alternate_image')) {
            if (File::exists(public_path($product_type->alternate_image))) {
                File::delete(public_path($product_type->alternate_image));
            }
            if (File::exists(public_path($product_type->alternate_image_webp))) {
                File::delete(public_path($product_type->alternate_image_webp));
            }
            $product_type->alternate_image_webp = Helper::uploadWebpImage($request->alternate_image, 'uploads/product/image/webp/', $request->title);
            $product_type->alternate_image = Helper::uploadFile($request->alternate_image, 'uploads/product/image/', $request->title);
        }


        $product_type->title = $validatedData['title'];
        if ($product_type->save()) {
            session()->flash('success', "Product Type '" . $product_type->title . "' has been updated successfully");
            return redirect(Helper::sitePrefix() . 'product/product-type');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the product Type");
        }
    }

    public function delete_product_type(Request $request)
    {
        if (isset($request->id) && $request->id != NULL) {
            $product_type = ProductType::find($request->id);
            if ($product_type) {
                if ($product_type->delete()) {
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

    /************************************* Size starts ****************************************/
    public function size()
    {
        $title = "Size List";
        $sizeList = Size::get();
        return view('Admin.product.size.list', compact('sizeList', 'title'));
    }

    public function size_create()
    {
        $key = "Create";
        $title = "Create Size";
        return view('Admin.product.size.form', compact('key', 'title'));
    }

    public function size_store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:sizes,title,NULL,id,deleted_at,NULL',
            // 'price' => 'required|unique:sizes,price,NULL,id,deleted_at,NULL',
            'image' => 'image|mimes:jpeg,png,jpg|max:512'

        ]);
        $size = new Size;
        if ($request->hasFile('image')) {
            $size->image_webp = Helper::uploadWebpImage($request->image, 'uploads/product/image/webp/', $request->title);
            $size->image = Helper::uploadFile($request->image, 'uploads/product/image/', $request->title);
        }
        $size->image_attribute = $request->image_attribute;
        $size->title = $validatedData['title'];
        // $size->price = $validatedData['price'];
        if ($size->save()) {
           session()->flash('success', "Size '" . $size->title . "' has been added successfully");
            return redirect(Helper::sitePrefix() . 'product/size');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the size");
        }
    }

    public function size_edit(Request $request, $id)
    {
        $key = "Update";
        $title = "Update Size";
        $size = Size::find($id);
        if ($size) {
            return view('Admin.product.size.form', compact('key', 'size', 'title'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function size_update(Request $request, $id)
    {
        $size = Size::find($id);
        $validatedData = $request->validate([
            'title' => 'required|unique:sizes,title,' . $id,
            // 'price' => 'required|unique:sizes,price,' . $id,
            'image' => 'image|mimes:jpeg,png,jpg|max:512',

        ]);
        if ($request->hasFile('image')) {
            if (File::exists(public_path($size->image))) {
                File::delete(public_path($size->image));
            }
            if (File::exists(public_path($size->image_webp))) {
                File::delete(public_path($size->image_webp));
            }
            $size->image_webp = Helper::uploadWebpImage($request->image, 'uploads/product/image/webp/', $request->title);
            $size->image = Helper::uploadFile($request->image, 'uploads/product/image/', $request->title);
        }
        $size->title = $validatedData['title'];
        $size->image_attribute = $request->image_attribute;
        // $size->price = $validatedData['price'];
        $size->updated_at = now();
        if ($size->save()) {
           session()->flash('success', "Size '" . $size->title . "' has been updated successfully");
            return redirect(Helper::sitePrefix() . 'product/size');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the size");
        }
    }

    public function delete_size(Request $request)
    {
        if (isset($request->id) && $request->id != NULL) {
            $size = Size::find($request->id);
            if ($size) {
                $productPriceSize = ProductPrice::where('size_id', $size->id)->count();

                if($productPriceSize>0){
                    return response()->json(['status' => false, 'message' => 'Error : Products with Size "' . $size->title . '" exists']);
                }
                else{

                    $deleted = $size->delete();
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

    /************************************* Shape starts ****************************************/
    public function shape()
    {
        $title = "Shape List";
        $shapeList = Shape::get();
        return view('Admin.product.shape.list', compact('shapeList', 'title'));
    }

    public function shape_create()
    {
        $key = "Create";
        $title = "Create Shape";
        return view('Admin.product.shape.form', compact('key', 'title'));
    }

    public function shape_store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:shapes,title,NULL,id,deleted_at,NULL',
            'image' => 'image|mimes:jpeg,png,jpg|max:512'
        ]);
        $shape = new Shape;
        if ($request->hasFile('image')) {
            $shape->image_webp = Helper::uploadWebpImage($request->image, 'uploads/product/image/webp/', $request->title);
            $shape->image = Helper::uploadFile($request->image, 'uploads/product/image/', $request->title);
        }
        if ($request->hasFile('icon')) {
            $shape->icon_webp = Helper::uploadWebpImage($request->icon, 'uploads/product/image/webp/', $request->title);
            $shape->icon = Helper::uploadFile($request->icon, 'uploads/product/image/', $request->title);
        }
        $shape->title = $validatedData['title'];
        $shape->image_attribute = $request->image_attribute;
        $shape->icon_attribute = $request->icon_attribute;
        if ($shape->save()) {
            session()->flash('success', "Shape '" . $shape->title . "' has been added successfully");
            return redirect(Helper::sitePrefix() . 'product/shape');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the shape");
        }
    }

    public function shape_edit(Request $request, $id)
    {
        $key = "Update";
        $title = "Update Shape";
        $shape = Shape::find($id);
        if ($shape) {
            return view('Admin.product.shape.form', compact('key', 'shape', 'title'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function shape_update(Request $request, $id)
    {
        $shape = Shape::find($id);
        $validatedData = $request->validate([
            'title' => 'required|unique:shapes,title,' . $id,
            'image' => 'image|mimes:jpeg,png,jpg|max:512',

        ]);
        if ($request->hasFile('image')) {
            if (File::exists(public_path($shape->image))) {
                File::delete(public_path($shape->image));
            }
            if (File::exists(public_path($shape->image_webp))) {
                File::delete(public_path($shape->image_webp));
            }
            
            $shape->image_webp = Helper::uploadWebpImage($request->image, 'uploads/product/image/webp/', $request->title);
            $shape->image = Helper::uploadFile($request->image, 'uploads/product/image/', $request->title);
        }
        if ($request->hasFile('icon')) {
            if (File::exists(public_path($shape->icon))) {
                File::delete(public_path($shape->icon));
            }
            if (File::exists(public_path($shape->icon_webp))) {
                File::delete(public_path($shape->icon_webp));
            }
            $shape->icon_webp = Helper::uploadWebpImage($request->icon, 'uploads/product/image/webp/', $request->title);
            $shape->icon = Helper::uploadFile($request->icon, 'uploads/product/image/', $request->title);
        }
        $shape->title = $validatedData['title'];
        $shape->updated_at = now();
        if ($shape->save()) {
           session()->flash('success', "Shape '" . $shape->title . "' has been updated successfully");
            return redirect(Helper::sitePrefix() . 'product/shape');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the shape");
        }
    }

    public function delete_shape(Request $request)
    {
        if (isset($request->id) && $request->id != NULL) {
            $shape = Shape::find($request->id);
            if ($shape) {
                $shape_product = Product::whereRaw("FIND_IN_SET('" . $request->id . "',shape_id)")->count();
                if($shape_product>0){
                    return response()->json(['status' => false, 'message' => 'Error : Products with Shape "' . $shape->title . '" exists']);
                }
                else{

                    $deleted = $shape->delete();
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
    /************************************* Frame starts ****************************************/
    public function frame()
    {
        $title = "frame List";
        $frameList = Frame::get();
        return view('Admin.product.frame.list', compact('frameList', 'title'));
    }

    public function frame_create()
    {
        $key = "Create";
        $title = "Create Frame";
        return view('Admin.product.frame.form', compact('key', 'title'));
    }

    public function frame_store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'title' => 'required|unique:frames,title',
            'image' => 'image|mimes:jpeg,png,jpg|max:512',
            // 'color' => 'required|unique:frames,deleted_at,NULL',
            'code' => 'required|unique:frames,deleted_at,NULL',
        ]);
        $frame = new Frame;

        if ($request->hasFile('image')) {
            $frame->image_webp = Helper::uploadWebpImage($request->image, 'uploads/frame/image/webp/', $request->title);
            $frame->image = Helper::uploadFile($request->image, 'uploads/frame/image/', $request->title);
        }
        $frame->title = $validatedData['title'];
        $frame->image_attribute = $request->image_attribute;
        // $frame->color = $validatedData['color'];
        $frame->code = $validatedData['code'];
        if ($frame->save()) {
            session()->flash('success', "Frame '" . $frame->title . "' has been added successfully");
            return redirect(Helper::sitePrefix() . 'product/frame');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the frame");
        }
    }

    public function frame_edit($id)
    {
        $key = "Update";
        $title = "Update Frame";
        $frame = Frame::find($id);
        if ($frame) {
            return view('Admin.product.frame.form', compact('key', 'frame', 'title'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function frame_update(Request $request, $id)
    {
        $frame = Frame::find($id);
        $validatedData = $request->validate([
            'title' => 'required|unique:frames,title,' . $id,
            'image' => 'image|mimes:jpeg,png,jpg|max:512',
            // 'color' => 'required|unique:frames,color,' . $id,
            'code' => 'required|unique:frames,code,' . $id,
        ]);
        if ($request->hasFile('image')) {
            if (File::exists(public_path($frame->image))) {
                File::delete(public_path($frame->image));
            }
            if (File::exists(public_path($frame->image_webp))) {
                File::delete(public_path($frame->image_webp));
            }
            $frame->image_webp = Helper::uploadWebpImage($request->image, 'uploads/frame/image/webp/', $request->title);
            $frame->image = Helper::uploadFile($request->image, 'uploads/frame/image/', $request->title);
        }
        $frame->image_attribute = $request->image_attribute;
        $frame->title = $validatedData['title'];
        $frame->updated_at = now();
        if ($frame->save()) {
           session()->flash('success', "Frame '" . $frame->title . "' has been updated successfully");
            return redirect(Helper::sitePrefix() . 'product/frame');
        } else {
            return back()->withInput($request->input())->withErrors("Error while updating the frame");
        }
    }

    public function delete_frame(Request $request)
    {
        if (isset($request->id) && $request->id != NULL) {
            $frame = Frame::find($request->id);
            if ($frame) {
                $frame_product = Product::whereRaw("FIND_IN_SET('" . $request->id . "',frame_color)")->count();
                if($frame_product>0){
                    return response()->json(['status' => false, 'message' => 'Error : Products with Shape "' . $frame->title . '" exists']);
                }
                else{

                    $deleted = $frame->delete();
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
}


