@extends('Admin.layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="nav-icon fas fa-user-shield"></i> Sitemap  Generator</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a>
                        </li>
               
                        <li class="breadcrumb-item active">Sitemap Generator</li>
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
            <form role="form" id="formWizard" data-product_id="{{@$product->id}}"
                  action="{{url('sitemap')}}" class="form--wizard"
                  enctype="multipart/form-data" method="post">
                {{csrf_field()}}
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Sitemap Generator</h3>
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
                                <label> Select Type</label>
                               <select name="type" id="type" class="form-control">
                                <option value="products">products</option>
                                <option value="blogs">Blogs</option>
                               </select>
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

@endsection
