@if ((Auth::user()->admin->role) == "Super Admin")
    <li class="nav-item">
        <a href="{{url(Helper::sitePrefix().'administration')}}"
           class="nav-link {{ (Request::segment(2)=='administration')?'active':'' }}">
            <i class="nav-icon fas fa-user-shield"></i>
            <p>Administration</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{url(Helper::sitePrefix().'vendor')}}"
           class="nav-link {{ (Request::segment(2)=='vendor')?'active':'' }}">
            <i class="nav-icon fas fa-user-shield"></i>
            <p>Vendor</p>
        </a>
    </li>
@endif
<li class="nav-item">
    <a href="{{url(Helper::sitePrefix().'customer')}}"
       class="nav-link {{ (Request::segment(2)=='customer')?'active':'' }}">
        <i class="nav-icon fas fa-user"></i>
        <p>Customer</p>
    </a>
</li>
{{-- 
<li class="nav-item">
    <a href="{{url(Helper::sitePrefix().'home')}}"
        class="nav-link {{ (Request::segment(2)=='home')?'active':'' }}">
        <i class="nav-icon fas fa-th-list"></i>
        <p>Home</p>
    </a>
</li> --}}

<li class="nav-item">
    <a href="{{url(Helper::sitePrefix().'about')}}"
        class="nav-link {{ (Request::segment(2)=='about')?'active':'' }}">
        <i class="nav-icon fas fa-th-list"></i>
        <p>About</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{url(Helper::sitePrefix().'banner')}}"
        class="nav-link {{ (Request::segment(2)=='banner')?'active':'' }}">
        <i class="nav-icon fas fa-th-list"></i>
        <p>Banners</p>
    </a>
</li>

<li class="nav-item {{ (Request::segment(2)=='enquiry')?'menu-is-opening menu-open':'' }}">
    <a href="#" class="nav-link {{ (Request::segment(2)=='enquiry')?'active':'' }}">
        {{--        <i class="nav-icon fas fa-envelope"></i>--}}
        <i class="nav-icon fas fa-inbox"></i>
        <p>Enquiry
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: {{ (Request::segment(2)=='enquiry')?'block':'none' }}">
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'enquiry')}}"
               class="nav-link {{ (Request::is(Helper::sitePrefix().'enquiry'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Contact Page</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'enquiry/bulk')}}"
               class="nav-link {{ (Request::segment(3)=='product')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p> Bulk Enquiry </p>
            </a>
        </li>
    </ul>
</li>


<li class="nav-item">
    <a href="{{url(Helper::sitePrefix().'site-information')}}"
       class="nav-link {{ (Request::segment(2)=='site-information')?'active':''}}">
        <i class="nav-icon fas fa-cogs"></i>
        <p>Site Information</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{url(Helper::sitePrefix().'contact')}}"
       class="nav-link {{ (Request::segment(2)=='contact')?'active':''}}">
        <i class="nav-icon fas fa-envelope"></i>
        <p>Contact</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{url(Helper::sitePrefix().'country')}}"
       class="nav-link {{ (Request::segment(2)=='country') && (Request::segment(3)!='shipping-charge')?'active':'' }}">
        <i class="nav-icon fas fa-globe"></i>
        <p>Country</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{url(Helper::sitePrefix().'currency')}}"
       class="nav-link {{ (Request::segment(2)=='currency') && (Request::segment(3)!='shipping-charge')?'active':'' }}">
       <i class="nav-icon fas fa-money-check"></i>
        <p>Currency</p>
    </a>
</li>


<li class="nav-item {{ (Request::segment(2)=='product')?'menu-is-opening menu-open':'' }}">
    <a href="#" class="nav-link {{ (Request::segment(2)=='product')?'active':'' }}">
        <i class="nav-icon fas icon fas fa-info"></i>
        <p>
            Product
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: {{ (Request::segment(2)=='product')?'block':'none' }}">

        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'product/category')}}"
               class="nav-link {{ (Request::segment(3)=='category')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Category</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'product/sub-category')}}"
               class="nav-link {{ (Request::segment(3)=='sub-category')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Sub Category</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'product/product-type')}}"
               class="nav-link {{ (Request::segment(3)=='product-type')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Product Type</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'product/tag')}}"
               class="nav-link {{ (Request::segment(3)=='tag')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Tags</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'product/')}}"
               class="nav-link {{ (Request::segment(2)=='product' && (Request::segment(3)=='create' || Request::segment(3)=='edit' || Request::segment(3)==''))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Product</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'product/review')}}"
               class="nav-link {{ (Request::segment(3)=='review')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Reviews</p>
                <span class="badge badge-info pull-right">{{App\Models\ProductReview::active()->count()}}</span>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a href="{{url(Helper::sitePrefix().'coupon')}}" class="nav-link {{ (Request::segment(2)=='coupon')?'active':'' }}">
        {{--        <i class="nav-icon fas fa-asterisk"></i>--}}
        <i class="nav-icon fas fa-money-bill-wave"></i>
        <p>Coupon</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{url(Helper::sitePrefix().'order')}}" class="nav-link {{ (Request::segment(2)=='order')?'active':'' }}">
        <i class="nav-icon fas fa-th"></i>
        <p>Order</p>
        <span class="pull-right-container">
            <span class="badge badge-success pull-right">{{App\Models\Order::OrderCountByStatus('Processing')}}</span>
        </span>
    </a>
