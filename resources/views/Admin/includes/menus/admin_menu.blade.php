@if ((Auth::user()->admin->role) == "Super Admin")
    <li class="nav-item">
        <a href="{{url(Helper::sitePrefix().'administration')}}"
           class="nav-link {{ (Request::segment(2)=='administration')?'active':'' }}">
            <i class="nav-icon fas fa-user-shield"></i>
            <p>Administration</p>
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
{{-- <li class="nav-item">
    <a href="{{url(Helper::sitePrefix().'guests')}}"
       class="nav-link {{ (Request::segment(2)=='guests')?'active':'' }}">
        <i class="nav-icon fas fa-user-circle"></i>
        <p>Guests</p>
    </a>
</li> --}}
<li class="nav-item {{ (Request::segment(2)=='home')?'menu-is-opening menu-open':'' }}">
    <a href="#" class="nav-link {{ (Request::segment(2)=='home')?'active':'' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: {{ (Request::segment(2)=='home')?'block':'none' }}">
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'home/banner')}}"
               class="nav-link {{ (Request::segment(3)=='banner')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Sliders</p>
            </a>
        </li>
        {{--        <li class="nav-item">--}}
        {{--            <a href="{{url(Helper::sitePrefix().'home/hot-deal')}}"--}}
        {{--               class="nav-link {{ (Request::segment(3)=='hot-deal')?'active':'' }}">--}}
        {{--                <i class="far fa-circle nav-icon"></i>--}}
        {{--                <p>Hot Deal</p>--}}
        {{--            </a>--}}
        {{--        </li>--}}
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'home/our-collection/create')}}"
               class="nav-link {{ (Request::segment(3)=='our-collection' && Request::segment(4)=='create')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Our Collection</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'home/our-selection/create')}}"
               class="nav-link {{ (Request::segment(3)=='our-selection' && Request::segment(4)=='create')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Our Selection</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'home/testimonial')}}"
               class="nav-link {{ (Request::segment(3)=='testimonial')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Testimonials</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'home/usertestimonial')}}"
               class="nav-link {{ (Request::segment(3)=='usertestimonial')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>User Testimonial</p>
            </a>
        </li>


    </ul>
</li>
<li class="nav-item {{ (Request::segment(2)=='banner')?'menu-is-opening menu-open':'' }}">
    <a href="#" class="nav-link {{ (Request::segment(2)=='banner')?'active':'' }}">
        <i class="nav-icon fas fa-image"></i>
        <p>Banner
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: {{ (Request::segment(2)=='banner')?'block':'none' }}">

        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'banner/product')}}"
               class="nav-link {{ (Request::segment(3)=='product')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Product </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'banner/blogs')}}"
               class="nav-link {{ (Request::segment(3)=='blogs')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Blog</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'banner/cart')}}"
               class="nav-link {{ (Request::segment(3)=='cart')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Cart</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'banner/checkout')}}"
               class="nav-link {{ (Request::segment(3)=='checkout')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Checkout</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'banner/contact')}}"
               class="nav-link {{ (Request::segment(3)=='contact')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Contact</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'banner/about')}}"
               class="nav-link {{ (Request::segment(3)=='about')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>About Us</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'banner/my-account')}}"
               class="nav-link {{ (Request::segment(3)=='my-account')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>My Account</p>
            </a>
        </li>




        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'banner/faq')}}"
               class="nav-link {{ (Request::segment(3)=='faq')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Faq</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'banner/shipping-policy')}}"
               class="nav-link {{ (Request::segment(3)=='faq')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Shipping Policy</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'banner/payment-policy')}}"
               class="nav-link {{ (Request::segment(3)=='faq')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>payment-policy</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'banner/privacy-policy')}}"
               class="nav-link {{ (Request::segment(3)=='privacy-policy')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Privacy Policy</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'banner/terms-and-conditions')}}"
               class="nav-link {{ (Request::segment(3)=='terms-and-conditions')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Terms and Condition</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'banner/return-policy')}}"
               class="nav-link {{ (Request::segment(3)=='return-policy')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Return Policy</p>
            </a>
        </li>



        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'banner/disclaimer')}}"
               class="nav-link {{ (Request::segment(3)=='disclaimer')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Disclaimer</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'banner/404')}}"
               class="nav-link {{ (Request::segment(3)=='404')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>404 </p>
            </a>
        </li>
    </ul>
