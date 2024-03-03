@extends('Admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-user-shield"></i> Manage Products</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Product List</li>
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
                            <div class="card-header">
                                <a href="{{url(Helper::sitePrefix().'product/create')}}"
                                   class="btn btn-success pull-right">Add Product <i
                                        class="fa fa-plus-circle pull-right mt-1 ml-2"></i></a>
                                        <!--  modal button ------------------ -->
                                        
                                <a href="{{url(Helper::sitePrefix().'product/   ')}}"
                                   class="btn btn-primary pull-right mr-3">Export <i
                                        class="fa fa-download pull-right mt-1 ml-2"></i></a>

                               
                            </div>
                            <div class="card-body">
                                <table id="product-list-data-table" class="table table-bordered table-hover dataTable yajra-data-tables">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Category</th>
                                        <th>Gallery</th>
                                        <th>Offer</th>
                                        <th>Status</th>
                                        <th>Most Relevent</th>
                                    {{-- <th>Latest</t[h> --}}
                                        <th>Popular</th>
                                        <th >Display to Home</th>
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

        <div class="modal fade" id="importModal">
            <div class="modal-dialog" id="modalContent">
                <div class="modal-content">
                    <form role="form" id="importForm" class="" enctype="multipart/form-data" action="{{url('admin/product/import')}}"
                          method="post">
                          @csrf
                        <div class="modal-header">
                           
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="status">Import a File*</label>
                                    <input type="file" name="import_file" id="import_file" class="form-control required"accept=".xls,.xlsx"> 
                                    <br>
                                    Sample File : <a href="{{asset('backend/dist/products.xlsx')}}">Download</a>
                                    </div>
                                    <div class="help-block with-errors" id="import_file_error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary pull-left importSubmitButton" name="submit" >Upload</button>
                        <img class="animation__shake loadingImg" src="{{url('backend/dist/img/loading.gif')}}" style="display:none;">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(function () {
        var table = $('#product-list-data-table').DataTable({
            processing: true,
                serverSide: true,
                responsive: true,
                paging: true,
                bDestroy: true,
            ajax: "{{ url('admin/product') }}",
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'product_title', name: 'title', searchable: true},
                {data: 'product_type', name: 'product_type', searchable: true},
                {data: 'category', name: 'category', searchable: true},
                {data: 'gallery', name: 'gallery', orderable: false, searchable: false},
                {data: 'status', name: 'status', orderable: false, searchable: false},
                {data: 'is_featured', name: 'is_featured', orderable: false, searchable: false},
                {data: 'new_arrival', name: 'new_arrival', orderable: false, searchable: false},
                {data: 'offer', name: 'offer', orderable: false, searchable: false},
                // {data: 'best_seller', name: 'best_seller', orderable: false, searchable: false},
                {data: 'display_to_home', name: 'display_to_home', orderable: false, searchable: false},
                {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        }).page.len(25).draw();;
    });
        </script>
@endpush