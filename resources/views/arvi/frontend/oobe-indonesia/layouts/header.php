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

        <link rel="apple-touch-icon" sizes="76x76" href="assets/img/fav/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="assets/img/fav/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="assets/img/fav/favicon-16x16.png">
        <link rel="manifest" href="assets/img/fav/site.webmanifest">
        <link rel="mask-icon" href="assets/img/fav/safari-pinned-tab.svg" color="#fff">
       
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
        <link rel="stylesheet" href="assets/css/bootstrap-side-modals.css">
        <link rel="stylesheet" href="assets/css/style.css?<?=date('dmyhis')?>">
    </head>

    <body class="mobile theme-default">
    
    <!---- START NAVS --->
    <div class="modal fade " id="modal-left" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideout bg-theme-primary">
            <div class="modal-content bg-theme-primary">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="staticBackdropLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                            <h5 class="m-0">Unregistered</h5>
                            <div><a href="page-register.php" class="text-white">Register now</a></div>
                        </div>
                    </div>
                    <!--- //Registered user -->

                    <div class="nav mt-4 align-items-end">
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <!-- Register user menu -->
                            <li><a href="page-my-order.php">My Order <span class="badge bg-warning float-end">4</span></a></li>
                            <li><a href="page-my-history.php">Order History</a></li>
                            <!-- //Register user menu -->
                            <li><hr /></li>
                            <li><a href="#">Join as Merchant</a></li>
                            <li><a href="#">About us</a></li>
                            <li><a href="page-pp.php">Privacy Policy</a></li>
                            <li><a href="page-tc.php">Term & Condition</a></li>
                            <li><a href="page-login.php">Sign In / Sign Out</a></li>
                        </ul>
                    </div>

                    <div class="text-center p-2 fixed-bottom">
                        <img src="assets/img/logo/oobe-logomark-white-sm.png" class="img-80" />
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!---- END NAVS --->

    <!-- MODAL shopping cart -->
    <div class="modal fade bottom" id="modalShoppingCart" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalShoppingCart" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">

                    <ul class="list-unstyled m-0 p-0 list-cart">
                        <li>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="">Total</div>
                                
                                <!-- LOADING STATE 
                                when items still loading remove .d-none
                                -->
                                <div class="ol-price-loader loading d-none"></div>
                                <!-- //LOADING STATE -->

                                <div class="text-theme-primary fw-bold">Rp. 60.000</div>
                            </div>
                        </li>
                        <li class="test-showhide-loader">
                            <!-- 
                            SKLETEON LOADER FOR LIST ITEM
                            USED THIS to load each loading items
                            -->
                            <div class="d-flex ol-loader-sm">
                                <div class="ol-img loading"></div>
                                <div class="ol-more">
                                    <div class="ol-title loading"></div>
                                    <div class="ol-desc loading"></div>
                                    <div class="ol-price loading"></div>
                                </div>
                            </div>
                            <!-- //SKLETEON LOADER FOR LIST ITEM-->
                        </li>
                        <li id="item0">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <a href="page-product.php?act=edit">
                                    <div class="d-flex">
                                        <div class="me-2"><div class="img-wrapper-cart" style="background-image: url('assets/img/menus/Oishimoo_thumb.jpg');"></div></div>
                                        <div>
                                            <div class="small">Suhimoo Tebet</div>
                                            <div class="fw-bold text-theme-primary"><?=strlen('Beef Teriyaki Onigiri (Sushi Rice)') > 25 ? substr('Beef Teriyaki Onigiri (Sushi Rice)',0,25)."..." : 'Beef Teriyaki Onigiri (Sushi Rice)';?></div>
                                            <div>
                                                Rp 15.000 x 3
                                                <div class="small text-muted">Notes: <em><?=strlen('Engga pake wasabi, mayo sama sushi :P') > 20 ? substr('Engga pake wasabi, mayo sama sushi :P',0,20)."..." : 'Engga pake wasabi, mayo sama sushi :P';?></em></div>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                                <div>
                                    <div class="fw-bold text-center mb-2">Rp 45.000</div>
                                    <!-- count -->
                                    <div class="counter-lg text-center" id="field3">
                                        <button class="counter-btn min sub text-theme-primary-dark"><i class="fas fa-minus"></i></button>
                                        <input type="number" name="qty" class="field" id="qtys" maxlength="12" min="1" value="3" disabled readonly />
                                        <button class="counter-btn add text-theme-primary-dark"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li id="item1">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <a href="page-product.php?act=edit">
                                    <div class="d-flex">
                                        <div class="me-2"><div class="img-wrapper-cart" style="background-image: url('assets/img/menus/Izumi_thumb.jpg');"></div></div>
                                        <div>
                                            <div class="small">Donmoo Tebet</div>
                                            <div class="fw-bold text-theme-primary"><?=strlen('Izumi Platter') > 25 ? substr('Izumi Platter',0,25)."..." : 'Izumi Platter';?></div>
                                            <div>Rp 15.000 x 1</div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                                <div>
                                    <div class="fw-bold text-center mb-2">Rp 15.000</div>
                                    <!-- count -->
                                    <div class="counter-lg text-center" id="field3">
                                        <button class="counter-btn min sub text-theme-primary-dark"><i class="far fa-trash-alt"></i></button> <!-- IF QTY <= 1, change to trash can and remove the item when this clicked -->
                                        <input type="number" name="qty" class="field" id="qtys" maxlength="12" min="1" value="1" disabled readonly />
                                        <button class="counter-btn add text-theme-primary-dark"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="m-0 p-0">
                            <div class="d-flex align-items-center justify-content-end">
                                <button type="button" class="btn btn-theme-secondary" onclick="location.href='page-checkout.php';">Check out</button>
                            </div>
                        </li>
                    </uL>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- //MODAL shopping cart -->
    
    <header class="fixed-top">
        <div class="container container-xs">
            <div class="row g-0 justify-content-between">
                <div class="col-8">
                    <div class="d-flex align-items-center">
                        <div><i class="fas fa-map-marker-alt text-white"></i></div>
                        <div class="user-location">
                            <a href="javascript: void(0)" data-bs-toggle="modal" data-bs-target="#modalLocation">
                                <div class="text-white small lh-sm">Your location &nbsp; <span><i class="fas fa-angle-down "></i></span></div>
                                <div class="text-white small fw-bold lh-sm">Gedung Menara Kuningan</div>
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
                            <a href="#javascript: void(0);" data-bs-toggle="modal" data-bs-target="#modal-merchant-search"><i class="fas fa-search text-white"></i></a>
                        </div>
                        <?php
                            }
                        ?>
                        <!-- //SEARCH menus only in merchant page -->
                        <div class="burger-sm text-end me-4 shopping-cart">
                            <span class="shopping-wrapper"><span class="shopping-count hidden" id="shoppingQty">26</span>
                            <a href="javascript: void(0);" data-bs-toggle="modal" data-bs-target="#modalShoppingCart"><i class="material-icons text-white">shopping_bag</i></a>
                        </div>
                        <div class="burger-sm text-end"><a href="javascript: void(0);" data-bs-toggle="modal" data-bs-target="#modal-left"><i class="fas fa-bars text-white"></i></a></div>
                    </div>
                </div>
            </div>
        </div>
    </header>