</li>
{{--
<li class="nav-item">
    <a href="{{url(Helper::sitePrefix().'offer-strip')}}"
       class="nav-link {{ (Request::segment(2)=='offer-strip')?'active':'' }}">
        <i class="nav-icon fas fa-stopwatch"></i>
        <p>Offer Strip</p>
    </a>
</li>
--}}
<li class="nav-item">
    <a href="{{url(Helper::sitePrefix().'about')}}"
        class="nav-link {{ (Request::segment(2)=='about')?'active':'' }}">
        <i class="nav-icon fas fa-th-list"></i>
        <p>About</p>
    </a>
    {{-- <ul class="nav nav-treeview" style="display: {{ (Request::segment(2)=='about')?'block':'none' }}"> --}}
        {{-- <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'about')}}"
               class="nav-link {{ (Request::segment(2)=='about' && Request::is(Helper::sitePrefix().'about'))?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Who We Are</p>
            </a>
        </li> --}}
        {{--        <li class="nav-item">--}}
        {{--            <a href="{{url(Helper::sitePrefix().'about/feature')}}"--}}
        {{--               class="nav-link {{ (Request::segment(3)=='feature')?'active':'' }}">--}}
        {{--                <i class="far fa-circle nav-icon"></i>--}}
        {{--                <p>About Feature</p>--}}
        {{--            </a>--}}
        {{--        </li>--}}
    {{-- </ul> --}}
</li>
<li class="nav-item">
    <a href="{{url(Helper::sitePrefix().'contact')}}"
       class="nav-link {{ (Request::segment(2)=='contact')?'active':''}}">
        <i class="nav-icon fas fa-envelope"></i>
        <p>Contact</p>
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
        {{-- <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'enquiry/product')}}"
               class="nav-link {{ (Request::segment(3)=='product')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p> Product </p>
            </a>
        </li> --}}
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
    <a href="{{url(Helper::sitePrefix().'blog')}}"
       class="nav-link {{ (Request::segment(2)=='blog')?'active':''}}">
        <i class="nav-icon fas fa-rss"></i>
        <p>Blog</p>
    </a>
</li>
<!-- <li class="nav-item">
    <a href="{{url(Helper::sitePrefix().'testimonial')}}"
       class="nav-link {{ (Request::segment(2)=='testimonial')?'active':''}}">
        <i class="nav-icon fas fa-quote-left"></i>
        <p>Testimonial</p>
    </a>
</li> -->

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
<li class="nav-item">
    <a href="{{url(Helper::sitePrefix().'country/shipping-charge')}}"
       class="nav-link {{ (Request::segment(3)=='shipping-charge')?'active':'' }}">
        <i class="nav-icon fas fa-ship"></i>
        <p>Shipping charge</p>
    </a>
