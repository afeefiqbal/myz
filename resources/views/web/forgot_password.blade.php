
@extends('web.layouts.main')
@section('content')
<section class="loginSection position-relative">
        <div class="container position-relative">
            <div class="row">
                <div class="col-xxl-5 col-xl-6 col-lg-7 myAccountContainer">
                    <div class="myAccountForm">
                        <h3>Forgot Password</h3>
                        <form action="" id="forgot">
                    <div class="row">
                        <!-- <div class="form-group">
                            <input type="text" class="form-control required" id="name" name="name" placeholder="Name*">
                            <span class="invalidMessage"></span>
                        </div> -->
                        <div class="form-group">
                            <img src="{{asset('frontend/images/icon-email.png')}}" alt="">
                            <input type="text" class="form-control required" id="email" name="email" placeholder="Email*">
                        </div>

                        <!-- <div class="form-group">
                            <textarea name="" class="form-control form-message" placeholder="Message*"></textarea>

                        </div> -->
                        <div class="form-group">
                            <button class="btn primary_btn  form_submit_btn" data-url="/forgot-password" id="forgotpasswdform_submit_btn">Send</button>
                        </div>
                    </div>
                </form>
                        <h6 class="or">OR</h6>
                        <div class="loginOptionWrapper">
                            <a class="btnBox" href="{{ url('auth/google') }}"> <img src="{{asset('frontend/images/googleIcon.png')}}" alt="">  <p>Continue With Google</p> </a>
                            <a class="btnBox btnBoxFace" href="{{ url('auth/facebook') }}"> <img src="{{asset('frontend/images/facebookIcon.png')}}" alt=""> <p>Continue With Facebook</p> </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 myAccountImageBox">
                    <img class="img-fluid w-100" src="assets/images/loginImage.png" alt="">
                </div>
            </div>
        </div>
    </section>

@endsection
@push('scripts')

@endpush
