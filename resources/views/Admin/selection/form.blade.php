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
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Heading Form</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    @include('Admin.selection.heading_form')
                </div>

                <form role="form"  id="formWizards" class="form--wizards"  method="post">
                    {{csrf_field()}}
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Our Selection</h3>
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
                                <div class="form-group col-md-12">
                                    <label>Product 1*</label>
                                    <select name="product[]" id="products"  maxlength="1" class="form-control select2 required1 product-select">
                                        <option value>Select Product</option>  
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}" @if(@$firstSelection->product_id == $product->id) selected @endif >{{$product->title}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="products_error"></div>
                                    @error('product')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                               
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Product 2*</label>
                                    <select name="product[]" id="products1"  maxlength="1"  class="form-control select2 required1 product-select">
                                        <option value>Select Product</option> 
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}" @if(@$secondSelection->product_id == $product->id) selected @endif  >{{$product->title}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="products1_error"></div>
                                    @error('product1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                               
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Product 3*</label>
                                    <select name="product[]" id="products2"  maxlength="1" class="form-control select2 required1 product-select">
                                        <option value>Select Product</option> 
                                        @foreach($products as $product)
                                        <option value="{{$product->id}}" @if(@$thirdSelection->product_id == $product->id) selected @endif  >{{$product->title}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="products2_error"></div>
                                    @error('product2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                               
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Product 4*</label>
                                    <select name="product[]" id="products3"  maxlength="1"  class="form-control select2 required1 product-select">
                                        <option value>Select Product</option>
                                        @foreach($products as $product)
                                        <option value="{{$product->id}}" @if(@$fourthSelection->product_id == $product->id) selected @endif  >{{$product->title}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="products3_error"></div>
                                    @error('product3')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                               
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Product 5*</label>
                                    <select name="product[]" id="products4"  maxlength="1" class="form-control select2 required1 product-select">
                                        <option value>Select Product</option>
                                        @foreach($products as $product)
                                        <option value="{{$product->id}}" @if(@$fifthSelection->product_id == $product->id) selected @endif  >{{$product->title}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="products4_error"></div>
                                    @error('product4')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                               
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Product 6*</label>
                                    <select name="product[]" id="products5"  maxlength="1"  class="form-control select2 required1 product-select">
                                        <option value>Select Product</option>
                                        @foreach($products as $product)
                                        <option value="{{$product->id}}" @if(@$sixthSelection->product_id == $product->id) selected @endif  >{{$product->title}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="products5_error"></div>
                                    @error('product5')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                               
                            </div>

                           
                           
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Product 7*</label>
                                    <select name="product[]" id="products6"  maxlength="1" class="form-control select2 required1 product-select">
                                        <option value>Select Product</option>
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}" @if(@$seventhSelection->product_id == $product->id) selected @endif  >{{$product->title}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="products6_error"></div>
                                    @error('product6')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                               
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Product 8*</label>
                                    <select name="product[]" id="products7"  maxlength="1"  class="form-control select2 required1 product-select">
                                        <option value>Select Product</option>
                                        @foreach($products as $product)
                                        <option value="{{$product->id}}" @if(@$eightSelection->product_id == $product->id) selected @endif  >{{$product->title}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="products7_error"></div>
                                    @error('product6')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                               
                            </div>

                            


                          
                        <div class="card-footer">
                            <input type="submit" name="btn_save" value="Submit"
                                   class="btn btn-primary pull-left submitBtn1">
                            <button type="reset" class="btn btn-default">Cancel</button>
                            <input type="hidden" name="id" id="id" value="{{ isset($product)?$product->id:'0' }}">
                            <img class="animation__shake loadingImg1" src="{{url('backend/dist/img/loading.gif')}}"
                                 style="display:none;">
                        </div>
                    </div>
                </form>

            </div>
        </section>
    </div>
    <script>
        $(document).ready(function(){
          $(".js-example-basic-multiple").select2();
        });//document ready
        </script>
        
    <script type="text/javascript">

        $(document).ready(function () {
            $('#featured_image_div').hide();
            @if(isset($product))
            @endif
   
        });
       
    </script>
@endsection
