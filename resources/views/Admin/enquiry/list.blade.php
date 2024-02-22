@extends('Admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-user-shield"></i> Manage Enquiry</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{url(Helper::sitePrefix().'dashboard')}}">
                                    Home
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Enquiry List</li>
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
                            <div class="box-header" style="height:50px;">
                                <div class="box-tools" style="margin-top: 8px;">
                                    <div class="col-sm-12">
                                        <div class="actions delete_btn" style="display: none;">
                                            <input type="hidden" name="ids" id="ids">
                                            <a href="javascript:void(0);" id="delete_multiple_item_btn"
                                               class="btn btn-danger"
                                               data-url="/enquiry/{{ $type == "bulk"?'bulk/':'' }}delete-multiple">
                                                <i class="fa fa-trash"></i> Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                        <a class="export_excel_enquiry">
                                            <button type="button" class="btn btn-primary " >Export</button>
                                        </a>
                                    </div>
                             <input type="hidden" name="type" id="type" value="{{@$type}}">
                                </div>
                                <table id="product-enquiry-table" class="table table-bordered table-hover dataTable yajra-data-tables" width="100%">
                                    <thead>
                                    <tr>
                                        <th># <input type="checkbox" class="mt-2 ml-3" name="check_all" id="check_all">
                                        </th>
                                        <th>Name</th>
                                        @if($type == "bulk")
                                            <th>Product</th>
                                            <th>Type</th>
                                            <th>Frame</th>
                                            <th>Mount</th>
                                            <th>Size</th>
                                        @endif
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                 
                                        <th>Message</th>
                                        {{-- <th>Reply</th> --}}
                                        <th>Request URL</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $type = @$type;
                                            if($type == "bulk"){
                                                $type = 'bulk';
                                            }
                                                else{
                                                    $type = '';
                                                }
                                           
                                        @endphp
                                    {{-- @foreach($enquiryList as $enquiry)
                                        <tr>
                                            <td>{{ $loop->iteration }}
                                                <input type="checkbox" class="single_box mt-2 ml-3" name="single_box"
                                                       id="{{ $enquiry->id }}" value="{{ $enquiry->id }}"></td>
                                            <td>{{ $enquiry->name}}</td>
                                            @if($type == "bulk")
                                                <td>{{ $enquiry->product->title ?? ''}}</td>
                                                <td>{{ $enquiry->productType->title ?? ''}}</td>
                                                <td>{{ $enquiry->Frame->title ?? ''}}</td>
                                           
                                                <td>
                                                    @if (@$enquiry->productType->id == 4)
                                                       {{ $enquiry->mount}}
                                                    @else
                                                        
                                                    @endif
                                            </td>
                                                <td>{{ $enquiry->Size->title  ?? ''}}</td>
                                            @endif
                                            <td>{{ $enquiry->email}}</td>
                                            <td>{{ $enquiry->phone }}</td>
                                        
                                            <td>{{ $enquiry->message }}</td>
                                            <td>{{ $enquiry->reply }}</td>
                                            <td>{{ $enquiry->request_url }}</td>
                                            <td>{{ date("d-M-Y", strtotime($enquiry->created_at))  }}</td>
                                            <td class="text-right py-0 align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="#" class="btn btn-danger mr-2 delete_entry tooltips"
                                                       title="Delete Enquiry" data-url="enquiry/delete"
                                                       data-id="{{$enquiry->id}}"><i class="fas fa-trash"></i></a>
                                                    <a class="mr-2 btn btn-primary"
                                                       href="{{ url(Helper::sitePrefix().'enquiry/'.($type == "bulk"?'bulk/':'').'view/'.$enquiry->id) }}"><i
                                                            class="fa fa-eye fa-lg"></i></a>
                                                    <a class="btn btn-success mr-2 reply_modal"
                                                       href="javascript:void(0)"
                                                       data-url="enquiry/{{ $type == "bulk"?'bulk/':'' }}reply"
                                                       data-toggle="modal" data-reply="{!! $enquiry->reply !!}"
                                                       data-id="{{ $enquiry->id }}"
                                                       data-enquiry="{!! $enquiry->message !!}">
                                                        <i class="fa fa-reply fa-lg"
                                                           style="color:{{ ($enquiry->reply==NULL)?'red':'white' }}"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade" id="reply-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" method="post" id="formWizard" class="reply_form">
                        <div class="modal-body">
                            {{csrf_field()}}
                            <div class="box-body">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label> Enquiry*</label>
                                            <textarea disabled id="request_details" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label> Reply*</label>
                                            <textarea class="form-control" required id="reply" name="reply"
                                                      placeholder="Reply to request"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="form-group">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close
                                </button>
                                <input type="submit" class="btn btn-primary" id="reply_to_enquiry"
                                       value="Update Reply">
                                <input type="hidden" id="enquiry_url" name="enquiry_url"
                                       value="{{ $type == "bulk"?'bulk/':'' }}reply">
                                <input type="hidden" id="id" name="id">
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    @push('scripts')
    <script type="text/javascript">

        $(function () {
            var table = $('#product-enquiry-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                // stateSave: true,
                paging: true,
                bDestroy: true,
             
                // dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 '
                //     + 'col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i>' +
                //     '<"col-sm-12 col-md-6"p>>',
                @php
                   $url = url('admin/enquiry/'.$type);
                @endphp
                ajax: "{{$url }}",
                columns: [
                    {data: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'name', name: 'name', orderable: false, searchable: false},
                    @if($type == "bulk")
                    {data: 'product', name: 'product', orderable: false, searchable: false},
                    {data: 'type', name: 'type', orderable: false, searchable: false},
                    {data: 'frame', name: 'frame', orderable: false, searchable: false},
                    {data: 'mount', name: 'mount', orderable: false, searchable: false},
                    {data: 'size', name: 'size', orderable: false, searchable: false},
                    @endif
                    {data: 'email', name: 'email', orderable: false, searchable: false},
                    {data: 'phone', name: 'phone', orderable: false, searchable: false},
                    {data: 'message', name: 'message', orderable: false, searchable: false},
                    // {data: 'reply', name: 'reply', orderable: false, searchable: false},
                    {data: 'request_url', name: 'request_url', orderable: false, searchable: false},
                    {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });
            $('#filter').click(function(){
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                if(from_date != '' &&  to_date != '')
                {
                    $('#product-enquiry-table').DataTable().destroy();
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
                $('#product-enquiry-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    // stateSave: true,
                    paging: true,
                    
               bDestroy: true,
                    // dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 '
                    //     + 'col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i>' +
                    //     '<"col-sm-12 col-md-6"p>>',
                    ajax: {
                        @php
                        $url = url('admin/enquiry/'.$type);
                        @endphp
                        ajax: "{{$url }}",
                    
                        data:{from_date:from_date, to_date:to_date}
                    },
                    columns: [
                    {data: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'name', name: 'name', orderable: false, searchable: false},
                    @if($type == "bulk")
                    {data: 'product', name: 'product', orderable: false, searchable: false},
                    {data: 'type', name: 'type', orderable: false, searchable: false},
                    {data: 'frame', name: 'frame', orderable: false, searchable: false},
                    {data: 'mount', name: 'mount', orderable: false, searchable: false},
                    {data: 'size', name: 'size', orderable: false, searchable: false},
                    @endif
                    {data: 'email', name: 'email', orderable: false, searchable: false},
                    {data: 'phone', name: 'phone', orderable: false, searchable: false},
                    {data: 'message', name: 'message', orderable: false, searchable: false},
                    // {data: 'reply', name: 'reply', orderable: false, searchable: false},
                    {data: 'request_url', name: 'request_url', orderable: false, searchable: false},
                    {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                });
            }
        });
        $('.refresh').click(function(){
        location.reload();
    });     
    </script>
    @endpush
@endsection
