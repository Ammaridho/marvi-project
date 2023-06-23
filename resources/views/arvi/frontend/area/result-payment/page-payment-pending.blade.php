<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Oobe - Payment status</title>
        <meta name="description" content="Hello there">
        <meta name="keywords" content="food delivery">
        <meta name='viewport' content='initial-scale=1, viewport-fit=cover'>
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0"/>

        <link rel="apple-touch-icon" sizes="76x76" href="apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
        <link rel="manifest" href="site.webmanifest">
        <link rel="mask-icon" href="safari-pinned-tab.svg" color="#5bbad5">
       
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
        <link rel="stylesheet" href="/frontend-oobe-indonesia/assets/css/bootstrap-side-modals.css">
        <link rel="stylesheet" href="/frontend-oobe-indonesia/assets/css/style.css?<?=date('dmyhis')?>">
    </head>

    <body class="mobile theme-default">

    <section>
        <div class="container-fluid container-xs">

            <!-- payment succsess -->
            <div class="d-flex align-items-center justify-content-center vh-100">
                <div class="text-center">
                    <div class="mb-3 text-warning">
                        <span class="material-icons md-48">hourglass_top</span>
                    </div>
                    <h2 class="text-theme-primary">Waiting for Payment</h2>
                    <div>Pleased proceed to pay the transaction.</div>
                    <hr>
                    <div class="small">AMOUNT PAID</div>
                    <div class="fw-bold fs-5">{{$currency}} {{$totalPrice}}</div>
                    <hr>
                    <div class="small mb-2">
                        Refrence # 091827354 <br />
                        Payment method : Virtual Account BCA<br />
                        Virtual account number : <a href="#" onclick="copyToClipboard('#1234567890123')">
                            <u id="1234567890123">1234567890123</u> <i class="far fa-copy small"></i></a>
                    </div>
                    @if (Auth::check())
                        <button class="btn btn-sm btn-outline-primary mt-3" type="button" 
                        onclick="location.href='{{route('my-order-index-area',['code'=>$code])}}';">View my order history</button>
                    @endif
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
</html>  