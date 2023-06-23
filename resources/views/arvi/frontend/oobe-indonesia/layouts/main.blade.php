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

        <link rel="apple-touch-icon" sizes="76x76" href="/frontend-oobe-indonesia/assets/img/fav/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/frontend-oobe-indonesia/assets/img/fav/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/frontend-oobe-indonesia/assets/img/fav/favicon-16x16.png">
        <link rel="mask-icon" href="/frontend-oobe-indonesia/assets/img/fav/safari-pinned-tab.svg" color="#fff">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
        <link rel="stylesheet" href="/frontend-oobe-indonesia/assets/css/bootstrap-side-modals.css">
        <link rel="stylesheet" href="/frontend-oobe-indonesia/assets/css/style.css?<?=date('dmyhis')?>">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="/frontend-oobe-indonesia/assets/js/cart.js"></script>
    </head>

    <body class="mobile theme-default">

        <!---- START NAVS --->
        <div class="modal fade " id="modal-left" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-slideout bg-theme-primary">
                <div class="modal-content bg-theme-primary">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="staticBackdropLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <!--- Registered user -->
                        <div class="d-flex flex-grow text-white d-none">
                            <div class="me-3 text-center">
                                <a href="page-profile.php" class="text-white lh-base">
                                    <span class="material-icons md-48 lh-sm">account_circle</span>
                                    <div class="small">edit</div>
                                </a>
                            </div>
                            <div class="me-3 align-self-center">
                                <h5 class="m-0">Jushua Metamin Jr.</h5>
                                <div>+62 1234 5678 90</div>
                            </div>
                        </div>
                        <!--- //Registered user -->

                        <!--- Registered user -->
                        <div class="d-flex flex-grow text-white">
                            <div class="me-3 text-center">
                                <a href="page-profile.php" class="text-white lh-base">
                                    <span class="material-icons md-48 lh-sm">account_circle</span>
                                </a>
                            </div>
                            <div class="me-3 align-self-center">

                                @if (auth()->user())
                                <h5 class="m-0">{{auth()->user()->name}}</h5>
                                <div>
                                    <a href="{{route('profile')}}" class="text-white">
                                        Setting Profile
                                    </a>
                                </div>
                                @else
                                <h5 class="m-0">Unregistered</h5>
                                <div>
                                    <a href="{{route('signup-oobe-indonesia')}}"
                                    class="text-white">Register now</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        <!--- //Registered user -->

                        <div class="nav mt-4 align-items-end">
                            <ul>
                                <li><a href="{{route('index-oobe')}}">Home</a></li>
                                @if (auth()->user())
                                <!-- Register user menu -->
                                <li>
                                    <a href="{{route('my-order-index')}}">My Order
                                        <span class="badge bg-warning float-end">
                                            {{
                                                DB::table('merchant_orders')
                                                ->where('user_id',Auth::user()->id)
                                                ->where('payment_status',1)
                                                ->count()
                                            }}
                                        </span>
                                    </a>
                                </li>
                                <li><a href="#">Order History</a></li>
                                <!-- //Register user menu -->
                                @endif
                                <li><hr /></li>
                                <li><a href="#">Join as Merchant</a></li>
                                <li><a href="{{route('about-us')}}">About us</a></li>
                                <li><a href="{{route('pp')}}">Privacy Policy</a></li>
                                <li><a href="{{route('tnc')}}">Term & Condition</a></li>
                                @if (auth()->user())
                                    <li><a href="{{route('logout-oobe-indonesia')}}">Sign Out</a></li>
                                @else
                                    <li><a href="{{route('login-oobe-indonesia')}}">Sign In</a></li>
                                @endif
                            </ul>
                        </div>

                        <div class="text-center p-2 fixed-bottom">
                            <img src="/frontend-oobe-indonesia/assets/img/logo/oobe-logomark-white-sm.png"
                            class="img-80" />
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!---- END NAVS --->

        <!-- MODAL shopping cart -->
        <div class="modal fade bottom" id="modalShoppingCart" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="modalShoppingCart" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" id="view-all-cart">

                </div>
            </div>
        </div>
        <!-- //MODAL shopping cart -->

        <!-- modal loading -->
        <div class="modal fade modalLoading" aria-hidden="true" 
        data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modalLoading" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" 
                style="background-color: rgba(0,0,0,.0001) !important; border: none;">
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="/img/loading.gif" alt="" height="30px">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- //modal address -->

        <header class="fixed-top">
            <div class="container container-xs">
                <div class="row g-0 justify-content-between">
                    <div class="col-8">
                        <div class="d-flex align-items-center">
                            <div><i class="fas fa-map-marker-alt text-white"></i></div>
                            <div class="user-location">
                                <a href="javascript: void(0)" data-bs-toggle="modal"
                                data-bs-target="#modalLocation">
                                    <div class="text-white small lh-sm">
                                        Your location &nbsp;
                                        <span><i class="fas fa-angle-down "></i></span>
                                    </div>
                                    <div class="text-white small fw-bold lh-sm">
                                        Gedung Menara Kuningan
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-end">
                            <!-- SEARCH menus only in merchant page -->
                            <?php
                                if(basename($_SERVER['PHP_SELF']) == 'page-merchant.php'){
                            ?>
                            <div class="burger-sm text-end me-4">
                                <a href="#javascript: void(0);" data-bs-toggle="modal"
                                data-bs-target="#modal-merchant-search">
                                    <i class="fas fa-search text-white"></i>
                                </a>
                            </div>
                            <?php
                                }
                            ?>
                            <!-- //SEARCH menus only in merchant page -->
                            <div class="burger-sm text-end me-4 shopping-cart">
                                <span class="shopping-wrapper">
                                    <span class="shopping-wrapper"><span class="shopping-count d-none"
                                        id="shoppingQty">0</span>
                                <a href="javascript: void(0);" class="open-cart" data-bs-toggle="modal"
                                data-bs-target="#modalShoppingCart" >
                                    <i class="material-icons text-white">shopping_bag</i>
                                </a>
                            </div>
                            <div class="burger-sm text-end"><a href="javascript: void(0);"
                                data-bs-toggle="modal" data-bs-target="#modal-left">
                                <i class="fas fa-bars text-white"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="mt-2" id="main-content">
            @yield('content')
        </div>
    </body>
