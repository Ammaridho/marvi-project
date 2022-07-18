@extends('sushimoo.layouts.main')

@section('content')
    <!-- 
        MENU CATEGORY
    -->
    <section>
        <div class="container-fluid g-0 container-mobile mb-5 bg-theme-primary-light vh-100">
            <div class="row">
                <div class="col-12">
                    <ul class="list-unstyled sm-menu text-uppercase font-openSans">

                        @foreach ($categories as $item)
                            
                            <li><a href="{{ route('Master-Menu.listProduct',['id' => $item->id]) }}" class="menuCategories">{{$item->category_name}} <span class="float-end pr-2"><i class="fas fa-chevron-right"></i></span></a></li>
                        
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </section>

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
    <script>
        // $('.menuCategories').on('click',function () {
        //     // alert('test');
        //     let idCategory = $(this).data('id');
        //     $.get(`{{ route('Master-Menu.listProduct',['id'=>1]) }}`,{idCategory:idCategory},function (data) {
        //         $(".content").html(data);
        //     })
        // })
    </script>
@endsection     

