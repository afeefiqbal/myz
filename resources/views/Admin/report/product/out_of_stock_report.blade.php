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
                            
                            <table id="recordsReport"  class="table table-bordered table-hover dataTable yajra-data-tables">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product</th>
                                        <th>Type</th>
                                        <th>Size</th>
                                        <th>Status</th>
                                        <th>SKU</th>
                                      	<th class="action">Action</th>
                                    </tr>
                                </thead>
                               
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
                title: 'Out of Stock Product Report',
                exportOptions: {
                        columns: ':not(.action)',
                    },

            },
            ],
            ajax: "{{ url('admin/report/product/out-of-stock') }}",
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                {data : 'title', name : 'title'},
                {data: 'productType', name: 'productType'},
                {data: 'size', name: 'size'},
                {data: 'status', name: 'status'},
                {data: 'sku', name: 'sku'},
                {data: 'action', name: 'action', orderable: false, searchable: false},

            ],
        }).page.len(10).draw();
    });
     
</script>
    
@endpush
