@php
    $title = 'Delivery Method';
@endphp

@extends('arvi.frontend.store.layouts.main')
@section('content')

    <section class="section-first">
        <div class="container-fluid container-xs mt-2">
            <div class="mt-3">
                <div class="d-flex">
                    <div><h5>Delivery method</h5></div>
                </div>
                <div class="mt-2">
                    <div id="fulfilmentError" role="alert"
                    class="form-text error-message alert alert-danger p-2 d-none">
                        Please choose fulfilment method.
                    </div>
                    <div class="form-group mb-3">
                        <label class="radio-selection">
                            @if ($merchant->support_pickup > 0)
                                <input type="radio" name="fulfilmentMethod" 
                                value="box-pickup" data-id="0" class="option-address"
                                id="pick-up-fulfilment"/>
                                <div>
                                    <i class="fas fa-shopping-bag"></i> Self Pickup 
                                    <div class="float-end text-muted"></div>
                                </div>
                            @else
                                <input type="radio" name="fulfilmentMethod" 
                                value="box-pickup" data-id="0" 
                                class="option-address" disabled/>
                                <div>
                                    <i class="fas fa-shopping-bag"></i> 
                                    Self Pickup (not available) 
                                    <div class="float-end text-muted"></div>
                                </div>
                            @endif
                        </label>
                    </div>
                    <div class="form-group mb-2">
                        <label class="radio-selection">
                            @if (count($deliveryMethod) > 0)
                                <input type="radio" name="fulfilmentMethod" 
                                id="delivery-fulfilment" value="box-delivery" 
                                class="option-address selectDeliver complete-delivery"/>
                                <div><i class="fas fa-shipping-fast"></i> Delivery </div>
                            @else
                                <input type="radio" name="fulfilmentMethod" 
                                value="box-delivery" class="option-address 
                                selectDeliver" disabled/>
                                <div>
                                    <i class="fas fa-shipping-fast"></i> 
                                    Delivery (not available) 
                                </div>
                            @endif
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="devider"></section>

    <section>
        <div class="container-fluid container-xs mt-2">
            <div class="my-4 box">
                <div class=" d-flex justify-content-center
                align-items-center text-muted small">
                    Select delivery method
                </div>
            </div>

            {{-- pickup --}}
            <div class="mt-3 box hidden" id="show-box-pickup">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mb-2"><h5>Pickup Location</h5></div>
                </div>
                <div class="form-group mb-3">
                    <label class="radio-selection">
                        <input type="radio" class="complete-pickup" name="locationPic" 
                        value="{{$location->id}}" checked />
                        <div>
                            {{$location->name}}
                            <div class="float-end icon hiidden text-muted">
                                <span class="material-icons">
                                    check_circle_outline
                                </span>
                            </div>
                        </div>
                    </label>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="my-2 fw-bold">Recepient</div>
                </div>
                <div class="form-group mb-3">
                    <input type="text" class="f-inputbox complete-pickup" 
                    autocomplete="off" id="name-pickup" name="nameCustPic" />
                    <label class="f-label">Recepient name *</label>
                    <div id="namePicError" role="alert" class="form-text error-message
                    alert alert-danger p-2 d-none">
                        This field is required.
                    </div>
                </div>
                <div class="form-group mb-3">
                    <input type="text" class="f-inputbox phone_with_ddd complete-pickup" 
                    autocomplete="off" id="phone" name="phoneCustPic" />
                    <label class="f-label">Recepient phone number *</label>
                    <div id="phonePicError" role="alert" class="form-text error-message
                    alert alert-danger p-2 d-none">
                        This field is required.
                    </div>
                </div>
                <div class="form-group mb-3">
                    <input type="email" class="f-inputbox" 
                    autocomplete="off" id="email" name="emailCustPic"/>
                    <label class="f-label">Recepient email address</label>
                    <div id="emailPicError" role="alert" class="form-text error-message
                    alert alert-danger p-2 d-none">
                        This field is required.
                    </div>
                </div>
            </div>

            <!-- delivery -->
            <div class="mt-3 box hidden" id="show-box-delivery">
                <div class="mb-2"><h5>Delivery</h5></div>
                <a href="javascript: void(0)" class="d-none" data-bs-toggle="modal" 
                data-bs-target="#modalLocation">
                    <div class="d-flex justify-content-center 
                    align-items-center mb-3 
                    bg-light border rounded text-center p-1" 
                    style="height: 120px;background: url('/assets/img/map.png') 
                    no-repeat center center;">
                        <span class="p-2 rounded bg-white">Pick a location</span>
                    </div>
                </a>
                <input type="hidden" name="locationDel" 
                value="{{$location->id}}" checked />
                <div class="d-flex justify-content-between align-items-center">
                    <div class="my-2 fw-bold">Address</div>
                    @if (Auth::check())
                    <button type="button" class="btn btn-sm btn-primary-outline"
                    id="btnSavedAddress" data-bs-toggle="modal" 
                    data-bs-target="#modalAddress">
                    <i class="far fa-bookmark"></i> Saved address</button>
                    @endif
                </div>
                <div class="form-group mb-3">
                    <input type="text" class="f-inputbox complete-delivery"
                    autocomplete="off" id="fname" name="nameCustDel"/>
                    <label class="f-label">Recepient name *</label>
                    <div id="nameError" role="alert" class="form-text error-message
                    alert alert-danger p-2 d-none">
                        This field is required.
                    </div>
                </div>
                <div class="form-group mb-3">
                    <input type="text" class="f-inputbox phone_with_ddd 
                    complete-delivery"
                    autocomplete="off" id="phone" name="phoneCustDel"
                    inputmode="decimal" />
                    <label class="f-label">Recepient phone number *</label>
                    <div id="phoneError" role="alert" class="form-text 
                    error-message
                    alert alert-danger p-2 d-none">
                        This field is required.
                    </div>
                </div>
                <div class="form-group mb-3">
                    <input type="email" class="f-inputbox" 
                    autocomplete="off" id="email" name="emailCustDel"/>
                    <label class="f-label">Recepient email address</label>
                    <div id="emailError" role="alert" class="form-text 
                    error-message
                    alert alert-danger p-2 d-none">
                        This field is required.
                    </div>
                </div>
                <div class="form-group mb-3">
                    <textarea class="f-textbox complete-delivery" rows="2" 
                    id="address" name="addressCustDel"
                    placeholder="&#10;&nbsp;Floor or room number, lobby ..."></textarea>
                    <label class="f-label">Address *</label>
                    <div id="addressError" role="alert" class="form-text error-message
                    alert alert-danger p-2 d-none">
                        This field is required, please fill your detail location.
                    </div>
                </div>
                <div class="form-group mb-3">
                    <select class="single-option" name="sub-district" 
                    style="width: 100%;">
                    </select>
                    <div id="sub-districtError" role="alert" 
                    class="form-text error-message
                    alert alert-danger p-2 d-none">
                        This field is required, please choose your district.
                    </div>
                </div>

                <div class="form-group mb-3">
                    <textarea class="f-textbox" rows="2" 
                    id="notes" name="notesCustDel"
                    placeholder="&#10;&nbsp;near by ..."></textarea>
                    <label class="f-label">Notes </label>
                    <div id="notesError" role="alert" class="form-text error-message
                    alert alert-danger p-2 d-none">
                        This field is required, please fill your detail location.
                    </div>
                </div>
                
                @if (Auth::check())
                <div class="form-check checkbox checkbox-custom mb-3">
                    <input class="form-check-input" name="savedAddress" value="1"
                    type="checkbox" id="savedAddress" data-name="displayName">
                    <label class="form-check-label" for="savedAddress">
                        Save this address
                    </label>
                </div>
                @endif
            </div>

            {{-- form pickup --}}
            <form id="form-delivery-method" action="{{route("payment-checkout-store",["code"=>$code])}}" method="POST">
                @csrf
                <input type="hidden" name="cart" value="">
                <input type="hidden" name="bioCust" value="">
                <input type="hidden" name="deliveryId" value="">
                <input type="hidden" name="totalShoppingPrice" value="">
                <input type="hidden" name="courier" value="">
                <input type="hidden" name="cost_delivery" value="">
            </form>

        </div>
    </section>
    
    <section class="devider"></section>
    
    <div id="list-delivery-exist">   
    </div>


    @php
        $i = 1;
        function round_up ( $value, $precision ) { 
            $pow = pow ( 10, $precision ); 
            return ( ceil ( $pow * $value ) + ceil 
            ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow; 
        }
        $sumItem = 0;
        $sumAll = 0;
        // total price in one merchant order
        $totalPriceMerc = array();
    @endphp
    @foreach ($orders as $item)
    <section>
        <div class="container-fluid container-xs mt-2">
            <div class="mt-3">
                <div class="d-flex justify-content-between 
                align-items-center">
                    <div class="small text-theme-primary">
                        {{$item['merchantName']}}
                    </div>
                </div>
                <div class="mt-2">
                    <div class="d-flex justify-content-between mb-2">
                        <div>Shopping ({{$item['totalItems']}} items)</div>
                        <div>{{$currency}} {{number_format($item['totalPrices'])}}</div>
                    </div>
                    @php
                        $sumFees = 0; 
                        $sum     = 0;
                    @endphp
                    @foreach ($item['fees'] as $key => $fee)
                        <div class="d-flex justify-content-between mb-2">
                            <div>{{$fee['name']}}</div>
                            <div>{{$fee['currency']}}
                                @if ($fee['type_value'] == 'fixed')
                                    {{number_format($fee['value_fee'])}}
                                    @php
                                        $sumFees += $fee['value_fee'];
                                    @endphp
                                @else
                                    @if ($fee['currency'] == 'IDR')
                                        {{number_format(ceil(round_up($item['totalPrices'] * 
                                        $fee['value_fee']/100 , 2)))}}
                                        @php
                                            $sumFees += ceil(round_up($item['totalPrices'] * 
                                            $fee['value_fee']/100 , 2))
                                        @endphp
                                    @else
                                        {{number_format(round_up($item['totalPrices'] * 
                                        $fee['value_fee']/100 , 2))}}
                                        @php
                                            $sumFees += round_up($item['totalPrices'] * 
                                            $fee['value_fee']/100 , 2)
                                        @endphp
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                    @php
                        $sum = $item['totalPrices'] + $sumFees;
                        $sumItem += $item['totalItems'];
                        $sumAll += $sum;
                        array_push($totalPriceMerc,$sum);
                    @endphp
                    <div class="d-flex justify-content-between mb-2 border-top pt-2">
                        <div><strong>Sub Total</strong></div>
                        <div><strong>{{$currency}} {{number_format($sum)}}</strong></div>
                    </div>
                </div>
            </div>
        </div>
        <section class="devider"></section>
    </section>
    @endforeach


    <section>
        <div class="container-fluid container-xs mt-2">
            <div class="mt-3">
                <div class="d-flex">
                    <div><h6>Order summary</h6></div>
                </div>
                <div class="mt-2">
                    <div class="d-flex justify-content-between mb-2">
                        <div>Total shopping ({{$sumItem}} items)</div>
                        <div>
                            {{$currency}} 
                            <span id="total-price" data-price="{{$sumAll}}">
                                {{number_format($sumAll)}}
                            </span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between 
                    mb-2 detail-cost-delivery">
                        <div>Delivery cost</div>
                        <div>
                            <span>{{$currency}}</span> 
                            <span id="delivery-cost">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-last">
        <div class="fixed-bottom bg-white border-top">
            <div class="container-fluid container-xs">
                <div class="d-grid my-2">
                    <button class="btn btn-theme-secondary py-2 
                    text-theme-primary-dark text-white"
                    type="button" id="confirm-orders" disabled>
                        <div class="d-flex justify-content-between">
                            <div>Proceed Payment</div>
                            <div class="fw-bold">
                                {{$currency}} 
                                <span id="countQtys">
                                    {{number_format($sum)}}
                                </span>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <!-- =================================================================
    MODAL
    ================================================================== -->

    <!-- modal address -->
    <div class="modal fade" id="modalAddress" aria-hidden="true"
    aria-labelledby="modalAddress" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">

                    @if (count($saved_address)>0)
                        @foreach ($saved_address as $item)
                            <div class="form-group mb-3">
                                <label class="radio-selection">
                                    <input type="radio" class="saved-address" 
                                    name="delivery" 
                                    data-data="{{ $item }}" />
                                    <div>
                                        <div class="d-flex justify-content-between 
                                        align-items-start">
                                            <div>
                                                <div class="fw-bold">{{ $item->name }}</div>
                                                <div>{{ $item->phone_number }}</div>
                                            </div>
                                            <div class="small icon">
                                                <i class="fas fa-check-circle text-success"></i>
                                            </div>
                                        </div>
                                        <div class="small">
                                            address : {{ $item->address }}
                                        </div>
                                        <div class="small">
                                            notes : {{ $item->address }}
                                        </div>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center">
                            You didn't have any saved address.
                        </div>
                    @endif

                </div>
                <div class="modal-footer border-0 justify-content-between">
                    <div class="flex-grow-1">
                        <div class="d-grid">
                            <button type="button" class="btn btn-sm 
                            btn-outline-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-grid">
                            <button type="button" class="btn btn-sm 
                            btn-theme-secondary"
                            data-bs-dismiss="modal"
                            @if (!count($saved_address)>0)
                                disabled
                            @endif
                            >Select address</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //modal address -->


    <script>

        $(function(){
            // sub district options
            $(".single-option").select2({
                placeholder: "Select a Sub-District",
                ajax: {
                    url: "{{route('search-district')}}",
                    delay: 200,
                    data: function (params) {
                        return {
                            keySearch: params.term
                        };
                    },
                    processResults: (data, params) => ({
                        results: data.map(item => ({
                            text: item.name+', '+item.district.name+', '+
                            item.district.city.name+', '+item.postcode,
                            id: JSON.stringify({
                                subdistrict : item.name,
                                district : item.district.name,
                                city : item.district.city.name,
                                province : item.district.city.province.name,
                                postcode : item.postcode
                            }),
                        }))
                    }),
                }
            });

        });

        // list delivery exist
        $("select[name='sub-district']").on('change',function () {
            let district    = JSON.parse($(this).val());
            let merchant_id ='{{$merchant->id}}';
            let currency    = '{{$currency}}';
            let client_id   = '{{$client_id}}';
            let origin      = "{{$location['postal_code']}}";
            let destination = district.postcode;
            let weight      = '{{$totalWeight}}';
            $.get("{{route('check-rates')}}",{
                merchant_id:merchant_id,
                currency:currency,
                client_id:client_id,
                origin:origin,
                destination:destination,
                weight:weight,
                // volume:volume
            },function (data) {
                $('#list-delivery-exist').html(data);
            })
        })

        // autoinput
        $('.saved-address').on('click',function () {
            let data = $(this).data('data');
            // label auto up
            $('.f-label').addClass('f-up');
            $("input[name='nameCustDel']").val(data['name']);
            $("input[name='phoneCustDel']").val(data['phone_number']);
            $("input[name='emailCustDel']").val(data['email']);
            $("textarea[name='addressCustDel']").val(data['address']);
            $("textarea[name='notesCustDel']").val(data['notes']);
        })

        // set disabled button if district has change
        $('.single-option').select2().on('click change keyup',function () {
            $('#confirm-orders').prop("disabled",true);
            $('.detail-cost-delivery').addClass('d-none');
        })

        // active button if all filled
        $('.complete-delivery').on('click change keyup',function () {
            if ($("input[name='nameCustDel']").val() == ''
            || $("input[name='phoneCustDel']").val() == ''
            || $("input[name='emailCustDel']").val() == ''
            || $("textarea[name='addressCustDel']").val() == ''
            || $(".single-option").val() == null
            || $("input[name='deliveryMethod']:checked").val() == undefined) {
                $('#confirm-orders').prop("disabled",true);
                $('.detail-cost-delivery').addClass('d-none');
            }else{
                $('#confirm-orders').prop("disabled",false);
                $('.detail-cost-delivery').removeClass('d-none');
            }
        })

        // checkout
        $('#confirm-orders').on('click',function () {
            // set d-none all message error
            $('.error-message').addClass('d-none');
            if ($("input[name='fulfilmentMethod']:checked").val() == 'box-delivery') {
                if ($("input[name='nameCustDel']").val() == ''
                || $("input[name='phoneCustDel']").val() == ''
                || $("textarea[name='addressCustDel']").val() == ''
                || $(".single-option").val() == null
                || $("input[name='deliveryMethod']:checked").val() == undefined) {
                    if ($("input[name='nameCustDel']").val() == '') {
                        $('#nameError').removeClass('d-none');
                    }
                    if ($("input[name='phoneCustDel']").val() == '') {
                        $('#phoneError').removeClass('d-none');
                    }
                    if ($("textarea[name='addressCustDel']").val() == '') {
                        $('#addressError').removeClass('d-none');
                    }
                    if ($(".single-option").val() == null) {
                        $('#sub-districtError').removeClass('d-none');
                    }
                } else {
                    // get data form
                    let locationId         = '{{$location->id}}';
                    let savedAddress       = $("input[name='savedAddress']:checked").val();
                    let nameCustDel        = $("input[name='nameCustDel']").val();
                    let phoneCustDel       = $("input[name='phoneCustDel']").val();
                    let emailCustDel       = $("input[name='emailCustDel']").val();
                    let addressCustDel     = $("textarea[name='addressCustDel']").val();
                    let notesCustDel       = $("textarea[name='notesCustDel']").val();
                    let deliveryId         = $('input[name="deliveryMethod"]:checked')
                    .val();
                    let shipping_channel   = $('input[name="deliveryMethod"]:checked')
                    .data('courier');
                    let shipping_service   = $('input[name="deliveryMethod"]:checked')
                    .data('service_type');
                    let cost_delivery      = $('input[name="deliveryMethod"]:checked')
                    .data('cost');
                    let totalShoppingPrice = parseFloat($('#total-price').data('price'));

                    // compact data to object
                    let bioCust = {
                        savedAddress:savedAddress,
                        locationId:locationId,
                        nameCust:nameCustDel,
                        phoneCust:phoneCustDel,
                        emailCust:emailCustDel,
                        addressCust:addressCustDel,
                        notesCust:notesCustDel,
                        district:JSON.parse($("select[name='sub-district']").val()),
                    }

                    let courier = {
                        delivery_id:deliveryId,
                        shipping_channel:shipping_channel,
                        shipping_service:shipping_service,
                        cost_delivery:cost_delivery
                    }

                    // set value cart
                    $("#form-delivery-method input[name='cart']").val(sessionStorage.getItem('cart-oobe-store'));
                    $("#form-delivery-method input[name='bioCust']").val(JSON.stringify(bioCust));
                    $("#form-delivery-method input[name='deliveryId']").val(deliveryId);
                    $("#form-delivery-method input[name='totalShoppingPrice']").val(totalShoppingPrice);
                    $("#form-delivery-method input[name='courier']").val(JSON.stringify(courier));
                    $("#form-delivery-method input[name='cost_delivery']").val(cost_delivery);
                    document.getElementById('form-delivery-method').submit();
                }
            }else if($("input[name='fulfilmentMethod']:checked").val() == 'box-pickup'){
                if ($("input[name='nameCustPic']").val() == ''
                || $("input[name='phoneCustPic']").val() == '') {
                    if ($("input[name='nameCustPic']").val() == '') {
                        $('#namePicError').removeClass('d-none');
                    }
                    if ($("input[name='phoneCustPic']").val() == '') {
                        $('#phonePicError').removeClass('d-none');
                    }
                } else {

                    // get data form
                    let locationId         = '{{$location->id}}';
                    let nameCustPic        = $("input[name='nameCustPic']").val();
                    let phoneCustPic       = $("input[name='phoneCustPic']").val();
                    let emailCustPic       = $("input[name='emailCustPic']").val();
                    let deliveryId         = $("input[name='fulfilmentMethod']:checked").data('id');
                    let totalShoppingPrice = parseFloat($('#total-price').data('price'));

                    // compact data to object
                    let bioCust = {
                        locationId:locationId,
                        nameCust:nameCustPic,
                        phoneCust:phoneCustPic,
                        emailCust:emailCustPic
                    }

                    // set value cart
                    $("#form-delivery-method input[name='cart']").val(sessionStorage.getItem('cart-oobe-store'));
                    $("#form-delivery-method input[name='bioCust']").val(JSON.stringify(bioCust));
                    $("#form-delivery-method input[name='deliveryId']").val(deliveryId);
                    $("#form-delivery-method input[name='totalShoppingPrice']").val(totalShoppingPrice);
                    document.getElementById('form-delivery-method').submit();
                }
            }else{
                $('#fulfilmentError').removeClass('d-none');
            }
        })

        $(document).ready(function(){
            $(".shopping-cart").addClass('d-none');
            $(".modalLoading").modal('hide');
            $('.detail-cost-delivery').addClass('d-none');
        });

        // pickup
        $('#pick-up-fulfilment, .complete-pickup').on('click change keyup',function () {
            $('.detail-cost-delivery').addClass('d-none');
            // total all price
            let delivery = 0;
            let price    = parseFloat($('#total-price').data('price'));
            let total    =  price + delivery;
            $('#countQtys').text(total.toLocaleString('en-US'));
            if ($("input[name='nameCustPic']").val() == '' ||
            $("input[name='phoneCustPic']").val() == '') {
                $('#confirm-orders').prop("disabled",true);
            }else{
                $('#confirm-orders').prop("disabled",false);
            }
        })
    </script>
    </body>
</html>

@endsection
