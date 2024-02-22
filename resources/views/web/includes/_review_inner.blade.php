<section class="testimonialSection productTestimonialSection">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-12 pt-60">
                <div class="testimonialsSlider">
                    @foreach($reviews as $review)
                        <div class="testimonialsCard">
                            <div class="testimonialsProfile">
                                <div class="leftPhoto">
                                    <img class="img-fluid" src="{{asset('frontend/images/testimonail.png')}}" alt="">
                                </div>
                                <div class="rightDetails">
                                    <h3>{{$review->name}}</h3>
                                  
                                    <div class="reviewIconStar">
                                        
                                        <div class="my-rating-readonly" data-rating="{{$review->rating}}"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="textWrapper">
                            
                                <p>{!!$review->review!!}</p>
                            </div>
                        </div>
                   @endforeach
                </div>
            </div>
            <div class="col-12 text-center mt-md-5">
                <a href="#review-form" class="primary_btn">Add Your Review</a>
            </div>
        </div>
    </div>
   
</section>