</html>

<!-- modal location -->
<div class="modal fade" id="modalLocation" aria-hidden="true"
aria-labelledby="modalLocation" tabindex="-1">
    <div class="modal-dialog  modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 m-0">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.342932510688!2d106.82847965106406!3d-6.218428295476405!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3cbd9ee81e7%3A0x730534af13796af4!2sMenara%20Kuningan!5e0!3m2!1sen!2sid!4v1657004901618!5m2!1sen!2sid"
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>

<!-- core -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<!-- app -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script type="text/javascript" src="/frontend-oobe-indonesia/assets/js/jquery.ellipsis.min.js"></script>
<script type="text/javascript" src="/frontend-oobe-indonesia/assets/js/app.js"></script>

{{-- script plugin --}}
<script type="text/javascript" src="/arvi/backend-assets/vendor/libs/popper/popper.js"></script>
<script type="text/javascript" src="/arvi/backend-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script type="text/javascript" src="/arvi/backend-assets/vendor/js/menu.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
<script type="text/javascript" src="/arvi/backend-assets/vendor/libs/jquery-lazy/jquery.lazy.min.js"></script>

<script type="text/javascript" src="/arvi/backend-assets/vendor/libs/jquery-mask/jquery.mask.min.js"></script>
<script type="text/javascript" src="/frontend-oobe-indonesia/assets/js/main.js"></script>
<script type="text/javascript" src="/frontend-oobe-indonesia/assets/js/demo.js"></script>

<script>
    // get quantity item
    cart = JSON.parse(sessionStorage.getItem('cart-oobe-indonesia'));
    if (cart && cart.length > 0) {
        $('.shopping-count').removeClass('d-none').text(cart.length);
    }else{
        $('.shopping-count').addClass('d-none');
    }

    // function open shopping cart
    $('.open-cart').on('click',function () {
        
        $.ajax({
            type: "GET",
            url: "{{route('index-shopping-cart')}}",
            data: {cart:JSON.parse(sessionStorage.getItem('cart-oobe-indonesia'))},
            success: function (response) {
                $.get("{{route('index-shopping-cart')}}",
                {cart:JSON.parse(sessionStorage.getItem('cart-oobe-indonesia'))},function (data) {
                    $('#view-all-cart').html(data);
                })
            },
            error: function (response) {
                sessionStorage.removeItem('cart-oobe-indonesia');
                location.reload();
            }
        });
    });

</script>
