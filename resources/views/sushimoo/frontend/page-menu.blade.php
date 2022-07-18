@extends('sushimoo.layouts.main')

@section('content')
    <!-- 
        MENU
    -->
    
    <!-- GLOBAL  CART -->
    <div class="fixed-bottom">
        <div class="container-mobile">
            <a href="{{ route('cart.') }}" class="no-underline">
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

    <section class="">
    
        <div class="container-mobile">
            <div class="header-menu text-center text-white ">
                <a href="javascript: void(0);" class="text-white goHome" onclick="history.back()">
                    <div class="closeModaal"><i class="fas fa-chevron-left"></i></div>
                </a>
                <div class="fw-600 text-uppercase pt-3">ID Category = {{$idCategory}};  Personal Platter</div>
            </div>
            <div class="subSummary p-3 text-gray small">
                Fit for 1 Sushi Enthusiast.
            </div>
            <div class="container-mobile mt-4">
                <ul class="list-unstyled sub-menuList">

                    @foreach ($products as $item)
                        <!-- menu 1 -->
                        <li><a href="{{ route('Master-Menu.detailProduct',['id' => $item->id]) }}" class="detailProduct" data-id="{{$item->id}}">
                            <div class="container-fluid">
                                <div class="row g-3">
                                    <div class="col-4">
                                        <div class="img-wrapper" style="background-image: url(/sushimoo/assets/img/menus/Mito.png);"></div>
                                    </div>
                                    <div class="col-8">
                                        <h5 class="fw-bolder text-dark-green text-uppercase">{{$item->name}}</h5>
                                        <div class="small">{{$item->description}}</div>
                                        <div class="sub-price mb-10 mt-10 pr-2 text-right">
                                            <span class="float-right fs-5 fw-bolder text-danger">{{$item->retail_price}} <span class="pl-1 pr-2"><i class="fas fa-chevron-right text-gray"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a></li>
                        <!-- //menu 1 -->
                    @endforeach

                
                </ul>
            </div>
        </div>
    </section>

    {{-- <script>
        // go home
        // go home
        $('.goHome').on('click',function () {
            // $.get("{{ route('Master-Menu.listCategory') }}",function (data) {
            //     $(".content").html(data);
            // })

            window.location = "/o";
        })
        // go detail Product
        $('.detailProduct').on('click',function () {
            let idProduct = $(this).data('id');
            $.get("{{ route('Master-Menu.detailProduct',['id'=>1]) }}",{idProduct:idProduct},function (data) {
                $(".content").html(data);
            })
        })
    </script> --}}

@endsection  