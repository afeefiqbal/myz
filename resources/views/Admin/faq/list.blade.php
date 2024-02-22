@extends('Admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-user-shield"></i> Manage FAQ</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{url(Helper::sitePrefix().'dashboard')}}">
                                    Home
                                </a>
                            </li>
                            <li class="breadcrumb-item active">FAQ List</li>
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
                                <div class="actions delete_btn" style="display: none;">
                                    <input type="hidden" name="ids" id="ids">
                                    <a href="javascript:void(0);" id="delete_multiple_item_btn"
                                       class="btn btn-danger"
                                       data-url="/faq/delete_multiple">
                                        <i class="fa fa-trash"></i> Delete</a>
                                </div>
                                <a href="{{url(Helper::sitePrefix().'faq/create')}}" class="btn btn-success pull-right">Add
                                    FAQ <i class="fa fa-plus-circle pull-right mt-1 ml-2"></i></a>
                            </div>
                            <div class="card-body">
                                <table id="recordsListView" class="table table-bordered table-hover dataTable">
                                    <thead>
                                    <tr>
                                        <th># <input type="checkbox" class="mt-2 ml-3" name="check_all" id="check_all">
                                        </th>
                                        <th>Question</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th class="not-sortable">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($faqList as $faq)
                                        <tr>
                                            <td>{{ $loop->iteration }}
                                                <input type="checkbox" class="single_box mt-2 ml-3" name="single_box"
                                                       id="{{ $faq->id }}" value="{{ $faq->id }}">
                                            </td>
                                            <td>{{ $faq->question }}</td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" class="status_check"
                                                           data-url="/status-change" data-table="FAQ"
                                                           data-field="status" data-pk="{{ $faq->id}}"
                                                        {{($faq->status=="Active")?'checked':''}}>
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td>{{ date("d-M-Y", strtotime($faq->created_at))  }}</td>
                                            <td class="text-right py-0 align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{url(Helper::sitePrefix().'faq/edit/'.$faq->id)}}"
                                                       class="btn btn-success mr-2 tooltips" title="Edit FAQ"><i
                                                            class="fas fa-edit"></i></a>
                                                    <a href="#" class="btn btn-danger mr-2 delete_entry tooltips"
                                                       title="Delete FAQ" data-url="faq/delete"
                                                       data-id="{{$faq->id}}"><i class="fas fa-trash"></i></a>
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
    </div>
@endsection
