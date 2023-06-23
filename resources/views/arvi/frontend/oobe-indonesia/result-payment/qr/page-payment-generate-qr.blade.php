@extends('arvi.frontend.oobe-indonesia.layouts.main')

@section('content')

    <body class="mobile theme-default">

        <section class="section-first">
            <div class="container-fluid container-xs mt-2">
                <div class="mt-4">
                
                    <div class="my-3 text-center">
                        <h6>Scan the QR code with your 
                            payment application</h6>
                        <div class="small mb-2">
                            Complete the payment within 
                            <span class="countdown bg-light 
                            rounded p-1 px-2 text-danger">
                                <span id="minutes"></span>
                                <span id="seconds"></span>
                            </span>
                        </div>

                        <div class="visible-print text-center">
                            {!! \QRCode::text($qr_string)->setSize(5)->svg() !!}
                        </div>

                        <div class="mt-1 text-center">
                            <div class="small text-muted">Total payment</div>
                            <strong>
                                {{$data->payment->currency}} 
                                {{number_format($data->payment->totalPrice)}}
                            </strong>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>

        <section class="devider"></section>

        <section>
            <div class="container-fluid container-xs mt-2 small">
                <div class="my-4">
                <strong class="mb-2">Payment method</strong>
                        <ol>
                            <li>Open your bank payment application or 
                                e-wallet on your mobile phone.</li>
                            <li>ScanQR code above.</li>
                            <li>Make sure the total bill is correct, 
                                then click pay.</li>
                            <li>After successful payment, it will be 
                                automatically verified.</li>
                        </ol>
                </div>
                <div class="alert alert-secondary">
                        Please do not close this page until the payment is verified.
                </div>
            </div>
        </section>

        <!-- =================================================================
        MODAL
        ================================================================== -->
        <!-- modal times up -->
        <div class="modal fade modal-fullscreen" id="modalTimesUp" 
        data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" 
        aria-labelledby="modalTimesUp" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body p-3">

                        <div class="text-center">
                            <span class="material-icons text-theme-primary md-48">
                                running_with_errors
                            </span>
                        </div>
                        <div class="text-center fw-bold fs-5">
                            The payment deadline has expired
                        </div>
                        <div>This QR code is no longer valid due to 
                            exceeding the payment deadline.
                             Please try again to get a new QR code.</div>
                        
                    </div>
                    <div class="modal-footer border-0 
                    justify-content-between">
                        <div class="flex-grow-1">
                            <div class="d-grid">
                                <a href="{{route('payment-store-failed')}}" 
                                class="btn btn-sm btn-outline-secondary">
                                    Cancel the transaction
                                </a>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-grid">
                                <button type="button" 
                                class="btn btn-sm btn-theme-secondary"
                                onclick="location.href='{{route('payment-store-generate-qr',['data' => json_encode($data)])}}';"
                                 data-bs-dismiss="modal">Try again</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- //modal remove item -->
        
        <!-- core -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

        <!-- app -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
        <script type="text/javascript" src="/frontend-oobe-indonesia/assets/js/app.js"></script>
        <script>
            $(function(){
                // hide shopping cart
                $('.shopping-cart').hide();
                // delete all data shopping cart after store data
                sessionStorage.removeItem('cart-oobe-indonesia');

                // modal timeout
                setTimeout(function() {
                    $('#modalTimesUp').modal('show');
                }, 120000);

                //modal timeout if the user not doing nothing!
                setTimeout(function() {
                    window.location= ("{{route('payment-store-failed')}}");
                }, 180000);
                
                var endTime = '{{$data->timer}}';			
                function makeTimer(endTime) {
                    endTime = (Date.parse(endTime) / 1000);
                    
                    var now = new Date();
                    now = (Date.parse(now) / 1000);
                    
                    var timeLeft = endTime - now;
                    
                    if (timeLeft > -25201) {  //25201 bit time

                    var days = Math.floor(timeLeft / 86400); 
                    var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
                    var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
                    var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

                    //if (hours < "10") { hours = "0" + hours; }
                    if (minutes < "10") { minutes = "0" + minutes; }
                    if (seconds < "10") { seconds = "0" + seconds; }

                    //$("#days").html(days + "<span>Days</span>");
                    //$("#hours").html(hours + "<span>Hours</span>");
                    $("#minutes").html(minutes + " <span>menit</span>");
                    $("#seconds").html(seconds + " <span>detik</span>");	
                    }	
                }
                setInterval(function() { makeTimer(endTime); }, 1000);

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
                                var urlJavascript = "{{ route('payment-store-success') }}";
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

            });
        </script>
    </body>
@endsection