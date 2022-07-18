@extends('sushimoo.layouts.main')

@section('content')

    
<form action="{{ route('cart.store',['id'=>$product->id]) }}" method="post">

    @csrf

    <!-- DETAIL -->
    <div class="container-mobile">
        <div class="container-detail">
            <div class="d-flex img-wrapper-modal justify-content-between align-items-center" style="background-image: url(/sushimoo/assets/img/menus/Mito.png);">

                <a href="javascript:void(0);" class="text-white" onclick="history.back()">
                <div class="btn-closed">
                    <i class="fas fa-angle-left"></i>
                </div>
                </a>

                <input type="hidden" name="idProduct" value="{{$product->id}}">
                
                <div class="counter-lg" id="field3">
                    <button type="button" class="counter-btn minus qp"><i class="fas fa-minus"></i></button>
                    <input type="number" name="qtyProduct" class="field" min="1" maxlength="12" value="1" readonly/>
                    <button type="button" class="counter-btn plus qp" ><i class="fas fa-plus"></i></button>
                </div>


            </div>
            <div class="mt-3 mx-3">
                <div class="fs-4">{{$product->name}}</div>
                <div class="fs-5 text-danger fw-bold" id="retail-price">{{$product->retail_price}}</div>
                <div class="small text-muted">{{$product->description}}</div>

                <div class="border-dotted mt-3"></div>

                <div class="d-flex justify-content-between mt-3 mb-3">
                    <div><strong>Extra Condiments</strong> <span class="text-muted small">Optional</span></div>
                    <div></div>
                </div>
                

                @foreach ($extraAtributesCondiments as $item)
                    
                <div class="d-flex justify-content-between mt-3 mb-3">
                    <div class="mt-1">{{$item->name}} <span>(+ {{$item->currency}} {{$item->fee}})</span></div>
                    <div class="counter">
                        <button type="button" class="counter-btn sub"><i class="fas fa-minus"></i></button>
                        <input type="number" name="extraCon[{{$item->id}}]" class="field" id="1" maxlength="12" value="0" readonly/>
                        <button type="button" class="counter-btn add"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                
                @endforeach

                <div class="border-dotted mt-2"></div>

                <div class="d-flex justify-content-between mt-3 mb-3">
                    <div><strong>Extra Cutlery</strong> <span class="text-muted small">Optional</span></div>
                    <div></div>
                </div>

                @foreach ($extraAtributesCutlery as $item)
                    <div class="d-flex justify-content-between mt-3 mb-3">
                        <div class="mt-1">{{$item->name}}  <span>(+ {{$item->currency}} {{$item->fee}})</span></div>
                        <div class="counter">
                            <button type="button" class="counter-btn sub"><i class="fas fa-minus"></i></button>
                            <input type="number" name="extraCut[{{$item->id}}]" class="field" id="4" maxlength="12" value="0" readonly/>
                            <button type="button" class="counter-btn add"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                @endforeach

                <div class="border-dotted mt-2"></div>

                <div class="d-flex justify-content-between mt-3 mb-3">
                    <div><strong>Tambah catatan</strong> <span class="text-muted small">Optional</span></div>
                    <div><span class="rchars small text-muted"></span></div>
                </div>
                <div class="mt-3 mb-3">
                    <textarea name="notesProduct" placeholder="Example: Make my dish awesome like always!" class="area-notes"></textarea>
                </div>

            </div>
        </div>
    </div>

    <!-- ITEM CART -->
    <div class="fixed-bottom">
        <div class="container-mobile">
            <div class="no-underline">
                <div class="d-flex justify-content-between align-items-center status-cart shadow"><!-- add .empty if any there's NO selection has been made -->
                    <div>
                        <button type="submit" class="no-underline">
                            <div class="f-16 text-uppercase">Tambah ke pesanan</div>
                        </button>
                    </div>
                    <a href="{{ route('cart.') }}">
                        <div class="btn btn-theme-secondary">Rp. 123.456</div>
                    </a>
                </div>
                </div>
            
        </div>
    </div>

</form>

<?php //dd(session('cart'));?>

    <script>

        var price = parseInt({{ $product->retail_price }});
        
        //count price product
        $('.minus').click(function () {
            var input = $(this).parent().find('input');
            var count = parseInt(input.val()) - 1;
            count = count < 1 ? 1 : count;
            input.val(count);
            $('#retail-price').html(count*price);
            input.change();
            return false;
          });
          $('.plus').click(function () {
              var input = $(this).parent().find('input');
              input.val(parseInt(input.val()) + 1);
              count = input.val();
              $('#retail-price').html(count*price);
              input.change();
              return false;
          });


    </script>

@endsection  