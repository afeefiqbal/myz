<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{'ARTMYST#'.$order->order_code}} - Cancelled details</h4>
    </div>
    <div class="modal-body">
        <div class="box-body">
            <div class="form-group">
                <div class="col-md-12">
                    <div class="form-group">
                        <label> Sub Total</label>
                        <input type="text" id="title" placeholder="Sub Total" class="form-control" autocomplete="off"
                               disabled value="{{ $cancelledTotal['total'] }}">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Amount after coupon applied</label>
                        <input type="text" id="code" placeholder="Shipping Charge" class="form-control"
                               autocomplete="off" disabled
                               value="{{ $cancelledTotal['total']-$cancelledTotal['couponCharge'] }}">
                    </div>
                </div>
                @if($cancelledTotal['taxAmount']!=0)
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Tax Amount </label>
                            <input type="text" id="code" placeholder="Tax Amount" class="form-control"
                                   autocomplete="off" disabled value="{{ $cancelledTotal['taxAmount'] }}">
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Tax Amount </label>
                        <input type="text" id="code" placeholder="Tax Amount" class="form-control" autocomplete="off"
                               disabled value="{{ $cancelledTotal['taxAmount'] }}">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Shipping Charge </label>
                        <input type="text" id="code" placeholder="Shipping Charge" class="form-control"
                               autocomplete="off" disabled value="{{ $cancelledTotal['shippingCharge'] }}">
                    </div>
                </div>
                @php
                    $total = $cancelledTotal['total']-$cancelledTotal['couponCharge'];
                    $returnAmount = $total+$cancelledTotal['taxAmount']+$cancelledTotal['shippingCharge']+$cancelledTotal['codCharge'];
                @endphp
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Return Amount </label>
                        <input type="text" id="code" placeholder="Return Amount" class="form-control" autocomplete="off"
                               disabled value="{{ ($returnAmount>0)?number_format($returnAmount,2):'0.00' }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
    </div>
</div>
