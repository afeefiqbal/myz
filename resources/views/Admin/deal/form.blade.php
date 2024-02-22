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
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'deal')}}">Deal</a></li>
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
                <form role="form" id="formWizard" class="form--wizard" enctype="multipart/form-data" method="post">
                    {{csrf_field()}}
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Deal Form</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Title*</label>
                                    <input type="text" name="title" id="title" placeholder="Title"
                                           class="form-control required for_canonical_url required" autocomplete="off"
                                           value="{{ isset($deal)?$deal->title:'' }}">
                                    <div class="help-block with-errors" id="title_error"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Canonical URL*</label>
                                    <input type="text" name="short_url" id="short_url" placeholder="Canonical URL"
                                           class="form-control required" autocomplete="off"
                                           value="{{ isset($deal)?$deal->short_url:'' }}">
                                    <div class="help-block with-errors" id="short_url_error"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Start Date*</label>
                                    <input type="date" max="2999-12-31" name="start_date" id="start_date"
                                           placeholder="Start Date"
                                           class="form-control required" autocomplete="off"
                                           value="{{ isset($deal)?$deal->start_date:'' }}">
                                    <div class="help-block with-errors" id="start_date_error"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label> End Date*</label>
                                    <input type="date" max="2999-12-31" name="end_date" id="end_date"
                                           placeholder="Start Date"
                                           class="form-control required" autocomplete="off"
                                           value="{{ isset($deal)?$deal->end_date:'' }}">
                                    <div class="help-block with-errors" id="end_date_error"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label> Deal Type*</label>
                                    <select class="form-control required" name="offer_type" id="offer_type">
                                        <option value="">Select Option</option>
                                        @foreach(['Fixed','Normal','Percentage'] as $offer_type)
                                            <option
                                                value="{{ $offer_type }}" {{(@$deal->offer_type==$offer_type)?'selected':''}}>{{ $offer_type }}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="offer_type_error"></div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Deal Amount*</label>
                                    <input type="number" min="0" name="offer_value" id="offer_value"
                                           placeholder="Deal Amount" class="form-control required" autocomplete="off"
                                           value="{{ isset($deal)?$deal->offer_value:'' }}">
                                    <div class="help-block with-errors" id="offer_value_error"></div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Product List Type*</label>
                                    <select class="form-control product_list_type select2" name="product_list_type"
                                            id="product_list_type">
                                        @foreach(['Brand','Category','Sub-category'] as $product_list_type)
                                            <option value="{{ $product_list_type }}"
                                                {{(@$deal->product_list_type==$product_list_type)?'selected':''}}
                                            >{{ $product_list_type }}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="product_list_type_error"></div>
                                </div>
                            </div>
                            <div class="form-row categoryDiv"
                                 style="display:{{(isset($deal) && $deal->product_list_type!='Brand')?'block':'none'}}">
                                <div class="form-group col-md-6">
                                    <label> Category*</label>
                                    <select class="form-control select2 productGetDrop" name="deal_category_id[]"
                                            id="deal_category_id" multiple>
                                        <option value="">Select Option</option>
                                        @foreach($categories as $cat)
                                            <option value="{{$cat->id}}">{{$cat->title}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="deal_category_id_error"></div>
                                </div>
                                <div class="form-group col-md-6 subCategoryDiv"
                                     style="display:{{(@$deal->product_list_type=='Sub-category')?'block':'none'}}">
                                    <label> Sub-category*</label>
                                    <select class="form-control select2 productGetDropSub" name="deal_sub_category_id[]"
                                            id="deal_sub_category_id" multiple>
                                        @if(@$deal->product_list_type=='Sub-category')
                                            <option value="">Select Option</option>
                                            @foreach($subCategories as $sub)
                                                <option value="{{$sub->id}}">{{$sub->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="help-block with-errors" id="deal_sub_category_id_error"></div>
                                </div>
                            </div>
                            <div class="form-row brandDiv"
                                 style="display:{{(@$deal->product_list_type=='Category'||@$deal->product_list_type=='Sub-category')?'none':'block'}}">
                                <div class="form-group col-md-12">
                                    <label> Brands*</label>
                                    <select class="form-control select2 productGetDrop" multiple name="brand_id[]"
                                            id="brand_id" data-deal_id="{{isset($deal)?$deal->id:'0'}}">
                                        <option value="">Select Option</option>
                                        @foreach($brands as $brand)
                                            <option value="{{$brand->id}}">{{$brand->title}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="type_error"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Offer Type*</label>
                                    <select class="form-control select2 productGetDropOffer" name="offer_option"
                                            id="offer_option" data-deal_id="{{isset($deal)?$deal->id:'0'}}">
                                        @foreach(['Offer','No Offer','Both'] as $offer_option)
                                            <option value="{{ $offer_option }}"
                                                {{(@$deal->offer_option==$offer_option)?'selected':''}}
                                            >{{ $offer_option }}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="offer_option_error"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12 brandProduct">
                                    <label> Products*</label>
                                    <select class="form-control select2 required" name="products[]" multiple
                                            id="products">
                                        @if(@$deal->products!=NULL)
                                            @foreach($products as $product)
                                                <option value="{{$product->id}}">{{$product->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="help-block with-errors" id="products_error"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Banner Title</label>
                                    <input type="text" name="banner_title" id="banner_title"
                                           placeholder="Banner Title"
                                           class="form-control" autocomplete="off"
                                           value="{{ isset($deal)?$deal->banner_title:'' }}">
                                    <div class="help-block with-errors" id="banner_title_error"></div>
                                    @error('banner_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Banner Sub Title</label>
                                    <input type="text" name="banner_sub_title" id="banner_sub_title"
                                           placeholder="Banner Sub Title"
                                           class="form-control" autocomplete="off"
                                           value="{{ isset($deal)?$deal->banner_sub_title:'' }}">
                                    <div class="help-block with-errors" id="banner_sub_title_error"></div>
                                    @error('banner_sub_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label> Desktop Banner</label>
                                    <div class="file-loading">
                                        <input id="desktop_banner" name="desktop_banner" type="file"
                                               accept="image/*">
                                    </div>
                                    <span
                                        class="caption_note">Note: Image size should be minimum of 1920 x 340</span>
                                    @error('desktop_banner')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Mobile Banner</label>
                                    <div class="file-loading">
                                        <input id="mobile_banner" name="mobile_banner" type="file" accept="image/*">
                                    </div>
                                    <span
                                        class="caption_note">Note: Image size should be minimum of 960 x 450</span>
                                    @error('mobile_banner')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Banner Attribute</label>
                                    <input type="text" class="form-control placeholder-cls" id="banner_attribute"
                                           name="banner_attribute" placeholder="Alt='Banner Attribute'"
                                           value="{{ isset($deal)?$deal->banner_attribute:'' }}">
                                    @error('banner_attribute')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Meta Title</label>
                                    <textarea class="form-control" id="meta_title" name="meta_title"
                                              placeholder="Meta Title">{{ isset($deal)?$deal->meta_title:'' }}</textarea>
                                    @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Meta Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description"
                                              placeholder="Meta Description">{{ isset($deal)?$deal->meta_description:'' }}</textarea>
                                    @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Meta Keyword</label>
                                    <textarea class="form-control" id="meta_keyword" name="meta_keyword"
                                              placeholder="Meta Keyword">{{ isset($deal)?$deal->meta_keyword:'' }}</textarea>
                                    @error('meta_keyword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Other Meta Tag</label>
                                    <textarea class="form-control" id="other_meta_tag" name="other_meta_tag"
                                              placeholder="Other Meta Tag">{{ isset($deal)?$deal->other_meta_tag:'' }}</textarea>
                                    @error('other_meta_tag')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="submit" name="btn_save" value="Submit"
                                   class="btn btn-primary pull-left submitBtn">
                            <input type="hidden" name="min_price" id="min_price" value="{{ @$min_price }}">
                            <input type="hidden" name="id" id="id" value="{{ isset($deal)?$deal->id:'0' }}">
                            <button type="reset" class="btn btn-default">Cancel</button>
                            <img class="animation__shake loadingImg" src="{{url('backend/dist/img/loading.gif')}}"
                                 style="display:none;">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#products').val([{{@$deal->products}}]).change();
            var type_value = [{{@$deal->type_value}}];
            if ({{(@$deal->product_list_type == "Brand")?1:0}}) {
                $('#brand_id').val(type_value).change();
            } else if ({{(@$deal->product_list_type == "Category")?1:0}}) {
                $('#deal_category_id').val(type_value).change();
            } else {
                $('#deal_category_id').val([{{ isset($selectedCategories)?implode(',',$selectedCategories):'' }}]).change();
                $('#deal_sub_category_id').val(type_value).change();
            }

            $("#desktop_banner").fileinput({
                'theme': 'explorer-fas',
                validateInitialCount: true,
                overwriteInitial: false,
                autoReplace: true,
                layoutTemplates: {actionDelete: ''},
                removeLabel: "Remove",
                initialPreviewAsData: true,
                dropZoneEnabled: false,
                required: false,
                allowedFileTypes: ['image'],
                minImageWidth: 1920,
                minImageHeight: 340,
                maxImageWidth: 1920,
                maxImageHeight: 340,
                showRemove: true,
                maxFileSize: 512,
                @if(isset($deal) && $deal->desktop_banner!=NULL)
                initialPreview: ["{{asset($deal->desktop_banner)}}",],
                initialPreviewConfig: [{
                    caption: "{{last(explode('/',$deal->desktop_banner))}}",
                    width: "120px"
                }]
                @endif
            });

            $("#mobile_banner").fileinput({
                'theme': 'explorer-fas',
                validateInitialCount: true,
                overwriteInitial: false,
                autoReplace: true,
                initialPreviewShowDelete: false,
                initialPreviewAsData: true,
                dropZoneEnabled: false,
                required: false,
                allowedFileTypes: ['image'],
                minImageWidth: 960,
                minImageHeight: 450,
                maxImageWidth: 960,
                maxImageHeight: 450,
                showRemove: true,
                maxFileSize: 512,
                @if(isset($deal) && $deal->mobile_banner!=NULL)
                initialPreview: ["{{asset($deal->mobile_banner)}}",],
                initialPreviewConfig: [{
                    caption: "{{ last(explode('/',$deal->mobile_banner))}}",
                    width: "120px"
                }]
                @endif
            });
        });
    </script>
@endsection
