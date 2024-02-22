@extends('Admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-user-shield"></i> Manage Customer</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Customer List</li>
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
                                {{-- <a href="{{url(Helper::sitePrefix().'customer/create')}}"
                                   class="btn btn-success pull-right">Add
                                    Customer <i class="fa fa-plus-circle pull-right mt-1 ml-2"></i></a> --}}
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover dataTable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        {{--<th>Username</th>--}}
                                        <th>Phone Number</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th class="not-sortable">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($customerList as $customer)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{ $customer->first_name.' '.$customer->last_name}}</td>
                                            <td>{{ ($customer->user != null) ? $customer->user->email : ''}}</td>
                                            {{--<td>{{ $customer->user->username}}</td>--}}
                                            <td>{{ ($customer->user != null)  ? $customer->user->phone : ''}}</td>
                                            <td>
                                                @if ($customer->user != null)
                                                    
                                                <label class="switch">
                                                    <input type="checkbox" class="status_check"
                                                           data-url="/status-change" data-table="User"
                                                           data-field="status" data-pk="{{ $customer->user->id }}"
                                                        {{($customer->user->status=="Active")?'checked':''}}>
                                                    <span class="slider"></span>
                                                </label>
                                                @else
                                                    
                                                @endif
                                            </td>
                                            <td>{{ date("d-M-Y", strtotime($customer->created_at))  }}</td>
                                            <td class="text-right py-0 align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    {{-- <a href="{{url(Helper::sitePrefix().'customer/edit/'.$customer->id)}}"
                                                       class="btn btn-success mr-2 tooltips" title="Edit Customer"><i
                                                            class="fas fa-edit"></i></a> --}}
                                                    <a href="{{url(Helper::sitePrefix().'customer/address/'.$customer->id)}}"
                                                       class="btn btn-primary mr-2 tooltips" title="Address"><i
                                                            class="fas fa-address-card fa-lg"></i></a>
                                                    <a href="#" class="btn btn-danger mr-2 delete_entry tooltips"
                                                       title="Delete Customer" data-url="customer/delete"
                                                       data-id="{{$customer->id}}"><i class="fas fa-trash"></i></a>
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
