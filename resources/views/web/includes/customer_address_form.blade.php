
                                            <form action="" id="my_address_add_form_">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="">First Name</label>
                                                            <input type="text" class="form-control required" name="first_name" id="first_name" value="{{ @$customerAddress->first_name }}" placeholder="First Name*">
                                                          
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="">Last Name</label>
                                                            <input type="text" class="form-control required" placeholder="Last Name*" value="{{ @$customerAddress->last_name }}" name="last_name" id="last_name">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="">Email</label>
                                                            <input type="text" class="form-control required" value="{{ @$customerAddress->email }}" name="email" id="email" placeholder="Email*" >
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="">Phone Number</label>
                                                            <input type="text" class="form-control required cust-phone" placeholder="Phone Number*" value="{{ @$customerAddress->phone }}" name="phone" id="phone">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group" >
                                                            <select name="country" id="shipping_country" class="form-control form_select" name="country">
                                                                <option selected disabled value="">Select Emirate*</option>
                                                            @foreach($countries as $country)
                                                                        <option value="{{ $country->id }}"
                                                                            {{(@$customerAddress->state->country_id==$country->id)?'selected':''}}>
                                                                            {{$country->title}}</option>
                                                                    @endforeach
</select>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-6">
                                                        <div class="form-group" >
                                                            <select name="state" id="shipping_state" class="form-control form_select">
                                                                <option selected disabled value="">Select Emirate*</option>
                                                                @if(!empty($states))
                                                                        @foreach($states as $state)
                                                                            <option value="{{ $state->id }}"
                                                                                {{(@$customerAddress->state_id==$state->id)?'selected':''}}
                                                                            >{{$state->title}}</option>
                                                                        @endforeach
                                                                    @endif
                                                               
                                                            </select>
                                                        </div>
                                                    </div>


                                                    
                                                       
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="zipcode" placeholder="Zip Code" value="{{ @$customerAddress->zipcode }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <textarea class="form-control form-message" name="address" placeholder="Address*">{{ @$customerAddress->address }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                                                <label class="form-check-label" for="flexSwitchCheckDefault">Set as default address</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group address_label">
                                                            <lable class="label_cnt">
                                                                <span>Address Label</span>
                                                                (optional)
                                                            </lable>
                                                            <div class="d-flex">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" {{ !isset($customerAddress) ? 'checked' : '' }} {{ @$customerAddress->address_type == 'Home' ? 'checked' : '' }} type="radio"
                                                                               name="address_type" id="address_label_type" value="Home">
                                                                    <label class="form-check-label" for="home">
                                                                        Home
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" {{ @$customerAddress->address_type == 'Work' ? 'checked' : '' }} type="radio"
                                                                               name="address_type" id="address_label_type" value="Work">
                                                                    <label class="form-check-label" for="work">
                                                                        Work
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="id" name="id" value="{{@$customerAddress->id??0}}">
                                                        <input type="hidden" name="set_session" id="set_session" value="0">
                                                        <input type="hidden" name="show_page" id="show_page" value="1">
                                                        <input type="hidden" id="account_type" name="account_type"  value="{{(Auth::guard('customer')->check())?1:0}}">
                                                        <input type="hidden" name="is_default" id="is_default" value="0">
                                                    <div class="col-12 d-flex flex-column flex-sm-row mt-3">
                                                        <a href="javascript:void(0)" class="secondary_btn" id="add_address_go">Cancel</a>
                                                        <div class="form-group mb-0">
                                                            <button class="btn primary_btn form_submit_btn" data-url="/customer/update-customer-address">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                     
                                        
                                  