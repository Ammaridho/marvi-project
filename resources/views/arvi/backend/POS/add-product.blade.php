<div class="modal-header border-bottom pb-3">
    <h5 class="modal-title">{{$product->name}} <br>
        @if ($product->discount_price > 0)
            <s class="text-danger">{{$product->currency}} {{$product->retail_price}}</s>
            {{$product->currency}} {{$product->discount_price}}
        @else
            {{$product->currency}} {{$product->retail_price}}
        @endif
    </h5>
    <button type="button" class="btn-close" 
    data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body center p-3">
    <div class="row g-2">
        @if (count($productVariants) > 0)
            <div class="col-12">
                <div class="fw-bold">Variation / 
                    <span class="fw-normal text-light">
                        Choose one
                    </span>
                </div>
                <hr class="mt-1 mb-2 mx-0" />
            </div>
            @foreach ($productVariants as $item)
            <div class="col-6">
                <div class="d-grid mb-2">
                    <input type="radio" class="btn-check" name="variant" value="{{$item->id}}"
                    id="variant{{$item->id}}" data-price="{{$item->retail_price}}" 
                    data-weight="{{$item->weight}}" autocomplete="off" />
                    <label class="btn btn-outline-primary" for="variant{{$item->id}}">
                        {{$item->name}} (+{{$item->retail_price}})
                    </label>
                </div>
            </div>
            @endforeach
        @endif
        @if (count($productAttributes) > 0)
            <div class="col-12">
                <div class="fw-bold">Add on / 
                    <span class="fw-normal text-light">
                        Choose many
                    </span>
                </div>
                <hr class="mt-1 mb-2 mx-0" />
            </div>
            @foreach ($productAttributes as $item)
                <div class="col-6">
                    <div class="d-grid mb-2">
                        <input type="checkbox" class="btn-check attribute" 
                        name="attribute" value="1" id="attribute{{$item->id}}"
                         data-price="{{$item->retail_price}}" 
                        data-weight="{{$item->weight}}" data-id="{{$item->id}}" 
                        autocomplete="off" />
                        <label class="btn btn-outline-primary" 
                        for="attribute{{$item->id}}">
                            {{$item->name}} (+{{$item->retail_price}})
                        </label>
                    </div>
                </div>
            @endforeach
        @endif
        @if (count($extraAttributes) > 0)
            <div class="col-12">
                <div class="fw-bold">Add on extra / 
                    <span class="fw-normal text-light">
                        Choose many
                    </span>
                </div>
                <hr class="mt-1 mb-2 mx-0" />
            </div>
            @foreach ($extraAttributes as $item)
                <div class="col-6">
                    <div class="d-grid mb-2">
                        <input type="checkbox" class="btn-check extraAttribute" 
                        name="extraAttribute" 
                        value="1" id="extraAttribute-{{$item['sku']}}" autocomplete="off" 
                        data-price="{{$item['fee']}}" data-id="{{$item['id']}}" 
                        data-weight="{{$item['weight']}}" 
                        @if (isset($item['brand_id'])) data-type="b" @endif />
                        <label class="btn btn-outline-primary" 
                        for="extraAttribute-{{$item['sku']}}">
                            {{$item['name']}} (+{{$item['fee']}})
                        </label>
                    </div>
                </div>
            @endforeach
        @endif
         <div class="col-12">
              <div class="fw-bold">Quantity</div>
              <hr class="mt-1 mb-2 mx-0" />
         </div>
         <div class="col-12">
        
            <div class="input-group mb-2">
                <input type="text" name="qty" class="form-control 
                input-number text-center" value="1" min="1" max="10">

                <button class="btn btn-outline-primary 
                btn-number subc" type="button"
                data-type="minus">
                    <i class='bx bx-minus'></i>
                </button>

                <button class="btn btn-outline-primary 
                btn-number addc" type="button" 
                data-type="plus"> 
                    <i class='bx bx-plus'></i>
                </button>
           </div>

         </div>
    </div>
</div>
<div class="modal-footer border-top pb-2">
    <button type="button" class="btn btn-primary" 
    id="submit-add-product-pos" data-bs-dismiss="modal">Done</button>
</div>

