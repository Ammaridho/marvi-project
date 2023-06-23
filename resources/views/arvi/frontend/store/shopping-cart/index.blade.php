<div class="modal-body m-0 p-0">

    <ul class="list-unstyled m-0 p-0 list-cart scroll">
        @if (count($shoppingCarts)<1)
        <li>
            <div class="d-flex align-items-center justify-content-between">                
                <div class="text-theme-primary fw-bold">
                    Empty, please choose product!
                </div>
            </div>
        </li>
        @endif
            {{-- <li class="test-showhide-loader">
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
        </li> --}}
        
        @if (count($shoppingCarts)>0)
        
            @foreach ($shoppingCarts as $key => $item)
            <li>
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <a href="{{route('show-store-order-store',['code'=>$code,'productId' => 
                        $item['product']['id'] , 'cartId' => $key])}}">
                        <div class="d-flex">
                            <div class="me-2">
                                @if (isset($item['product']['url']))
                                    @if ($item['product']['url'] != 'url')
                                        <div class="img-wrapper-cart" 
                                        style="background-image: url('/storage/arvi/backend-assets/img/products/brands/{{
                                        $item['product']['url']}}');">
                                        </div>
                                    @elseif($item['product']['image_mime'])
                                        <div class="img-wrapper-cart" 
                                        style="background-image: url('/arvi/assets/img/products/{{
                                            $item['product']['image_mime'].'.'.$item['product']['image_type']}}');">
                                        </div>
                                    @endif
                                @else
                                    <div class="img-wrapper-cart" 
                                        style="background-image: 
                                            url('/arvi/backend-assets/img/default/product.jpg');">
                                    </div>
                                @endif
                            </div>
                            <div class="detail-product">
                                <div class="small">
                                    {{$item['product']['merchantName']}} 
                                </div>
                                <div class="fw-bold text-theme-primary box box--responsive">
                                    {{$item['product']['name']}}
                                </div>
                                <!-- variant -->
                                @if ($item['variant'])
                                    <div class="small">
                                        <strong>Variant: </strong>
                                        {{$item['variant']['name']}}
                                    </div>
                                @endif
                                <!-- attribute -->
                                @if ($item['attribute'])
                                <div class="small">
                                    <strong>Extra Condiments: </strong><br>
                                        @foreach ($item['attribute'] as $item1)
                                            - {{$item1['name']}} 
                                            {{$item1['qty']>1?$item1['qty'].'x':''}}
                                            <br>
                                        @endforeach
                                    </div>
                                @endif
                                <!-- extra-attribute -->
                                @if ($item['extraAttribute'])
                                <div class="small">
                                    <strong>Extra Cutlery: </strong><br>
                                        @foreach ($item['extraAttribute'] as $item2)
                                            - {{$item2['name']}} 
                                            {{$item2['qty']>1?$item2['qty'].'x':''}}
                                            <br>
                                        @endforeach
                                    </div>
                                @endif
                                <!-- note -->
                                @if ($item['note'])
                                    <div class="small">
                                        <strong>Notes: </strong>
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
                            <span class="total-price-product" 
                            data-price="{{$item['totalPricePerProduct'] * $item['qty']}}">
                                {{number_format($item['totalPricePerProduct'] * $item['qty'])}}
                            </span>
                        </div>
                        <!-- count -->
                        <div class="counter-lg text-center" id="field3">
                            <button class="counter-btn min subc 
                            text-theme-primary-dark qty-product">
                                @if ($item['qty'] > 1)
                                    <i class="fas fa-minus"></i>
                                @else
                                    <i class='far fa-trash-alt'></i>
                                @endif
                            </button>
                            <input type="number" name="qty" class="field qty 
                            qty-product" data-id="{{$key}}"
                            data-price="{{$item['totalPricePerProduct']}}" 
                            data-weight="{{$item['weight']}}" maxlength="12" 
                            min="1" value="{{$item['qty']}}" readonly/>
                            <button class="counter-btn addc 
                            text-theme-primary-dark qty-product">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach

            <li class="spacer"></li>
            <li class="m-0 p-0 fixed-bottom btn-checkout border-top">
                <div class="d-grid">

                    <form id="cart-form" action="{{route('delivery-checkout-store',['code'=>$code])}}" method="POST">
                        @csrf
                        <input type="hidden" name="cart" value="">
                    </form>

                    <button type="button" onclick="document.getElementById('cart-form').submit();" 
                    class="btn btn-theme-secondary p-0 text-light">
                        <div class="d-flex justify-content-between align-items-center px-2">
                            <div class="text-start small lh-sm">
                                <span id="count-item-cart"></span> items<br />
                                Orders from {{$countUniqStore}} store
                            </div>
                            <div>
                                <!-- LOADING STATE 
                                when items still loading remove .d-none
                                -->
                                <div class="ol-price-loader loading d-none"></div>
                                <!-- //LOADING STATE -->
                                {{reset($shoppingCarts)['product']['currency']}} 
                                <span id="all-price-total">0</span>
                            </div>
                        </div>
                    </button>
                </div>
            </li>
        @else
            <li class="spacer"></li>
            <li class="m-0 p-0 fixed-bottom btn-checkout border-top">
                <div class="d-grid">
                    <button type="button" class="btn btn-theme-secondary p-0" disabled>
                        <div class="d-flex justify-content-between align-items-center px-2">
                            <div>
                                <!-- LOADING STATE 
                                when items still loading remove .d-none
                                -->
                                <div class="ol-price-loader loading d-none"></div>
                                <!-- //LOADING STATE -->
                                Empty!
                            </div>
                        </div>
                    </button>
                </div>
            </li>
        @endif

    </ul>
