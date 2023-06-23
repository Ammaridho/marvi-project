@extends('arvi.frontend.oobe-indonesia.layouts.main')

@section('content')

        <section class="section-first"></section>
        <div class="search-box bg-white w-100 sticky container-xs">
            <div class="form-group has-search">
                <input type="text" class="form-control textbox" id="searchSomething"
                data-bs-toggle="modal" data-bs-target="#modal-global-search"
                autocomplete="off" readonly />
                <span class="fa fa-search form-control-feedback"></span>
            </div>
        </div>

        <section>
            <div class="container-fluid g-0 container-xs">
                <div class="mt-2">
                    <div class="banner-hero px-2">
                        <!-- banner loader -->
                        {{-- <a href="#" class="me-2">
                            <div class="img-hero bg-light d-flex align-items-center
                            justify-content-center loading">
                                <img src="/frontend-oobe-indonesia/assets/img/loading-food.png">
                            </div>
                        </a> --}}

                        <!-- //banner loader -->
                        @foreach ($banners as $item)

                            @if (isset($item))
                                <a href="{{ $item->url }}" class="me-2">
                                    <div class="img-hero bg-light"
                                        style="background-image: url('/storage/arvi/backend-assets/img/banners/{{$item->image_url}}')">
                                    </div>
                                </a>
                            @endif

                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- pick a merchant-->
        <section>
            <div class="container-fluid container-xs">
                <h6>Pick a restaurant</h6>
                <div class="merchant-list">
                    @foreach ($merchants as $item)
                        <div class="pb-4">
                            <div class="card mx-1 shadow">
                                <a href="{{route('index-store-order', ['merchantId' => $item->id])}}"
                                    class="pick-store">
                                    <div class="card-body text-center merchant-logo">
                                        @if (isset($item->image_url))
                                            <img src="/storage/arvi/backend-assets/img/logo/merchants/{{$item->image_url}}" />
                                        @else
                                            <img src="/frontend-oobe-indonesia/assets/img/merchant/default-brand-logo.png" />
                                        @endif
                                        <small>{{$item->name}}</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- //pick a merchant-->

        <!-- info promo -->
        <section class="d-none">
            <div class="container-fluid container-xs">
                <div class="card">
                    <a href="javascript:void(0);">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="small">
                                <img src="/frontend-oobe-indonesia/assets/img/coupon.png"
                                class="img-20">
                                 Potentially <strong>PROMO</strong> applied
                            </div>
                            <div>
                                <i class="fas fa-arrow-circle-right fs-3 text-theme-secondary"></i>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
        </section>
        <!-- //info promo -->

        <!-- promo -->
        <section class="d-none">
            <div class="container-fluid container-xs mt-3">

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <h6 class="m-0">BUY 1 GET 1!</h6>
                    </div>
                    <div>
                        <div class="text-end">
                            <span class="badge rounded-pill btn-theme-secondary pt-2 pb-2 px-3">
                                <a href="#" class="text-white">See more</a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="merchant-h">
                    <!--
                        SKLETEON LOADER FOR LIST ITEM
                        USED THIS to load each loading items
                    -->
                    {{-- <div class="mx-1 test-showhide-loader">
                        <div class="card">
                            <div class="card-body px-2 pt-2 pb-4">
                                <div class="ol-vloader">
                                    <div class="ol-img loading"></div>
                                    <div class="ol-more">
                                        <div class="ol-title loading"></div>
                                        <div class="ol-price loading"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mx-1 test-showhide-loader">
                        <div class="card">
                            <div class="card-body px-2 pt-2 pb-4">
                                <div class="ol-vloader">
                                    <div class="ol-img loading"></div>
                                    <div class="ol-more">
                                        <div class="ol-title loading"></div>
                                        <div class="ol-price loading"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mx-1 test-showhide-loader">
                        <div class="card">
                            <div class="card-body px-2 pt-2 pb-4">
                                <div class="ol-vloader">
                                    <div class="ol-img loading"></div>
                                    <div class="ol-more">
                                        <div class="ol-title loading"></div>
                                        <div class="ol-price loading"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mx-1 test-showhide-loader">
                        <div class="card">
                            <div class="card-body px-2 pt-2 pb-4">
                                <div class="ol-vloader">
                                    <div class="ol-img loading"></div>
                                    <div class="ol-more">
                                        <div class="ol-title loading"></div>
                                        <div class="ol-price loading"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <!--  //SKLETEON LOADER-->

                    <div class="mx-1">
                        <div class="card">
                            <div class="card-body px-2 pt-2 pb-4">
                                <a href="page-product.php">
                                <div class="img-wrapper-h" style="background-image: url('/frontend-oobe-indonesia/assets/img/menus/Chizu.png');"></div>
                                <div class="small text-muted mt-1">Promo</div>
                                <div class="fw-bold"><?=strlen('B1G1 - Medium Platters') > 16 ? substr('B1G1 - Medium Platters',0,16)."..." : 'B1G1 - Medium Platters';?></div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="fw-bold text-theme-primary">Rp 76.000</div>
                                    <div>
                                        <div class="ms-3 small"><i class="fas fa-star text-theme-primary"></i> 4.5</div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="mx-1">
                        <div class="card">
                            <div class="card-body px-2 pt-2 pb-4">
                                <a href="page-product.php">
                                <div class="img-wrapper-h" style="background-image: url('/frontend-oobe-indonesia/assets/img/menus/UmiPlatter.png');"></div>
                                <div class="small text-muted mt-1">Promo</div>
                                <div class="fw-bold"><?=strlen('B1G1 - Large Platters') > 16 ? substr('B1G1 - Large Platters',0,16)."..." : 'B1G1 - Large Platters';?></div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="fw-bold text-theme-primary">Rp 76.000</div>
                                    <div>
                                        <div class="ms-3 small"><i class="fas fa-star text-theme-primary"></i> 4.5</div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="mx-1">
                        <div class="card">
                            <div class="card-body px-2 pt-2 pb-4">
                                <a href="page-product.php">
                                <div class="img-wrapper-h" style="background-image: url('/frontend-oobe-indonesia/assets/img/menus/Zeitakumoo.png');"></div>
                                <div class="small text-muted mt-1">Promo</div>
                                <div class="fw-bold"><?=strlen('B1G1 - Premium Platters') > 16 ? substr('B1G1 - Premium Platters',0,16)."..." : 'B1G1 - Premium Platters';?></div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="fw-bold text-theme-primary">Rp 76.000</div>
                                    <div>
                                        <div class="ms-3 small"><i class="fas fa-star text-theme-primary"></i> 4.5</div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="mx-1">
                        <div class="card">
                            <div class="card-body px-2 pt-2 pb-4">
                                <a href="page-product.php">
                                <div class="img-wrapper-h" style="background-image: url('/frontend-oobe-indonesia/assets/img/menus/Fiery_Chicken_Karage.png');"></div>
                                <div class="small text-muted mt-1">Promo</div>
                                <div class="fw-bold"><?=strlen('B1G1 - Medium Platters') > 16 ? substr('B1G1 - Medium Platters',0,16)."..." : 'B1G1 - Medium Platters';?></div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="fw-bold text-theme-primary">Rp 76.000</div>
                                    <div>
                                        <div class="ms-3 small"><i class="fas fa-star text-theme-primary"></i> 4.5</div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- //promo -->

        <!-- tabbed menus -->
        <section>
            <div class="container-fluid container-xs mt-3">

                <div class="tab-line">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="favourite-tab" data-bs-toggle="tab" 
                            data-bs-target="#favourite-tab-pane" type="button" role="tab" 
                            aria-controls="favourite-tab-pane" aria-selected="true">Popular</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="new-tab" data-bs-toggle="tab" 
                            data-bs-target="#new-tab-pane" type="button" role="tab" 
                            aria-controls="new-tab-pane" aria-selected="false">New</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="rating-tab" data-bs-toggle="tab" 
                            data-bs-target="#rating-tab-pane" type="button" role="tab" 
                            aria-controls="rating-tab-pane" aria-selected="false">Rating</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="favourite-tab-pane"
                         role="tabpanel" aria-labelledby="favourite-tab" tabindex="0">
                            <!-- favorit item -->
                            <div class="card-menu">
                                <!--
                                    SKLETEON LOADER FOR LIST ITEM
                                    USED THIS to load each loading items
                                -->
                                <div class="test-showhide-loader">

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
                                    </div>
                                    <div class="card shadow-sm">
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
                                    </div>
                                    <div class="card shadow-sm">
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
                                    </div>
                                    <div class="card shadow-sm">
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

                                </div>
                                <!--  //SKLETEON LOADER-->

                                @foreach ($productTabPopular as $item)

                                <div class="card shadow-sm">
                                    <div class="card-body listitem">
                                        <a href="{{route('show-store-order',['productId' => $item['id'] ])}}">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    @if (isset($item['url']))
                                                        @if ($item['url'] != 'url')
                                                            <div class="img-wrapper-sm"
                                                                style="background-image: url('/storage/arvi/backend-assets/img/products/brands/{{$item['url']}}');">
                                                            </div>
                                                        @elseif(isset($item['image_mime']))
                                                            <div class="img-wrapper-sm"
                                                            style="background-image: url('/arvi/assets/img/products/{{$item['image_mime'].'.'.$item['image_type']}}');">
                                                        </div>
                                                    @endif
                                                    @else
                                                        <div class="img-wrapper-sm"
                                                            style="background-image: url('/arvi/backend-assets/img/default/product.jpg');">
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="px-3">
                                                    <div class="fw-bold"></div>
                                                    <div class="fw-bold">
                                                        <?=strlen($item['name']) > 25 ?
                                                        substr($item['name'],0,25)."..." :
                                                         $item['name'];?>
                                                    </div>
                                                    <div class="fs-7">
                                                       (store : {{$item['merchantName']}})
                                                    </div>
                                                    <div class="fs-6">
                                                        <?=strlen($item['description']) > 100 ?
                                                        substr($item['description'],0,100)."..." :
                                                         $item['description'];?></div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="fw-bold fs-5 text-theme-primary">
                                                            @php
                                                                $discount = isset($item['discount_price'])?
                                                                $item['discount_price']:0;
                                                            @endphp
            
                                                            @if ($discount>0)
                                                                <s>{{$item['currency']}} 
                                                                {{number_format($item['retail_price'])}}</s> = 
                                                                {{$item['currency']}} 
                                                                {{number_format($discount)}}                   
                                                            @else
                                                                {{$item['currency']}} 
                                                                {{number_format($item['retail_price'])}}        
                                                            @endif

                                                        </div>
                                                        <div>
                                                            <div class="ms-3 small hidden">
                                                                <i class="fas fa-star text-theme-primary"></i> 4.9
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                @endforeach

                            </div>
                            <!-- // favorit item -->
                        </div>
                        <div class="tab-pane fade" id="new-tab-pane" role="tabpanel" aria-labelledby="new-tab" tabindex="0">
                            <!-- new item -->
                            <div class="card-menu">

                                @foreach ($productTabNew as $item)

                                <div class="card shadow-sm">
                                    <div class="card-body listitem">
                                        <a href="{{route('show-store-order',['productId' => $item['id'] ])}}">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    @if (isset($item['url']))
                                                        @if ($item['url'] != 'url')
                                                            <div class="img-wrapper-sm"
                                                                style="background-image: url('/storage/arvi/backend-assets/img/products/brands/{{$item['url']}}');">
                                                            </div>
                                                        @elseif(isset($item['image_mime']))
                                                            <div class="img-wrapper-sm"
                                                            style="background-image: url('/arvi/assets/img/products/{{$item['image_mime'].'.'.$item['image_type']}}');">
                                                        </div>
                                                    @endif
                                                    @else
                                                        <div class="img-wrapper-sm"
                                                            style="background-image: url('/arvi/backend-assets/img/default/product.jpg');">
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="px-3">
                                                    <div class="fw-bold"></div>
                                                    <div class="fw-bold"><?=strlen($item['name']) > 25 ?
                                                        substr($item['name'],0,25)."..." : $item['name'];?>
                                                    </div>
                                                    <div class="fs-7">
                                                       (store : {{$item['merchantName']}})
                                                    </div>
                                                    <div class="fs-6"><?=strlen($item['description']) > 100 ?
                                                        substr($item['description'],0,100)."..." : $item['description'];?></div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="fw-bold fs-5 text-theme-primary">
                                                            {{$item['currency']}} {{$item['retail_price']}}
                                                        </div>
                                                        <div>
                                                            <div class="ms-3 small hidden">
                                                                <i class="fas fa-star text-theme-primary"></i> 4.9
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                @endforeach

                            </div>
                            <!-- // new item  -->
                        </div>
                        <div class="tab-pane fade" id="rating-tab-pane" role="tabpanel" aria-labelledby="rating-tab" tabindex="0">
                            <!-- rating item -->
                            <div class="card-menu">
                                @foreach ($productTabPopular as $item)

                                <div class="card shadow-sm">
                                    <div class="card-body listitem">
                                        <a href="{{route('show-store-order',['productId' => $item['id'] ])}}">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    @if (isset($item['url']))
                                                        @if ($item['url'] != 'url')
                                                            <div class="img-wrapper-sm"
                                                                style="background-image: url('/storage/arvi/backend-assets/img/products/brands/{{$item['url']}}');">
                                                            </div>
                                                        @elseif(isset($item['image_mime']))
                                                            <div class="img-wrapper-sm"
                                                            style="background-image: url('/arvi/assets/img/products/{{$item['image_mime'].'.'.$item['image_type']}}');">
                                                        </div>
                                                    @endif
                                                    @else
                                                        <div class="img-wrapper-sm"
                                                            style="background-image: url('/arvi/backend-assets/img/default/product.jpg');">
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="px-3">
                                                    <div class="fw-bold"></div>
                                                    <div class="fw-bold">
                                                        <?=strlen($item['name']) > 25 ?
                                                        substr($item['name'],0,25)."..." : $item['name'];?>
                                                    </div>
                                                    <div class="fs-7">
                                                       (store : {{$item['merchantName']}})
                                                    </div>
                                                    <div class="fs-6">
                                                        <?=strlen($item['description']) > 100 ?
                                                        substr($item['description'],0,100)."..." : $item['description'];?>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="fw-bold fs-5 text-theme-primary">
                                                            {{$item['currency']}} {{$item['retail_price']}}
                                                        </div>
                                                        <div>
                                                            <div class="ms-3 small hidden">
                                                                <i class="fas fa-star text-theme-primary"></i> 4.9
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                @endforeach

                            </div>
                            <!-- // rating item -->
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- //tabbed menus -->

        <!-- GLOBAL  CART -->
        <div class="fixed-bottom d-none">
            <div class="container-mobile">
                <a href="page-cart.php">
                    <div class="d-flex justify-content-between align-items-center status-cart shadow">
                        <div>
                            <div class="f-12 text-uppercase">Lihat pesanan</div>
                            <div class=""><i class="fas fa-shopping-basket"></i> 2 menu</div>
                        </div>
                        <div class="btn btn-theme-secondary">Rp. 345.000 <i class="fas fa-angle-right"></i> </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- //GLOBAL  CART -->

        <!-- =================================================================
        MODAL
        ================================================================== -->


        <!-- Modal -->
        <div class="modal fade" id="modal-global-search" tabindex="-1" aria-labelledby="modal-global-search" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen-sm-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <form class="w-100" onsubmit="return false">
                        <div class="merchant-search me-3">
                            <div class="form-group has-search">
                                <input type="text" class="form-control" id="search-merchant" placeholder="What do you want to eat today?">
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
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

        <script>
            // search
            $('#search-merchant, #searchSomething').on('keyup click',function () {
                let search = $(this).val();
                $.get("{{route('search-oobe-indonesia')}}",{search:search},function (data) {
                    $('#list-search-product').html(data);
                })
            })

            // pick-store
            $('.pick-store').on('click',function () {
                let merchantId = $(this).data('id');
                $.get("{{route('index-store-order')}}",{merchantId:merchantId},function(data) {
                    $('#main-content').html(data);
                })
            })

            //jquery
            $(function(){
                var textbox = $('.textbox'),
                captionLength = 0,
                caption = '',
                id = setTimeout(TypingEffect, 2000);
                function TypingEffect() {
                    var tag = Math.floor((Math.random() * 6) + 1);

                    if (tag == 1) {
                        caption = "Best sushi"
                    }
                    if (tag == 2) {
                        caption = "Chicken karage"
                    }
                    if (tag == 3) {
                        caption = "Friday promo"
                    }
                    if (tag == 4) {
                        caption = "Promo 7.7"
                    }
                    if (tag == 5) {
                        caption = "Es kopi susu"
                    }
                    if (tag == 6) {
                        caption = "Burger keju"
                    }

                    clearTimeout(id); //clear first clearTimeout(TypingEffect, 600) call
                    captionLength = 1; //start at 0
                    id = setInterval(type, 50); //call type every 50ms
                }

                function type() {
                    textbox.attr("placeholder", caption.substring(0, captionLength++));
                    if (captionLength === caption.length + 1) {
                    clearInterval(id); //clear clearInterval(type, 50)
                    id = setTimeout(ErasingEffect, 1000); //start ErasingEffect call once after delay
                    }
                }

                function ErasingEffect() {
                    clearTimeout(id); //clear clearTimeout(ErasingEffect, 2000); call
                    captionLength = caption.length; //start at end
                    id = setInterval(erase, 50); //call erase every 50ms
                }

                function erase() {
                    textbox.attr("placeholder", caption.substring(0, captionLength--));
                    if (captionLength < 0) {
                        clearInterval(id); //clear clearInterval(erase, 50)
                        id = setTimeout(TypingEffect, 1000); //start over
                    }
                }

                //banner hero sliders
                $('.banner-hero').slick({
                    dots: true,
                    infinite: false,
                    slidesToShow:1,
                    arrows: false,
                    autoplay: true,
                    autoplaySpeed: 4000,
                    speed: 300,
                });

                //merchant sliders
                $('.merchant-list').slick({
                    dots: false,
                    infinite: false,
                    arrows: false,
                    autoplay: false,
                    speed: 300,
                    slidesToShow: 3,
                });
                $('.merchant-h').slick({
                    dots: false,
                    infinite: false,
                    arrows: false,
                    autoplay: false,
                    speed: 300,
                    slidesToShow: 2,
                    variableWidth: true
                });

                //stciky search


            });
        </script>

@endsection
