@extends('Admin.layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="nav-icon fas fa-user-shield"></i> {{$title}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">{{$title}} </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @include('Admin.report.order.box_values')
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
                                    @php
                                    if(@$method){
                                        $status = $method;

                                    }
                                    else{
                                        $status = $status;
                                    }
                                    if(@$status){
                                        $status = $status;
                                    }
                                @endphp
                                    <input type="hidden" name="status" id="status" value="{{@$status}}">
                                </div>
                                <div class="col-sm-3">
                                    <button type="button" class="btn btn-primary filter" id="filter">Filter</button>
                                    <button type="button" class="btn btn-default refresh" id="refresh">Refresh</button>
                                    <br>
                                </div>
                                <div class="col-sm-3">
                                    <a class="report_export_excel">
                                        <button type="button" class="btn btn-primary " >Export</button>
                                    </a>
                                </div>
                            </div>
                            <div >
                                <table class="table table-bordered table-hover dataTable yajra-data-tables" id="order-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Order Code</th>
                                            <th>Customer</th>
                                            <th>No of Items</th>
                                            <th>Payment Method</th>
                                            <th>Price</th>
                                            <th>Date</th>
                                         
                                        </tr>
                                    </thead>
                                    @php
                                        if(@$method){
                                            $status = $method;

                                        }
                                        else{
                                            $status = $status;
                                        }
                                        if(@$status){
                                            $status = $status;
                                        }
                                    @endphp
                                                           <input type="hidden" name="status" id="status" value="{{@$status}}">
                                    {{-- <tbody>
                                       @php 
                                            $i=1 
                                        @endphp 
                                            @foreach($orderList as $order)
                                                @if($status == 'refunded' || $status == 'failed' || $status == 'cancelled')
                                                    @php $order['total_price'] = $order['orderTotalAmount']; @endphp
                                                @endif
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td><a href="{{url(Helper::sitePrefix().'order/view/'.$order['order']->id)}}">{{ 'CFF'.$order['order']->order_code}}</a></td>
       
                                                        <td>{{ @$order['order']->orderCustomer->shippingAddress->first_name.' '.@$order['order']->orderCustomer->shippingAddress->last_name }}</td>
                                                    <td>{{ $order['OrderProducts'] }}</td>
                                                    <td>{{ $order['order']->payment_method }}</td>
                                                    <td>{{ $order['order']->currency.' '.$order['total_price'] }}</td>
                                                    @if($status == 'refunded' || $status == 'failed' || $status == 'cancelled')
                                                        <td>{{ $order['order']->currency.' '.$order['return_amount'] }}</td>
                                                    @endif
                                                    <td>{{ date("d-M-Y", strtotime($order['order']->created_at))  }}</td>
                                                </tr>
                                            @php 
                                                $i++;
                                            @endphp 
                                        @endforeach
                                    </tbody> --}}
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
    
<script type="text/javascript">
    $(function () {
        var table = $('#order-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            // stateSave: true,
            paging: true,
            paginate: true,
            bDestroy: true,
            // dom: 'Bfrtip',
            responsive: true,
            // buttons: [{
            //     extend:  'excel',
            //     title: 'My Data',
            //     exportOptions: {
            //             columns: ':not(.action)',
            //         },

            // },
            // ],
            // columnDefs: [
            //     { targets: 'action', visible: true },
            // ],
            @php
                $url = 'report/order/'.$status;
            @endphp
            ajax: {
                url: "{{ url(Helper::sitePrefix().''.$url) }}",
            },
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'order_code', name: 'order_code'},
                {data: 'customer', name: 'customer'},
                {data: 'no_of_items', name: 'no_of_items'},
                {data: 'payment_method', name: 'payment_method'},
                {data: 'price', name: 'price'},
          
                {data: 'date', name: 'date'},               
            ],
        });
        $('#filter').click(function(){
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if(from_date != '' &&  to_date != '')
            {
                $('#order-table').DataTable().destroy();
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
            $('#order-table').DataTable({
                processing: true,
            serverSide: true,
            responsive: true,
            // stateSave: true,
            paging: true,
            paginate: true,
            bDestroy: true,
    
            responsive: true,
        
            @php
            $url = 'report/order/'.$status;
            @endphp
            ajax: {
                url: "{{ url(Helper::sitePrefix().''.$url) }}",
                data:{from_date:from_date, to_date:to_date}
            },
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'order_code', name: 'order_code'},
                {data: 'customer', name: 'customer'},
                {data: 'no_of_items', name: 'no_of_items'},
                {data: 'payment_method', name: 'payment_method'},
                {data: 'price', name: 'price'},
           
                {data: 'date', name: 'date'},               
            ],
            });
        }
    });
    $('.refresh').click(function(){
        location.reload();
    });
</script>
@endpush