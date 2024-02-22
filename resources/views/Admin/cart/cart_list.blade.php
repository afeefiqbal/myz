@extends('Admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-user-shield"></i> {!!$title!!}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{url(Helper::sitePrefix().'dashboard')}}">
                                    Home
                                </a>
                            </li>
                            <li class="breadcrumb-item active">{!!$title!!}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
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

                        <div class="card card-info">
                            <form method="POST" id="cart-list-filter-form" role="form">
                                {{csrf_field()}}
                                <div class="card-header">
                                    <h3 class="card-title">Filter Cart</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-sm-4">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="nav-icon far fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="text" class="form-control daterange"
                                                       placeholder="Date Range" id="date_range" name="date_range">
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <select class="form-control select2" id="cart_list_product"
                                                    name="cart_list_product">
                                                <option value="">Select Product</option>
                                                @foreach($productList as $product)
                                                    <option value="{{$product->id}}">{{$product->title}}</option>
                                                @endforeach
                                            </select>
                                            <div class="help-block with-errors" id="cart_list_product_error"></div>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <select class="form-control select2" id="cart_list_customer"
                                                    name="cart_list_customer">
                                                <option value="">Select Customer</option>
                                                @foreach($customerList as $customer)
                                                    <option
                                                        value="{{$customer->id}}">{{$customer->first_name.' '.$customer->last_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <input type="submit" id="cart-list-search" name="btn_save" value="Submit"
                                           class="btn btn-primary pull-left">
                                    <button type="reset" class="btn btn-default">Reset</button>
                                    <img class="animation__shake loadingImg"
                                         src="{{url('backend/dist/img/loading.gif')}}" style="display:none;">
                                </div>
                            </form>
                        </div>

                        <div class="card card-success card-outline">
                            <div class="card-header delete_btn" style="display: none;">
                                <input type="hidden" name="ids" id="ids">
                                <a href="javascript:void(0)" class="btn btn-success pull-right"
                                   id="send_notify_btn"><i
                                        class="fa fa-paper-plane"></i> Send</a>
                            </div>
                            <div class="card-body" id="cart-list-html">
                                <table id="recordsListView" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th># <input type="checkbox" class="mt-2 ml-3" name="check_all"
                                                     id="check_all">
                                        </th>
                                        <th>Customer</th>
                                        <th>Products</th>
                                        <th>Created Date</th>
                                        <th class="not-sortable">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cartItem as $item)
                                        @php
                                            $customerData = App\Models\Customer::find($item->id);
                                        @endphp
                                        @if($customerData!=NULL)
                                            <tr>
                                                <td>{{ $loop->iteration }}
                                                    <input type="checkbox" class="single_box mt-2 ml-3"
                                                           name="single_box" id="{{ $item->id }}"
                                                           value="{{ $item->id }}"></td>
                                                <td>
                                                    {{ $customerData->first_name." ".$customerData->last_name }}
                                                </td>
                                                <td>
                                                    <table id="childTable" class="table table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Product</th>
                                                            <th>Type</th>
                                                            <th>Frame Colour</th>
                                                            <th>Has Mount</th>
                                                            <th>Size</th>
                                                            <th>Quantity</th>
                                                            <th>Offer Amount</th>
                                                            <th>Cost</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(count($item->cart_data)>0)
                                                            @php
                                                                $key=1;
                                                            @endphp
                                                            @foreach($item->cart_data as   $cart)
                                                            @if(getType($cart) == 'object')
                                                            <tr>
                                                                <td>
                                                                    {{$key}}
                                                                </td>
                                                                
                                                               @php
                                                                   $productData = App\Models\Product::find($cart->attributes->product_id);
                                                                   @endphp
                                                                   <td>
                                                                  {{ $productData->title }}
                                                                 </td>
                                                              
                                                               
                                                               <td>
                                                                @php
                                                                    $productType = App\Models\ProductType::find($cart->attributes->type);
                                                                @endphp
                                                                {{ $productType->title }}
                                                               </td>
                                                               <td>
                                                                @if ($cart->attributes->frame != null)
                                                                @php
                                                                    $frameData = App\Models\Frame::find($cart->attributes->frame);
                                                                @endphp
                                                                {{ $frameData->title }}
                                                                    
                                                                    
                                                                @endif
                                                                <td>
                                                                 
                                                                 {{ $cart->attributes->mount }}
                                                                </td>
                                                                <td>
                                                                 @php
                                                                     $sizeData = \App\Models\Size::find($cart->attributes->size);
                                                                 @endphp
                                                                 {{ $sizeData->title }}
                                                                </td>
                                                                <td>
                                                                 {{$cart->quantity}}
                                                                 </td>
                                                                 <td>{{$cart->attributes->currency}} {{$cart->attributes->offer_amount}}</td>
                                                                 <td>{{$cart->attributes->currency}} {{$cart->price}}</td>
                                                             </tr>
                                                            @endif
                                                            @php
                                                            $key++;
                                                        @endphp
                                                            @endforeach
                                                        @endif
                                                           
                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td>{{ date("d-M-Y", strtotime($item->created_at))  }}</td>
                                                <td>
                                                    <a class="ml-2 common-cart-class cart_notify_modal"
                                                       href="javascript:void(0)" data-toggle="modal"
                                                       data-id="{{ $item->id }}"><i class="fa fa-send fa-lg"></i></a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" id="notify-cart-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Template Body</h4>
                    </div>
                    <form role="form" method="post" id="formWizard" class="reply_form">
                        <div class="modal-body">
                            {{csrf_field()}}
                            <div class="box-body">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label> Title*</label>
                                            <input type="text" name="title" id="title" class="form-control required"
                                                   required>
                                            <span id="title_error">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label> Body Text*</label>
                                            <textarea class="form-control required textarea" required id="description"
                                                      name="description" placeholder="Mail Body"></textarea>
                                            <span id="description_error">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="cart_notify">Send Notification</button>
                            <input type="hidden" id="customer_id" name="customer_id">
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.content -->
    </div>
@endsection
