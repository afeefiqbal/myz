  <!-- Header Start -->
  <header class="pb-md-4 pb-0">
    <div class="header-top">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-3 d-xxl-block d-none">
                    <div class="top-left-header">
                        <i class="iconly-Location icli text-white"></i>
                        <span class="text-white"> Khalid Bin Walid Road, Bur Dubai, UAE</span>
                    </div>
                </div>

                <div class="col-xxl-6 col-lg-9 d-lg-block d-none">
                    <div class="header-offer">
                        <div class="notification-slider">
                            <div>
                                <div class="timer-notification">
                                    <h6><strong class="me-1">Welcome to MYZ!</strong>

                                    </h6>
                                </div>
                            </div>

                            <div>
                                <div class="timer-notification">
                                    <h6>Something you love is now on sale!
                                        <a href="#" class="text-white">Buy Now
                                            !</a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="top-nav top-header sticky-header">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="navbar-top">
                        <button class="navbar-toggler d-xl-none d-inline navbar-menu-button" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#primaryMenu">
                            <span class="navbar-toggler-icon">
                                <i class="fa-solid fa-bars"></i>
                            </span>
                        </button>
                        <a href="{{route('/')}}" class="web-logo nav-logo">
                            <img src="{{asset('assets/images/logo/logo.jpeg')}}" class="img-fluid blur-up lazyload" alt="">
                        </a>
                        <div class="middle-box">

                            <form class="position-relative">
                            <div class="search-box">
                                <div class="input-group">
                                    <input type="search" class="form-control" placeholder="I'm searching for..." id="main-search" 
                                        aria-label="Recipient's username" aria-describedby="button-addon2">
                                    <button class="btn" type="submit" id="searchBtn">
                                        <i data-feather="search"></i>
                                    </button>
                                
                                </div>
                            </form>
                            </div>
                        </div>

                        <div class="rightside-box">
                            <div class="search-full">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i data-feather="search" class="font-light"></i>
                                    </span>
                                    <input type="text" class="form-control search-type" placeholder="Search here..">
                                    <span class="input-group-text close-search">
                                        <i data-feather="x" class="font-light"></i>
                                    </span>
                                </div>
                            </div>
                            <ul class="right-side-menu">
                                <li class="right-side">
                                    <div class="delivery-login-box">
                                        <div class="delivery-icon">
                                            <div class="search-box">
                                                <i data-feather="search"></i>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="right-side">
                                    <a href="https://wa.me/{!! @$contact->whatsapp_number !!}" class="delivery-login-box" target="_blank">
                                        <div class="delivery-icon">
                                            <i class="fa fa-whatsapp" aria-hidden="true" style="font-size: 27px;"></i>
                                        </div>

                                    </a>
                                </li>
                                <li class="right-side">
                                    <a href="/contact" class="delivery-login-box">
                                        <div class="delivery-icon">
                                            <i data-feather="phone-call"></i>
                                        </div>
                                        <div class="delivery-detail">
                                            <h6>Free
                                                Delivery</h6>
                                            <h5>+971-50-232-9670</h5>
                                        </div>
                                    </a>
                                </li>
                                @if(Auth::guard('customer')->check())
                                <li class="right-side">
                                    <a href="{{url('customer/account/wishlist')}}" class="btn p-0 position-relative header-wishlist">
                                        <i data-feather="heart"></i>
                                    </a>
                                </li>
                                    @endif
                                <li class="right-side">
                                    <div class="onhover-dropdown header-badge">
                                        <button type="button" onclick="location.href = '{{ url('/cart') }}'" class="btn p-0 position-relative header-wishlist">
                                            <i data-feather="shopping-cart"></i>
                                            <span class="position-absolute top-0 start-100 translate-middle badge">  {{ Helper::getCartItemCount()}}
                                                <span class="visually-hidden">unread messages</span>
                                            </span>
                                        </button>

                                    </div>
                                </li>
                                @if(Auth::guard('customer')->check())
                                <li class="right-side onhover-dropdown">
                                    <div class="delivery-login-box">
                                        <div class="delivery-icon">
                                            <i data-feather="user"></i>
                                        </div>

                                    </div>

                                    <div class="onhover-div onhover-div-login">
                                        <ul class="user-box-name">
                                            <li class="product-box-contain">
                                                <i></i>
                                                <a href="{{ url('customer/account/profile') }}">My Account</a>
                                            </li>

                                            <li class="product-box-contain">
                                                <a href="{{ url('logout') }}">Logout</a>
                                            </li>

                                            <li class="product-box-contain">
                                                <a href="{{url('forgot-password')}}">Forgot Password</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                @else
                                <li class="right-side onhover-dropdown">
                                    <div class="delivery-login-box">
                                        <div class="delivery-icon">
                                            <i data-feather="user"></i>
                                        </div>

                                    </div>

                                    <div class="onhover-div onhover-div-login">
                                        <ul class="user-box-name">
                                            <li class="product-box-contain">
                                                <i></i>
                                                <a href="{{url('login')}}">Log In</a>
                                            </li>

                                            <li class="product-box-contain">
                                                <a href="{{url('register')}}">Register</a>
                                            </li>

                                            <li class="product-box-contain">
                                                <a href="{{url('forgot-password')}}">Forgot Password</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid-lg">

        <div class="row">
            <div class="col-12">
                <div class="header-nav">
                    <div class="header-nav-left">
                        <button class="dropdown-category">
                            <i data-feather="align-left"></i>
                            <span>All Categories</span>
                        </button>

                        <div class="category-dropdown">
                            <div class="category-title">
                                <h5>Categories</h5>
                                <button type="button" class="btn p-0 close-button text-content">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>

                            <ul class="category-list">
                                @foreach ($sideMenus as $sidemenu)

                                <li class="onhover-category-list">
                                    <a href="javascript:void(0)" class="category-name">
                                        @php
                                        $subSideMenu = App\Models\SideMenuDetail::active()->where('menu_id',$sidemenu->id)->first();
                                        @endphp
                                        <h6> {{ $sidemenu->title}}</h6>
                                        <i class="fa-solid fa-angle-right"></i>
                                    </a>
                                    @if($sidemenu->menu_type=="category")
                                    <div class="onhover-category-box">
                                        <div class="list-1">
                                            @php
                                            $sideMenuDetails = App\Models\SideMenuDetail::active()->where('menu_id',$sidemenu->id)->get();

                                            $colorId = [];
                                            foreach($sideMenuDetails as $sideMenuDetail){
                                                $colorId[] = $sideMenuDetail->category_id;
                                                ($sideMenudetail);
                                            }
                                            $colorItems = App\Models\Category::whereIn('id',$colorId)->get();
                                            @endphp

                                            <ul>
                                                @foreach ($colorItems as $menuCat)

                                                <li>
                                                    <a href="{{url('category/'.$menuCat->short_url)}}">{{$menuCat->title}}</a>
                                                </li>
                                                @endforeach



                                            </ul>
                                        </div>


                                    </div>
                                    @endif
                                </li>
                                @endforeach


                            </ul>
                        </div>
                    </div>
                    @if($menus->isNotEmpty())
                    <div class="header-nav-middle">
                        <div class="main-nav navbar navbar-expand-xl navbar-light navbar-sticky">
                            <div class="offcanvas offcanvas-collapse order-xl-2" id="primaryMenu">
                                <div class="offcanvas-header navbar-shadow">
                                    <h5>Menu</h5>
                                    <button class="btn-close lead" type="button" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <ul class="navbar-nav">
                                        @foreach($menus as $menu)
                                        @php
                                            $subMenu = App\Models\MenuDetail::active()->where('menu_id',$menu->id)->first();
                                        @endphp
                                        @if($subMenu==NULL)

                                        @if($menu->menu_type=="category")
                                        @else
                                        <li class="nav-item active">
                                            <a class="nav-link nav-link-2" href="{{ url($menu->url) }}">
                                                {{$menu->title}}
                                            </a>
                                        </li>
                                        @endif
                                        @else

                                        <li class="nav-item dropdown dropdown-mega">
                                            <a class="nav-link dropdown-toggle ps-xl-2 ps-0"
                                                href="javascript:void(0)" data-bs-toggle="dropdown">{{$menu->title}}</a>

                                            <div class="dropdown-menu dropdown-menu-2 row g-3">
                                                @if($menu->menu_type=="category")
                                                    @php
                                                        $menuDetails = App\Models\MenuDetail::active()->where('menu_id',$menu->id)->get();
                                                        $colorId = [];
                                                        foreach($menuDetails as $menuDetail){
                                                            $categoryId[] = $menuDetail->category_id;
                                                        }
                                                        $categoryItems = App\Models\Category::whereIn('id',$categoryId)->get();
                                                    @endphp
                                                @endif
                                                <div class="dropdown-column col-xl-3">
                                                    <h5 class="dropdown-header">{{$menu->title}}</h5>
                                                    @foreach ($categoryItems as $menuCat)
                                                    <a class="dropdown-item" href="{{url('category/'.$menuCat->short_url)}}">{{$menuCat->title}}</a>
                                                    @endforeach


                                                </div>



                                            </div>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="header-nav-right">
                        <button class="btn deal-button" data-bs-toggle="modal" data-bs-target="#deal-box">
                            <i data-feather="zap"></i>
                            <span>Deal Today</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header End -->

<!-- mobile fix menu start -->
<div class="mobile-menu d-md-none d-block mobile-cart">
    <ul>
        <li class="active">
            <a href="index">
                <i class="iconly-Home icli"></i>
                <span>Home</span>
            </a>
        </li>

        <li class="mobile-category">
            <a href="javascript:void(0)">
                <i class="iconly-Category icli js-link"></i>
                <span>Category</span>
            </a>
        </li>

        <li>
            <a href="search" class="search-box">
                <i class="iconly-Search icli"></i>
                <span>Search</span>
            </a>
        </li>

        <li>
            <a href="wishlist" class="notifi-wishlist">
                <i class="iconly-Heart icli"></i>
                <span>My Wish</span>
            </a>
        </li>

        <li>
            <a href="cart">
                <i class="iconly-Bag-2 icli fly-cate"></i>
                <span>Cart</span>
            </a>
        </li>
    </ul>
</div>
