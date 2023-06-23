@php
    $title = 'Confirm Payment Ewallet';
@endphp

@extends('arvi.frontend.store.layouts.main')

@section('content')

    <body class="mobile theme-default">

        <!-- payment succsess -->
        <section class="section-first">
            <div class="container-fluid container-xs mt-2">
                <div class="mt-3">
                    <div class="d-flex align-items-center justify-content-start">
                        <form id="form" 
                        action="{{route('payment-checkout-store',['code'=>$code,'data' => json_encode($data)])}}" 
                        method="POST">@csrf</form>
                        <a href="javascript:void(0)" onclick="$('#form').submit()">
                            <span class="material-icons me-2">arrow_back</span>
                        </a>
                        <h5 class="small">Payment method</h5>
                    </div>
                    <div class="my-5 text-center">
                        <h6>PAY WITH</h6>
                        <img class="" src="/frontend-oobe-indonesia/assets/img/logo/logo-{{strtolower($data['payment']['channel_code'])}}.png">
                    </div>
                </div>
            </div>
        </section>

        <section class="devider"></section>

        @if ($data['payment']['channel_code'] == 'OVO')
            <section>
                <div class="container-fluid container-xs mt-2 small">
                    <div class="mt-3">
                        <div class="d-flex">
                            <div><h6>Phone Number</h6></div>
                        </div>
                        <div class="mt-2">
                            <div class="d-flex justify-content-between mb-2">
                                <input type="text" class="f-inputbox phone_with_ddd complete-pickup" 
                                autocomplete="off" id="phone" name="noTelpOvo" />
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

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
        <!-- //payment succsess -->

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
            $(document).ready(function(){
                $(".shopping-cart").addClass('d-none');
                // cek cart exist
                if (sessionStorage.getItem('cart-oobe-store') == null) {
                    window.location.href = "{{route('index-store',['code'=>$code])}}";
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
                var urlJavascript = "{{ route('payment-store-generate-ew-store',['code'=>$code]) }}"
                +'?data=' + JSON.stringify($(this).data('data'))
                +'&noTelpOvo='+ $('input[name="noTelpOvo"]').val();
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