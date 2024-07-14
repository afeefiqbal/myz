@extends('Admin.layouts.main')
@section('content')

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><i class="nav-icon fas fa-tachometer-alt"></i> Admin Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                @include('Admin.dashboard.box_values')
                <div class="row">
                    <section class="col-lg-12 connectedSortable">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card card-success card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="ion ion-clipboard mr-1"></i>
                                            Latest Orders
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table no-margin">
                                            <thead>
                                            <tr>
                                                <th>Order Code</th>
                                                <th>Customer</th>
                                                <th>Total</th>
                                                <th>Coupon</th>
                                                <th>Cancelled</th>
                                                <th>Payment Method</th>
                                                <th>Created At</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($latestOrders as $order)
                                                @if($order->orderProducts!=NULL)
                                                    @php
                                                        $productTotal = App\Models\Order::getProductTotal($order->id);
                                                        $orderTotal = App\Models\Order::getOrderTotal($order->id);
                                                         $cancelledTotal = App\Models\Order::getCancelledProductTotal($order->id);
                                                    @endphp
                                                    @php
                                                        $total = $cancelledTotal['total']-$cancelledTotal['couponCharge'];
                                                        $returnAmount = $total+$cancelledTotal['taxAmount']+$cancelledTotal['shippingCharge']+$cancelledTotal['otherCouponCharge'];
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <a href="{{url(Helper::sitePrefix().'order/view/'.$order->id)}}">{{ 'MYZ#'.$order->order_code }}</a>
                                                        </td>
                                                        @if(@$order->orderCustomer->user_type=="User")
                                                            <td>{{ $order->orderCustomer->shippingAddress->first_name.' '.$order->orderCustomer->shippingAddress->last_name }}</td>
                                                        @else
                                                            <td>{{ @$order->orderCustomer->shippingAddress->first_name.' '.@$order->orderCustomer->shippingAddress->last_name}}</td>
                                                        @endif
                                                        <td>{{ $orderTotal }}</td>
                                                        <td>{{ ($order->orderCoupons)?$order->orderCoupons->sum('coupon_value'):'0' }}</td>
                                                        <td>{{ $returnAmount }}</td>
                                                        <td>{{ $order->payment_method }}</td>
                                                        <td>{{ date("d-M-Y", strtotime($order->created_at))  }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{url(Helper::sitePrefix().'order')}}"
                                           class="small-box-footer pull-right">View All <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-danger card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">Recently Added Products</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="products-list product-list-in-card pl-2 pr-2">
                                            @foreach($latestProducts as $product)
                                                <li class="item">
                                                    <div class="product-img">
                                                        <img
                                                            src="{{ (isset($product->thumbnail_image) && File::exists(public_path($product->thumbnail_image)))? asset($product->thumbnail_image):asset('frontend/images/default-image.jpg')}}"
                                                            alt="Product Image" class="img-size-50">
                                                    </div>
                                                    <div class="product-info">
                                                        <a href="javascript:void(0)"
                                                           class="product-title">{{ $product->title }}
                                                            <span
                                                                class="badge badge-success float-right">{{$product->price}}</span></a>
                                                        <span class="product-description">{{ $product->sku }}</span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="{{url(Helper::sitePrefix().'product')}}" class="uppercase">View All
                                            Products</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-danger card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">Current Month Sales</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <p class="text-center">
                                                    <strong>Sales: {{ date("F, d Y", strtotime(date('Y-m-01 h:i:s'))) }}
                                                        - {{ date("F, d Y", strtotime(date('Y-m-d h:i:s'))) }}</strong>
                                                </p>
                                                <div class="chart">
                                                    <div id="barchart" style="height: 500px;overflow-x:scroll;"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="text-center">
                                                    <strong>Order Summary</strong>
                                                </p>
                                                <div class="progress-group">
                                                    Processing Order
                                                    <span
                                                        class="float-right"><b>{{$currentMonthOnProcessing}}</b></span>
                                                    <div class="progress progress-sm">
                                                        @if($totalOrders['totalOrders']!=0)
                                                            <div class="progress-bar bg-primary"
                                                                 style="width: {{($currentMonthOnProcessing/$totalOrders['totalOrders'])*100}}%"></div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="progress-group">
                                                    On-Hold Orders
                                                    <span class="float-right"><b>{{$currentMonthOnHold}}</b></span>
                                                    <div class="progress progress-sm">
                                                        @if($totalOrders['totalOrders']!=0)
                                                            <div class="progress-bar bg-warning"
                                                                 style="width: {{($currentMonthOnHold/$totalOrders['totalOrders'])*100}}%"></div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="progress-group">
                                                    Completed Orders
                                                    <span class="float-right"><b>{{$currentMonthCompleted}}</b></span>
                                                    <div class="progress sm">
                                                        @if($totalOrders['totalOrders']!=0)
                                                            <div class="progress-bar bg-success"
                                                                 style="width: {{($currentMonthCompleted/$totalOrders['totalOrders'])*100}}%"></div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="progress-group">
                                                    Cancelled Orders
                                                    <span class="float-right"><b>{{$currentMonthCancelled}}</b></span>
                                                    <div class="progress sm">
                                                        @if($totalOrders['totalOrders']!=0)
                                                            <div class="progress-bar bg-danger"
                                                                 style="width: {{($currentMonthCancelled/$totalOrders['totalOrders'])*100}}%"></div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="progress-group">
                                                    Refund Order
                                                    <span class="float-right"><b>{{$currentMonthRefunded}}</b></span>
                                                    <div class="progress sm">
                                                        @if($totalOrders['totalOrders']!=0)
                                                            <div class="progress-bar bg-primary"
                                                                 style="width: {{($currentMonthRefunded/$totalOrders['totalOrders'])*100}}%"></div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="progress-group">
                                                    Failed Orders
                                                    <span class="float-right"><b>{{$currentMonthFailed}}</b></span>
                                                    <div class="progress sm">
                                                        @if($totalOrders['totalOrders']!=0)
                                                            <div class="progress-bar bg-danger"
                                                                 style="width: {{($currentMonthFailed/$totalOrders['totalOrders'])*100}}%"></div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-center">
                                            <div class="row">
                                                <div class="col-sm-3 col-xs-6">
                                                    <div class="description-block border-right">
                                                        <!--<span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>-->
                                                        <h5 class="description-header">{{$monthNetSales}}</h5>
                                                        <span class="description-text">CURRENT MONTH NET SALES</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 col-xs-6">
                                                    <div class="description-block border-right">
                                                        <!--<span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>-->
                                                        <h5 class="description-header">{{$monthProducts['productCount']}}</h5>
                                                        <span class="description-text">CURRENT MONTH PRODUCTS</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 col-xs-6">
                                                    <div class="description-block border-right">
                                                        <!--<span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>-->
                                                        <h5 class="description-header">{{$monthOrders['orderCount']}}</h5>
                                                        <span class="description-text">CURRENT MONTH ORDERS</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 col-xs-6">
                                                    <div class="description-block">
                                                        <!--<span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>-->
                                                        <h5 class="description-header">{{$monthNewCustomers['customerCount']}}</h5>
                                                        <span class="description-text">CURRENT MONTH CUSTOMERS</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card card-danger card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">{{count($latestMembers)}} New Members</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="users-list clearfix">
                                            @foreach($latestMembers as $member)
                                                <li>
                                                    <img
                                                        src="{{(isset($member->user->profile_image) && File::exists(public_path($member->user->profile_image))) ? asset($member->user->profile_image) : asset('frontend/images/user.png') }}"
                                                        alt="User Image">
                                                    <a class="users-list-name"
                                                       href="javascript:void(0)">{{$member->first_name.' '.$member->last_name}}</a>
                                                    <span
                                                        class="users-list-date">{{ date("F, d Y", strtotime($member->created_at)) }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="{{url(Helper::sitePrefix().'customer/')}}" class="uppercase">View All
                                            Customers</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box bg-yellow">
                                    <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Inventory</span>
                                        <span class="info-box-number">{{$totalProducts['productCount']}}</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 50%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="info-box bg-green">
                                    <span class="info-box-icon"><i class="fa fa-user-circle"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Registered Customer</span>
                                        <span class="info-box-number">{{$totalProducts['customerCount']}}</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 50%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="info-box bg-red">
                                    <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Active Coupon</span>
                                        <span class="info-box-number">{{$totalActiveCoupons}}</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 50%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="info-box bg-aqua">
                                    <span class="info-box-icon"><i class="fa fa-lightbulb-o"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Active Orders</span>
                                        <span class="info-box-number">{{$totalActiveOrders}}</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 50%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </section>
                </div>
            </div>
        </section>
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

        google.charts.load('current', {'packages': ['bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Date', 'Sales'],
                @foreach ($chartInfo as $info => $value)
                    {!! "['" . $info . "', " . $value . "]," !!}
                    @endforeach
            ]);

            var options = {
                chart: {
                    title: 'Bar Graph | Sales',
                    subtitle: 'Date, and Sales:',
                },
                bars: 'vertical'
            };
            var chart = new google.charts.Bar(document.getElementById('barchart'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
@endsection
