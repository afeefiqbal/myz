
@extends('web.layouts.main')
@section('content')



<section class="loginSection position-relative">
        <div class="container position-relative">
            <div class="row">
                <div class="col-xxl-5 col-xl-6 col-lg-7 myAccountContainer">
                    <div class="myAccountForm">
                        <h3>Login</h3>
                        <form action="" id="login">
                    <div class="row">
                        <!-- <div class="form-group">
                            <input type="text" class="form-control required" id="name" name="name" placeholder="Name*">
                            <span class="invalidMessage"></span>
                        </div> -->
                        <div class="form-group">
                            <img src="{{asset('frontend/images/loginUser.png')}}" alt="">
                            <input type="text" class="form-control required" id="username" name="username" placeholder="Email*" value="{{old('username')}}">
                        </div>
                        <div class="form-group">
                            <img src="{{asset('frontend/images/loginPassword.png')}}" alt="">
                            <input type="password" class="form-control required" id="password" name="password" placeholder="Password*">
                            <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>
                        <!-- <div class="form-group">
                            <textarea name="" class="form-control form-message" placeholder="Message*"></textarea>

                        </div> -->
                        <div class="form-group">
                          
                            <div class="btnRegister">
                                <a href="{{url('/forgot-password')}}">Forgotten password?</a>
                            </div>
                        </div>
                        <div class="col-12x ">
                            <div class="form-group btnWrapper">
                                <button class="btn primary_btn loginform_submit_btn" data-url="/login" >Login</button>
                                <div class="btnRegister">
                                    <p>Create an Account</p>
                                    <a href="{{url('/register')}}">Register</a>
                                </div>
                            </div>
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
                    <img class="img-fluid w-100" src="{{asset('frontend/images/images/loginImage.png')}}" alt="">
                </div>
            </div>
        </div>
    </section>

@endsection
@push('scripts')

@endpush
