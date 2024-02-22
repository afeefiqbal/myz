<table id="recordsListView" class="table table-bordered table-hover">
    <thead>
    <tr>
        <th># <input type="checkbox" class="mt-2 ml-3" name="check_all" id="check_all"></th>
        <th>Customer</th>
        <th>Products</th>
        <th>Created Date</th>
        <th class="not-sortable">Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($cartItem as $item)
        @php
            $customerData = App\Models\Customer::find($item->id);
        @endphp
        @if($customerData!=NULL)
            <tr>
                <td>{{ $loop->iteration }}
                    <input type="checkbox" class="single_box mt-2 ml-3" name="single_box" id="{{ $item->id }}"
                           value="{{ $item->id }}"></td>
                <td>
                    {{ $customerData->first_name." ".$customerData->last_name }}
                </td>
                <td>
                    <table id="childTable" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Size</th>
                            <th>Size Cost</th>
                            <th>Qty</th>
                            <th>Offer</th>
                            <th>Offer Amount</th>
                            <th>Cost</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($item->cart_data)>0)
                            @foreach($item->cart_data as $key=>$cart)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$cart->name}}</td>
                                    <td>{{$cart->attributes->size_id}}</td>
                                    <td>{{$cart->attributes->size_amount}}</td>
                                    <td>{{$cart->quantity}}</td>
                                    <td>{{ ($cart->attributes->offer!=0)?'Yes':'No'}}</td>
                                    <td>{{$cart->attributes->currency}} {{$cart->attributes->offer_amount}}</td>
                                    <td>{{$cart->attributes->currency}} {{$cart->price}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </td>
                <td>{{ date("d-M-Y", strtotime($item->created_at))  }}</td>
                <td>
                    <a class="ml-2 common-cart-class cart_notify_modal" href="javascript:void(0)" data-toggle="modal"
                       data-id="{{ $item->id }}"><i class="fa fa-send fa-lg"></i></a>
                </td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
