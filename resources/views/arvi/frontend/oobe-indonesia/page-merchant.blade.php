@extends('arvi.frontend.oobe-indonesia.layouts.main')
@section('content')

    <section class="section-first">
        <div class="container-fluid g-0 container-xs px-2 pt-2">
            @if (isset($merchant->image_url))
                <div class="img-hero-lg" 
                style="background-image: url('/storage/arvi/backend-assets/img/logo/merchants/{{$merchant->image_url}}')">
            @else
                <div class="img-hero-lg" 
                style="background-image: url('/frontend-oobe-indonesia/assets/img/menus/default-image-cover.jpg')">
            @endif
                <div class="mt-2 ms-2">
                    <a href="{{route('index-oobe')}}">
                        <div class="btn-back">
                            <i class="fas fa-angle-left text-white"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="merchant-pull">
            <div class="container-fluid g-0 container-xs">
                <div class="card border-0 shadow-sm mx-3">
                    <div class="card-body">
                        
                        <div class="float-end hidden">
                            <a href="#"><i class="far fa-heart"></i></a>
                        </div>
                        <div class="d-flex">
                            <div>
                                @if (isset($merchant->logo))
                                    <div class="py-2 px-4 border rounded img-brand-logo" 
                                    style="background-image: url('/storage/arvi/backend-assets/img/logo/brands/{{$merchant->logo}}')">
                                @else
                                    <div class="py-2 px-4 border rounded img-brand-logo" 
                                    style="background-image: url('/frontend-oobe-indonesia/assets/img/merchant/default-brand-logo.png')">
                                @endif
                                </div>
                            </div>
                            <div class="ms-2">
                                <div class="fw-bold fs-4">{{$merchant->name}}</div>
                                <div class="text-muted small">{{$merchant->description}}</div>
                                <div class="text-muted small hidden">
                                    <i class="fas fa-star text-theme-primary"></i> 4.8 (7251)
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-merchant-push"></section>
    <div class="search-box bg-white w-100 sticky container-xs p-2">
        <div class="menu-warp-container">
            <div class="menu-warp">
                <ul class="list-inline m-0 p-0 merchant-list-menu">
                    @foreach ($listProduct as $key => $item)
                        @if ($key != 'noCategory')
                            <li class="list-inline-item"><a href="#c-{{$key}}">{{$key}}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <section class="section-last">
        <div class="container-fluid container-xs mt-4">

            

            <!-- list item in category -->
            {{-- <h6 class="fw-bold" id="menu-cat-1">Promo EZO</h6> --}}
            <div class="card-menu">

                <!-- 
                    SKLETEON LOADER FOR LIST ITEM
                    USED THIS to load each loading items
                -->
                {{-- <div class="card shadow-sm test-showhide-loader">
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
                <!--  //SKLETEON LOADER--> --}}

                @foreach ($listProduct as $category => $products)
                    <!-- list item in category -->
                    @if ($category != 'noCategory')
                        <h6 class="fw-bold" id="c-{{$category}}">{{$category}}</h6>
                    @endif
                    {{-- product in category --}}
                    @foreach ($products as $item)
                    <div class="card shadow-sm">
                        <div class="card-body listitem">
                            <a href="{{route('show-store-order',['productId' => $item['merchant_products_id'] ])}}">
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
                                            substr($item['name'],0,25)."..." : $item['name'];?></div>
                                        <div class="fs-6"><?=strlen($item['description']) > 100 ? 
                                            substr($item['description'],0,100)."..." : $item['description'];?></div>
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
                    <!-- // list item in category -->
                @endforeach


            </div>
        </div>
    </section>

    <!-- =================================================================
    MODAL
    ================================================================== -->

    <!-- Modal -->
    <div class="modal fade" id="modal-merchant-search" tabindex="-1" 
    aria-labelledby="modal-merchant-search" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <form class="w-100" onsubmit="return false">
                    <div class="merchant-search me-3">
                        <div class="form-group has-search">
                            <input type="text" class="form-control" id="search-merchant" 
                            placeholder="What do you want to eat today?">
                            <span class="fa fa-search form-control-feedback"></span>
                            <button type="reset">&times;</button>
                        </div>
                    </div>
                    </form>
                    <a href="#" data-bs-dismiss="modal" class="small text-danger" >Cancel</a>
                </div>
                <div class="modal-body">
                    
                    <!-- no data in menu 
                    Seach  by typing on input menu min 3 letters
                    -->
                    <div class="text-center text-muted my-2">
                        <img src="/frontend-oobe-indonesia/assets/img/not-available-menu.png" class="mb-2 img-fluid">
                        <h2 class="m-0">Oh no!</h2>
                        Your search seems to be missing from our kitchen. Please try something else :)
                    </div>
                    <!-- //no data in menu -->

                    <!-- ajax search result -->
                    <div class="card-menu mt-2">
                        <!-- loader -->
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
                        <!-- loader -->

                        <div class="card shadow-sm">
                            <div class="card-body listitem">
                                <a href="page-product.php">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="img-wrapper-sm" 
                                        style="background-image: url('/frontend-oobe-indonesia/assets/img/menus/Izumi_thumb.jpg');"></div>
                                    </div>
                                    <div class="px-3">
                                        <div class="fw-bold"><?=strlen('Izumi Platter') > 25 ? 
                                            substr('Izumi Platter',0,25)."..." : 'Izumi Platter';?></div>
                                        <div class="fs-6">Halal & healthy beef form farmers.</div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="fw-bold fs-5 text-theme-primary">Rp 176.000</div>
                                            <div>
                                                <div class="ms-3 small">
                                                    <i class="fas fa-star text-theme-primary"></i> 4.4
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>

                        <div class="card shadow-sm">
                            <div class="card-body listitem">
                                <a href="page-product.php">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="img-wrapper-sm" 
                                        style="background-image: url('/frontend-oobe-indonesia/assets/img/menus/Oishimoo_thumb.jpg');"></div>
                                    </div>
                                    <div class="px-3">
                                        <div class="fw-bold"></div>
                                        <div class="fw-bold"><?=strlen('Beef Teriyaki Onigiri (Sushi Rice)') > 25 ? 
                                            substr('Beef Teriyaki Onigiri (Sushi Rice)',0,25)."..." :
                                             'Beef Teriyaki Onigiri (Sushi Rice)';?></div>
                                        <div class="fs-6">Halal & healthy beef form farmers.</div>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-bold fs-5 text-theme-primary">
                                                Rp 56.000
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
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript" src="/frontend-oobe-indonesia/assets/js/app.js"></script>

    <script>
        $(function(){
            //smooth scroll
            $(".merchant-list-menu li a[href^='#']").click(function(event){
                $('html, body').stop().animate({
                    scrollTop: $($.attr(this, 'href')).offset().top - 125
                }, 600);
                $('.search-box').addClass('shadow');
                //e.preventDefault();
            });

            $(window).scroll(function() {
            var scroll = $(window).scrollTop();
                if (scroll <= 60) {
                    $(".search-box").removeClass("shadow");
                    return;
                }
                if (scroll >= 60) {
                    $(".search-box").addClass("shadow");
                }   
            });

            $('.merchant-list-menu').slick({
                dots: false,
                infinite: false,
                slidesToShow:2,
                arrows: false,
                autoplay: false,
                speed: 300,
            });

        });
    </script>
    </body>
</html>  
@endsection