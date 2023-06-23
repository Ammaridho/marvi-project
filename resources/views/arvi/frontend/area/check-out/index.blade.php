    <section class="section-first">
        <div class="container-fluid container-xs mt-2">

            <div class="mt-5">
                <div class="d-flex">
                    <div>
                        <h5>Your orders</h5>
                    </div>
                </div>
                <div class="mt-2">
                    <ul class="list-unstyled m-0 p-0 list-cart">
                        <!-- 
                            SKLETEON LOADER FOR LIST ITEM
                            USED THIS to load each loading items
                        -->
                        {{-- <li id="item0">
                            <div class="d-flex ol-loader-sm">
                                <div class="ol-img loading"></div>
                                <div class="ol-more">
                                    <div class="ol-title loading"></div>
                                    <div class="ol-desc loading"></div>
                                    <div class="ol-price loading"></div>
                                </div>
                            </div>
                        </li> --}}
                        <!-- //SKLETEON LOADER FOR LIST ITEM-->
                        {{-- {{dd($shoppingCarts)}} --}}
                        @if (count($shoppingCarts)>0)
                            @foreach ($shoppingCarts as $key => $item)
                
                            <li>
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <a href="{{route('show-store-order-area',
                                        ['code'=>$code,'productId' => $item['product']['id'] , 'cartId' => $key])}}">
                                        <div class="d-flex">
                                            <div class="me-2">
                                                @if ($item['product']['url'] != 'url')
                                                    <div class="img-wrapper-cart" 
                                                        style="background-image: 
                                                        url('/arvi/backend-assets/img/products/brands/{{
                                                        $item['product']['url']}}');">
                                                    </div>
                                                @elseif($item['product']['image_mime'])
                                                    <div class="img-wrapper-cart" 
                                                        style="background-image: 
                                                        url('/arvi/assets/img/products/{{
                                                        $item['product']['image_mime'].'.'
                                                        .$item['product']['image_type']}}');">
                                                    </div>
                                                @else
                                                    <div class="img-wrapper-cart" 
                                                        style="background-image: 
                                                        url('/arvi/backend-assets/img/default/product.jpg');">
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="detail-product">
                                                <div class="small">{{$item['product']['merchantName']}} </div>
                                                <div class="fw-bold text-theme-primary box box--responsive">
                                                    {{$item['product']['name']}}
                                                </div>
                                                <!-- variant -->
                                                @if ($item['variant'])
                                                    <div class="small">
                                                        <strong>Variant: </strong>{{$item['variant']['name']}}
                                                    </div>
                                                @endif
                                                <!-- attribute -->
                                                @if ($item['attribute'])
                                                    <div class="small">
                                                    <strong>Extra Condiments: </strong>
                                                    @foreach ($item['attribute'] as $item1)
                                                        <br>
                                                        - {{$item1['name']}} 
                                                        {{$item1['qty']>1?$item1['qty'].'x':''}}
                                                    @endforeach
                                                    </div>
                                                @endif
                                                <!-- extra-attribute -->
                                                @if ($item['extraAttribute'])
                                                    <div class="small">
                                                    <strong>Extra Cutlery: </strong>
                                                    @foreach ($item['extraAttribute'] as $item2)
                                                        <br>
                                                        - {{$item2['name']}} 
                                                        {{$item2['qty']>1?$item2['qty'].'x':''}}
                                                    @endforeach
                                                    </div>
                                                @endif
                                                <!-- note -->
                                                @if ($item['note'])
                                                    <div class="small">
                                                        <strong>Notes: </strong>
                                                        <br>
                                                        {{$item['note']}}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        </a>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-center mb-2">
                                            {{$item['product']['currency']}} 
                                            <span class="total-price-product tpp">
                                                {{$item['totalPricePerProduct'] * $item['qty']}}
                                            </span>
                                        </div>
                                        <!-- count -->
                                        <div class="counter-lg text-center" id="field3">
                                            <button class="counter-btn min subcc 
                                            text-theme-primary-dark qty-product">
                                                @if ($item['qty'] > 1)
                                                    <i class="fas fa-minus"></i>
                                                @else
                                                    <i class='far fa-trash-alt'></i>
                                                @endif
                                            </button>
                                            <input type="number" name="qty" 
                                            class="field qty qty-product" data-id="{{$key}}"
                                            data-price="{{$item['totalPricePerProduct']}}" 
                                            maxlength="12" min="1" value="{{$item['qty']}}" readonly/>
                                            <button class="counter-btn addcc text-theme-primary-dark 
                                            qty-product"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            
                            @endforeach
                        @else
                            <h1 class="text-center">Product Empty, Please choose Product!</h1>
                        @endif
                        
                    </uL>
                </div>
            </div>
        </div>
    </section>

    <section class="section-last">
        <div class="fixed-bottom bg-white border-top">
            <div class="container-fluid container-xs">
                <div class="d-grid my-2">
                    <button class="btn btn-theme-secondary 
                    py-2 text-theme-primary-dark text-white" 
                    type="button" id="confirm-products"
                    @if (!(count($shoppingCarts)>0))
                        disabled
                    @endif>
                        <div class="d-flex justify-content-between">
                            <div>Confirm orders    </div>
                            @if (count($shoppingCarts)>0)
                                <div class="fw-bold">
                                    {{reset($shoppingCarts)['product']['currency']}} 
                                    <span id="all-price">0</span> 
                                </div>
                            @endif
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- =================================================================
    MODAL
    ================================================================== -->
    <!-- modal remove item -->
    <div class="modal fade" id="modalRemoveItem" aria-hidden="true" data-backdrop="static"
    aria-labelledby="modalRemoveItem" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center fw-bold">Are you sure to remove this item?</div>
                </div>
                <div class="modal-footer border-0 justify-content-between">
                    <div class="flex-grow-1">
                        <div class="d-grid">
                            <button type="button" class="btn btn-sm btn-outline-secondary 
                            confirm-remove-product" data-bs-dismiss="modal" >Cancel</button>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-grid">
                            <button type="button" class="btn btn-sm btn-theme-secondary 
                            confirm-remove-product" data-type="yes"
                            data-bs-dismiss="modal">Yes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //modal remove item -->

    <script>

    // checkout
    $('#confirm-products').on('click',function () {
        $.ajax({
            url: '{{route("delivery-checkout-area",['code'=>$code])}}',
            type: "post",
            data: {"_token": "{{ csrf_token() }}",cart:sessionStorage.getItem('cart')} ,
            success: function (data) {
                $('#main-content').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            }
        });
    })

    window.onbeforeunload = function(event)
    {
        return confirm("Confirm refresh");
    };

    $(function(){
        //Count + -
        $('.addcc').click(function () {
            $(this).prev().val(+$(this).prev().val() + 1);
        });
        $('.subcc').click(function () {
            $(this).next().val(+$(this).next().val() - 1);
        });
    });

    $(document).ready(function(){
        sumAllPrice();
        $('.shopping-cart').hide();
        $("button.qty-product").on('click',function () {
            qty = $(this).siblings('.qty').val();
            price = $(this).siblings('.qty').data('price');
            var data = $(this);
            
            if (qty > 0) {
                let total = Math.round((qty * price) * 100) / 100;
                // price product total
                $(this).parent().siblings().children('.total-price-product').text(total);
                // qty detail (left)
                $(this).parent().parent().siblings().children().children()
                .children('.detail-product').children('.price-detail')
                .children('.product-qty').text(qty);
                sumAllPrice()

                // update session cart
                cart = JSON.parse(sessionStorage.getItem('cart'));
                key = $(this).siblings('.qty').data('id');
                Object.assign(cart[key],{qty:qty,totalPriceAll:total});
                sessionStorage.setItem('cart-oobe-indonesia-area', JSON.stringify(cart));
                
                if (qty == 1) {
                    $(this).parent().children('.min').html(`<i class='far fa-trash-alt delete-product'></i>`);
                }else{
                    $(this).parent().children('.min').html(`<i class="fas fa-minus"></i>`);
                }
            }
            else{
                key = $(this).siblings('.qty').data('id');
                $('.confirm-remove-product').data('key',key);
                $('#modalRemoveItem').modal('show');
            }
        })
    });

    $('.confirm-remove-product').on('click',function () {
        $(`[data-id="${key}"].qty-product`).val(1);
        key = $(this).data('key');
        type = $(this).data('type');
        if (typeof type !== 'undefined') {
            cart = JSON.parse(sessionStorage.getItem('cart'));
            cart.splice(key,1);
            sessionStorage.setItem('cart-oobe-indonesia-area', JSON.stringify(cart));
            // reopen cart
            $.ajax({
                url: '{{route("list-checkout-area",['code'=>$code])}}',
                type: "post",
                data: {"_token": "{{ csrf_token() }}",
                cart:sessionStorage.getItem('cart')} ,
                success: function (data) {
                    $('#main-content').html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
                }
            });
        } 
    })

    // total all price
    function sumAllPrice() {
        var sum = 0;
        $('.tpp').each(function () {
            sum += parseFloat($(this).text());
        })
        $('#all-price').text(Math.round(sum * 100) / 100);
    }
    </script>
    </body>
</html>  