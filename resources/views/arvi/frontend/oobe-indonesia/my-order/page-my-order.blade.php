@extends('arvi.frontend.oobe-indonesia.layouts.main')

@section('content')
    <section class="section-first">
        <div class="container-fluid container-xs mt-2">

            <div class="mt-3">
                <div class="d-flex">
                    <div>
                        <h5>My orders</h5>
                    </div>
                </div>
                <div class="mt-2">
                    
                    <!-- 
                        <span class="badge bg-success text-dark">Order Created</span>
                        <span class="badge bg-success text-dark">Confirmed by Oobe Squad</span>
                        <span class="badge bg-success text-dark">Meal Preparation</span>
                        <span class="badge bg-success">Completed</span>
                    -->
                    
                    <ul class="list-unstyled m-0 p-0 list-item">
                        <!-- 
                            SKLETEON LOADER FOR LIST ITEM
                            USED THIS to load each loading items
                        -->
                        {{-- <li id="loader">
                            <div class="d-flex ol-loader-sm">
                                <div class="ol-img loading"></div>
                                <div class="ol-more">
                                    <div class="ol-title loading"></div>
                                    <div class="ol-desc loading"></div>
                                    <div class="ol-price loading"></div>
                                </div>
                            </div>
                        </li> --}}
                        <!-- //SKLETEON LOADER FOR LIST ITEM-->

                        @foreach ($orders as $item)
                        <li>
                            <a href="{{route('my-order-index-detail',['id' => $item->id ])}}">
                                <div class="d-flex align-items-start justify-content-start">
                                    <div class="me-3">
                                        @if ($item->image_url)
                                            <div class="img-wrapper-cart" 
                                            style="background-image: 
                                            url('/storage/arvi/backend-assets/img/logo/merchants/{{$item->image_url}}');">
                                            </div>
                                        @else
                                            <div class="img-wrapper-cart" 
                                            style="background-image: 
                                            url('/frontend-oobe-indonesia/assets/img/menus/Oishimoo_thumb.jpg');">
                                            </div>                         
                                        @endif
                                    </div>
                                    <div class="w-100">
                                        <div class="d-flex align-items-start justify-content-between">
                                            <div class="small">
                                                {{Carbon\Carbon::parse($item->create_time)
                                                ->setTimezone($item->loc_tz)->format('d M Y H:i:s')}}
                                            </div>
                                            <div class="small">#OOBE-{{$item->id}}</div>
                                        </div>
                                        <div class="d-flex align-items-start justify-content-between">
                                            <div class="fw-bold">{{$item->merchantName}}</div>
                                            <div>
                                                @if ($item->order_status == 0)
                                                    <span class="badge bg-label-danger text-dark">
                                                        Canceled
                                                    </span>
                                                @elseif($item->order_status == 1)
                                                    @if ($item->payment_status == 0) 
                                                        <span class="badge bg-label-info text-dark">
                                                            Payment Pending
                                                        </span>
                                                    @else
                                                        <span class="badge bg-label-warning text-dark">
                                                            Waiting Confirmation
                                                        </span>
                                                    @endif
                                                @elseif($item->order_status == 2)
                                                    <span class="badge bg-label-success text-dark">
                                                        Meal Preparation
                                                    </span>
                                                @elseif($item->order_status == 3)
                                                    <span class="badge bg-label-success text-dark">
                                                        Waiting for pick up
                                                    </span>
                                                @elseif($item->order_status == 4)
                                                    <span class="badge bg-info text-dark">
                                                        Process Delivery
                                                    </span>
                                                @else
                                                    <span class="badge bg-success text-dark">
                                                        Completed
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <div class="small">Total</div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="fw-bold">{{$item->currency}} 
                                                    {{number_format($item->total_gross_price)}}</div>
                                                <div>{{$item->items}} items</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @endforeach
                       
                    </uL>

                </div>
            </div>
        </div>
    </section>

    <!-- =================================================================
    MODAL
    ================================================================== -->

    <!-- core -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    
@endsection