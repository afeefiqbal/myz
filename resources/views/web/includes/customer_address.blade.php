
   <a class="btn secondary_btnAdd primary_btn" id="add_address_gos">Add Address <i class="fa-solid fa-plus"></i></a>
<div class="address_wrapper">


@if($customerAddresses->isNotEmpty())
@foreach($customerAddresses as $address)
@if(isset($address->state))
    @php $shipping = App\Models\ShippingCharge::active()->where('state_id' ,$address->state->id)->first();
    @endphp
    @else
    @php $shipping = ''; @endphp
@endif
                                                <div class="address_box  {{ $address->is_default == 'Yes' ? 'set_default' : '' }}">
                                                @if($address->is_default == 'Yes')
                                                    <div class="default_icon">
                                                        <img class="img-fluid" src=" {{asset('frontend/images/defaultActive.png')}}" alt="">
                                                    </div>
                                                   
        @endif
                                                    <h6 class="ads_name">
                                                    {{ $address->first_name .' '.$address->last_name }}
                                                    </h6>
                                                    <ul>
                                                        <li>
                                                            <p>
                                                            {{ $address->address_type }}
                                                            </p>
                                                        </li>
                                                        <li class="add_line">
                                                            <p>
                                                            {!! $address->address !!}
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p class="add_line">
                                                                {{ $address->state->title }},
                                                            {{ $address->country->title }}
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p>
                                                            Email : {{ $address->email }}
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p class="add_line">
                                                            Phone Number : {{ $address->phone }}
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p class="add_line">
                                                            Zip Code : {{ $address->zipcode }}
                                                            </p>
                                                        </li>
                                                    </ul>
                                                    
                                             
                                                    <div class="buttons_area ">
                                                        <a class="edit_add address-form" id="add_address_go" data-id="{{ $address->id }}"
                                              href="javascript:void(0)"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                                        <a class="remove_add remove-address"  data-id="{{ $address->id }}" href="javascript:void(0)"><i class="fa-solid fa-trash-can"></i> Remove</a>

                                                        @if( $address->is_default == 'No')
                                                        <a class="set_d_add default_address" data-id="{{$address->id}}" href=""> <img class="img-fluid"  href="javascript:void(0)" data-id="{{$address->id}}" src="{{asset('frontend/images/defaultActive.png')}}" alt=""> Set as Default
                                                    
                                                    </a>
                                                    @endif
                                                    </div>
                                                </div>

                                                @endforeach
                                          @endif
                                            </div> 