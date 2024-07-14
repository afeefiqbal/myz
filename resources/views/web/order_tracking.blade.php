
@extends('web.layouts.main')
@section('content')


    <!-- Breadcrumb Section Start -->
     <!-- Breadcrumb Section Start -->
     <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>Order Tracking</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="index.html">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Order Tracking</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
    @if($order)
    <section class="order-detail">
        <div class="container-fluid-lg">
            <div class="row g-sm-4 g-3">
      

                <div class="col-xxl-12 col-xl-8 col-lg-6">
                    <div class="row g-sm-4 g-3">
                        <div class="col-xl-4 col-sm-6">
                            <div class="order-details-contain">
                                <div class="order-tracking-icon">
                                    <i data-feather="package" class="text-content"></i>
                                </div>

                                <div class="order-details-name">
                                    <h5 class="text-content">Order ID</h5>
                                    <h2 class="theme-color">MYZ#{{$order->orderData->order_code}}</h2>
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-xl-4 col-sm-6">
                            <div class="order-details-contain">
                                <div class="order-tracking-icon">
                                    <i class="text-content" data-feather="map-pin"></i>
                                </div>

                                <div class="order-details-name">
                                    <h5 class="text-content">Destination</h5>
                                    <h4>{{$order->shippingAddress->address}}, {{$order->shippingAddress->state->title}}, {{$order->shippingAddress->state->country->title}}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 overflow-hidden">
                            @php
                                $statuses = [ 'pending','processing' ,'packed', 'shipped', 'Out for Delivery','Delivered'];
                                 $currentStatus=  $order->orderData->status; // Replace this with your dynamic status
                            @endphp

                            <ol class="progtrckr">
                                @foreach ($statuses as $status)
                              
                                <li class="progtrckr-{{ $currentStatus == $status || $loop->index < array_search($currentStatus, $statuses) ? 'done' : 'todo' }}">
                                    <h5>{{ $status }}</h5>
                                    @if ($currentStatus == $status)
                                        <h6>Processing</h6>
                                    @elseif ($loop->index < array_search($currentStatus, $statuses))
                                        <h6>Done</h6>
                                    @else
                                        <h6>Pending</h6>
                                    @endif
                                </li>
                            @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Order Detail Section End -->

    <!-- Order Table Section Start -->
    {{-- <section class="order-table-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table order-tab-table">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Location</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Order Placed</td>
                                    <td>26 Sep 2021</td>
                                    <td>12:00 AM</td>
                                    <td>California</td>
                                </tr>

                                <tr>
                                    <td>Preparing to Ship</td>
                                    <td>03 Oct 2021</td>
                                    <td>12:00 AM</td>
                                    <td>Canada</td>
                                </tr>

                                <tr>
                                    <td>Shipped</td>
                                    <td>04 Oct 2021</td>
                                    <td>12:00 AM</td>
                                    <td>America</td>
                                </tr>

                                <tr>
                                    <td>Delivered</td>
                                    <td>10 Nav 2021</td>
                                    <td>12:00 AM</td>
                                    <td>Germany</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    @endif
    <!-- Order Detail Section Start -->
    @endsection
@push('scripts')

<script>
   $(document).ready(function() {
        $('#generate-link-btn').on('click', function() {
            $.ajax({
                url: '{{ route('affiliate.generateLink') }}',
                method: 'GET',
                success: function(data) {
                    if (data.link) {
                        $('#link-container').html(`
                            <p>Your affiliate link: <a href="${data.link}" target="_blank">${data.link}</a></p>
                            <button id="copy-link-btn" class="btn btn-secondary">Copy to Clipboard</button>
                        `);
                        $('#copy-link-btn').on('click', function() {
                            navigator.clipboard.writeText(data.link).then(function() {
                                alert('Affiliate link copied to clipboard!');
                            }, function(err) {
                                alert('Failed to copy text: ', err);
                            });
                        });
                    } else {
                        console.log(data)
                        $('#link-container').html(`<p>${data.error}</p>`);
                    }
                },
                error: function(xhr, status, error) {
                    $('#link-container').html(`<p>An error occurred: ${xhr.responseText}</p>`);
                }
            });
        });
    });
    </script>
@endpush