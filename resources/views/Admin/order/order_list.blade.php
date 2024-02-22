@extends('Admin.layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="nav-icon fas fa-user-shield"></i> Manage Orders</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">{{$title}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
      	<div class="container-fluid">
        	<div class="row">
          		<div class="col-12">
          			@if (session('success'))
		                <div class="alert alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert">×</button>
		                    {{ session('success') }}
		                </div>
		            @elseif(session('error'))
		                <div class="alert alert-danger" role="alert">
		                    <button type="button" class="close" data-dismiss="alert">×</button>
		                    {{ session('error') }}
		                </div>
		            @endif
          			<div class="card card-success card-outline">
		              	
              			<div class="card-body">
                            <div class="row">
                                
                                <div class="col-sm-3">
                                    <input type="date" name="from_date" id="from_date" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <input type="date" name="to_date" id="to_date" class="form-control">
                                    <br>
                                    <input type="hidden" name="status" id="status" value="{{@$status}}">
                                </div>
                                <div class="col-sm-3">
                                    <button type="button" class="btn btn-primary filter" id="filter">Filter</button>
                                    <button type="button" class="btn btn-default refresh" id="refresh">Refresh</button>
                                    <br>

                                </div>
                                <div class="col-sm-3">
                                    <a class="export_excel">
                                        <button type="button" class="btn btn-primary " >Export</button>
                                    </a>
                                </div>
                         
                            </div>
                            <div class="row">

                            </div>
                			 <table  id="order-list-data-table" class="table table-bordered table-hover dataTable yajra-data-tables"  width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Code</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                  
                                        <th>User Choosed Currency</th>
                                        <th>Order Total</th>
                                        <th>Payment Method</th>
                                        <th width="150px">Order Status</th>
                                        <th>Created Date</th>
                                        <th class="not-sortable">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                     
                            </table>
              	        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="orderStatusModal">
    <div class="modal-dialog" id="modalContent">
        <div class="modal-content">
            <form role="form" id="formWizard" class="" enctype="multipart/form-data"
                  method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Status Change Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="status">Status*</label>
                                <input type="hidden" name="page" value="{{ @$title }}">
                                <select class="form-control select2 required" name="order_status" id="order_status">
                                    <option value="">Select Status</option>
                                    <option value="Processing">Processing</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Failed">Failed</option>
                                    <option value="Cancelled">Cancelled</option>
                                    <option value="Returned">Returned</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="order_id" id="order_id" class="required" value="">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary pull-left orderStatusChangeBtn" name="submit"
                    data-table="Order"
                            data-url="/admin/order/change-order-status">Change Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="order-product-modal">
    <div class="modal-dialog modal-lg" id="order-product-modal-content">

    </div>
</div>
<div class="modal fade" id="refund-splitup-modal">
    <div class="modal-dialog" id="refund-splitup-modal-content">

    </div>
</div>
@endsection
@push('scripts')
    
<script type="text/javascript">
 $(function () {
    var table = $('#order-list-data-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        // stateSave: true,
        paging: true,
        bDestroy: true,
       
        // dom: 'Bfrtip',
        // buttons: [{
        //         extend:  'excel',
        //         text: 'Export to Excel',
        //         //style the button
        //         className: 'btn btn-success',    
        //         exportOptions: {
        //                 columns: ':not(.action)',
        //             },
        //         },
        //     ],
            
            columnDefs: [
                { targets: 'action', visible: false },
            ],  
        ajax: "{{ url('admin/order') }}",
        columns: [
            {data: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'order_code', name: 'order_code'},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'product_total', name: 'product_total'},
            {data: 'currency', name: 'currency'},
            // {data: 'coupon_value', name: 'coupon_value'},
            {data: 'order_total', name: 'order_total'},
            {data: 'payment_method', name: 'payment_method'},
            {data: 'order_status', name: 'order_status'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
    }).page.len(50).draw();
    $('#filter').click(function(){
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        if(from_date != '' &&  to_date != '')
        {
            $('#order-list-data-table').DataTable().destroy();
            load_data(from_date, to_date);
        }
        else
        {
            swal({
                title: "Please select date range",
                type: "warning",
                timer: 1400,
            });
        }
    });
    function load_data(from_date, to_date){
        $('#order-list-data-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        // stateSave: true,
        paging: true,
        bDestroy: true,
        // dom: 'Bfrtip',
        //     buttons: [{
        //         extend:  'excel',
        //         text: 'Export to Excel',
        //         //style the button
        //         className: 'btn btn-success',    
        //         exportOptions: {
        //                 columns: ':not(.action)',
        //             },

        //     },
        //     ],
        //     columnDefs: [
        //         { targets: 'action', visible: true },
        //     ],
            ajax: {
                url: "{{ url('admin/order') }}",
                data:{from_date:from_date, to_date:to_date}
            },
      
        columns: [
            {data: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'order_code', name: 'order_code'},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'product_total', name: 'product_total'},
       
            // {data: 'coupon_value', name: 'coupon_value'},
            {data: 'order_total', name: 'order_total'},
            {data: 'payment_method', name: 'payment_method'},
            {data: 'order_status', name: 'order_status'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
    }).page.len(100).draw();;
    }

})

</script>
@endpush
