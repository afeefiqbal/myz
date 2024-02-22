@extends('Admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-user-shield"></i> Manage Currency</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'/dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Currency List</li>
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
                                <a href="{{url(Helper::sitePrefix().'currency/create')}}"
                                   class="btn btn-success pull-right">Add
                                    Currency <i class="fa fa-plus-circle pull-right mt-1 ml-2"></i></a>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover dataTable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Currency</th>
                                        <th>Code</th>
                                        <th>Symbol</th>
                                        <th>Status</th>
                                        <!-- <th>Is Default</th> -->
                                        <th>Created Date</th>
                                        <th class="not-sortable">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($currencyList as $currency)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            @if($currency->code=="AED")
                                                <td>
                                                    <a href="{{ url(Helper::sitePrefix().'currency/rate/create/'.$currency->id)}}">
                                                        {{ $currency->title }}
                                                        <i class="fa fa-link"></i></a></td>
                                            @else
                                                <td>{{ $currency->title }}</td>
                                            @endif
                                            <td>{{ $currency->code }}</td>
                                            <td>{{ $currency->symbol }}</td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" class="status_check"
                                                           data-url="/status-change" data-table="Currency"
                                                           data-field="status" data-pk="{{ $currency->id}}"
                                                        {{($currency->status=="Active")?'checked':''}}>
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <!--
                                            <td><input id="switch-default-{{$loop->iteration}}" type="checkbox" class="is_default"
                                                       data-size="mini" data-id="{{ $currency->id}}"
                                                       @if($currency->is_default == 1)
                                                checked="checked"







                                            @endif>
                                            </td>
                                            -->
                                            <td>{{ date("d-M-Y", strtotime($currency->created_at))  }}</td>
                                            <td class="text-right py-0 align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{url(Helper::sitePrefix().'currency/edit/'.$currency->id)}}"
                                                       class="btn btn-success mr-2 tooltips" title="Edit Currency"><i
                                                            class="fas fa-edit"></i></a>
                                                            @if($currency->code !=="AED")
                                                    <a href="#" class="btn btn-danger mr-2 delete_entry tooltips"
                                                       title="Delete Currency" data-url="currency/delete"
                                                       data-id="{{$currency->id}}"><i class="fas fa-trash"></i></a>

                                                       @endif
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
