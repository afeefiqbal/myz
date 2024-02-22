
@extends('web.layouts.main')
@section('content')
<section class="loginSection position-relative">
        <div class="container position-relative">
            <div class="row">
                <div class="col-xxl-5 col-xl-6 col-lg-7 myAccountContainer">
                    <div class="myAccountForm">
                        <h3>Verify Your Email</h3>
                        <form action="" id="verify">
                    <div class="row">
                        <!-- <div class="form-group">
                            <input type="text" class="form-control required" id="name" name="name" placeholder="Name*">
                            <span class="invalidMessage"></span>
                        </div> -->
                       
                        <!-- <div class="form-group">
                            <textarea name="" class="form-control form-message" placeholder="Message*"></textarea>
                         
                        </div> -->
                        
                        <div class="form-group">
                            <button class="btn primary_btn form_submit_btn" data-url="/email-verification/{{$token}}" >Verify</button>
                        </div>
                    </div>
                </form>
                        
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