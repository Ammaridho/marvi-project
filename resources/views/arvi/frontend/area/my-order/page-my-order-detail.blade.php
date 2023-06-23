@extends('arvi.frontend.area.layouts.main')

@section('content')

    <section class="section-first">
        <div class="container-fluid container-xs mt-2">

            <div class="mt-3">
                <div class="d-flex">
                    <div>
                        <h5>Detail my orders</h5>
                    </div>
                </div>
                <div class="mt-2">
                    
                    <div class="d-flex align-items-start justify-content-start">
                        <div class="w-100">
                            
                            <div class="mt-2 fw-bold">{{$order->merchantName}}</div>
                            <!-- 
                                <span class="bg-light text-dark">Order Placed</span>
                                <span class="bg-warning text-dark">Order Processed</span>
                                <span class="bg-success">Order Completed</span>
                            -->
                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <div class="">Order Status</div>
                                <div class="">
                                    @if ($order->order_status == 0)
                                        <span class="badge bg-label-danger text-dark">Canceled</span>
                                    @elseif($order->order_status == 1)
                                        <span class="badge bg-label-warning text-dark">On proccess</span>
                                    @elseif($order->order_status == 2)
                                        <span class="badge bg-label-success text-dark">Already pickup</span>
                                    @elseif($order->order_status == 3)
                                        <span class="badge bg-label-success text-dark">Proccess delivery</span>
                                    @elseif($order->order_status == 4)
                                        <span class="badge bg-info text-dark">Meal preparation</span>
                                    @elseif($order->order_status == 5)
                                        <span class="badge bg-warning text-dark">Confirm by oobe squad</span>
                                    @elseif($order->order_status == 6)
                                        <span class="badge bg-secondary text-dark">order created</span>
                                    @else
                                        <span class="badge bg-success text-dark">Completed</span>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <div class="">Order Date </div>
                                <div class="text-muted">{{date("M d, Y h:m", strtotime($order->create_time))}}</div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <div class="">Transaction ID</div>
                                <div class="text-muted">#{{$order->id}}</div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <div class="">Payment Method</div>
                                <div class="text-muted">{{$order->paymentName}}</div>
                            </div>
                            <hr />

                            @foreach ($order->merchantOrderDetail as $item)
                                <div class="my-2">
                                    <div class=" text-theme-primary">
                                        {{
                                            DB::table('merchant_products')
                                            ->find($item->product_id)
                                            ->name
                                        }}
                                    </div>
                                    <div>{{$item->currency}} {{$item->selling_price/$item->qty}}
                                         x {{$item->qty}} 
                                        <span class="float-end">{{$item->currency}} 
                                            <span class="selling_price">{{$item->selling_price}}</span>
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                            

                            @if (count($fees) > 0)
                                <hr>
                                <div class="my-2">
                                    <div class="text-theme-primary">Fees </div>
                                    <div id="fees"></div>
                                </div>
                            @endif

                            <hr>
                            
                            <div class="my-2">
                                <div class="text-theme-primary">Delivery Method </div>
                                <div>{{$order->deliveryName}} 
                                    <span class="float-end">{{$order->currency}} 
                                        {{$order->cost_delivery}}</span>
                                </div>
                            </div>
                            <hr>
                            <div class="my-2">
                                <div class="fw-bold">
                                    Total <span class="float-end">Rp 
                                        {{$order->total_gross_price}}</span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="devider"></section>

    {{-- next to squad settlements --}}

    {{-- <section>
        <div class="container-fluid container-xs my-3">
            <div><h6>Shipping Info</h6></div>
            <div class="d-flex align-items-center justify-content-between mt-2">
                <div class="">Obee Squad Name</div>
                <div class="">Sigit Van Houten</div>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-2">
                <div class="">Mobile Number</div>
                <div class="">+62 8121 765 345</div>
            </div>
        </div>
    </section>

    <section class="devider"></section>

    <section class="section-last">
        <div class="container-fluid container-xs my-3">
            <div><h6>Order Status</h6></div>
            <div>
                <div class="vtl">
                    <div class="event">
                        <div class="dates small">15 Mar 2237 12:34</div>
                        <div class="txt">Obee Squad goes to customer to deliver package</div>
                    </div>
                    <div class="event">
                        <div class="dates small">13 Mar 2237 14:25</div>
                        <div class="txt">Restaurant prepared the meal</div>
                    </div>
                    <div class="event">
                        <div class="dates small">13 Mar 2237 20:15</div>
                        <div class="txt">Obee Squad accepted order</div>
                    </div>
                    <div class="event">
                        <div class="dates small">13 Mar 2237 20:12</div>
                        <div class="txt">Order placed</div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- =================================================================
    MODAL
    ================================================================== -->

    <!-- core -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script>

        // sum all selling_price
        let total_price = 0;
        $('.selling_price').each(function (data) {
            total_price += parseFloat($(this).text());
        });

        // fees
        let fees = <?php echo json_encode(json_decode($fees)); ?>;
        let valueFees = [];
        let htmlFees = [];
        let totalFees = 0;
        
        fees.forEach(function (data) {
            if (data['type_value'] == 'percentage') {
                valueFees[data['name']] = total_price * data['value_fee'] / 100;
                $(`<div>${data['name']} 
                    <span class="float-end">${data['currency']} 
                        ${valueFees[data['name']]}</span>
                </div>`).appendTo('#fees');
            } else {
                valueFees[data['name']] = data['value_fee'];
                $(`<div>${data['name']} 
                    <span class="float-end">${data['currency']} 
                        ${valueFees[data['name']]}</span>
                </div>`).appendTo('#fees');
            }
        });

    </script>
@endsection