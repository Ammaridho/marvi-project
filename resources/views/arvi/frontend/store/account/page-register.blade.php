<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Oobe - Register</title>
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
                    <form class="login-form mb-4" id="registration-form"
                    action="{{route('otp-store',['code'=>$code])}}" 
                    method="POST" autocomplete="off">
                    @csrf
                        <div class="text-white text-center mb-3 fw-normal">
                            Join us it only takes few seconds.
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control input-login" required="required"
                            autocomplete="off" id="name" name="name" value="{{old('name')}}" 
                            placeholder="Your full name *" />
                            @if($errors->has('name'))
                                <div role="alert" class="form-text alert alert-danger p-2">
                                    This field is required.
                                </div>
                            @endif
                        </div>
                         <div class="mb-3">
                            <input type="email" class="form-control input-login" required="required"
                            autocomplete="off" id="email" name="email" value="{{old('email')}}" 
                            placeholder="Email address *" />
                            @if($errors->has('email'))
                                <div role="alert" class="form-text alert alert-danger p-2">
                                    your email already used.
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control input-login phone_with_ddd" 
                            required="required"
                            autocomplete="off" id="phone" name="phone" value="{{old('phone')}}"
                            inputmode="decimal" placeholder="Mobile number *" />
                            @if($errors->has('phone'))
                                <div role="alert" class="form-text alert alert-danger p-2">
                                    This field is required.
                                </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <textarea class="form-control input-login" rows="2" id="address"
                            autocomplete="off" name="address" placeholder="Address"></textarea>
                        </div>
                        <div class="mb-3 form-group password-group">
                            <input type="password" class="form-control input-login password-box"
                            required="required" autocomplete="off" id="password1" name="password" 
                            value=""
                            placeholder="Password *"  />
                            <a href="#!" class="password-visibility">
                                <i class="fa fa-eye text-white"></i>
                            </a>
                            <div role="alert" class="form-text alert alert-danger p-2 hidden">
                                This field is required.
                            </div>
                        </div>
                        <div class="mb-3 form-group password-group">
                            <input type="password" class="form-control input-login password-box"
                            required="required" autocomplete="off" id="password2" 
                            name="password_confirmation" value=""
                            placeholder="Re-type password *"  />
                            <a href="#!" class="password-visibility">
                                <i class="fa fa-eye text-white"></i>
                            </a>
                            @if($errors->has('password'))
                                <div role="alert" class="form-text alert alert-danger p-2">
                                    your password not match.
                                </div>
                            @endif
                        </div>
                        <div class="d-grid mt-4">
                            <button class="btn btn-theme-secondary text-theme-primary-dark text-white"
                            type="submit">Create free account</button>
                        </div>
                        <div class="text-center small mt-2 text-white">
                            By creating accont you agree to our
                            <u>
                                <a href="#" class="text-white">Term and Use</a>
                            </u>
                            and
                            <u>
                                <a href="#" class="text-white">Privacy policy</a>
                            </u>.
                        </div>

                        <div class="mt-4 text-center">
                            <a href="{{route('login-store',['code'=>$code])}}" 
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

    <!-- app -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/frontend-oobe-indonesia/assets/js/app.js"></script>

    {{-- script plugin --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
    <script type="text/javascript" src="/arvi/backend-assets/vendor/libs/jquery-lazy/jquery.lazy.min.js"></script>

    <script type="text/javascript" src="/arvi/backend-assets/vendor/libs/jquery-mask/jquery.mask.min.js"></script>
    <script type="text/javascript" src="/arvi/backend-assets/js/demo.js"></script>

    </body>
</html>
