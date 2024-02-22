@extends('Admin.layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="nav-icon fas fa-user-shield"></i> Manage {{$title}}</h1>
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
          			<div class="card card-success card-outline">
              			<div class="card-body">
                            <div class="row">

                               
                            </div>
                            <table id="recordsReport"  class="table table-bordered table-hover dataTable yajra-data-tables">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product</th>
                                        <th>Status</th>
                                        <th>Type</th>
                                        <th>SKU</th>
                                      	<th class="action">Action</th>
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
        var table = $('#recordsReport').DataTable({
            processing: true,
            // serverSide: true,
            responsive: true,
            dom: 'Bfrtip',
         
            paging: true,
            bDestroy: true,
            buttons: [{
                extend:  'excel',
                title: 'Featured Products Report',
                exportOptions: {
                        columns: ':not(.action)',
                    },

            },
            ],
            ajax: "{{ url('admin/report/product/featured') }}",
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                {data : 'title', name : 'title'},
                {data: 'status', name: 'status'},
                {data: 'productType', name: 'productType'},
                {data: 'sku', name: 'sku'},
                {data: 'action', name: 'action', orderable: false, searchable: false},

            ],
        }).page.len(10).draw();
    });
   
</script>
@endpush