</li>
<li class="nav-item {{ (Request::segment(2)=='seo')?'menu-is-opening menu-open':'' }}">
    <a href="#" class="nav-link {{ (Request::segment(2)=='seo') ?'active':'' }}">
        <i class="nav-icon fas fa-asterisk"></i>
        <p>SEO Data
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: {{ (Request::segment(2)=='seo')?'block':'none' }}">
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'seo/home')}}"
               class="nav-link {{ (Request::segment(3)=='home')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Home</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'seo/about')}}"
               class="nav-link {{ (Request::segment(3)=='about')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>About</p>
            </a>
        </li>

        {{-- <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'seo/team')}}"
               class="nav-link {{ (Request::segment(3)=='team')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Team</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'seo/testimonial')}}"
               class="nav-link {{ (Request::segment(3)=='testimonial')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Testimonial</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'seo/event')}}"
               class="nav-link {{ (Request::segment(3)=='event')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Event</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'seo/Faq')}}"
               class="nav-link {{ (Request::segment(3)=='Faq')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>FAQ</p>
            </a>
        </li> --}}

        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'seo/blogs')}}"
               class="nav-link {{ (Request::segment(3)=='blogs')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Blog</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'seo/contact')}}"
               class="nav-link {{ (Request::segment(3)=='contact')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Contact</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'seo/privacy-policy')}}"
               class="nav-link {{ (Request::segment(3)=='privacy-policy')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Privacy Policy</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'seo/return-policy')}}"
               class="nav-link {{ (Request::segment(3)=='return-policy')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Return Policy</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'seo/shipping-policy')}}"
               class="nav-link {{ (Request::segment(3)=='shipping-policy')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Shipping Policy</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'seo/terms-and-conditions')}}"
               class="nav-link {{ (Request::segment(3)=='terms-and-conditions')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Terms & Conditions</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'seo/disclaimer')}}"
               class="nav-link {{ (Request::segment(3)=='disclaimer')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Disclaimer</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'seo/products')}}"
               class="nav-link {{ (Request::segment(3)=='products')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Products</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'seo/login')}}"
               class="nav-link {{ (Request::segment(3)=='login')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Login</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'seo/my-account')}}"
               class="nav-link {{ (Request::segment(3)=='my-account')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>My Account</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'seo/cart')}}"
               class="nav-link {{ (Request::segment(3)=='cart')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Cart</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'seo/wishlist')}}"
               class="nav-link {{ (Request::segment(3)=='wishlist')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Wishlist</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'seo/checkout')}}"
               class="nav-link {{ (Request::segment(3)=='checkout')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Checkout</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'seo/thank-you')}}"
               class="nav-link {{ (Request::segment(3)=='thank-you')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Thank you</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'seo/extra')}}"
               class="nav-link {{ (Request::segment(3)=='extra')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Extra Seo Data</p>
            </a>
        </li>
    </ul>
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
            <a href="{{url(Helper::sitePrefix().'product/color')}}"
               class="nav-link {{ (Request::segment(3)=='color')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Color</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'product/size')}}"
               class="nav-link {{ (Request::segment(3)=='size')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Size</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'product/shape')}}"
               class="nav-link {{ (Request::segment(3)=='shape')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Shape</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'product/frame')}}"
               class="nav-link {{ (Request::segment(3)=='frame')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Frame</p>
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
                <li class="nav-item">
                    <a href="{{url(Helper::sitePrefix().'report/order/cancelled')}}"
                       class="nav-link {{ (Request::segment(4)=='cancelled')?'active':'' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cancelled Orders</p>
                        <span class="pull-right-container">
                            <span
                                class="badge badge-info pull-right">{{App\Models\Order::OrderCountByStatus('Cancelled')}}</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url(Helper::sitePrefix().'report/order/refunded')}}"
                       class="nav-link {{ (Request::segment(4)=='refunded')?'active':'' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Refund Orders</p>
                        <span class="pull-right-container">
                            <span class="badge badge-info pull-right">{{App\Models\Order::OrderCountByStatus('Refunded')}}</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url(Helper::sitePrefix().'report/order/failed')}}"
                       class="nav-link {{ (Request::segment(4)=='failed')?'active':'' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Failed Orders</p>
                        <span class="pull-right-container">
                            <span class="badge badge-info pull-right">{{App\Models\Order::OrderCountByStatus('Failed')}}</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url(Helper::sitePrefix().'report/order/method/cod')}}"
                       class="nav-link {{ (Request::segment(5)=='cod')?'active':'' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>COD Orders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url(Helper::sitePrefix().'report/order/method/online-payment')}}"
                       class="nav-link {{ (Request::segment(5)=='online-payment')?'active':'' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Online-payment Orders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url(Helper::sitePrefix().'report/order-offer')}}"
                       class="nav-link {{ (Request::segment(3)=='order-offer')?'active':'' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Offer applied orders</p>
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
<li class="nav-item hide-menu{{ (Request::segment(2)=='mail')?'menu-is-opening menu-open':'' }}">
    <a href="#" class="nav-link {{ (Request::segment(2)=='mail')?'active':'' }}">
        <i class="nav-icon fas fa-cart-plus"></i>
        <p>
            Abandoned Cart
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: {{ (Request::segment(2)=='mail')?'block':'none' }}">
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'mail/list')}}"
               class="nav-link {{ (Request::segment(3)=='list')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Mail Template </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url(Helper::sitePrefix().'mail/cart')}}"
               class="nav-link {{ (Request::segment(3)=='cart')?'active':'' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Cart</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="{{url(Helper::sitePrefix().'sitemap_generator')}}" class="nav-link {{ (Request::segment(2)=='sitemap_generator')?'active':'' }}">
        {{--        <i class="nav-icon fas fa-asterisk"></i>--}}
        <i class="nav-icon fas fa-money-bill-wave"></i>
        <p>Sitemap Generator</p>
    </a>
</li>