
    <!-- Footer Section Start -->
    <footer class="section-t-space">
        <div class="container-fluid-lg">
            <div class="service-section">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="service-contain">
                            @if(@$first_image)
                            <div class="service-box">
                             
                                <div class="service-image">
                                    <img src="{{asset(@$first_image)}}" class="blur-up lazyload" alt="">
                                </div>

                                <div class="service-detail">
                                    <h5>{{@$first_image_text}}</h5>
                                </div>
                            </div>
                            @endif
                            @if (@$second_image)
                            <div class="service-box">
                                <div class="service-image">
                                    <img src="{{asset(@$second_image)}}" class="blur-up lazyload" alt="">
                                </div>

                                <div class="service-detail">
                                    <h5>{{@$second_image_text}}</h5>
                                </div>
                            </div>
                                
                            @endif
                            @if (@$third_image)
                            <div class="service-box">
                                <div class="service-image">
                                    <img src="{{asset(@$third_image)}}" class="blur-up lazyload" alt="">
                                </div>

                                <div class="service-detail">
                                    <h5>{{@$third_image_text}}</h5>
                                </div>
                            </div>
                            @endif

                            {{-- <div class="service-box">
                                <div class="service-image">
                                    <img src="{{asset(@$third_image)}}" class="blur-up lazyload" alt="">
                                </div>

                                <div class="service-detail">
                                    <h5>{{@$third_image_text}}</h5>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-footer section-b-space section-t-space">
                <div class="row g-md-4 g-3">
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="footer-logo">
                            <div class="theme-logo">
                                <a href="index.php">
                                    <img src="{{asset('assets/images/logo/logo.jpeg')}}" class="blur-up lazyload" alt="">
                                </a>
                            </div>

                            <div class="footer-logo-contain">
                                <p></p>

                                <ul class="address">
                                    <li>
                                        <i data-feather="home"></i>
                                        <a href="javascript:void(0)">{!! @$siteInformation->address !!}</a>
                                    </li>
                                    <li>
                                        <i data-feather="mail"></i>
                                        <a href="javascript:void(0)">{{@$siteInformation->email}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>



                    <div class="col-xl col-lg-2 col-sm-3">
                        <div class="footer-title">
                            <h4>Useful Links</h4>
                        </div>

                        <div class="footer-contain">
                            <ul>
                                <li>
                                    <a href="/" class="text-content">Home</a>
                                </li>
                                <li>
                                    <a href="{{url('products')}}" class="text-content">Shop</a>
                                </li>
                                <li>
                                    <a href="{{url('about')}}" class="text-content">About Us</a>
                                </li>
                                <li>
                                    {{-- <a href="blog.php" class="text-content">Blog</a> --}}
                                </li>
                                <li>
                                    <a href="{{url('contact')}}" class="text-content">Contact Us</a>
                                </li>
                            </ul>

                        </div>

                    </div>

                    @isset($menus)
                    <div class="col-xl col-lg-2 col-sm-3">
                        <div class="footer-title">
                            <h4>Categories</h4>
                        </div>
                        <div class="footer-contain">
                            <ul>
                                @foreach($menus as $menu)
                                @if($menu->menu_type=="category")
                                    @php
                                        $menuDetails = App\Models\MenuDetail::active()->where('menu_id',$menu->id)->get();
                                        $colorId = [];
                                        foreach($menuDetails as $menuDetail){
                                            $categoryId[] = $menuDetail->category_id;
                                        }
                                        $categoryItems = App\Models\Category::whereIn('id',$categoryId)->get();
                                    @endphp
                                @foreach ($categoryItems as $cat)

                                <li>
                                    <a href="{{url('category/'.$cat->short_url)}}" class="text-content">{{ $cat->title }}</a>
                                </li>

                                @endforeach
                                @endif

                                @endforeach

                            </ul>

                        </div>

                    </div>
                @endisset

                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="footer-title">
                            <h4>Contact Us</h4>
                        </div>

                        <div class="footer-contact">
                            <ul>
                                <li>
                                    <div class="footer-number">
                                        <i data-feather="phone"></i>
                                        <div class="contact-number">
                                            <h5 class="text-content"> :{{@$siteInformation->phone}} </h5>
                                            
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="footer-number">
                                        <i data-feather="mail"></i>
                                        <div class="contact-number">
                                            <h6 class="text-content">Email Address :</h6>
                                            <h5>{{@$siteInformation->email}}</h5>
                                        </div>
                                    </div>
                                </li>


                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sub-footer section-small-space">
                <div class="reserve">
                    <h6 class="text-content">©2024 All rights reserved</h6>
                </div>

                <div class="payment">
                    <img src="{{asset('assets/images/payment/1.png')}}" class="blur-up lazyload" alt="">
                </div>

                <div class="social-link">
                    <h6 class="text-content">Stay connected :</h6>
                    <ul>
                        <li>
                            <a href="https://www.facebook.com/" target="_blank">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://twitter.com/" target="_blank">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.instagram.com/" target="_blank">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://in.pinterest.com/" target="_blank">
                                <i class="fa-brands fa-pinterest-p"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Quick View Modal Box Start -->

    <!-- Quick View Modal Box End -->

    <!-- Location Modal Start -->
    <div class="modal location-modal fade theme-modal" id="locationModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Choose your Delivery Location</h5>
                    <p class="mt-1 text-content">Enter your address and we will specify the offer for your area.</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="location-list">
                        <div class="search-input">
                            <input type="search" class="form-control" placeholder="Search Your Area">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>

                        <div class="disabled-box">
                            <h6>Select a Location</h6>
                        </div>

                        <ul class="location-select custom-height">
                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Alabama</h6>
                                    <span>Min: $130</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Arizona</h6>
                                    <span>Min: $150</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>California</h6>
                                    <span>Min: $110</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Colorado</h6>
                                    <span>Min: $140</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Florida</h6>
                                    <span>Min: $160</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Georgia</h6>
                                    <span>Min: $120</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Kansas</h6>
                                    <span>Min: $170</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Minnesota</h6>
                                    <span>Min: $120</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>New York</h6>
                                    <span>Min: $110</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Washington</h6>
                                    <span>Min: $130</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Location Modal End -->


    <!-- Cookie Bar Box Start -->
    {{-- zc<div class="cookie-bar-box">
        <div class="cookie-box">
            <div class="cookie-image">
                <img src="{{asset('assets/images/cookie-bar.png')}}" class="blur-up lazyload" alt="">
                <h2>Cookies!</h2>
            </div>

            <div class="cookie-contain">
                <h5 class="text-content">We use cookies to make your experience better</h5>
            </div>
        </div>

        <div class="button-group">
            <button class="btn privacy-button">Privacy Policy</button>
            <button class="btn ok-button">OK</button>
        </div>
    </div> --}}
    <!-- Cookie Bar Box End -->

    <!-- Deal Box Modal Start -->
    <div class="modal fade theme-modal deal-modal" id="deal-box" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title w-100" id="deal_today">Deal Today</h5>
                        <p class="mt-1 text-content">Recommended deals for you.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="col-xl-8 ratio_65">
                        <div class="home-contain h-100 ">
                            <div class="h-100">
                                <img src="{{@$banners->deal_image}}" class="bg-img blur-up lazyload" alt="">
                            </div>
                            <div class="home-detail p-center-left w-75">
                                <div>
                                    <h6><span></span></h6>
                                    <h1 class="text-uppercase"> <span class="daily"></span></h1>
                                    <p class="w-75 d-none d-sm-block"></p>
                                    <button onclick="location.href = '{{url(isset($banners) ? $banners->deal_image_url : url('products'))}}';"
                                        class="btn btn-animation mt-xxl-4 mt-2 home-button mend-auto">Shop Now <i
                                            class="fa-solid fa-right-long icon"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Deal Box Modal End -->

    <!-- Tap to top start -->
    <div class="theme-option">

        <div class="back-to-top">
            <a id="back-to-top" href="#">
                <i class="fas fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <!-- Tap to top end -->

    <!-- Bg overlay Start -->
    <div class="bg-overlay"></div>
    <!-- Bg overlay End -->

    <!-- Bg overlay Start -->
    <div class="bg-overlay"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> --}}
<script>
    function goToByScroll(id){
        $('html,body').animate({scrollTop: $("#"+id).offset().top-0},'slow');
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.15.6/sweetalert2.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script type="text/javascript">
    var base_url = "{{ url('/') }}";
    var token = "{{ csrf_token() }}";
    var swal = Swal.mixin({
        backdrop: true, showConfirmButton: true,
    });
    var Toast = Swal.mixin({
        toast: true, position: 'top-end', showConfirmButton: false, timer: 3000
    });

    @if(Session::has('login-errors'))
    Toast.fire("Error",'{{Session::get('login-errors')}}', 'error');
    @endif

</script>
<script src="https://kit.fontawesome.com/99358fb784.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.4.1/jquery.fancybox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
<script  src="{{ asset('frontend/js/form-select2_new.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xzoom/1.0.15/xzoom.min.js"></script>
<script src="{{ asset('frontend/xzoom/js/setup.js')}}"></script>
<!-- <script  src="{{ asset('frontend/js/scripts.min.js')}}"></script> -->
<!-- <script  src="{{ asset('frontend/js/custom.min.js')}}"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
    function goToByScroll(id){
        $('html,body').animate({scrollTop: $("#"+id).offset().top-0},'slow');
    }
</script>

<script src="https://kit.fontawesome.com/99358fb784.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.4.1/jquery.fancybox.min.js"></script>

<script  src="{{ asset('frontend/js/jquery.star-rating-svg.min.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
<script  src="{{ asset('frontend/js/form-select2_new.min.js')}}"></script>

<!--    <script src="assets/owlcarousel/owl.carousel.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xzoom/1.0.15/xzoom.min.js"></script>
<script src="{{ asset('js/wizard.js')}}"></script>
<script src="{{ asset('frontend/xzoom/js/setup.js')}}"></script>
  <!-- latest jquery-->
  <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
  <script  src="{{ asset('frontend/js/jquery.star-rating-svg.min.js')}}"></script>
  <!-- jquery ui-->
  <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <script src="{{asset('assets/js/wizard.js')}}"></script>

<!--    <script src="https://code.jquery.com/jquery-2.2.4.min.js')}}"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.5.0/dist/sweetalert2.all.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <!-- Bg overlay End -->
    <script src="https://kit.fontawesome.com/99358fb784.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.4.1/jquery.fancybox.min.js"></script>

    <script  src="{{ asset('frontend/js/jquery.star-rating-svg.min.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
    <!-- latest jquery-->
    <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    <script  src="{{ asset('frontend/js/custom.js')}}"></script>
    <script  src="{{ asset('frontend/js/scripts.js')}}"></script>
    <script  src="{{ asset('frontend/js/demo.js')}}"></script>
    <!-- jquery ui-->
    <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
    <script src="../assets/js/bootstrap/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap js-->
    <script src="{{asset('assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap/bootstrap-notify.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap/popper.min.js')}}"></script>

    <!-- feather icon js-->
    <script src="{{asset('assets/js/feather/feather.min.js')}}"></script>
    <script src="{{asset('assets/js/feather/feather-icon.js')}}"></script>

    <!-- Lazyload Js -->
    <script src="{{asset('assets/js/lazysizes.min.js')}}"></script>

    <!-- Slick js-->
    <script src="{{asset('assets/js/slick/slick.js')}}"></script>
    <script src="{{asset('assets/js/slick/custom_slick.j')}}s"></script>

    <!-- Auto Height Js -->
    <script src="{{asset('assets/js/auto-height.js')}}"></script>

    <!-- Timer Js -->
    <!-- <script src="assets/js/timer.js"></script> -->

    <!-- Fly Cart Js -->
    <script src="{{asset('assets/js/fly-cart.js')}}"></script>

    <!-- Quantity js -->
    <script src="{{asset('assets/js/quantity-2.js')}}"></script>

    <!-- WOW js -->
    <script src="{{asset('assets/js/wow.min.js')}}"></script>
    <script src="{{asset('assets/js/custom-wow.js')}}"></script>

    <!-- script js -->
    <script src="{{asset('assets/js/script.js')}}"></script>

    <!-- thme setting js -->
    <script src="{{asset('assets/js/theme-setting.js')}}"></script>
    <script>
     
    
      
    
        function injectGoogleTranslate() {
            var googleTranslateScript = document.createElement('script');
            googleTranslateScript.type = 'text/javascript';
            googleTranslateScript.src = '//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
            (document.head || document.body).appendChild(googleTranslateScript);
        }
    
        window.addEventListener('load', injectGoogleTranslate);
    </script>
    @stack('scripts')
</body>

</html>