<script src="/frontend-oobe-indonesia/assets/js/cart.js"></script>
<script>
    $( document ).ready(function() {
        if('{{count($productVariants)}}'>0){
            $('#submit-add-product-pos').attr('disabled', true);
        }
    });

    $('input[name="variant"]').on('click',function () {
        if ('{{count($productVariants)}}'>0) {
            $('#submit-add-product-pos').attr('disabled', false);
        }
    })

    $(function(){
        //Count + -
        $('.addc').click(function () {
            $(this).prev().prev().val(+$(this).prev().prev().val() + 1);
        });
        $('.subc').click(function () {
            if ($(this).prev().val() > 0) 
            $(this).prev().val(+$(this).prev().val() - 1);
        });
    });

    $('#submit-add-product-pos').on('click',function () {

        // product
        let merchantId   = '{{$product->merchant_id}}';
        let productId    = '{{$product->id}}';
        let qty          = parseFloat($("input[name='qty']").val());
        let weight       = parseFloat("{{$product->weight}}");
        // let priceProduct = parseFloat('{{$product->retail_price}}');

        let priceProduct = 0;
        // check discount_price exist
        if ('{{$product->discount_price}}' == '') {
            priceProduct = parseFloat('{{$product->retail_price}}');            
        } else {
            priceProduct = parseFloat('{{$product->discount_price}}');            
        }     
        
        // variant
        let weightVariant = 0;
        let variantPrice = 0;
        let idVariant     = parseFloat($("input[name='variant']:checked").val());
        let priceVariant  = parseFloat($("input[name='variant']:checked").data('price'));
        if (parseInt('{{count($productVariants)}}')>0) {
            weightVariant    += parseFloat($("input[name='variant']:checked").data('weight'));
            variantPrice     += parseFloat($("input[name='variant']:checked").data('price'));
        }
        let variant       = {'id':idVariant, 'price':priceVariant, 'weight':weightVariant};
        
        // attribute
        let attribute = [];
        let weightAttributeTotal = 0;
        let totalAttributePrice = 0;
        $(".attribute:checked").each(function () {
            let idAttribute     = $(this).data('id');
            let priceAttribute  = toFixedIfNecessary($(this).data('price'));
            let qtyAttribute    = parseFloat($(this).val());
            let weightAttribute = toFixedIfNecessary($(this).data('weight'));
            if (qtyAttribute > 0) {
                attribute.push({'id':idAttribute, 'price':priceAttribute,
                'qty':qtyAttribute, 'weight':weightAttribute});
                weightAttributeTotal += (weightAttribute * qtyAttribute);
            }
            totalAttributePrice += priceAttribute * qtyAttribute;
        });
        
        //extra attribute
        var extraAttribute = [];
        let weightExtraAttributeTotal = 0;
        var totalExtraAttributePrice = 0;
        $(".extraAttribute:checked").each(function () {
            let idExtraAttribute      = $(this).data('id');
            let priceExtraAttribute   = toFixedIfNecessary($(this).data('price'));
            let qtyExtraAttribute     = $(this).val();
            let weightExtraAttribute  = toFixedIfNecessary($(this).data('weight'));
            if (qtyExtraAttribute > 0) {
                if ($(this).data('type') != null) {
                    let typeExtraAttribute = $(this).data('type');
                    extraAttribute.push({
                        'id':idExtraAttribute,
                        'price':priceExtraAttribute,
                        'qty':qtyExtraAttribute,
                        'type':typeExtraAttribute,
                        'weight':weightExtraAttribute
                    });
                }else{
                    extraAttribute.push({
                        'id':idExtraAttribute,
                        'price':priceExtraAttribute,
                        'qty':qtyExtraAttribute,
                        'weight':weightExtraAttribute
                    });
                }
                weightExtraAttributeTotal += (weightExtraAttribute * qtyExtraAttribute);
            }
            totalExtraAttributePrice += priceExtraAttribute * qtyExtraAttribute;
        });
        
        // note
        let note = "";
        
        // sum per product (with price variant, attribute, and extra attribute)
        let totalPricePerProduct = toFixedIfNecessary(((priceProduct+variantPrice) +
        totalAttributePrice + totalExtraAttributePrice));

        // weight total
        let totalWeight = 
        (qty * ((parseInt('{{count($productVariants)}}')>0?weightVariant:weight) + 
        weightAttributeTotal + weightExtraAttributeTotal));

        // sum all total
        let totalPriceAll = qty * totalPricePerProduct;
        
        // shopping cart naming
        let nameCart = 'cart-pos-cashier';

        storeCart(merchantId,productId,qty,weight,
        totalWeight,variant,attribute,extraAttribute,
        note,totalPricePerProduct,totalPriceAll,nameCart);

        refreshPOSCart();
    })

    function toFixedIfNecessary(value){
        return +parseFloat(value).toFixed( 2 );
    }
</script>