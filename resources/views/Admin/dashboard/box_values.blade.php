<div class="row">
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{$processingOrders}}</h3>
                <p>ORDER PROCESSING</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{url(Helper::sitePrefix().'report/order/processing')}}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{$ohHoldOrders}}</h3>
                <p>ORDER ON-HOLD</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{url(Helper::sitePrefix().'report/order/on hold')}}" class="small-box-footer">More info
                <i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{$outOfStock}}</h3>
                <p>OUT OF STOCK PRODUCTS</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{url(Helper::sitePrefix().'report/product/out-of-stock')}}" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<div class="row">
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{$todaySales}}</h3>
                <p>TODAY SALES</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            {{--            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>--}}
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{$monthSales}}</h3>
                <p>THIS MONTH SALES</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            {{--            <a href="{{url('job/Completed')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>--}}
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{$yearSales}}</h3>
                <p>THIS YEAR SALES</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            {{--            <a href="{{url('pending-jobs')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>--}}
        </div>
    </div>
    <!-- ./col -->
</div>
