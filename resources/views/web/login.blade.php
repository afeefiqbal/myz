
@extends('web.layouts.main')
@section('content')



  <!-- Breadcrumb Section Start -->
  <section class="breadscrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadscrumb-contain">
                    <h2 class="mb-2">Log In</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="index.php">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Log In</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- log in section start -->
<section class="log-in-section background-image-2 section-b-space">
    <div class="container-fluid-lg w-100">
        <div class="row">
            <div class="col-xxl-6 col-xl-5 col-lg-6 d-lg-block d-none ms-auto">
                <div class="image-contain">
                    <img src="assets/images/inner-page/log-in.png" class="img-fluid" alt="">
                </div>
            </div>

            <div class="col-xxl-4 col-xl-5 col-lg-6 me-auto">
                <div class="log-in-box">
                    <div class="log-in-title">
                        <h3>Welcome To MYZ</h3>
                        <h4>Log In Your Account</h4>
                    </div>

                    <div class="input-box">
                        <form class="row g-4" id="login">
                            <div class="col-12">
                                <div class="form-floating theme-form-floating log-in-form">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Email Address" value="{{old('username')}}">
                                    <label for="email">Email Address</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating theme-form-floating log-in-form">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password">
                                    <label for="password">Password</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="forgot-box">
                                    <div class="form-check ps-0 m-0 remember-box">
                                        <input class="checkbox_animated check-box" type="checkbox"
                                            id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">Remember me</label>
                                    </div>
                                    <a href="{{url('forgot-password')}}" class="forgot-password">Forgot Password?</a>
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-animation w-100 justify-content-center loginform_submit_btn" data-url="/login" type="submit">Log
                                    In</button>
                            </div>
                        </form>
                    </div>

                    {{-- <div class="other-log-in">
                        <h6>or</h6>
                    </div> --}}

                    <div class="log-in-button">
                        {{-- <ul>
                            <li>
                                <a href="https://www.google.com/" class="btn google-button w-100">
                                    <img src="assets/images/inner-page/google.png" class="blur-up lazyload"
                                        alt=""> Log In with Google
                                </a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/" class="btn google-button w-100">
                                    <img src="assets/images/inner-page/facebook.png" class="blur-up lazyload"
                                        alt=""> Log In with Facebook
                                </a>
                            </li>
                        </ul> --}}
                    </div>

                    <div class="other-log-in">
                        <h6></h6>
                    </div>

                    <div class="sign-up-box">
                        <h4>Don't have an account?</h4>
                        <a href="{{url('register')}}">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@push('scripts')

@endpush
