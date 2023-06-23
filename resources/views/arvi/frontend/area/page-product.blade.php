@extends('arvi.frontend.area.layouts.main')
@section('content')
    
    <section class="section-first">
        <div class="container-fluid container-xs px-2 pt-2">
            @if ($product->url != 'url' && isset($product->url))
                <div class="img-hero-product" 
                style="background-image: 
                url('/arvi/backend-assets/img/products/brands/{{$product->url}}');">
            @else
                <div class="img-hero-product" style="background-image: 
                url('/arvi/backend-assets/img/default/product.jpg')">
            @endif
                <div class="mt-2 ms-2 ">
                    <a href="{{route('index-area',['code'=>$code ])}}">
                        <div class="btn-back"><i class="fas fa-angle-left text-white"></i></div>
                    </a>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-end">
                <div class="me-3">
                    <h5 class="p-0 mt-3 mb-1">{{$product->name}}</h5>
                    <div class="fs-4 text-theme-primary fw-bold">{{$product->currency}}. 
                        <span id="itemPrice">{{$product->retail_price}}</span></div>
                </div>
                
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid container-xs mt-2">
            <div class="me-2">
                <div class="text-muted small hidden">
                    <i class="fas fa-star text-theme-primary"></i> <strong>4.8</strong> (7251)
                </div>
                <div class="text-muted">{{$product->description}}</div>
            </div>
        </div>
    </section>

    @if (count($productVariants) > 0)
    <section>
        <div class="container-fluid container-xs mt-2">
            <div class="d-flex justify-content-between mt-3 mb-2">
                <div>
                    <strong>Variant</strong>  
                    <span class="text-muted small">Required</span>
                </div>
                <div></div>
            </div>
            <div id="variantpHelp" class="form-text text-danger d-none">
                Please choose variant.
            </div>
            @foreach ($productVariants as $key => $item)
                <!-- variant --->
                <div class="d-flex justify-content-between mb-2 pb-2 
                {{$key+1 == count($productVariants) ? 'by-2':'border-bottom my-2'}}">
                    <div class="mt-1 w-100">
                        <label class="w-100" for="sample1">
                            <div class="d-flex justify-content-between">
                                <div>{{$item->name}}</div>
                                @if ($item->retail_price > 0)
                                    <div class="mt-1"> 
                                        <span>(+ {{$item->currency_price}} {{$item->retail_price}})</span>
                                    </div>
                                @else
                                    <div>Free</div>
                                @endif
                            </div>
                        </label>
                    </div>
                    <div class="ms-2 form-check mt-1">
                        <input class="form-check-input countAllInput variant" type="radio" 
                        name="variant" id="sample1" value="{{$item->id}}" 
                        data-price="{{$item->retail_price}}">
                    </div>
                </div>
                <!-- //variant -->
            @endforeach
        </div>
    </section>
    @endif

    @if (count($productAttributes) > 0)
    <section class="devider"></section>

    <section>
        <div class="container-fluid container-xs mt-2">
            <div class="mt-3">
                <div class="d-flex justify-content-between mt-3 mb-3">
                    <div>
                        <strong>Extra Condiments</strong> 
                        <span class="text-muted small">Optional</span>
                    </div>
                    <div></div>
                </div>
                @foreach ($productAttributes as $key => $item)
                <div class="d-flex justify-content-between pb-2 
                {{$key+1 == count($productAttributes) ? 'by-2':'border-bottom my-2'}}">
                    <div class="mt-1">{{$item->name}} 
                        @if ($item->retail_price > 0)
                            <span>(+ {{$item->currency}} {{$item->retail_price}})</span>
                        @else
                            <span>(Free)</span>
                        @endif
                    </div>
                    <div class="counter">
                        <button type="button"  class="counter-btn sub countAllInput">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" name="qtyAttribute" class="field qtyAttribute" 
                        maxlength="12" value="0" readonly 
                        data-price="{{$item->retail_price}}" data-id="{{$item->id}}"/>
                        <button type="button" class="counter-btn add countAllInput">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if (count($extraAttributes) > 0)
    <section class="devider"></section>

    <section>
        <div class="container-fluid container-xs mt-2">
            <div class="mt-3">
                <div class="d-flex justify-content-between mt-3 mb-3">
                    <div>
                        <strong>Extra Cutlery</strong> 
                        <span class="text-muted small">Optional</span>
                    </div>
                    <div></div>
                </div>
                @foreach ($extraAttributes as $key => $item)
                <div class="d-flex justify-content-between pb-2 
                {{$key+1 == count($extraAttributes) ? 'by-2':'border-bottom my-2'}}">
                    <div class="mt-1">{{$item['name']}} 
                        @if ($item['fee'] > 0)
                            <span>(+ {{$item['currency']}} {{$item['fee']}})</span>
                        @else
                            <span>(Free)</span>
                        @endif
                        @if (isset($item['brand_id']))
                            {{$item['brand_id']}}
                        @endif
                    </div>
                    <div class="counter">
                        <button type="button" class="counter-btn sub countAllInput">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" name="qtyExtraAttribute" 
                        class="field qtyExtraAttribute" maxlength="12" value="0" 
                        data-price="{{$item['fee']}}" data-id="{{$item['id']}}" 
                        @if (isset($item['brand_id'])) data-type="b" @endif readonly />
                        <button type="button" class="counter-btn add countAllInput">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <section class="devider"></section>

    <section class="section-last">
        <div class="container-fluid container-xs mt-2">
            <div class="d-flex justify-content-between my-2 pb-2">
                <div><strong>Add notes</strong> 
                    <span class="text-muted small">Optional</span></div>
                <div><span class="rchars small text-muted"></span></div>
            </div>
            <div class="mb-3">
                <textarea name="noteOrder" 
                placeholder="Example: Make my dish awesome like always!" class="area-notes"></textarea>
            </div>
        </div>
        <div id="testfiled"></div>
    </section>
    
    <section>
        <div class="fixed-bottom bg-white border-top">
            <div class="container-fluid container-xs">
                <div class="d-flex justify-content-between">
                    <!-- count -->
                    <div class="counter-lg mt-3 mb-3 text-center" id="field3">
                        <button type="button" class="counter-btn min sub 
                        text-theme-primary-dark countAllInput">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" name="qty" class="field" id="qtys" 
                        maxlength="12" min="1" value="1" readonly />
                        <button type="button" class="counter-btn add 
                        text-theme-primary-dark countAllInput qty-counter">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div class="counter-lg mt-4 mb-3 text-center" id="field3">
                        <div><h5>{{$product->currency}}. <span id="countQtys">0</span></h5></div>
                    </div>
                    <div class="d-grid my-2">
                        <button class="btn btn-theme-secondary py-2 
                        text-theme-primary-dark text-white" type="submit" id="add-to-cart" disabled>
                            <div class="d-flex justify-content-between">
                                <div>Add to Cart</div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- =================================================================
    MODAL
    ================================================================== -->
    <div class="modal fade" id="modalConfirm" aria-hidden="true" 
    aria-labelledby="modalConfirm" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-body">
                    
                    <div class="fw-bold">Item successfully added to shopping cart.</div>
                    <div>Are you want to buy another product or check out?</div>

                </div>
                <div class="modal-footer border-0 justify-content-between">
                    <div class="flex-grow-1">
                        <div class="d-grid">
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal"
                            onclick="location.href='{{route('index-store-order', ['merchantId' => $merchantId])}}';">
                                Continue
                            </button>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-grid">
                            <button type="button" class="btn btn-sm btn-theme-secondary" id="checkout">
                                Check out
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- core -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    
    <script>
        $( document ).ready(function() {
            // checkout
            $('#checkout').on('click',function () {
                $('#modalConfirm').modal('hide');
                setTimeout(function() {
                    $('.open-cart').first().trigger( "click" );
                    $('#modalShoppingCart').modal('show');
                }, 1000);
            })
        });

        
        // set old value if data exist on session
        if ('{{$cartId}}' != '') {
            var oldCart = JSON.parse(sessionStorage.getItem('cart-oobe-indonesia-area'))['{{$cartId}}'];
            if (oldCart != null) {
                $("input[name='qty']").val(oldCart.qty);
                $(`input.variant[value=${oldCart.variant.id}]`).trigger('click');
                // attribute
                oldCart.attribute.forEach(element => {
                    $(`input[name='qtyAttribute'][data-id=${element.id}]`).val(element.qty);
                });
                // extra attribute
                oldCart.extraAttribute.forEach(element => {
                    $(`input[name='qtyExtraAttribute'][data-id=${element.id}]`).val(element.qty);
                });
                $("textarea[name='noteOrder']").text(oldCart.note);
                countAll();
            }   
        }
            
        // auto sum
        $(".countAllInput").on('click',function () {
            countAll();
        })
        
        var total_price = 0;
        function countAll(params) {
            setTimeout(function() {
                // product & variant
                let qty = parseFloat($("input[name='qty']").val());
                let priceProduct = parseFloat('{{$product->retail_price}}');
                let variant = 0;
                if (parseInt('{{count($productVariants)}}')>0) {
                    variant += parseFloat($("input[name='variant']:checked").data('price'));
                }
                let totalProductPrice = priceProduct+variant;
                // attribute
                var attribute = [];
                var totalAttributePrice = 0;
                $(".qtyAttribute").each(function () {
                    let id       = $(this).data('id');
                    let price    = toFixedIfNecessary($(this).data('price'));
                    let qty      = $(this).val();
                    attribute.push([id,price,qty]); 
                    totalAttributePrice += price * qty;
                });
                //extra attribute
                var extraAttribute = [];
                var totalExtraAttributePrice = 0;
                $(".qtyExtraAttribute").each(function () {
                    let id       = $(this).data('id');
                    let price    = toFixedIfNecessary(($(this).data('price')));
                    let qty      = parseFloat($(this).val());
                    if (qty > 0) {
                        extraAttribute.push([id,price,qty]);
                    }
                    totalExtraAttributePrice += price * qty;
                });

                // sum all total
                let total = toFixedIfNecessary(qty * (totalProductPrice + totalAttributePrice +
                 totalExtraAttributePrice));
                if (isNaN(total)) {
                    $('#variantpHelp').removeClass('d-none');
                }else{
                    if (qty > 0) {
                        $('#add-to-cart').removeAttr('disabled');
                    }else{
                        $('#add-to-cart').attr('disabled', true);
                    }
                    $('#variantpHelp').addClass('d-none');
                    $('#countQtys').text(total);
                }

            }, 100);
        }

        function toFixedIfNecessary(value){
            return +parseFloat(value).toFixed( 2 );
        }

        // submit form
        $('#add-to-cart').on('click',function () {

            // product
            let merchantId = '{{$product->merchant_id}}';
            let productId = '{{$product->id}}';
            let qty = parseFloat($("input[name='qty']").val());
            let priceProduct = parseFloat('{{$product->retail_price}}');

            // variant
            let id    = parseFloat($("input[name='variant']:checked").val());
            let price = parseFloat($("input[name='variant']:checked").data('price'));
            let variant = {'id' : id, 'price':price};
            let variantPrice = 0;
            if (parseInt('{{count($productVariants)}}')>0) {
                variantPrice += parseFloat($("input[name='variant']:checked").data('price'));
            }

            // attribute
            var attribute = [];
            var totalAttributePrice = 0;
            $(".qtyAttribute").each(function () {
                let id       = $(this).data('id');
                let price    = toFixedIfNecessary(($(this).data('price')));;
                let qty = parseFloat($(this).val());
                if (qty > 0) {
                    attribute.push({'id':id,'price':price,'qty':qty}); 
                }
                totalAttributePrice += price * qty;
            });

            //extra attribute
            var extraAttribute = [];
            var totalExtraAttributePrice = 0;
            $(".qtyExtraAttribute").each(function () {
                let id       = $(this).data('id');
                let price    = toFixedIfNecessary(($(this).data('price')));
                let qty = $(this).val();
                if (qty > 0) {
                    if ($(this).data('type') != null) {
                        let type = $(this).data('type');
                        extraAttribute.push({'id':id,'price':price,'qty':qty,'type':type});
                    }else{
                        extraAttribute.push({'id':id,'price':price,'qty':qty});
                    }
                }
                totalExtraAttributePrice += price * qty;
            });

            // note
            let note = $("textarea[name='noteOrder']").val();

            // sum per product (with price variant, attribute, and extra attribute)
            let totalPricePerProduct = toFixedIfNecessary((((priceProduct+variantPrice)) +
            totalAttributePrice + totalExtraAttributePrice));
            
            // sum all total
            let totalPriceAll = qty * totalPricePerProduct;
            
            // shopping cart naming
            let nameCart = 'cart-oobe-indonesia-area';

            // update or not
            if ('{{$cartId}}' != '') {
                let cartId = '{{$cartId}}';
                // store to cart
                storeCart(merchantId,productId,qty,variant,attribute,extraAttribute,
                note,totalPricePerProduct,totalPriceAll,nameCart,cartId);
            }else{
                // store to cart
                storeCart(merchantId,productId,qty,variant,attribute,extraAttribute,
                note,totalPricePerProduct,totalPriceAll,nameCart);
            }

        })

        $(function(){
            // add to cart
            $('#add-to-cart').on('click', function () {
                var $this = $(this);
                var loadingText = 'Adding to cart ...';
                if ($(this).html() !== loadingText) {
                    $this.data('original-text', $(this).html());
                    $this.html(loadingText);
                    $this.prop('disabled', true);
                }
                setTimeout(function() {
                    $this.html($this.data('original-text'));
                    $this.prop('disabled', false);
                }, 1000);

                $('#shoppingQty').show('slow');
                $('#qtys').val('0');
                $('#countQtys').remove();

                setTimeout(function() {
                    $('#modalConfirm').modal('show');
                }, 1000);
            });
        });
        
    </script>
    </body>
</html>

@endsection