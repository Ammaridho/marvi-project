<div class="modal-header border-bottom pb-3">
    <h5 class="modal-title">
        {{$currency}} {{number_format($totalPrice)}}
    </h5>
    <button type="button" class="btn-close" 
    data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body center p-3">
    <div class="row">
        @if (count($bundlePayments) == 0)
            <h4 class="text-center">Please set store payment method!</h4>
        @endif
        <div class="col-12 col-md-8 col-sm-12">
            <div class="row g-2">
                <div class="col-12 d-none">
                    <div class="fw-bold">Bio customer</div>
                    <hr class="mt-1 mb-0 mx-0"/>
                </div>
                <div class="col-12 d-none">
                    <label for="">Name *</label>
                    <div class="mb-2">
                        <input type="text" name="nameCust" class="form-control"
                        id="name-customer" placeholder="Customer name.." 
                        value="{{$merchantName}}" autocomplete="off" required>
                    </div>                               
                </div>
                <div class="col-12 d-none">
                    <label for="">Email Reciept</label>
                    <div class="mb-2">
                        <input type="email" name="emailCust" class="form-control"
                        id="email-customer" placeholder="Customer email.." 
                        autocomplete="off">
                    </div>                               
                </div>
                @if (isset($bundlePayments['CASH'][0]['id']))
                    <div class="col-12">
                        <div class="fw-bold">Cash</div>
                        <hr class="mt-1 mb-2 mx-0" />
                    </div>
                    <div class="col-4">
                        <div class="d-grid mb-2">
                            <input type="radio" class="btn-check oprion custCash" 
                            name="paymp" value="{{$totalPrice}}" 
                            data-idpay="{{$bundlePayments['CASH'][0]['id']}}"
                            id="cash0" autocomplete="off" />
                            <label class="btn btn-outline-primary" for="cash0">
                                {{$currency}} {{number_format($totalPrice)}}
                            </label>
                        </div>
                    </div>
                    @foreach ($custCash as $key => $item)
                    <div class="col-4">
                        <div class="d-grid mb-2">
                            <input type="radio" class="btn-check oprion custCash" 
                            data-idpay="{{$bundlePayments['CASH'][0]['id']}}"
                            name="paymp" value="{{$item}}" id="cash{{$key+1}}" autocomplete="off" />
                            <label class="btn btn-outline-primary" for="cash{{$key+1}}">
                                {{$currency}} {{number_format($item)}}
                            </label>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-12">
                        <div class="mb-2">
                            <input type="number" class="form-control noArrow numbers" id="custCash-custom" 
                            data-idpay="{{$bundlePayments['CASH'][0]['id']}}"
                            required autocomplete="off" placeholder="Cash amount" required>
                        </div>                               
                    </div>
                @endif       
            </div>
        </div>
        <div class="col-12 col-md-4 col-sm-12">
            <div class="row g-2">
                @if (count($bundlePayments) > 0)
                    <div class="col-12">
                        <div class="fw-bold">Payment</div>
                        <hr class="mt-1 mb-2 mx-0" />
                    </div>
                    @foreach ($bundlePayments as $key => $category)
                        @if (!in_array($key,['CREDIT_CARD','CASH']) )
                            <div class="col-12 d-none">
                                <div class="fw-bold">
                                    @if ($key == 'VIRTUAL_ACCOUNT')
                                    Virtual Account
                                    @elseif($key == 'EWALLET')
                                    E-Wallet
                                    @elseif($key == 'QR_CODE')
                                    QR
                                    @elseif($key == 'CREDIT_CARD')
                                    Credit Card
                                    @elseif($key == 'RETAIL_OUTLET')
                                    Retail Outlet
                                    @elseif($key == 'CASH')
                                    Cashier
                                    @endif
                                </div>
                                <hr class="mt-1 mb-2 mx-0" />
                            </div>
                            @foreach ($category as $item)
                                @if ($item['method'] == 'OVO')
                                    <div class="col-12 mb-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <input type="radio" class="btn-check oprion provider-payment ovop" 
                                                name="paymp" value="{{$item['method']}}" data-idpay="{{$item['id']}}"
                                                id="pym-{{$item['id']}}" autocomplete="off"/>
                                                <label class="btn btn-outline-primary" for="pym-{{$item['id']}}">
                                                    <img src="/arvi/backend-assets/img/icons/payment/logo-{{strtolower($item['method'])}}.png" 
                                                    class="" style="height: 30px;">
                                                </label>
                                            </div>
                                            <input type="text" name="noTelpOvo" class="f-inputbox 
                                            phone_with_ddd complete-pickup form-control ovop" autocomplete="off" 
                                            placeholder="(+62) 8129-30..." aria-label="" 
                                            aria-describedby="basic-addon1">
                                        </div>
                                        @if ($totalPrice < 100)
                                            <div id="minTrxOvo" class="Help form-text text-danger">
                                                Min trx IDR 100
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="col-12 mb-1">
                                        <div class="d-grid">
                                            <input type="radio" class="btn-check oprion provider-payment" 
                                            name="paymp" value="{{$item['method']}}" 
                                            data-idpay="{{$item['id']}}"
                                            id="pym-{{$item['id']}}" autocomplete="off"/>
                                            <label class="btn btn-outline-primary" for="pym-{{$item['id']}}">
                                                <img src="/arvi/backend-assets/img/icons/payment/logo-{{strtolower($item['method'])}}.png" 
                                                class="" style="height: 30px;">
                                            </label>
                                            @if ($item['method'] == 'DANA' && $totalPrice < 100)
                                                <div id="minTrxOvo" class="Help form-text text-danger">
                                                    Min trx IDR 100
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                    <div id="minTrx" class="Help form-text text-danger d-none">
                        Min trx IDR 1000
                    </div>
                @endif 
            </div>
        </div>
    </div>
