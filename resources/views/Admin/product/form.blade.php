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
                            <div class="form-group col-md-4">
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
                            <div class="form-group col-md-4">
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

                            <div class="form-group col-md-4">
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
                            
                            <div class="form-group col-md-4">
                                <label> Select  a Vendor *</label>
                                <select class="form-control select2 required " name="vendor_id" id="vendor_id" >
                                    @foreach($vendors as $vendor)
                                    <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                @endforeach
                                </select>
                                <div class="help-block with-errors" id="vendor_id_error"></div>
                                @error('vendor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label> Stock*</label>
                                <input type="number" name="stock" id="stock" placeholder="Stock" class="form-control {{(@$product->qunatity=='Out of stock')?'':'required'}}" autocomplete="off" value="{{ isset($product)?$product->stock:'2000' }}">
                                <div class="help-block with-errors" id="stock_error"></div>
                            </div>
                            <div class="form-group col-md-4">
                             <label> Quantity*</label>
                             <select class="form-control required" name="quantity" id="quantity">
                                 <option value="In Stock" {{ (@$product->quantity=='In Stock')?'selected':''}}>In
                                     Stock
                                 </option>
                                 <option
                                     value="Out of Stock" {{  (@$product->quantity=='Out of Stock')?'selected':'' }}>
                                     Out of stock
                                 </option>
                             </select>
                             <div class="help-block with-errors" id="quantity_error"></div>
                         </div>
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
                         
                            <div class="form-group col-md-5">
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
                            <div class="form-group col-md-4">
                                <label> Price *</label>
                                <input type="text" name="price" id="price" placeholder="Price"
                                       class="form-control required" autocomplete="off"
                                       value="{{ isset($product)?$product->price:'' }}">
                                <div class="help-block with-errors" id="pricpe_error"></div>
                                @error('price')
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

                            <div class="form-group col-md-12">
                                <label> About this  product*</label>
                                <textarea name="about_this_item" id="about_this_item"
                                          placeholder="about_this_item" class="form-control required tinyeditor"
                                          autocomplete="off">{{ isset($product)?$product->about_this_item:'' }}</textarea>
                                <div class="help-block with-errors" id="description_error"></div>
                                @error('about_this_item')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>


                        </div>
                        <div class="form-row">
                       
                            <div class="form-row" id="quantity_div"
                            style="display: {{(@$product->quantity=='Out of Stock')?'none':''}};">
                          
                        
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
