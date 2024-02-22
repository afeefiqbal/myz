<form id="review-form" class="product-review-form" method="post">
    <div class="formArea">
        <div class="head">
            <h5>Write A Review</h5>
            <div>
                <div class="my-rating" data-rating="0"></div>
                <input type="hidden" name="rating" id="rating" class="review-required rating">
            </div>
        </div>
        <div class="row">
            @if(!Auth::guard('customer')->check())
                <div class=" col-12 name">
                    <div class="form-group">
                        <label for="">Full Name</label>
                        <img src="{{ asset('frontend/images/loginUser.png') }}" alt="">
                        <input type="text" class="form-control product-review-required form-review" placeholder="Full Name"  name="name" id="name">
                    </div>
                </div>
                <div class=" col-12 email">
                    <div class="form-group">
                        <label for="">Email Address</label>
                        <img src="{{ asset('frontend/images/icon-email.png') }}" alt="">
                        <input   name="email" id="email"  type="text" class="form-control form-review product-review-required" placeholder="Email Address">
                    </div>
                </div>
            @endif
            <div class="col-12 message review">
                <div class="form-group">
                    <label for="">Message</label>
                    <img src="{{ asset('frontend/images/icon-pen.png') }}" alt="">
                    <textarea class="form-control form-review product-review-required" rows="4"name="message" id="message" placeholder="Say Something" required></textarea>
                </div>
            </div>
            <input type="hidden" name="product_id" id="product_id"  value="{{$product_id}}">
            <div class="col-12x ">
                <div class="form-group d-flex align-items-end mb-0">
                    <button type="submit" data-url="/product-review" id="-form-btn" class="primary_btn form_submit_btn ">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
