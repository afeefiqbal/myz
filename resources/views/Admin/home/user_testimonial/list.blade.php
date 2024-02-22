@extends('Admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-user-shield"></i> Manage User Testimonial</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{url(Helper::sitePrefix().'dashboard')}}">
                                    Home
                                </a>
                            </li>
                            <li class="breadcrumb-item active">User Tesimonial List</li>
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
                                            {{-- <a href="javascript:void(0);" id="delete_multiple_item_btn"
                                               class="btn btn-danger"
                                               data-url="/enquiry/{{ $type == "bulk"?'bulk/':'' }}delete-multiple">
                                                <i class="fa fa-trash"></i> Delete</a> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="recordsListView" class="table table-bordered table-hover dataTable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Email</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        {{-- <th>Request URL</th>
                                        <th>Created Date</th> --}}
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($testimonialList as $testimonial)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                                {{-- <input type="checkbox" class="single_box mt-2 ml-3" name="single_box"
                                                       id="{{ $testimonial->id }}" value="{{ $testimonial->id }}"> --}}
                                            <td>{{ $testimonial->name}}</td>
                                            <td>{{ $testimonial->designation }}</td>
                                            <td>{{ $testimonial->email}}</td>
                                            <td>{!! $testimonial->message !!}</td>
                                            {{-- <td>{{ $testimonial->message }}</td> --}}
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" class="status_check"
                                                           data-url="/status-change" data-table="Testimonial"
                                                           data-field="status" data-pk="{{ $testimonial->id}}"
                                                        {{($testimonial->status=="Active")?'checked':''}}>
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            {{-- <td>{{ $enquiry->request_url }}</td> --}}
                                            {{-- <td>{{ date("d-M-Y", strtotime($enquiry->created_at))  }}</td> --}}
                                            <td class="text-right py-0 align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    {{-- <a href="{{url(Helper::sitePrefix().'home/testimonial/edit/'.$testimonial->id)}}"
                                                       class="btn btn-success mr-2 tooltips" title="Edit Testimonial"><i
                                                            class="fas fa-edit"></i></a> --}}
                                                    <a href="#" class="btn btn-danger mr-2 delete_entry tooltips"
                                                       title="Delete User Testimonial" data-url="home/testimonial/delete"
                                                       data-id="{{$testimonial->id}}"><i class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
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
                                {{-- <input type="hidden" id="enquiry_url" name="enquiry_url"
                                       value="{{ $type == "bulk"?'bulk/':'' }}reply"> --}}
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
@endsection
