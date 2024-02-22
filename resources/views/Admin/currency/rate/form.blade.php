@extends('Admin.layouts.main')
@section('content')
    @php
        use App\Models\CurrencyRate;
    @endphp
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-user-shield"></i> {{$title}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'currency')}}">Currency</a>
                            </li>
                            <li class="breadcrumb-item active">{{$title}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
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
                <form role="form" id="formWizard" class="form--wizard" enctype="multipart/form-data" method="post">
                    {{csrf_field()}}
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Currency Rate Form</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach($otherCurrencyList as $otherCurrency)
                                {{-- {{ $otherCurrency->otherCurrencyRate->where('currency_id','=',$currency->id) }}--}}
                                @php
                                    $currencyRate = CurrencyRate::where([['other_currency_id','=',$otherCurrency->id],['currency_id','=',$currency->id]])->first();
                                @endphp
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="other_currency_title"> Currency*</label>
                                        <input type="text" name="other_currency_title[]" id="other_currency_title"
                                               placeholder="Currency" class="form-control required" autocomplete="off"
                                               value="{{$otherCurrency->code}}" readonly>
                                        <input type="hidden" name="other_currency_id[]" id="other_currency_id"
                                               value="{{$otherCurrency->id}}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="conversion_rate"> Rate*</label>
                                        <input type="text" name="conversion_rate[]" id="conversion_rate"
                                               placeholder="Rate" class="form-control required" autocomplete="off"
                                               value="{{ isset($currencyRate)?$currencyRate->conversion_rate:'' }}">
                                        <input type="hidden" name="rate_id[]" id="rate_id"
                                               value="{{ isset($currencyRate)?$currencyRate->id:'0' }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="card-footer">
                            <input type="submit" name="btn_save" value="Submit"
                                   class="btn btn-primary pull-left submitBtn">
                            <button type="reset" class="btn btn-default">Cancel</button>
                            <input type="hidden" name="currency_id" id="currency_id"
                                   value="{{ isset($currency)?$currency->id:'0' }}">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
