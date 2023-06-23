@extends('arvi.frontend.oobe-indonesia.layouts.main')

@section('content')

    <body class="mobile theme-default">

        <section class="section-first">
            <div class="container-fluid container-xs mt-2">
                <div class="mt-3">
                    <div class="d-flex align-items-center justify-content-start">
                        <form id="form" 
                        action="{{route('payment-checkout',['data' => json_encode($data)])}}" 
                        method="POST">@csrf</form>
                        <a href="javascript:void(0)" onclick="$('#form').submit()">
                            <span class="material-icons me-2">arrow_back</span>
                        </a>
                        <h5 class="small">Payment method</h5>
                    </div>
                    <div class="my-5 text-center">
                        <h6>PAY WITH</h6>
                        <img class="" width="150" src="/frontend-oobe-indonesia/assets/img/logo/logo-cash.png">
                        <h6>Cash</h6>
                    </div>
                </div>
            </div>
        </section>

        <section class="devider"></section>

        <section>
            <div class="container-fluid container-xs mt-2 small">
                <div class="mt-3">
                    <div class="d-flex">
                        <div><h6>Total</h6></div>
                    </div>
                    <div class="m-2">
                        <div class="d-flex justify-content-between mb-2">
                            {{$data['payment']['currency']}} 
                            {{number_format($data['payment']['totalPrice'])}}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-last">
            <div class="fixed-bottom bg-white border-top">
                <div class="container-fluid container-xs">
                    <div class="d-grid my-2">
                        <button class="btn btn-theme-secondary py-2 
                        text-theme-primary-dark text-white" id="pay"
                        data-data="{{json_encode($data)}}" type="button">
                            <div class="d-flex justify-content-between">
                                <div>Pay</div>
                                <div class="fw-bold">
                                    {{$data['payment']['currency']}} 
                                    {{number_format($data['payment']['totalPrice'])}}
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- =================================================================
        MODAL
        ================================================================== -->

        <script type="text/javascript" src="/arvi/backend-assets/js/demo.js"></script>

        <script>
            $( document ).ready(function() {
                // hide shopping cart
                $('.shopping-cart').hide();
                // cek cart exist
                if (sessionStorage.getItem('cart-oobe-indonesia') == null) {
                    window.location.href = "{{route('index-oobe')}}";
                }
            });

            // check phone number if ovo
            if ("{{$data['payment']['channel_code']}}" == "OVO") {
                $('#pay').prop("disabled",true);
            }
            $('#phone').on('keyup',function () {
                if ($(this).val().length > 10) {
                    $('#pay').prop("disabled",false);
                }else{
                    $('#pay').prop("disabled",true); 
                }
            })
            
            // button pay
            $('#pay').on('click',function () {
                var urlJavascript = "{{ route('payment-store-generate-cash') }}"
                +'?data=' + JSON.stringify($(this).data('data'))
                +'&noTelpDana='+ $('input[name="noTelpDana"]').val();
                window.location.href = urlJavascript;
            })

            //copy
            function copyToClipboard(element) {
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val($(element).text()).select();
                document.execCommand("copy");
                $temp.remove();
            }
        </script>
    </body>

@endsection