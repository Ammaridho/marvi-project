@extends('arvi.frontend.oobe-indonesia.layouts.main')

@section('content')

    <body class="mobile theme-default">

    <section>
        <div class="container-fluid container-xs">
            
            <!-- payment succsess -->
            <div class="d-flex align-items-center 
            justify-content-center vh-100">
                <div class="text-center">
                    <div class="mb-3 text-warning">
                        <span class="material-icons md-48">
                            hourglass_top
                        </span>
                    </div>
                    <h2 class="text-theme-primary">Waiting for Payment</h2>
                    <div>Pleased proceed to pay the transaction.</div>
                    <hr>
                    <div class="small">AMOUNT PAID</div>
                    <div class="fw-bold fs-5">
                        {{$data->payment->currency}} 
                        {{number_format($data->payment->totalPrice)}}
                    </div>
                    <hr>
                    <div class="small mb-2">
                        Refrence #OOBE-{{$data->merchant_order_id}} <br />
                        Name : {{$data->payment->name}}<br />
                        Payment method : {{$data->payment->channel_code}}<br />
                        @if ($data->payment->channel_code == 'OVO')
                            phone account number : <a href="#" 
                            onclick="copyToClipboard('#{{$data->noTelpOvo}}')">
                            <u id="{{$data->noTelpOvo}}">{{$data->noTelpOvo}}</u> 
                            <i class="far fa-copy small"></i></a>
                        @endif
                    </div>
                </div>
            </div>    
            <!-- //payment succsess -->

        </div>
    </section>

    <section class="fixed-bottom text-center p-2 mb-3">
        <img src="/frontend-oobe-indonesia/assets/img/logo/oobe-logo-horizontal-dt.png" class="img-80">
    </section>

    <!-- =================================================================
    MODAL
    ================================================================== -->

    <!-- core -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <!-- app -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript" src="/frontend-oobe-indonesia/assets/js/app.js"></script>

    <script>
        $( document ).ready(function() {
            // hide shopping cart
            $('.shopping-cart').hide();
            // delete all data shopping cart after store data
            sessionStorage.removeItem('cart-oobe-indonesia');
        });

        //copy
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
        }

        // javascript check data transaction already paid
        function checkPayment(){
            $.ajax({
                url: '{{route("check-payment-callback")}}',
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    paymentId:"{{$data->payment->id}}"
                } ,
                success: function (data) {
                    if (data == 1) {
                        var urlJavascript = "{{ route('payment-store-success',['paymentId'=>$data->payment->id]) }}";
                        window.location.href = urlJavascript;
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
                }
            });
            setTimeout(checkPayment, 5000);
        }

        checkPayment();

    </script>
    </body>
@endsection