</li>
<li class="nav-item {{ (Request::segment(2)=='menu')?'menu-is-opening menu-open':'' }}">
    <a href="#" class="nav-link {{ (Request::segment(2)=='menu')?'active':'' }}">
        <i class="nav-icon fas fa-list"></i>
        <p>Menu
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: {{ (Request::segment(2)=='menu')?'block':'none' }}">
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'menu')}}"
               class="nav-link {{ (Request::is(Helper::sitePrefix().'menu'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Menu </p>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'menu/detail')}}"
               class="nav-link {{ (Request::segment(3)=='detail')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Menu Detail</p>
            </a>
        </li> --}}
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'side-menu')}}"
               class="nav-link {{ (Request::is(Helper::sitePrefix().'side-menu'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Side Menu </p>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'side-menu/detail')}}"
               class="nav-link {{ (Request::is(Helper::sitePrefix().'side-menu-detail'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Side Menu Detail</p>
            </a>
        </li> --}}
    </ul>
</li>
<li class="nav-item menu-report hide-menu {{ (Request::segment(2)=='report')?'menu-is-opening menu-open':'' }}">
    <a href="#" class="nav-link {{ (Request::segment(2)=='report')?'active':'' }}">
        <i class="nav-icon fas fa-file"></i>
        <p>Report
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: {{ (Request::segment(2)=='report')?'block':'none' }}">
        <li class="nav-item {{ (Request::segment(3)=='product')?'menu-is-opening menu-open':'' }}">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Product
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview" style="display: {{ (Request::segment(3)=='product')?'block':'none' }}">
                <li class="nav-item">
                    <a href="{{url(Helper::sitePrefix().'report/product/out-of-stock')}}"
                       class="nav-link {{ (Request::segment(4)=='out-of-stock')?'active':'' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Out of stock</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url(Helper::sitePrefix().'report/product/featured')}}"
                       class="nav-link {{ (Request::segment(4)=='featured')?'active':'' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Most Relevent</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url(Helper::sitePrefix().'report/product/new-product')}}"
                       class="nav-link {{ (Request::segment(4)=='new-product')?'active':'' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Latest Product</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item {{ (Request::segment(3)=='order')?'menu-is-opening menu-open':'' }}">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Order
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview" style="display: {{ (Request::segment(3)=='order')?'block':'none' }}">
                <li class="nav-item">
                    <a href="{{url(Helper::sitePrefix().'report/order/processing')}}"
                       class="nav-link {{ (Request::segment(4)=='processing')?'active':'' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Processing Order</p>
                        <span class="pull-right-container">
                            <span class="badge badge-info pull-right">{{App\Models\Order::OrderCountByStatus('Processing')}}</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url(Helper::sitePrefix().'report/order/hold')}}"
                       class="nav-link {{ (Request::segment(4)=='hold')?'active':'' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>On-hold Orders</p>
                        <span class="pull-right-container">
                            <span class="badge badge-info pull-right">{{count(App\Models\Order::getOrderByStatus('On Hold'))}}</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url(Helper::sitePrefix().'report/order/delivery')}}"
                       class="nav-link {{ (Request::segment(5)=='delivered')?'active':'' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Out of Delivery Orders</p>
                        <span class="pull-right-container">
                            <span class="badge badge-info pull-right">{{App\Models\Order::OrderCountByStatus('Out For Delivery')}}</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url(Helper::sitePrefix().'report/order/completed')}}"
                       class="nav-link {{ (Request::segment(4)=='completed')?'active':'' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Completed Orders</p>
                        <span class="pull-right-container">
                            <span class="badge badge-info pull-right">{{App\Models\Order::OrderCountByStatus('Completed')}}</span>
                        </span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item {{ (Request::segment(3)=='product')?'menu-is-opening menu-open':'' }}">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Customer
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview" style="display: {{ (Request::segment(3)=='customer')?'block':'none' }}">
                <li class="nav-item">
                    <a href="{{url(Helper::sitePrefix().'report/customer/basic')}}"
                       class="nav-link {{ (Request::segment(4)=='basic')?'active':'' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Basic Report</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url(Helper::sitePrefix().'report/customer/order-report')}}"
                       class="nav-link {{ (Request::segment(4)=='order-report')?'active':'' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Customer Order Report</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</li>
<li class="nav-item menu-detail hide-menu">
    <a href="{{url(Helper::sitePrefix().'report/detail-report')}}"
       class="nav-link {{ (Request::segment(3)=='detail_report')?'active':'' }}">
        <i class="nav-icon fas fa-layer-group"></i>
        <p>
            Detail Report
        </p>
    </a>
</li>

