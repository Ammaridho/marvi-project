@extends('arvi.frontend.oobe-indonesia.layouts.main')

@section('content')

    <section class="section-first">
        <div class="container-fluid container-xs mt-2">

            <div class="mt-3">
                <div class="d-flex">
                    <div>
                        <a href="{{route('my-order-index')}}">
                            <span class="material-icons me-2">arrow_back</span>
                        </a>
                    </div>
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
                                        <span class="badge bg-label-danger text-dark">
                                            Canceled
                                        </span>
                                    @elseif($order->order_status == 1)
                                        @if ($order->payment_status == 0) 
                                            <span class="badge bg-label-info text-dark">
                                                Payment Pending
                                            </span>
                                        @else
                                            <span class="badge bg-label-warning text-dark">
                                                Waiting Confirmation
                                            </span>
                                        @endif
                                    @elseif($order->order_status == 2)
                                        <span class="badge bg-label-success text-dark">
                                            Meal Preparation
                                        </span>
                                    @elseif($order->order_status == 3)
                                        <span class="badge bg-label-success text-dark">
                                            Waiting for pick up
                                        </span>
                                    @elseif($order->order_status == 4)
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
                            <div class="d-flex align-items-center 
                            justify-content-between mt-2">
                                <div class="">Order Date </div>
                                <div class="text-muted">
                                    {{Carbon\Carbon::parse($order->create_time)
                                    ->setTimezone($order->loc_tz)->format('d M Y H:i:s')}}
                                </div>
                            </div>
                            <div class="d-flex align-items-center 
                            justify-content-between mt-2">
                                <div class="">Transaction ID</div>
                                <div class="text-muted">#OOBE-{{$order->id}}</div>
                            </div>
                            <div class="d-flex align-items-center 
                            justify-content-between mt-2">
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
                                    <div>{{$item->currency}} 
                                        {{$item->selling_price/$item->qty}}
                                         x {{$item->qty}} 
                                        <span class="float-end">{{$item->currency}} 
                                            <span class="selling_price" data-price="{{$item->selling_price}}">
                                                {{number_format($item->selling_price)}}
                                            </span>
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
                                <div class="text-theme-primary">
                                    Delivery Method {{$order->deliveryName}} 
                                </div>
                                @if ($order->deliveryName)
                                    <div>{{$order->deliveryName}} - {{$order->subDeliveryName}}
                                        <span class="float-end">{{$order->currency}} 
                                            {{number_format($order->cost_delivery)}}
                                        </span>
                                    </div>
                                @else
                                    <div>Pick Up
                                        <span class="float-end">FREE</span>
                                    </div>
                                @endif
                            </div>
                            <hr>
                            <div class="my-2">
                                <div class="fw-bold">
                                    Total <span class="float-end">{{$order->currency}} 
                                        {{number_format($order->total_gross_price)}}</span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="devider"></section>

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
            total_price += parseFloat($(this).data('price'));
        });

        // fees
        let fees = <?php echo json_encode(json_decode($fees)); ?>;
        let valueFees = 0;
        
        fees.forEach(function (data) {
            if (data['type_value'] == 'percentage') {
                if (data['currency'] == 'IDR') {
                    valueFees = Math.ceil(total_price * data['value_fee'] / 100);
                }else{
                    valueFees = total_price * data['value_fee'] / 100;
                }
                $(`<div>${data['name']} 
                    <span class="float-end">
                        ${data['currency']} 
                        ${thousands_separators(parseFloat(valueFees))}</span>
                </div>`).appendTo('#fees');
            } else {
                valueFees = data['value_fee'];
                $(`<div>${data['name']} 
                    <span class="float-end">
                        ${data['currency']} 
                        ${thousands_separators(parseFloat(valueFees))}</span>
                </div>`).appendTo('#fees');
            }
        });

        function thousands_separators(num)
        {
        var num_parts = num.toString().split(".");
        num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return num_parts.join(".");
        }

    </script>
@endsection