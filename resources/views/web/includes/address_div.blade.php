@if(Auth::guard('customer')->check())
<div id ="login_div" class="   @if(!Auth::guard('customer')->check()) d-none @endif">
    <div class="checkoutDetailsLeft">
        
       
        
            <div class="headArea">
                @if ($customerAddresses->isNotEmpty())
                    <h4>
                        Select Shipping Address
                    </h4>
                @endif
                <div class="right">
                    <button class="btn secondary_btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#shippingAddress" aria-controls="billingAddress"><i class="fa-solid fa-plus"></i> Add Shipping Address</button>
                    <div class="slick-address-nav1">
                    </div>
                </div>
            </div>
       
        <div class="row">
            <div class="col-12">
                <div class="select_billing_address_slider">
                    @if (@$customerAddresses)
                        @foreach($customerAddresses as $address)
                        @php
                        $message = '';
                        $class = '';
                      if($address->state)
                                          $shipping = App\Models\ShippingCharge::active()
                                                          ->where('state_id' ,$address->state->id)->first();
                                      else
                                          $shipping = NULL;
                                      if($shipping == NULL){
                                          $class = 'd-none';
                                          $message = 'This item cannot be shipped on this location';
                                          $tooltipval = '';
                                      }
                  @endphp
                            <div class="select_address_card  address_session{{$address->id}}     @if (session('selected_customer_address')== $address->id) active @endif">
                                <h6 class="ads_name">
                                    {{$address->first_name.' '.$address->last_name}}
                                </h6>
                                <p class="addressLabel">
                                    {{$address->address_type}}
                                </p>
                                <div class="add_line">
                                    <p>
                                        {{$address->address}}
                                    </p>
                                </div>
                                <p class="phone">
                                    Email :  {{$address->email}}
                                </p>
                                <p class="phone">
                                    Phone : {{$address->phone}}
                                </p>
                                @if ($address->zipcode)
                                <p>
                                    <p>ZIP Code : {{$address->zipcode}}</p>
                                </p>
                                @endif
                                    @if ($address->state)
                                    <p>
                                        <p>State : {{ $address->state->title }}</p>
                                    </p>
                                    @endif
                                    <p>
                                        <p>Country
                                            :  {{$address->country->title ?? ''}}</p>
                                    </p>
                                   
                              <p>
                                <p style="color: red; margin-top: 10px;">{{ $message }}</p>
                              </p>
                                <div class="buttons_area">
                                    <a 
                                    class="set_d_add deliver login{{$address->id}}  @if(session('selected_customer_address')!= $address->id && $message == '')  @else d-none  @endif" href="" data-id="{{$address->id}}"  data-address-type="shipping"
                                    tabindex="0"><img src="{{asset('frontend/images/selectSliderActive.png')}}"
                                     alt=""  
                                     href="javascript:void(0)"> Select</a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="billingAddressOffcanvas position-relative">
                    <div class="offcanvas offcanvas-top add_address_form" data-bs-scroll="true" tabindex="-1" id="shippingAddress" aria-labelledby="offcanvasTopLabel">
                        <div class="offcanvas-header">
                            <h4>Add Shipping Address</h4>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <form action="#" id="addShippingLoginAddressForm" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">First Name</label>
                                        <input type="text" name="first_name" id="first_name"  class="form-control required " maxlength="60" required placeholder="First Name*"  value="{{(Session::has('shipping_first_name'))?session('shipping_first_name'):''}}">
                                       
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Last Name</label>
                                        <input type="text" name="last_name" id="last_name"  class="form-control required " maxlength="60" required placeholder="Last Name*"  value="{{(Session::has('shipping_last_name'))?session('shipping_last_name'):''}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="text" class="form-control required "   name="email" id="email"  maxlength="70" required placeholder="Email*"  value="{{(Session::has('shipping_email'))?session('shipping_email'):''}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Phone Number</label>
                                        <input type="text" class="form-control required  required login-shipping-phone" placeholder="Phone Number*"  name="phone" id="phone"   maxlength="70"  value="{{(Session::has('shipping_phone'))?session('shipping_phone'):''}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group" >
                                        <label for="">Country</label>
                                        <select name="country" id="shipping_country" class="form-control form_select required " >
                                            <option selected disabled value="">Select Country*</option>
                                            @foreach($scountries as $country)
                                            <option value="{{ $country->id }}"
                                                {{(session('shipping_country')==$country->id)?'selected':''}}
                                            >{{$country->title}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group" >
                                        <label for="">Emirate</label>
                                        <select class="form-control form_select required " name="state" id="shipping_state" >
                                            <option selected disabled value="">Select Emirate*</option>
                                            @if(!empty($shipping_states))
                                                @foreach($shipping_states as $shipping_state)
                                                    <option value="{{ $shipping_state->id }}"
                                                        {{(session('shipping_state')==$shipping_state->id)?'selected':''}}
                                                    >{{$shipping_state->title}}</option>
                                                @endforeach
                                             @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Zip Code</label>
                                        <input type="text" class="form-control  "   name="zipcode" id="zipcode" placeholder="Zip code"  value="{{(Session::has('shipping_zipcode'))?session('shipping_zipcode'):''}}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Address</label>
                                        <textarea class="form-control form-message  "  data-reload="true"   name="address" id="address" placeholder="Address*">{{(Session::has('shipping_address'))?session('shipping_address'):''}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="account_type" name="account_type" value="{{(Auth::guard('customer')->check())?1:0}}">
                            <input type="hidden" name="is_default" id="is_default" value="1">
                             <input type="hidden" id="id" name="id" value="0">
                             <input type="hidden" id="choose" name="choose" value="same" class="choose">
                            <input type="hidden" name="set_session" id="set_session"  value="1">
                            <div class="col-12 btnsBox align-items-end">
                                <button href="" class="submit-btn shipping-login-value-change">Submit</button>
                                
                            </div>
                        </form>
                    </div>
                   
                </div>

            </div>
        </div>
       
        <div class="row">
            <div class="col-12">
                <form action="" class="sameShipping">
                    <div class="form-check">
                        <input class="form-check-input different_shipping_address addressChoose" type="checkbox" value="same" name="address_choose"
                        id="different_shipping_address" data-customer="{{Auth::guard('customer')->check()?'true':'false'}}"  data-shipping-address="{{(session('selected_customer_address'))?'true':'false'}}"
                        {{ Session::get('different_shipping_address') ? 'checked':'' }}>
                        <br>
                        <label class="form-check-label" for="flexCheckDefault">
                            Bill to a different address?  <br>
                        </label>
                    </div>
                </form>
            </div>
        </div>
        <div class="select_address_area billiing_address_form  @if(!Helper::checkConfirmOrder())  @else d-none @endif d-none">
            <div class="headArea">
                <h4>
                    Add Billing Address
                </h4>
                <div class="right">
                    {{-- <button class="btn secondary_btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#billingAddress" aria-controls="billingAddress"><i class="fa-solid fa-plus"></i> Add Address</button> --}}
                    <div class="slick-address-nav2">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                 

                    <div class="billingAddressOffcanvas position-relative">
                        <div class="offcanvas offcanvas-top add_address_form show" data-bs-scroll="true" tabindex="-1" id="billingAddress" aria-labelledby="offcanvasTopLabel">
                         
                            <form action="" id="addBillingingLoginAddressForm">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="text" name="first_name" id="first_name" required class="form-control required billing-login-value-change" maxlength="60" required placeholder="First Name*"  value="{{(Session::has('billing_first_name'))?session('billing_first_name'):''}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="text" name="last_name" id="last_name" required class="form-control required billing-login-value-change" maxlength="60" required placeholder="Last Name*"  value="{{(Session::has('billing_last_name'))?session('billing_last_name'):''}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="email" name="email" id="email" class="form-control billing-required billing-login-value-change" placeholder="Email*" maxlength="70" required value="{{(Session::has('billing_email'))?session('billing_email'):''}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input  type="text" name="phone" id="phone" class="form-control billing-required billing-login-value-change login-billing-phone"  placeholder="Phone Number*" maxlength="70" required value="{{(Session::has('billing_phone'))?session('billing_phone'):''}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group" >
                                            <select  name="country" id="billing_country"   class="form-control form_select billing-required billing-login-value-change" required>
                                                <option selected disabled value="">Select Country*</option>
                                                @foreach($countries as $country)
                                                <option value="{{ $country->id }}" {{(session('billing_country')==$country->id)?'selected':''}} >{{$country->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group" >
                                            <select name="state" id="billing_state" class="form-control form_select  billing-login-value-change " >
                                                <option selected disabled value="">Select Emirate</option>
                                                @if(!empty($billing_states))
                                                @foreach($billing_states as $billing_state)
                                                    <option value="{{ $billing_state->id }}" {{(session('billing_state')==$billing_state->id)?'selected':''}} >{{$billing_state->title}}</option>
                                                @endforeach
                                            @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <input type="number" maxlength="15" name="zipcode" id="zipcode" class="form-control billing-login-value-change" placeholder="Zip Code " value="{{(Session::has('billing_zipcode'))?session('billing_zipcode'):''}}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <textarea class="form-control form-message billing-required  billing-login-value-change" required  name="address" id="address" placeholder="Address*">{{(Session::has('billing_address'))?session('billing_address'):''}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                        <input type="hidden" id="account_type" name="account_type"
                                        value="{{(Auth::guard('customer')->check())?1:0}}">
                                <input type="hidden" name="is_default" id="is_default"
                                        value="1">
                                <input type="hidden" id="id" name="id" value="0">
                                <input type="hidden" name="set_session" id="set_session"
                                        value="1">
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="customerNote">
      
                        <div class="form-group">
                            <label for="">Customer Note (Optional)</label>
                            <textarea class="form-control customerMessageField" id="remark" rows="4"
                        placeholder="Customer Message">{{(Session::has('order_remarks'))?session('order_remarks'):''}}</textarea>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<div id="guest_div"  class="@if(Auth::guard('customer')->check()) d-none @endif">
    <div class="checkoutDetailsLeft">

    <div class="row">
        <div class="col-12">
            <div class="billingAddressOffcanvas position-relative">
                <div class=" add_address_form" >
                    <div class="">
                        <h4>Add Shipping Address</h4>
                        <form action="#" id="addShippingAddressForm" class="addShippingAddressForm" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">First Name</label>
                                        <input type="text" name="shipping_first_name" id="first_name" required class="form-control required shipping-value-change" maxlength="60" required placeholder="First Name*"  value="{{(Session::has('shipping_first_name'))?session('shipping_first_name'):''}}">
                                        <span class="invalidMessage d-none">  </span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Last Name</label>
                                        <input type="text" name="shipping_last_name" id="last_name" required class="form-control required shipping-value-change" maxlength="60" required placeholder="Last Name*"  value="{{(Session::has('shipping_last_name'))?session('shipping_last_name'):''}}">
                                        <span class="invalidMessage d-none">  </span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="text" class="form-control required shipping-value-change"  required name="shipping_email" id="email"  maxlength="70" required placeholder="Email*"  value="{{(Session::has('shipping_email'))?session('shipping_email'):''}}">
                                        <span class="invalidMessage d-none">  </span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Phone Number</label>
                                        <input type="text" class="form-control required shipping-value-change guest-shipping-phone" required placeholder="Phone Number*"  name="shipping_phone" id="phone"   maxlength="70" required value="{{(Session::has('shipping_phone'))?session('shipping_phone'):''}}">
                                        <span class="invalidMessage d-none">  </span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group" >
                                        <label for="">Country</label>
                                        <select name="shipping_country" id="shipping_country" class="form-control form_select required shipping-value-change" required>
                                            <option selected disabled value="">Select Country*</option>
                                            @foreach($scountries as $country)
                                            <option value="{{ $country->id }}"
                                                {{(session('shipping_country')==$country->id)?'selected':''}}
                                            >{{$country->title}}</option>
                                        @endforeach
                                        </select>
                                        <span class="invalidMessage d-none">  </span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group" >
                                        <label for="">Emirate</label>
                                        <select class="form-control form_select required shipping-value-change" name="shipping_state" id="shipping_state" required>
                                            <option selected disabled value="">Select Emirate*</option>
                                            @if(!empty($shipping_states))
                                                @foreach($shipping_states as $shipping_state)
                                                    <option value="{{ $shipping_state->id }}"
                                                        {{(session('shipping_state')==$shipping_state->id)?'selected':''}}
                                                    >{{$shipping_state->title}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="invalidMessage d-none">  </span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Zipcode</label>
                                        <input type="text" class="form-control  shipping-value-change"   name="shipping_zipcode" id="zipcode" placeholder="Zip code"  value="{{(Session::has('shipping_zipcode'))?session('shipping_zipcode'):''}}">
                                        <span class="invalidMessage d-none">  </span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Address</label>
                                        <textarea class="form-control form-message shipping-value-change "  data-reload="true" required  name="shipping_address" id="address" placeholder="Address*">{{(Session::has('shipping_address'))?session('shipping_address'):''}}</textarea>
                                        <span class="invalidMessage d-none">  </span>
                                    </div>
                                </div>
                                <input type="hidden" id="account_type" name="account_type" value="{{(Auth::guard('customer')->check())?1:0}}">
                                <input type="hidden" name="is_default" id="is_default" value="1">
                                    <input type="hidden" id="id" name="id" value="0">
                                    <input type="hidden" id="choose" name="choose" value="same" class="choose">
                                    <input type="hidden" id="type" name="type" value="shipping" class="shipping">
                                <input type="hidden" name="set_session" id="set_session"  value="1">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="" class="sameShipping">
                <div class="form-check">
                    <input class="form-check-input different_shipping_address" type="checkbox" value="same" name="address_choose"
                    id="different_shipping_address"
                    {{ Session::get('different_shipping_address') ? 'checked':'' }}>
                    <br>
                    <label class="form-check-label" for="flexCheckDefault">
                        Bill to a different address?  <br>
                    </label>
                </div>
            </form>
        </div>
    </div>
    <div class="select_address_area billiing_address_form  @if(!Helper::checkConfirmOrder())  @else d-none @endif d-none">

        <div class="row">
            <div class="col-12">
                <div class="billingAddressOffcanvas position-relative">
                    <div class=" add_address_form" >
                        <div class="add_address_form">
                            <h4>Add Billing Address</h4>
                            <form action="" id="addBillingForm">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">First Name</label>
                                            <input type="text" name="first_name" id="first_name" required class="form-control required billing-value-change" maxlength="60" required placeholder="First Name*"  value="{{(Session::has('billing_first_name'))?session('billing_first_name'):''}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Last Name</label>
                                            <input type="text" name="last_name" id="last_name" required class="form-control required billing-value-change" maxlength="60" required placeholder="Last Name*"  value="{{(Session::has('billing_last_name'))?session('billing_last_name'):''}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="email" name="email" id="email" class="form-control billing-required billing-value-change" placeholder="Email*" maxlength="70" required value="{{(Session::has('billing_email'))?session('billing_email'):''}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Phone</label>
                                            <input  type="text" name="phone" id="phone" class="form-control guest-billing-phone billing-required billing-value-change"  placeholder="Phone Number*" maxlength="70" required value="{{(Session::has('billing_phone'))?session('billing_phone'):''}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group" >
                                            <label for="">Country</label>
                                            <select  name="country" id="billing_country"   class="form-control form_select billing-required billing-value-change" required>
                                                <option selected disabled value="">Select Country*</option>
                                                @foreach($countries as $country)
                                                <option value="{{ $country->id }}" {{(session('billing_country')==$country->id)?'selected':''}} >{{$country->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group" >
                                            <label for="">State</label>
                                            <select name="state" id="billing_state" class="form-control form_select  billing-value-change " >
                                                <option selected disabled value="">Select Emirate</option>
                                                @if(!empty($billing_states))
                                                @foreach($billing_states as $billing_state)
                                                    <option value="{{ $billing_state->id }}" {{(session('billing_state')==$billing_state->id)?'selected':''}} >{{$billing_state->title}}</option>
                                                @endforeach
                                            @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">Zip Code</label>
                                            <input type="number" maxlength="15" name="zipcode" id="zipcode" class="form-control billing-value-change" placeholder="Zip Code " value="{{(Session::has('billing_zipcode'))?session('billing_zipcode'):''}}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">Address</label>
                                            <textarea class="form-control form-message billing-required  billing-value-change" required  name="address" id="address" placeholder="Address*">{{(Session::has('billing_address'))?session('billing_address'):''}}</textarea>
                                        </div>
                                    </div>
                                    
                                    <!--added submit button start-->
                                   
                                   
                                    <!--added submit button end-->
                                    
                                    
                                </div>
                                <input type="hidden" id="account_type" name="account_type"
                                value="0">
                                <input type="hidden" name="is_default" id="is_default" value="1">

                                <input type="hidden" id="type" name="type" value="billing" class="choose">
                                <input type="hidden" id="id" name="id" value="0">
                        <input type="hidden" name="set_session" id="set_session" ovalue="1">
                       
                        </div>
                    </div>
                </div>
    
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="customerNote">
           
                    <div class="form-group">
                        <br>
                        <label for="">Customer Note (Optional)</label>
                        <textarea class="form-control customerMessageField" id="remark" rows="4"
                        placeholder="Customer Message">{{(Session::has('order_remarks'))?session('order_remarks'):''}}</textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