</div>

<script>
    // set value cart
    $("input[name='cart']").val(sessionStorage.getItem('cart-oobe-store'))

    // get quantity item
    cart = JSON.parse(sessionStorage.getItem('cart-oobe-store'));
    if (cart && cart.length > 0) {
        $('#count-item-cart').text(cart.length);
    }

    $(function(){
        //Count + -
        $('.addc').click(function () {
            $(this).prev().val(+$(this).prev().val() + 1);
        });
        $('.subc').click(function () {
            if ($(this).next().val() > 0) 
            $(this).next().val(+$(this).next().val() - 1);
        });
    });

    $(document).ready(function(){
        sumAllPrice()
        $("button.qty-product").on('click',function () {
            qty = $(this).siblings('.qty').val();
            price = $(this).siblings('.qty').data('price');
            weight = $(this).siblings('.qty').data('weight');
            if (qty > 0) {
                let total = toFixedIfNecessary((qty * price));
                let totalWeight = toFixedIfNecessary((qty * weight));
                // price product total
                $(this).parent().siblings().children('.total-price-product').
                text(total.toLocaleString('en-US'));
                $(this).parent().siblings().children('.total-price-product').
                data('price',total);
                // qty detail (left)
                $(this).parent().parent().siblings().children().children()
                .children('.detail-product').children('.price-detail')
                .children('.product-qty').text(qty);
                sumAllPrice();
                // update session cart
                cart = JSON.parse(sessionStorage.getItem('cart-oobe-store'));
                key = $(this).siblings('.qty').data('id');
                Object.assign(cart[key],{qty:qty,totalPriceAll:total,totalWeight:totalWeight});
                sessionStorage.setItem('cart-oobe-store', JSON.stringify(cart));
                if (qty == 1) {
                    $(this).parent().children('.min').
                    html(`<i class='far fa-trash-alt'></i>`);
                }else{
                    $(this).parent().children('.min').
                    html(`<i class="fas fa-minus"></i>`);
                }
            }else{
                // update session cart
                cart = JSON.parse(sessionStorage.getItem('cart-oobe-store'));
                key = $(this).siblings('.qty').data('id');
                cart.splice(key,1);
                sessionStorage.setItem('cart-oobe-store', JSON.stringify(cart));
                location.reload();
                // reopen cart
                $.get("{{route('index-shopping-cart')}}",
                {cart:JSON.parse(sessionStorage.getItem('cart-oobe-store'))},function (data) {
                    $('#view-all-cart').html(data);
                })
            }
        })
    });

    function toFixedIfNecessary(value){
        return +parseFloat(value).toFixed( 2 );
    }

    // total all price
    function sumAllPrice() {
        var sum = 0;
        $('.total-price-product').each(function () {
            sum += parseFloat($(this).data('price'));
        })
        $('#all-price-total').text(toFixedIfNecessary(sum).toLocaleString('en-US'));
    }

    
</script>