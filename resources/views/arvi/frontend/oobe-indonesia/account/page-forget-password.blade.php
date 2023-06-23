<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Oobe - Personal delivery assistant</title>
        <meta name="description" content="Hello there">
        <meta name="keywords" content="food delivery">
        <meta name='viewport' content='initial-scale=1, viewport-fit=cover'>
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0"/>
        <link rel="icon" type="image/x-icon" href="/frontend-oobe-indonesia/assets/img/fav/favicon.ico" />
       
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
        <link rel="stylesheet" href="/frontend-oobe-indonesia/assets/css/style.css?<?=date('dmyhis')?>">
    </head>

    <body class="mobile theme-default body-login">
        <div class="mx-4 mt-3 fixed-top">
            <a href="javascript: history.back();" class="text-white">
                <i class="fas fa-chevron-left fa-2x"></i>
            </a>
        </div>
        <section>
            <div class="container-fluid container-xs">
                <div class="d-flex align-items-center justify-content-center vh-100">
                    
                    <div class="login-page form w-100">
                        <div class="text-center logo-login">
                            <img src="/frontend-oobe-indonesia/assets/img/logo/oobe-logo-horizontal-white.png">
                        </div>

                        <!-- register -->
                        <form class="login-form mb-4" 
                        action="{{route('check-number-oobe-indonesia')}}" method="POST">
                            @csrf
                            <div class="text-white text-center mb-3 fw-normal">
                                Enter mobile number that associated with your acccount.
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control phone_with_ddd" 
                                required="required" autocomplete="off" id="phone" name="phone_number" 
                                inputmode="decimal" value="{{old('phone_number')}}" 
                                placeholder="Mobile number" />
                                @if($errors->has('phone_number'))
                                    <div role="alert" class="form-text alert alert-danger p-2">
                                        phone number not exist.
                                    </div>
                                @endif
                            </div>
                            <div class="d-grid mt-4">
                                <button class="btn btn-theme-secondary text-theme-primary-dark text-white" 
                                type="submit">
                                    Sent OTP
                                </button>
                            </div>

                            <div class="mt-4 text-center"> 
                                <a href="{{route('login-oobe-indonesia')}}" 
                                class="btn-register btn-link text-white small">
                                    Already have an account? <u>Sign in</u>
                                </a>
                            </div>
                        </form>
                        <!-- //register -->

                    </div>
                </div>    
            </div>
        </section>

        <!-- =================================================================
        MODAL
        ================================================================== -->

        <!-- core -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

        {{-- script plugin --}}
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script type="text/javascript" src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
        <script type="text/javascript" src="/arvi/backend-assets/vendor/libs/jquery-lazy/jquery.lazy.min.js"></script>
        <script type="text/javascript" src="/arvi/backend-assets/vendor/libs/jquery-mask/jquery.mask.min.js"></script>
        <script type="text/javascript" src="/arvi/backend-assets/js/demo.js"></script>
        <script src="/arvi/backend-assets/js/demo.js"></script>
    </body>
</html>  