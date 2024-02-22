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
                            <li class="breadcrumb-item active">{{$title}} </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-success card-outline">
                            <div class="card-body">
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <select class="form-control select2" id="report_order_id" name="report_order_id">
                                        <option value="">Select Order</option>
                                        @foreach($orderList['orderList'] as $order)
                                            <option
                                                value="{{$order->orderData->id}}">{{'ARTMYST'.$order->orderData->order_code}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card card-success card-outline">
                            <div class="card-body" id="result-offer-table">
                                <table class="table table-bordered table-hover dataTable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order Code</th>
                                        <th>Customer</th>
                                        <th>Product</th>
                                        <th>Cost</th>
                                        <th>Offer Amount</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
