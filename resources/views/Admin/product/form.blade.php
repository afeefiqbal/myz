@extends('Admin.layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="nav-icon fas fa-user-shield"></i> {{$title}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{url(Helper::sitePrefix().'product/')}}">Product</a>
                        </li>
                        <li class="breadcrumb-item active">{{$title}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form role="form" id="ProductFormWizard" data-product_id="{{@$product->id}}"
                  action="{{@$key=='Copy'?url(Helper::sitePrefix().'product/create'):''}}" class="form--wizard"
                  enctype="multipart/form-data" method="post">
                {{csrf_field()}}
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Product Form</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>

                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session('success') }}
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label> Title*</label>
                                <input type="text" name="title" id="title" placeholder="Title"
                                       class="form-control required for_canonical_url" autocomplete="off"
                                       {{@$key=='Copy'? 'readonly' :''}}
                                       value="{{ isset($product)?$product->title: old('title') }}">
                                <div class="help-block with-errors" id="title_error"></div>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label> Short URL *</label>
                                <input type="text" name="short_url" id="short_url" placeholder="Short URL"
                                       class="form-control required" autocomplete="off"
                                       value="{{ isset($product)?$product->short_url:'' }}">
                                <div class="help-block with-errors" id="short_url_error"></div>
                                @error('short_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Sku/Product Code*</label>
                                <input type="text" name="sku" id="sku" placeholder="Product Code"
                                       class="form-control required" autocomplete="off"
                                       value="{{ isset($product)?$product->sku:'' }}">
                                <div class="help-block with-errors" id="sku_error"></div>
                                @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label> Category*</label>
                                <select name="category[]" id="category" multiple
                                        class="form-control select2 required">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}"
                                            @if(isset($product))
                                            @php
                                                $productCategories = explode(',',$product->category_id);
                                            @endphp
                                       
                                        {{(in_array($category->id,$productCategories))?'selected':''}}
                                      
                                        @endif
                                        {{ in_array($category->id, old('category', [])) ? 'selected' : '' }}
                                            >{{$category->title}}</option>
                                     
                                    @endforeach
                                </select>
                                <div class="help-block with-errors" id="category_error"></div>
                                @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label> Sub Category *</label>
                                <select class="form-control select2 " name="sub_category[]"
                                        id="sub_category" multiple>
                                    @if(isset($subCategories))
                                        @foreach($subCategories as $second)

                                            <option value="{{$second->id}}"
                                                @if(isset($product))
                                                @php
                                                    $productSubCategories = explode(',',$product->sub_category_id);
                                                @endphp
                                           
                                            {{(in_array($second->id,$productSubCategories))?'selected':''}}
                                          
                                            @endif
                                            {{ in_array($second->id, old('sub_category', [])) ? 'selected' : '' }}
                                            >{{$second->title}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="help-block with-errors" id="sub_category_error"></div>
                                @error('sub_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label> Tags *</label>
                                <select class="form-control select2 required " name="tags[]" id="tag_id" multiple>
                                    @foreach($tags as $tag)
                                    <option value="{{$tag->id}}"

                                        @if(isset($product))
                                        @php
                                            $productTags = explode(',',$product->tag_id);
                                        @endphp
                                   
                                    {{(in_array($tag->id,$productTags))?'selected':''}}
                                  
                                    @endif
                                    {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}
                                   >{{$tag->title}}</option>
                                @endforeach
                                </select>
                                <div class="help-block with-errors" id="tag_id_error"></div>
                                @error('tags')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label> Colours *</label>
                                <select class="form-control select2 required" name="colors[]" id="color_id" multiple>
                                    @foreach($colors as $color)
                                    <option value="{{$color->id}}"

                                        @if(isset($product))
                                        @php
                                            $productColors = explode(',',$product->color_id);
                                        @endphp
                                   
                                    {{(in_array($color->id,$productColors))?'selected':''}}
                                  
                                    @endif
                                    {{ in_array($color->id, old('colors', [])) ? 'selected' : '' }}
                                   >{{$color->title}}</option>
                                @endforeach
                                </select>
                                <div class="help-block with-errors" id="color_id_error"></div>
                                @error('colors')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label> Product Description*</label>
                                <textarea name="description" id="description"
                                          placeholder="Description" class="form-control required tinyeditor"
                                          autocomplete="off">{{ isset($product)?$product->description:'' }}</textarea>
                                <div class="help-block with-errors" id="description_error"></div>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="form-row">




                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label> Product Type*</label>
                                <select name="product_type_id" id="type"
                                        class="form-control  required">
                                    <option value="">Select product type </option>
                                    @foreach($productTypes as $productType)
                                        <option value="{{$productType->id}}"
                                            {{ (@$productType->id==@$product->product_type_id)?'selected':'' }}
                                        >{{$productType->title}}</option>
                                    @endforeach
                                </select>
                                <div class="help-block with-errors" id="type_error"></div>
                                @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-3 frame_div  d-none">
                                <label> Frame Colour *</label>
                                <select name="frame_color[]" id="frame_color"  class="form-control select2 " multiple>
                                    <option value="">Select Frame Colour </option>
                                    @foreach($frames as $frame)

                                        <option value="{{$frame->id}}" 
                                            @if(isset($product))
                                            @php
                                                $productFrames = explode(',',$product->frame_color);
                                            @endphp
                                            {{(in_array($frame->id,$productFrames))?'selected':''}}
                                  
                                            @endif
                                            {{ in_array($frame->id, old('frame_color', [])) ? 'selected' : '' }}
                                             >{{$frame->title}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group col-md-3 mount_div  d-none">
                                <label> Has Mount *</label>
                              <input type="checkbox" name="is_mount" id="is_mount" class="form-check" @if(@$product->is_mount) checked @endif >
                            </div>
                            <div class="form-group col-md-3 ">
                                <label> Shapes *</label>
                                <select name="shapes[]" id="shapes"  class="form-control select2 required" multiple>
                                    <option value="">Select Shapes </option>
                                    @foreach($shapes as $shape)
                                        <option value="{{$shape->id}}"  
                                          
                                        @if(isset($product))
                                        @php
                                            $productShapes = explode(',',$product->shape_id);
                                        @endphp
                                   
                                    {{(in_array($shape->id,$productShapes))?'selected':''}}
                                  
                                    @endif
                                    {{ in_array($shape->id, old('shapes', [])) ? 'selected' : '' }}
                                            >{{$shape->title}}</option>
                                    @endforeach
                                </select>
                                <div class="help-block with-errors" id="shapes_error"></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <table class="table table-active">
                                <thead>
                                    <th>Size *</th>
                                    <th> Price *</th>
                                    <th> Availability*</th>
                                    <th> Stock*</th>
                                    <th> Alert Quantity *</th>
                                </thead>
                                @if (!isset($product))
                                <tbody>
                                    @foreach ($sizes as $size)
                                    <tr>
                                        <td>
                                            {{$size->title}}
                                        </td>
                                        <td>
                                            <input type="hidden" name="size[]" id="" value="{{$size->id}}">
                                            <input type="text" name="price[{{$size->id}}]" id="price{{$size->id}}"   class="form-control price-field" value="{{isset($product)?$product->price:''}}">

                                        </td>
                                        <td>
                                                <select class="form-control required"  name="availability[{{$size->id}}]"  id="availability">
                                                    @foreach(["In Stock", "Out of Stock"] AS $availability)
                                                        <option value="{{ $availability }}"
                                                            {{ old("availability", @$product->availability) == $availability ? "selected" : "" }}>{{ $availability }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block with-errors" id="availability_error"></div>
                                                @error('availability')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror


                                        </td>
                                        <td>

                                            <input type="text" name="stock[{{$size->id}}]" id="stock" placeholder="Stock"
                                                    class="form-control stock {{(@$product->availability=='Out of Stock')?'':'required'}}"
                                                    autocomplete="off" value="{{ isset($product)?$product->stock:'2' }}">
                                            <div class="help-block with-errors" id="stock_error"></div>
                                            @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-group col-md-3 availability_div"      style="display: {{(@$product->availability=='Out of stock')?'none':''}};">
                                            </div>
                                        </td>
                                        <td>

                                            <input type="text"name="alert_quantity[{{$size->id}}]" id="alert_quantity"
                                                    placeholder="Alert Quantity"
                                                    class="form-control alert_quantity {{(@$product->quantity=='Out of Stock')?'':'required'}}"
                                                    autocomplete="off"
                                                    value="{{ isset($product)?$product->alert_quantity:'1' }}">
                                            <div class="help-block with-errors" id="alert_quantity_error"></div>
                                            @error('alert_quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror


                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                                    @else
                                    <tbody>
                                        @foreach ($sizes as $size)
                                        <tr>
                                            <td>
                                                {{$size->title}}
                                            </td>
                                            <td>
                                                @php
                                                    $price = App\Models\ProductPrice::where('product_id',$product->id)->where('size_id',$size->id)->first();
                                                @endphp
                                                <input type="hidden" name="size[]" id="" value="{{$size->id}}">
                                                <input type="text" name="price[{{$size->id}}]" id="price" class="form-control  price-field" value="{{isset($price)?$price->price:''}}">
                                                <div class="help-block with-errors price-error" id="price_error"></div>
                                            </td>
                                        </td>
                                        <td>
                                                <select class="form-control  availability" name="availability[{{$size->id}}]" id="availability">
                                                    @foreach(["In Stock", "Out of Stock"] AS $availability)
                                                        <option value="{{ $availability }}"
                                                            {{ old("availability", @$price->availability) == $availability ? "selected" : "" }}>{{ $availability }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block with-errors" id="availability_error"></div>
                                                @error('availability')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror


                                        </td>
                                        <td>

                                            <input type="text" name="stock[{{$size->id}}]" id="stock" placeholder="Stock"
                                                    class="form-control stock {{(@$product->availability=='Out of Stock')?'':''}}"
                                                    autocomplete="off" value="{{ isset($price)?$price->stock:'2' }}">
                                            <div class="help-block with-errors" id="stock_error"></div>
                                            @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-group col-md-3 availability_div"      style="display: {{(@$price->availability=='Out of stock')?'none':''}};">
                                            </div>
                                        </td>
                                        <td>

                                            <input type="text" name="alert_quantity[{{$size->id}}]" id="alert_quantity"
                                                    placeholder="Alert Quantity"
                                                    class="form-control alert_quantity {{(@$price->quantity=='Out of Stock')?'':''}}"
                                                    autocomplete="off"
                                                    value="{{ isset($price)?$price->alert_quantity:'1' }}">
                                            <div class="help-block with-errors" id="alert_quantity_error"></div>
                                            @error('alert_quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror


                                        </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label> Product Thumbnail Image*</label>
                                <div class="file-loading">
                                    <input id="thumbnail_image" name="thumbnail_image" type="file" class="required"
                                           accept="image/png, image/jpg, image/jpeg">
                                </div>
                                <span class="caption_note">Note: Image Size must be less than 512KB</span>
                                @error('thumbnail_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label> Product Thumbnail Attribute*</label>
                                <input type="text" name="thumbnail_image_attribute"
                                       id="thumbnail_image_attribute"
                                       placeholder="Alt='Product Thumbnail Attribute'"
                                       class="form-control placeholder-cls" autocomplete="off"
                                       value="{{ isset($product)?$product->thumbnail_image_attribute:'' }}">
                                @error('thumbnail_image_attribute')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label> You May Also Like</label>
                                <select name="similar_product_id[]" multiple id="similar_product_id"
                                        class="form-control select2">
                                    @foreach($products as $similar)
                                        <option value="{{ $similar->id  }}"
                                                
                                        @if(isset($product))
                                        @php
                                            $productSimilars = explode(',',$product->similar_product_id);
                                        @endphp
                                   
                                    {{(in_array($similar->id,$productSimilars))?'selected':''}}
                                  
                                    @endif
                                    {{ in_array($similar->id, old('similar_product_id', [])) ? 'selected' : '' }}
                                            >{{ $similar->title }}</option>
                                    @endforeach
                                </select>
                                @error('similar_product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                         
                            <div class="form-group col-md-6">
                                <label> Related products </label>
                                <select name="related_product_id[]" multiple id="related_product_id"
                                        class="form-control select2">
                                    @foreach($products as $related)
                                        <option value="{{ $related->id }}"
                                            @if(isset($product))
                                        @php
                                            $productRelated = explode(',',$product->related_product_id);
                                        @endphp
                                   
                                    {{(in_array($related->id,$productRelated))?'selected':''}}
                                  
                                    @endif
                                    {{ in_array($related->id, old('related_product_id', [])) ? 'selected' : '' }}
                                            >{{ $related->title }}</option>
                                    @endforeach
                                </select>
                                @error('related_product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Banner Image</label>
                                <div class="file-loading">
                                    <input id="desktop_banner" name="desktop_banner" type="file"
                                            accept="image/png, image/jpg, image/jpeg">
                                </div>
                                <span class="caption_note">Note: uploaded images have a maximum size of <strong> 1920x500</strong> pixels and can't be over 512kb</span>
                                @error('desktop_banner')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label> Banner Attribute</label>
                                <input type="text" name="banner_attribute"
                                        id="banner_attribute"
                                        placeholder="Alt='Product Thumbnail Attribute'"
                                        class="form-control placeholder-cls" autocomplete="off"
                                        value="{{ isset($product)?$product->banner_attribute:'' }}">
                                @error('banner_attribute')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label> About This Item</label>
                                <textarea name="about_this_item" id="about_this_item"
                                          placeholder="About This Item" class="form-control   tinyeditor"
                                          autocomplete="off">{{ isset($product)?$product->about_item:'' }}</textarea>

                                @error('about_this_item')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Featured Image</label>
                                <div class="file-loading">
                                    <input id="featured_image" name="featured_image" type="file"
                                            accept="image/png, image/jpg, image/jpeg">
                                </div>
                                <span class="caption_note">Note: uploaded images have a maximum size of <strong> 900x830</strong> pixels and can't be over 512kb</span>
                                @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label> Featured Attribute</label>
                                <input type="text" name="featured_image_attribute"
                                        id="featured_image_attribute"
                                        placeholder="Alt='Product Thumbnail Attribute'"
                                        class="form-control placeholder-cls" autocomplete="off"
                                        value="{{ isset($product)?$product->featured_image_attribute:'' }}">
                                @error('featured_image_attribute')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="form-group col-md-12">
                                <label> Feature Description</label>
                                <textarea name="feature_description" id="feature_description"
                                          placeholder="Feture Description" class="form-control  tinyeditor"
                                          autocomplete="off">{{ isset($product)?$product->featured_description:'' }}</textarea>
                                <div class="help-block with-errors" id="feature_description_error"></div>
                                @error('feature_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label> Meta Title</label>
                                <textarea class="form-control" id="meta_title" name="meta_title" rows="4"
                                          placeholder="Meta Title">{{ isset($product)?$product->meta_title:'' }}</textarea>
                                @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label> Meta Description</label>
                                <textarea class="form-control" id="meta_description" name="meta_description" rows="4"
                                          placeholder="Meta Description">{{ isset($product)?$product->meta_description:'' }}</textarea>
                                @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label> Meta Keyword</label>
                                <textarea class="form-control" id="meta_keyword" name="meta_keyword" rows="4"
                                          placeholder="Meta Keyword">{{ isset($product)?$product->meta_keyword:'' }}</textarea>
                                @error('meta_keyword')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label> Other Meta Tag</label>
                                <textarea class="form-control" id="other_meta_tag" name="other_meta_tag" rows="4"
                                          placeholder="Other Meta Tag">{{ isset($product)?$product->other_meta_tag:'' }}</textarea>
                                @error('other_meta_tag')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="submit" id="btn_save" name="btn_save"
                               data-id="{{isset($product)?$product->id:''}}" value="Submit"
                               class="btn btn-primary pull-left submitBtn">
                        <button type="reset" class="btn btn-default">Cancel</button>
                        @if(@$key)
                            <input type="hidden" value="{{@$key}}" name="copy" id="copy">
                            <input type="hidden" value="{{@$product->id}}" name="copy_product_id" id="copy_product_id">
                        @endif
                        <input type="hidden" name="id" id="id" value="{{ isset($product)?$product->id:'0' }}">
                        <img class="animation__shake loadingImg" src="{{url('backend/dist/img/loading.gif')}}"
                             style="display:none;">
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
<script type="text/javascript">
$('#thumbnail_image').on('change',function(){
    $('#thumbnail_image').removeClass('required');
})
$('#type').on('change', function () {
        var type =$(this).val();
        if (type == 4) {
            $('.mount_div').removeClass('d-none');
            $('.frame_div').removeClass('d-none');

        } else {
            $('.mount_div').addClass('d-none');
            $('.frame_div').addClass('d-none');

        }
    });
    $(document).ready(function () {

        @if(isset($product))
        $('#thumbnail_image').removeClass('required');
        var type =$('#type').val();
        if (type == 4) {
            $('.mount_div').removeClass('d-none');
            $('.frame_div').removeClass('d-none');

        } else {
            $('.mount_div').addClass('d-none');
            $('.frame_div').addClass('d-none');

        }
        // $('#similar_product_id').val([{{@$product->similar_product_id}}]).change();
        // $('#shapes').val([{{@$product->shape_id}}]).change();
        // $('#tag_id').val([{{@$product->tag_id}}]).change();
        // $('#frame_color').val([{{@$product->frame_color}}]).change();
        // $('#related_product_id').val([{{@$product->related_product_id}}]).change();
        // $('#category').val([{{@$product->category_id}}]).change();
        // $('#color_id').val([{{@$product->color_id}}]).change()
        // $('#sub_category').val([{{@$product->sub_category_id}}]).change();
        @endif
        $("#thumbnail_image").fileinput({
            'theme': 'explorer-fas',
            validateInitialCount: true,
            overwriteInitial: false,
            autoReplace: true,
            initialPreviewShowDelete: false,
            initialPreviewAsData: true,
            dropZoneEnabled: false,
            required: true,
            allowedFileTypes: ['image'],

            maxFileSize: 512,
            showRemove: true,
            @if(isset($product) && $product->thumbnail_image!=NULL)
                initialPreview: ["{{asset($product->thumbnail_image)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($product->thumbnail_image!=NULL)?last(explode('/',$product->thumbnail_image)):''}}",
                    width: "120px",
                    key: "{{'Product/thumbnail_image/'.$product->id.'/thumbnail_image_webp' }}",
                }],
                @endif
        });

        $("#desktop_banner").fileinput({
            'theme': 'explorer-fas',
            validateInitialCount: true,
            overwriteInitial: false,
            autoReplace: true,
            initialPreviewShowDelete: false,
            initialPreviewAsData: true,
            dropZoneEnabled: false,
            required: false,
            allowedFileTypes: ['image'],
            minImageWidth: 1920,
            minImageHeight: 500,
            maxImageWidth: 1920,
            maxImageHeight: 500,
            maxFileSize: 512,
            showRemove: true,
            @if(isset($product) && $product->desktop_banner!=NULL)
                initialPreview: ["{{asset($product->desktop_banner)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($product->desktop_banner!=NULL)?last(explode('/',$product->desktop_banner)):''}}",
                    width: "120px",
                    key: "{{'Product/desktop_banner/'.$product->id.'/desktop_banner_webp' }}",
                }],
                @endif
        });

        $("#featured_image").fileinput({
            'theme': 'explorer-fas',
            validateInitialCount: true,
            overwriteInitial: false,
            autoReplace: true,
            initialPreviewShowDelete: false,
            initialPreviewAsData: true,
            dropZoneEnabled: false,
            required: false,
            allowedFileTypes: ['image'],
            minImageWidth: 900,
            minImageHeight: 830,
            maxImageWidth: 900,
            maxFileSize: 512,
            maxImageHeight: 830,
            showRemove: true,
            @if(isset($product) && $product->featured_image!=NULL)
                initialPreview: ["{{asset($product->featured_image)}}",],
                initialPreviewConfig: [{
                    caption: "{{ ($product->featured_image!=NULL)?last(explode('/',$product->featured_image)):''}}",
                    width: "120px",
                    key: "{{'Product/featured_image/'.$product->id.'/featured_image_webp' }}",
                }],
                @endif
        });
    });
</script>
@endsection