</div>
<div class="modal-footer border-top pb-2">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" 
    data-bs-target="#modalDone" id="charge-pos" disabled>Charge</button>
</div>

<script type="text/javascript" src="/arvi/backend-assets/js/demo.js"></script>

<script>
    
    $( document ).ready(function() { 
        // check price not under 
        if ('{{$totalPrice}}' < 100) {
            $('.ovop').attr('disabled',true);
            $('input[value="DANA"]').attr('disabled',true);
        }
    });

    // custom or not cash
    $('#custCash-custom').on('click keyup',function () {
        $('.provider-payment:checked').prop("checked",false);
        $('#charge-pos').attr('disabled',true);
        $('.custCash:checked').prop('checked', false);
        $('input[name="noTelpOvo"]').val('');
        let totalPrice = '{{$totalPrice}}';
        let custCashCustom =  parseInt($('#custCash-custom').val());
        if (custCashCustom >= totalPrice &&
            $("input[name='nameCust']").val() != '') {
            $('#charge-pos').attr('disabled',false);
        }else{
            $('#charge-pos').attr('disabled',true);
        }
    })
    
    // name cust
    $("input[name='nameCust']").on('click keyup',function () {
        if ($("input[name='nameCust']").val() != '') {
            if ($('#custCash-custom').val() != '' ||
                $('.custCash:checked').length > 0 || 
                $('.provider-payment:checked').length > 0) {
                $('#charge-pos').attr('disabled',false);
            }else{
                $('#charge-pos').attr('disabled',true);
            }
        } else {
            $('#charge-pos').attr('disabled',true);
        }
    });

    // ovo
    $("input[name='noTelpOvo']").on('click keyup',function () {
        $("input[name=paymp][value='OVO']").prop("checked",true);
        $('#custCash-custom').val('');
        if ($("input[name='nameCust']").val() != '' && $("input[name='noTelpOvo']").val() != '') {
            $('#charge-pos').attr('disabled',false);
        }else{
            $('#charge-pos').attr('disabled',true);
        }
    })

    // choose method
    $('.custCash, .provider-payment').on('click keyup',function () {
        $('#charge-pos').attr('disabled',true);
        $('#custCash-custom').val('');
        let custCash   = $('.custCash:checked').val();

        if (custCash === undefined &&
            $("input[name='nameCust']").val() != '') {
            $('#charge-pos').attr('disabled',false);
        } else {
            let totalPrice = '{{$totalPrice}}';
            if (parseInt(custCash) >= totalPrice &&
                 $("input[name='nameCust']").val() != '') {
                $('#charge-pos').attr('disabled',false);
            }else{
                $('#charge-pos').attr('disabled',true);
            }
        }
        if ($(this).val() != 'OVO') {
            $('input[name="noTelpOvo"]').val('');
        }else{
            if ($("input[name='noTelpOvo']").val() != '') {
                $('#charge-pos').attr('disabled',false);
            }else{
                $('#charge-pos').attr('disabled',true);
            }
        }
    })

    // charge
    $('#charge-pos').on('click',function () {
        event.preventDefault();
        let cart = sessionStorage.getItem('cart-pos-cashier');
        let totalPrice = '{{$totalPrice}}';
        var custCash = 0;
        var channel_code = '';
        var paymp = 0;
        var noTelpOvo = '';
        let name = $("input[name='nameCust']").val();
        let email = $("input[name='emailCust']").val();
        if($('input[name="noTelpOvo"]').val()!== undefined){
            noTelpOvo = $('input[name="noTelpOvo"]').val();
        }
        if ($('.custCash:checked').val()!== undefined) {
            custCash  = $('.custCash:checked').val();
            paymp = $('.custCash:checked').data('idpay');
        }else if($('.provider-payment:checked').val() !== undefined) {
            channel_code   = $('.provider-payment:checked').val();
            paymp       = $('.provider-payment:checked').data('idpay');
        }
        else{
            custCash   = $('#custCash-custom').val();
            paymp  = $('#custCash-custom').data('idpay');
        }
        let merchantId = '{{$merchantId}}';
        let selesType  = '{{$selesType}}';

        // check valid url
        var elm;
        function isValidURL(u){
        if(!elm){
            elm = document.createElement('input');
            elm.setAttribute('type', 'url');
        }
        elm.value = u;
        return elm.validity.valid;
        }

        $.ajax({
            type: 'POST',
            url: "{{ route('pos-store-order',['companyCode' => $companyCode]) }}",
            data: { 
                "_token": "{{ csrf_token() }}",
                cart:cart,
                totalPrice:totalPrice,
                custCash:custCash,
                merchantId:merchantId,
                selesType:selesType,
                paymp:paymp,
                channel_code:channel_code,
                noTelpOvo:noTelpOvo,
                name:name,
                email:email
            },
            success: function (data) {
                if (isValidURL(data)) {
                    sessionStorage.removeItem('cart-pos-cashier');
                    window.location.href = data;
                } else {
                    $('#modalDone').find('.modal-content').html(data);
                }
            },
            error: function (data) {
                console.log(data);
            }
        })
    })
</script>