@extends('web.layouts.main')
@section('content')


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
<section class="log-in-section section-b-space">
    <div class="container-fluid-lg w-100">
        <div class="row">
            <div class="col-xxl-6 col-xl-5 col-lg-6 d-lg-block d-none ms-auto">
                <div class="image-contain">
                    <img src="assets/images/inner-page/sign-up.png" class="img-fluid" alt="">
                </div>
            </div>

            <div class="col-xxl-6 col-xl-6 col-lg-12 me-auto">
                <div class="log-in-box">
                    <div class="log-in-title">
                        <h3>Welcome To Fastkart</h3>
                        <h4>Create New Account</h4>
                    </div>

                    <div class="input-box">
                        <form class="row g-4" id="registerForm">
                            <div class="col-6">
                                <div class="form-floating theme-form-floating">
                                    <input type="text" class="form-control required" id="firstname" name="firstname" placeholder="Full Name">
                                    <label for="firstname">First Name</label>
                                    <span class="invalidMessage">  </span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating theme-form-floating">
                                    <input type="text" class="form-control required" id="lastname" name="lastname" placeholder="Full Name">
                                    <label for="lastname">Last Name</label>
                                    <span class="invalidMessage">  </span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating theme-form-floating">
                                    <input type="email" class="form-control required" name="email" id="email" placeholder="Email Address">
                                    <label for="email">Email Address</label> 
                                    <span class="invalidMessage">  </span>
                                </div>
                            </div>
                            <div class=" col-6">
                                <div class="form-group form-floating theme-form-floating">
                                    <input type="text" class="form-control required register-phone" name="phone" id="phone"placeholder="Enter Phone number ">
                                    <label for="phone">Phone number</label>
                                    <span class="invalidMessage">  </span>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-floating theme-form-floating">
                                    <input type="password" class="form-control required" name="password" id="password" placeholder="Password">
                                    <label for="password"> Password</label>
                                 
                                    <span class="invalidMessage">  </span>
                                </div>
                            </div>
                            <div class=" col-6">
                                <div class="form-group">
                                    <div class="position-relative d-flex align-items-center form-floating theme-form-floating">
                                        <input id="confirm_password" type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Re-enter Password" name="password">
                                        <span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        <label for="">Confirm Password</label>
                                        <span class="invalidMessage">  </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="forgot-box">
                                    <div class="form-check ps-0 m-0 remember-box">
                                        <input class="checkbox_animated check-box " type="checkbox"
                                            id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">I agree with
                                            <span>Terms</span> and <span>Privacy</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-animation w-100 registerform_submit_btn" type="button" data-url="/register">Sign Up</button>
                            </div>
                        </form>
                    </div>
{{-- 
                    <div class="other-log-in">
                        <h6>or</h6>
                    </div>

                    <div class="log-in-button">
                        <ul>
                            <li>
                                <a href="https://accounts.google.com/signin/v2/identifier?flowName=GlifWebSignIn&amp;flowEntry=ServiceLogin"
                                    class="btn google-button w-100">
                                    <img src="assets/images/inner-page/google.png" class="blur-up lazyload"
                                        alt="">
                                    Sign up with Google
                                </a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/" class="btn google-button w-100">
                                    <img src="assets/images/inner-page/facebook.png" class="blur-up lazyload"
                                        alt=""> Sign up with Facebook
                                </a>
                            </li>
                        </ul>
                    </div> --}}

                    <div class="other-log-in">
                        <h6></h6>
                    </div>

                    <div class="sign-up-box">
                        <h4>Already have an account?</h4>
                        <a href="{{url('login')}}">Log In</a>
                    </div>
                </div>
            </div>

            <div class="col-xxl-7 col-xl-6 col-lg-6"></div>
        </div>
    </div>
</section>

    @endsection
@push('scripts')

@endpush




