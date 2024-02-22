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
            <div class="row">
                <div class="col-12">
                    <div class="card card-success card-outline">
                        <div class="card-body">
                            <div class="card-body">
                                <div class="row">
    
                                    <div class="col-sm-3">
                                        <input type="date" name="from_date" id="from_date" class="form-control">
                                    </div>
                                    <div class="col-sm-3">
        
                                        <input type="date" name="to_date" id="to_date" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" name="filter" id="filter" class="btn btn-primary" >Filter</button>
                                    </div>
                                </div>
                       
                               
                            </div>
                            <table id="contact-enquiry-table"  class="table table-bordered table-hover dataTable yajra-data-tables" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Phone Number</th>
                                        {{-- <th>Address</th> --}}
                                        <th>Email</th>
                                        <th>Username</th>
                                        <th>Status</th>
                                        <th>Signed Date</th> 
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
@endsection
@push('scripts')
    
<script type="text/javascript">
    $(function () {
        var table = $('#contact-enquiry-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            searchable: true,
            
            dom: 'Bfrtip',
         
            paging: true,
            bDestroy: true,
            buttons: [{
                extend:  'excel',
                title: 'My Data',
                exportOptions: {
                        columns: ':not(.action)',
                    },

            },
            ],
            ajax: "{{ url('admin/report/customer/basic') }}",
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                {data : 'customer_name', name : 'first_name',searchable: true},
                {data: 'phone_number', name: 'phone_number'},
                // {data: 'address', name: 'address'},
                {data: 'email', name: 'email'},
                {data: 'username', name: 'username'},
                {data: 'status', name: 'status'},
                {data : 'created_at', name : 'created_at'}
            ],
        }).page.len(25).draw();
    });
    $('#filter').click(function(){
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if(from_date != '' &&  to_date != '')
            {
              
                $('#contact-enquiry-table').DataTable().destroy();
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
           
            var table = $('#contact-enquiry-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            dom: 'Bfrtip',
         
            paging: true,
            bDestroy: true,
            buttons: [{
                extend:  'excel',
                title: 'My Data',
                exportOptions: {
                        columns: ':not(.action)',
                    },

            },
            ],
            ajax: {
                    
                    ajax: "{{ url('admin/report/customer/basic') }}",
                    data:{from_date:from_date, to_date:to_date}
                },
            //send data to server

            data:{from_date:from_date, to_date:to_date},
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                {data : 'customer_name', name : 'first_name',searchable: true},
                {data: 'phone_number', name: 'phone_number'},
                // {data: 'address', name: 'address'},
                {data: 'email', name: 'email'},
                {data: 'username', name: 'username'},
                {data: 'status', name: 'status'},
                {data : 'created_at', name : 'created_at'}
            ],
        }).page.len(25).draw();
        }
    
</script>
@endpush