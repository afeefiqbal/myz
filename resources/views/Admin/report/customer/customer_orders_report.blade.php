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
                                <div class="row">
                                    <div class="col-md-4">
                                        <select class="form-control" id="order_customer_id" name="order_customer_id">
                                            <option value="">Select Customer</option>
                                            @foreach($customerList as $customer)
                                                <option
                                                    value="{{$customer->id}}">{{$customer->first_name.' '.$customer->last_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control" id="order_status" name="order_status">
                                            @foreach(['Pending','Processing','On Hold','Cancelled','Packed','Shipped','Out For Delivery','Delivered','Completed','Returned','Refunded','Failed'] AS $status)
                                                <option value="{{ $status }}"
                                                    {{ (old("order_status") == $status)? "selected" : "" }}>
                                                    {{ $status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-primary" id="filter-customer-report">Filter</button>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card card-success card-outline">
                            <div class="card-body" id="result-customer-table">
                                <table class="table table-bordered table-hover ">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order Code</th>
                                        <th>No of Items</th>
                                        <th>Payment Method</th>
                                        <th>Remarks</th>
                                        <th>Price</th>
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
