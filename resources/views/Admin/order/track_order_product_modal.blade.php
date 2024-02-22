<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Order ARTMYST#{{$order->order_code}}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="timeline">
                    @foreach($orderproducts as $product)
                        @php
                            $orderStatus = App\Models\OrderLog::where('order_product_id',$product->id)->get();
                        @endphp
                        <div class="time-label">
                <span class="bg-red">
                  {{$product->productData->title ?? ''}}
                </span>
                        </div>
                        @foreach($orderStatus as $status)
                            <div>
                                <i class="fa fa-comment bg-blue"></i>

                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> {{ date("F d Y - h:i A", strtotime($status->created_at))  }}</span>

                                    <h3 class="timeline-header no-border"><b>{{$status->status}}</b></h3>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
    </div>
</div>
