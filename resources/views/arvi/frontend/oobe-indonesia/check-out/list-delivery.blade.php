@if(count($deliveryMethod) > 0)
    <section class="box show-box-delivery">
        <div class="container-fluid container-xs mt-2">
            <div class="d-flex mt-3">
                <div><h6>Select courier delivery</h6></div>
            </div>
            <div id="delMetError" role="alert" class="form-text error-message
            alert alert-danger p-2 d-none">
                The delivery method field is required.
            </div>
            @foreach ($deliveryMethod as $key => $item)
                <div class="form-group mb-2">
                    <label class="radio-selection">
                        <input type="radio" class="complete-delivery" name="deliveryMethod" 
                        value="{{$item['mdm_id']}}" data-cost="{{$item['rate']}}" 
                        data-courier="{{$item['courier']}}" 
                        data-service_type="{{$item['service_type']}}"/>
                        <div>
                            {{$item['courier']}} - {{$item['service_type']}} 
                            <div class="float-end text-muted">
                                {{$currency}} {{number_format($item['rate'])}}
                            </div>
                        </div>
                    </label>
                </div>
            @endforeach
        </div>
        <section class="devider"></section>
    </section>
@else
    <section class="box show-box-delivery">
        <div class="container-fluid container-xs mt-2">
            <div class="d-flex mt-3">
                <div><h6>Select courier delivery</h6></div>
            </div>
            <div id="delMetError" role="alert" class="form-text error-message
            alert alert-danger p-2 d-none">
                The delivery method field is required.
            </div>
            <div role="alert" class="form-text error-message
            alert alert-warning p-2">
                Delivery method is not exist.
            </div>
        </div>
        <section class="devider"></section>
    </section>
@endif

<script>
    $('input[name="deliveryMethod"], #delivery-fulfilment, .complete-delivery, .single-option')
    .on('click',function () {
        $('#delivery-cost').text($('input[name="deliveryMethod"]:checked').data('cost'));
        $('#delivery-cost-currency').removeClass('d-none');
        // total all price
        let delivery = parseFloat($('input[name="deliveryMethod"]:checked').data('cost'));
        let price    = parseFloat($('#total-price').data('price'));
        let total    =  price + delivery;
        $('#countQtys').text(total.toLocaleString('en-US'));
        if ($("input[name='nameCustDel']").val() == ''
        || $("input[name='phoneCustDel']").val() == ''
        || $("textarea[name='addressCustDel']").val() == ''
        || $(".single-option").val() == null
        || $("input[name='deliveryMethod']:checked").val() == undefined) {
            $('#confirm-orders').prop("disabled",true);
        }else{
            $('#confirm-orders').prop("disabled",false);
            $('.detail-cost-delivery').removeClass('d-none');
        }
    })
</script>