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
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'coupon')}}">Coupon</a></li>
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
                <form role="form" id="formWizard" class="form--wizard" enctype="multipart/form-data" method="post">
                    {{csrf_field()}}
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Coupon Form</h3>
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
                                <div class="form-group col-md-6">
                                    <label> Code*</label>
                                    <input type="text" name="code" id="code" placeholder="Code"
                                           class="form-control required" autocomplete="off"
                                           value="{{ isset($coupon)?$coupon->code: old('code') }}">
                                    <div class="help-block with-errors" id="code_error"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Title*</label>
                                    <input type="text" name="title" id="title" placeholder="Title"
                                           class="form-control required" autocomplete="off"
                                           value="{{ isset($coupon)?$coupon->title:old('code') }}">
                                    <div class="help-block with-errors" id="title_error"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label> Type*</label>
                                    <select class="form-control required coupon_type" name="type" id="type">
                                        <option value="">Select Type</option>
                                        <option value="Fixed" {{ (@$coupon->type=='Fixed')?'selected':old('type') }}>Fixed
                                        </option>
                                        <option value="Percentage" {{ (@$coupon->type=='Percentage')?'selected':'' }}>
                                            Percentage
                                        </option>
                                    </select>
                                    <div class="help-block with-errors" id="type_error"></div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Coupon Value*</label>
                                    <input type="number" min="0" name="coupon_value" id="coupon_value"
                                           placeholder="Coupon Value" class="form-control required"
                                           autocomplete="off"
                                           value="{{ isset($coupon)?$coupon->coupon_value:old('coupon_value') }}">
                                    <div class="help-block with-errors" id="coupon_value_error"></div>
                                </div>
                                <div class="form-group col-md-4 couponValueLimit"
                                     style="display:{{ (@$coupon->type=='Percentage')?'block':'none' }};">
                                    <label> Coupon Value Limit*</label>
                                    <input type="number" min="0" name="coupon_value_limit" id="coupon_value_limit"
                                           placeholder="Coupon Value Limit"
                                           class="form-control {{ (@$coupon->type=='Percentage')?'required':'' }}"
                                           autocomplete="off" {{ (@$coupon->type=='Percentage')?'':'disabled' }}
                                           value="{{ isset($coupon)?$coupon->coupon_value_limit:old('coupon_value_limit') }}">
                                    <div class="help-block with-errors" id="coupon_value_limit_error"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Free Shipping*</label>
                                    <select class="form-control required" name="is_free_shipping"
                                            id="is_free_shipping">
                                        <option value="">Select Option</option>
                                        <option value="Yes" {{ (@$coupon->is_free_shipping=='Yes')?'selected':old('is_free_shipping') }}>
                                            Yes
                                        </option>
                                        <option value="No" {{ (@$coupon->is_free_shipping=='No')?'selected':old('is_free_shipping') }}>No
                                        </option>
                                    </select>
                                    <div class="help-block with-errors" id="is_free_shipping_error"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Expiry Date* </label>
                                    <input type="date" max="2999-12-31" name="expiry_date" id="expiry_date" min="{{date('Y-m-d')}}"
                                           placeholder="Expiry Date"
                                           class="form-control required" autocomplete="off"
                                           value="{{ isset($coupon)?$coupon->expiry_date:old('expiry_date') }}">
                                    <div class="help-block with-errors" id="expiry_date_error"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label> Minimum Spend</label>
                                    <input type="number" min="0" name="minimum_spend" id="minimum_spend"
                                           placeholder="Minimum Spend" class="form-control" autocomplete="off"
                                           value="{{ isset($coupon)?$coupon->minimum_spend:old('minimum_spend') }}">
                                    <div class="help-block with-errors" id="minimum_spend_error"></div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Maximum Spend </label>
                                    <input type="number" min="0" name="maximum_spend" id="maximum_spend"
                                           placeholder="Maximum Spend" class="form-control" autocomplete="off"
                                           value="{{ isset($coupon)?$coupon->maximum_spend:old('maximum_spend') }}">
                                    <div class="help-block with-errors" id="maximum_spend_error"></div>
                                </div>
                                {{-- <div class="form-group col-md-4">
                                    <label> Allowed with other coupon</label>
                                    <select class="form-control required" name="individual_use" id="individual_use">
                                        <option value="No" {{ (@$coupon->individual_use=='No')?'selected':'' }}>No
                                        </option>
                                        <option value="Yes" {{ (@$coupon->individual_use=='Yes')?'selected':'' }}>Yes
                                        </option>
                                    </select>
                                    <div class="help-block with-errors" id="individual_use_error"></div>
                                </div> --}}
                            </div>
                            <div class="form-row">
                              
                                <div class="form-group col-md-6">
                                    <label> Included Categories </label>
                                    <select class="form-control select2  included_categories"
                                            {{ (@$coupon->excluded_categories || @$coupon->included_products)?'disabled':'' }}
                                            {{ (@$coupon->excluded_products && @!$coupon->included_categories)?'disabled':'' }}
                                            name="included_categories[]" id="included_categories" multiple>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="included_categories_error"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Excluded categories</label>
                                    <select class="form-control select2  excluded_categories"
                                            {{ (@$coupon->included_categories || @$coupon->excluded_products)?'disabled':'' }}
                                            {{ (@$coupon->included_products && @!$coupon->excluded_categories)?'disabled':'' }}
                                            name="excluded_categories[]" id="excluded_categories" multiple>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="excluded_categories_error"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Included Products </label>
                                    <select class="form-control select2  included_products"
                                            name="included_products[]"
                                            id="included_products" multiple
                                        {{ (@$coupon->excluded_products || @$coupon->included_categories)?'disabled':'' }}>
                                        @foreach(!empty($included_product_list)?$included_product_list:$products as $product)
                                            <option value="{{ $product->id }}">{{ $product->title }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" id="included_product_ids" name="included_product_ids"
                                           value="{{@$coupon->included_products}}">
                                    <div class="help-block with-errors" id="included_products_error"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Excluded Products</label>
                                    <select class="form-control select2 excluded_products"
                                            name="excluded_products[]"
                                            id="excluded_products" multiple
                                        {{ (@$coupon->included_products || @$coupon->excluded_categories)?'disabled':'' }}>
                                        @foreach((!empty($excluded_product_list)?$excluded_product_list:$products) as $product)
                                            <option value="{{ $product->id }}">{{ $product->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="excluded_products_error"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> Allow to public </label>
                                    <select class="form-control" required name="allow_public" id="allow_public">
                                        <option value="No" {{ (@$coupon->allow_public=='No')?'selected':'' }}>No
                                        </option>
                                        <option value="Yes" {{ (@$coupon->allow_public=='Yes')?'selected':'' }}>Yes
                                        </option>
                                    </select>
                                    <div class="help-block with-errors" id="allow_public_error"></div>
                                </div>
                                <div class="form-group col-md-6 allowedMail"
                                     style="display:{{ (@$coupon->allow_public=='Yes')?'none':'block' }};">
                                    <label> Allowed Mail(s) </label>
                                    <select class="form-control select2" name="allowed_mails[]" id="allowed_mails"
                                            multiple>
                                        @foreach($customerMails as $mails)
                                            <option value="{{$mails->id}}">{{$mails->email}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="allowed_mails_error"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label> Allowed coupon usage </label>
                                    <input type="number" min="0" name="usage_per_coupon" id="usage_per_coupon"
                                           class="form-control"
                                           value="{{ isset($coupon)?$coupon->usage_per_coupon:'5' }}">
                                    <div class="help-block with-errors" id="usage_per_coupon_error"></div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Allowed usage limit per person </label>
                                    <input type="number" min="0" name="usage_per_person" id="usage_per_person"
                                           class="form-control"
                                           value="{{ isset($coupon)?$coupon->usage_per_person:'1' }}">
                                    <div class="help-block with-errors" id="usage_per_person_error"></div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Applicable for sale price</label>
                                    <select class="form-control" name="applicable_only_if_sale_price"
                                            id="applicable_only_if_sale_price">
                                        <option
                                            value="No" {{ (@$coupon->applicable_only_if_sale_price=='No')?'selected':'' }}>
                                            No
                                        </option>
                                        <option
                                            value="Yes" {{ (@$coupon->applicable_only_if_sale_price=='Yes')?'selected':'' }}>
                                            Yes
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="submit" name="btn_save" value="Submit"
                                   class="btn btn-primary pull-left submitBtn">
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
            $('#included_categories').val([{{@$coupon->included_categories}}]).change();
            $('#excluded_categories').val([{{@$coupon->excluded_categories}}]).change();
            $('#included_products').val([{{@$coupon->included_products}}]).change();
            $('#excluded_products').val([{{@$coupon->excluded_products}}]).change();
            $('#allowed_mails').val([{{@$coupon->allowed_mails}}]).change();
        });
    </script>
@endsection
