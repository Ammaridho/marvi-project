@extends('arvi.frontend.area.layouts.main')
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

            @foreach ($payments as $item)
                
            <div class="mt-3">
                <div class="form-group mb-3">
                    <label class="radio-selection">
                        <input type="radio" class="payment-methods"
                        name="paymp" value="{{$item->id}}" />
                        <div class="small">
                            {{$item->method}}
                        </div>
                    </label>
                </div>
            </div>

            @endforeach

            <input type="hidden" name="merchantId" value="{{$merchant->id}}">
            <input type="hidden" name="deliveryId" value="{{$delivery->id}}">
            <input type="hidden" name="bioCust" value="{{json_encode($bioCust)}}">
                
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
                        <div>Total shopping (<span id="total-items"></span> items)</div>
                        <div>{{$merchant->currency}} <span id="total-price"></span></div>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <div>Delivery cost</div>
                        <div>{{$merchant->currency}} {{$delivery->cost_delivery}}</div>
                    </div>

                    <div id="fees"></div>

                    <div class="d-flex justify-content-between mb-2">
                        <div>Payment fee</div>
                        <div>{{$merchant->currency}} <span id="payment-cost">0</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid container-xs my-3 small">
          By pressing Proccess Payment, i agree to the 
          <a href="#" data-bs-toggle="modal" data-bs-target="#modalTNC">
               <u>terms and conditions</u>
          </a> that apply.
        </div>
    </section>

    <section class="section-last">
        <div class="fixed-bottom bg-white border-top">
            <div class="container-fluid container-xs">
                <div class="d-grid my-2">
                    <button class="btn btn-theme-secondary py-2 text-theme-primary-dark text-white" 
                    type="submit">
                        <div class="d-flex justify-content-between">
                            <div>Proccess payment</div>
                            <div class="fw-bold">
                                {{$merchant->currency}} <span id="countQtys">0</span>
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

    <div class="modal fade" id="modalTNC" tabindex="-1" aria-labelledby="modalTNC" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Term & Condition</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

    <script>
        $(document).ready(function(){
            $('.shopping-cart').hide();

            // total shopping items and price
            let cart = JSON.parse(sessionStorage.getItem('cart-oobe-indonesia-area'));
            let totalItems = 0;
            let totalPrice = 0;
            cart.forEach(function (data) {
                totalItems += data['qty'];
                totalPrice += data['totalPriceAll'];
            })
            $('#total-items').text(totalItems);
            $('#total-price').text(Math.round(totalPrice * 100) / 100);
            let total_price   = Math.round(totalPrice * 100) / 100;
            let cost_delivery = parseFloat('{{$delivery->cost_delivery}}');
            

            // fees
            let fees = <?php echo json_encode(json_decode($fees)); ?>;
            let valueFees = [];
            let htmlFees = [];
            let totalFees = 0;
            fees.forEach(function (data) {
                if (data['type_value'] == 'percentage') {
                    valueFees[data['name']] = total_price * data['value_fee'] / 100;
                    $(`<div class="d-flex justify-content-between mb-2">
                            <div>${data['name']}</div>
                            <div>
                                ${data['currency']} ${valueFees[data['name']]}
                            </div>
                        </div>`).appendTo('#fees');
                } else {
                    valueFees[data['name']] = data['value_fee'];
                    $(`<div class="d-flex justify-content-between mb-2">
                            <div>${data['name']}</div>
                            <div>
                                ${data['currency']} ${valueFees[data['name']]}
                            </div>
                        </div>`).appendTo('#fees');
                }
                totalFees += parseFloat(valueFees[data['name']]);
            })

            $('#countQtys').text(total_price+cost_delivery+totalFees);

        });

        // submit process payment
        $('#form-process-payment').on('submit',function () {
            event.preventDefault();
            $('.error-message').addClass('d-none');
            if ($("input[type='radio']:checked.payment-methods").val()) {
                // payment
                let paymp = $("input[name='paymp']").val();
                let cart = sessionStorage.getItem('cart-oobe-indonesia-area');
                let totalPrice = $('#countQtys').text();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('payment-store') }}",
                    data: $(this).serialize() + `&cart=${cart}&totalPrice=${totalPrice}`,
                    success: function (data) {
                        // delete all data shopping cart after store data
                        sessionStorage.removeItem("cart");
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