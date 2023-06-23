@extends('arvi.frontend.oobe-indonesia.layouts.main')
@section('content')

<form id="form-process-payment" method="post">
    @csrf
    <section class="section-first">
        <div class="container-fluid container-xs mt-2">
            <div class="mt-3">
            <div class="d-flex">
            <div><h5>Payment method</h5></div>
            </div>
            <div id="paymentError" role="alert" 
            class="form-text error-message alert alert-danger p-2 d-none">
                Please choose payment method.
            </div>
            @foreach ($bundlePayments as $key => $category)

                @if (!in_array($key,['CREDIT_CARD']) )
                    
                    <div class="mt-3">
                        <div class="d-flex mb-2">
                            <div class="fw-bold small">
                                @if ($key == 'VIRTUAL_ACCOUNT')
                                Virtual Account
                                @elseif($key == 'EWALLET')
                                E-Wallet
                                @elseif($key == 'QR_CODE')
                                QR
                                @elseif($key == 'CREDIT_CARD')
                                Credit Card
                                @elseif($key == 'RETAIL_OUTLET')
                                Retail Outlet
                                @elseif($key == 'CASH')
                                Cashier
                                @endif
                            </div>
                        </div>
                        @if ($key == 'EWALLET' && $totalShoppingPrice<100)
                            <div class="d-flex mb-2">
                                <small class="text-danger">min trx IDR 100</small>
                            </div>
                        @endif
                    </div>
                    
                    @foreach ($category as $item)
                    <div class="mt-3">
                        <div class="form-group mb-3">
                            <label class="radio-selection">
                                <input type="radio" class="payment-methods"
                                name="paymp" value="{{$item['id']}}" 
                                @if ($key == 'EWALLET' && $totalShoppingPrice<100)
                                    disabled>
                                    <div class="small bg-light">
                                @else
                                    >
                                    <div class="small">
                                @endif
                                    {{$item['method']}}
                                </div>
                            </label>
                        </div>
                    </div>
                    @endforeach
                    
                @endif

            @endforeach
            
            <input type="hidden" name="merchantId" value="{{$merchant->id}}">
            <input type="hidden" name="deliveryId" value="{{$deliveryId}}">
            <input type="hidden" name="courier" value="{{$courier}}">
            <input type="hidden" name="totalShoppingPrice" value="{{$totalShoppingPrice}}">
            <input type="hidden" name="bioCust" value="{{$bioCust}}">
                
            </div>
        </div>
        
    </section>

    <section class="devider"></section>

    <section>
        <div class="container-fluid container-xs mt-2">
            <div class="mt-3">
                <div class="d-flex">
                    <div><h6>Order summary</h6></div>
                </div>
                <div class="mt-2">
                    <div class="d-flex justify-content-between mb-2">
                        <div>Total shopping </div>
                        <div>
                            {{$merchant->currency}} 
                            {{number_format($totalShoppingPrice)}}
                        </div>
                    </div>
                    @if ($cost_delivery > 0)
                        <div class="d-flex justify-content-between mb-2">
                            <div>Delivery cost</div>
                            <div>
                                {{$merchant->currency}} 
                                {{number_format($cost_delivery)}}
                            </div>
                        </div>
                    @endif

                    <div id="fees"></div>

                    <div class="d-flex justify-content-between mb-2 d-none">
                        <div>Payment fee</div>
                        <div>
                            {{$merchant->currency}} 
                            <span id="payment-cost">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid container-xs my-3 small">
          By pressing Process Payment, i agree to the 
          <a href="{{route('tnc')}}" data-bs-toggle="modal" data-bs-target="#modalTNC">
               <u>terms and conditions</u>
          </a> that apply.
        </div>
    </section>

    <section class="section-last">
        <div class="fixed-bottom bg-white border-top">
            <div class="container-fluid container-xs">
                <div class="d-grid my-2">
                    <button class="btn btn-theme-secondary py-2 
                    text-theme-primary-dark text-white" 
                    type="submit" id="confirm-method" disabled>
                        <div class="d-flex justify-content-between">
                            <div>Process payment</div>
                            <div class="fw-bold">
                                {{$merchant->currency}} <span id="countQtys" 
                                data-price="{{$totalPrice}}">
                                    {{number_format($totalPrice)}}
                                </span>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </section>

</form>

    <!-- =================================================================
    MODAL
    ================================================================== -->

    <div class="modal fade" id="modalTNC" tabindex="-1" 
    aria-labelledby="modalTNC" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Term & Condition
                    </h5>
                    <button type="button" class="btn-close" 
                    data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('arvi.frontend.oobe-indonesia.check-out.termEndCondition')
                </div>
            </div>
        </div>
    </div>

    <!-- core -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="/frontend-oobe-indonesia/assets/js/cart.js"></script>
    <script type="text/javascript" src="/frontend-oobe-indonesia/assets/js/demo.js"></script>

    <script>
        $(document).ready(function(){
            $(".shopping-cart").addClass('d-none');
            $(".modalLoading").modal('hide');
            // cek cart exist
            if (sessionStorage.getItem('cart-oobe-indonesia') == null) {
                window.location.href = "{{route('index-oobe')}}";
            }
        });

        // check payment choosed
        $('.payment-methods').on('click',function () {
            $('#confirm-method').prop("disabled",false);
        })

        // submit process payment
        $('#form-process-payment').on('submit',function () {
            event.preventDefault();
            $('.error-message').addClass('d-none');
            if ($("input[type='radio']:checked.payment-methods").val()) {
                // payment
                let paymp              = $("input[name='paymp']:checked").val();
                let cart               = sessionStorage.getItem('cart-oobe-indonesia');
                let totalShoppingPrice = '{{$totalShoppingPrice}}';
                let totalPrice         = '{{$totalPrice}}';
                let costDelivery       = parseFloat('{{$cost_delivery}}');

                var formData = new FormData(this);
                formData.append("paymp", JSON.stringify(paymp));
                formData.append("cart", JSON.stringify(cart));
                formData.append("totalShoppingPrice", JSON.stringify(totalShoppingPrice));
                formData.append("totalPrice", JSON.stringify(totalPrice));
                formData.append("costDelivery", JSON.stringify(costDelivery));
                $.ajax({
                    type: 'POST',
                    url: "{{ route('payment-process') }}",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        $('#main-content').html(data);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                })
            } else {
                $('#paymentError').removeClass('d-none'); 
            }
        })
    </script>
    </body>
</html>  

@endsection