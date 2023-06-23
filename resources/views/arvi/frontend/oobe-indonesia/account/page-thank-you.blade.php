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

    <div class="mx-4 mt-3 fixed-top d-none">
        <a href="javascript: history.back();" class="text-white">
            <i class="fas fa-chevron-left fa-2x"></i>
        </a>
    </div>

    <section>
        <div class="container-fluid container-xs">
            <div class="d-flex align-items-center 
            justify-content-center vh-100">
                
                <div class="login-page form w-100">
                    <div class="text-center logo-login ">
                        <img src="/frontend-oobe-indonesia/assets/img/logo/oobe-logo-horizontal-white.png">
                    </div>

                    <div class="text-white my-4">
                         <h1 class="fw-light">Thank you for registering with Oobe Indonesia!</h1>
                         <div>We will send you a confirmation email for new account, meanwhile you can find great 
                            <a href="{{route('index-oobe')}}" class="text-white">
                                <u>food around you by clicking here.</u>
                            </a>
                        </div>
                    </div>
                    <div class="search-box w-100 sticky container-xs">
                         <div class="form-group has-search">
                              <input type="text" class="form-control textbox" 
                              id="searchSomething" data-bs-toggle="modal" 
                              data-bs-target="#modal-global-search" 
                              autocomplete="off" readonly placeholder="Search good burger" />
                              <span class="fa fa-search form-control-feedback mt-1"></span>
                         </div>
                    </div>

                </div>
            </div>
        </div>
    
    </section>

    <!-- =================================================================
    MODAL
    ================================================================== -->

    <!-- Modal -->
    <div class="modal fade" id="modal-global-search" 
    aria-labelledby="modal-global-search" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <form class="w-100" onsubmit="return false">
                        <div class="merchant-search me-3">
                            <div class="form-group has-search">
                                <input type="text" class="form-control" 
                                id="search-merchant" 
                                placeholder="What do you want to eat today?" autofocus>
                                <span class="fa fa-search form-control-feedback"></span>
                                <button type="reset">&times;</button>
                            </div>
                        </div>
                    </form>
                    <a href="#" data-bs-dismiss="modal" class="small text-danger" >Cancel</a>
                </div>
                <div class="modal-body">

                    <!-- ajax search result -->
                    <div class="card-menu mt-2">
                        <!-- loader -->
                        {{-- <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex ol-loader">
                                    <div class="ol-img loading"></div>
                                    <div class="ol-more">
                                        <div class="ol-title loading"></div>
                                        <div class="ol-desc loading"></div>
                                        <div class="ol-price loading"></div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!-- loader -->
                        <div id="list-search-product"></div>
                        
                    </div>
                    <!-- //ajax search result -->

                </div>
            </div>
        </div>
    </div>

    <!-- core -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <!-- app -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/frontend-oobe-indonesia/assets/js/app.js"></script>

    <script>
        $('#search-merchant, #searchSomething').on('keyup click',function () {
            let search = $(this).val();
            $.get("{{route('search-oobe-indonesia')}}",{search:search},function (data) {
                $('#list-search-product').html(data);
            })
        })
    </script>
    </body>
</html>  