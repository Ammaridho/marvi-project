@extends('arvi.frontend.oobe-indonesia.layouts.main')

@section('content')

    <body class="mobile theme-default">

    <section>
        <div class="container-fluid container-xs">

            <!-- payment succsess -->
            <div class="d-flex align-items-center justify-content-center vh-100">
                <div class="text-center">
                    <div class="mb-3 text-success">
                        <span class="material-icons md-48">verified</span>
                    </div>
                    <h2 class="text-theme-primary">Payment Successful</h2>
                    <div>You have completed your payment.</div>
                    <hr>

                    @if (auth()->user())
                        <button class="btn btn-sm btn-outline-primary mt-3" type="button" 
                        onclick="location.href='{{route('my-order-index')}}';">
                            View my order status
                        </button>
                    @else
                        <button class="btn btn-sm btn-outline-primary mt-3" type="button" 
                        onclick="location.href='{{route('index-oobe')}}';">Home</button>
                    @endif
                </div>
            </div>    
            <!-- //payment succsess -->


            @if (isset($sentOrderToLodi))
                <!-- payment succsess -->
                <div class="d-flex align-items-center justify-content-center vh-100">
                    <div class="text-center">
                        <h2 class="text-theme-primary">{{$sentOrderToLodi['message']}}</h2>
                    </div>
                </div>    
                <!-- //payment succsess -->
            @endif

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
        $(function(){
            // hide shopping cart
            $('.shopping-cart').hide();
            // delete all data shopping cart after store data
            sessionStorage.removeItem('cart-oobe-indonesia');
        });
    </script>
    </body>
@endsection