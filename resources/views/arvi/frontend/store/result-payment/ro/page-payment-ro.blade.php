@extends('arvi.frontend.store.layouts.main')

@section('content')

    <body class="mobile theme-default">
        
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
                        <img class="" 
                        src="/frontend-oobe-indonesia/assets/img/logo/{{strtolower($data['payment']['channel_code'])}}.png">
                    </div>
                    
                </div>
            </div>
        </section>
    
        <!-- SHOW THIS ONLY FOR QR -->
        <section class="devider"></section>
    
        <section>
            <div class="container-fluid container-xs mt-2 small">
                <div class="mt-3">
                    <div class="d-flex">
                        <div><h6>Order summary</h6></div>
                    </div>
                    <div class="mt-2">
                        <div class="d-flex justify-content-between mb-2">
                            <div>Total</div>
                            <div>
                                {{$data['payment']['currency']}} 
                                {{number_format($data['payment']['totalPrice'])}}
                            </div>
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
                        text-theme-primary-dark text-white" type="button" 
                        onclick="location.href='{{route('payment-store-generate-ro',['data' => json_encode($data)])}}';">
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
        </script>
    </body>

@endsection