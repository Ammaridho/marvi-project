@extends('arvi.frontend.area.layouts.main')

@section('content')

<form id="confirm-orders-form" method="get">
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
                            <input type="radio" name="fulfilmentMethod" 
                            value="box-pickup" data-id="1" class="option-address"/>
                            <div>
                                <i class="fas fa-shopping-bag"></i> Self Pickup 
                                <div class="float-end text-muted"></div>
                            </div>
                        </label>
                    </div>
                    <div class="form-group mb-2">
                        <label class="radio-selection">
                            <input type="radio" name="fulfilmentMethod" 
                            value="box-delivery" class="option-address selectDeliver"/>
                            <div><i class="fas fa-shipping-fast"></i> Delivery </div>
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
                        <input type="radio" name="locationPic" 
                        value="{{$merchant->location[0]->id}}" checked />
                        <div>
                            {{$merchant->location[0]->name}}
                            <div class="float-end icon hiidden text-muted">
                                <span class="material-icons">check_circle_outline</span>
                            </div>
                        </div>
                    </label>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="my-2 fw-bold">Recepient</div>
                </div>
                <div class="form-group mb-3">
                    <input type="text" class="f-inputbox" 
                    autocomplete="off" id="name-pickup" name="nameCustPic" />
                    <label class="f-label">Recepient name *</label>
                    <div id="namePicError" role="alert" class="form-text error-message
                    alert alert-danger p-2 d-none">
                        This field is required.
                    </div>
                </div>
                <div class="form-group mb-3">
                    <input type="number" class="f-inputbox numbers" 
                    autocomplete="off" id="phone" name="phoneCustPic" 
                    inputmode="decimal" pattern="[0-9]*" />
                    <label class="f-label">Recepient phone number *</label>
                    <div id="phonePicError" role="alert" class="form-text error-message
                    alert alert-danger p-2 d-none">
                        This field is required.
                    </div>
                </div>
            </div>

            <!-- Pinned address -->
            <div class="mt-3 box hidden" id="show-box-delivery">
                <div class="mb-2"><h5>Location</h5></div>
                <div class="form-group mb-3">
                    <label class="radio-selection">
                        <input type="radio" name="locationDel" 
                        value="{{$merchant->location[0]->id}}" checked />
                        <div>{{$merchant->location[0]->name}}
                            <div class="float-end icon hiidden text-muted">
                            <span class="material-icons">check_circle_outline</span></div>
                        </div>
                    </label>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="my-2 fw-bold">Delivery</div>
                    @if (Auth::check())
                    <button type="button" class="btn btn-sm btn-primary-outline"
                    id="btnSavedAddress" data-bs-toggle="modal" data-bs-target="#modalAddress">
                    <i class="far fa-bookmark"></i> Saved address</button>
                    @endif
                </div>
                <div class="form-group mb-3">
                    <input type="text" class="f-inputbox"
                    autocomplete="off" id="fname" name="nameCustDel"/>
                    <label class="f-label">Recepient name *</label>
                    <div id="nameError" role="alert" class="form-text error-message
                    alert alert-danger p-2 d-none">
                        This field is required.
                    </div>
                </div>
                <div class="form-group mb-3">
                    <input type="text" class="f-inputbox form-control phone_with_ddd"
                    autocomplete="off" id="phone" name="phoneCustDel"
                    inputmode="decimal" />
                    <label class="f-label">Recepient phone number *</label>
                    <div id="phoneError" role="alert" class="form-text error-message
                    alert alert-danger p-2 d-none">
                        This field is required.
                    </div>
                </div>
                <div class="form-group mb-3">
                    <input type="email" class="f-inputbox" autocomplete="off" id="email"
                    name="emailCustDel"/>
                    <label class="f-label">Recepient email address *</label>
                    <div id="emailError" role="alert" class="form-text error-message
                    alert alert-danger p-2 d-none">
                        This field is required.
                    </div>
                </div>
                <div class="form-group mb-3">
                    <textarea class="f-textbox" rows="2" id="address" name="addressCustDel"
                    placeholder="&#10;&nbsp;Floor or room number, lobby ..."></textarea>
                    <label class="f-label">Address *</label>
                    <div id="addressError" role="alert" class="form-text error-message
                    alert alert-danger p-2 d-none">
                        This field is required, please fill your detail location.
                    </div>
                </div>
                <div class="form-group mb-3">
                    <textarea class="f-textbox" rows="2" id="notes" name="notesCustDel"
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
        </div>
    </section>
    
    <section class="devider"></section>
    
    <section class="hidden box show-box-delivery">
        <div class="container-fluid container-xs mt-2">
            <div class="d-flex mt-3">
                <div><h6>Select</h6></div>
            </div>
            <div class="">
                @foreach ($deliveryMethod as $item)
                @if ($item->name != 'Pick Up')
                    <div class="form-group mb-2">
                        <label class="radio-selection">
                            <input type="radio" name="deliveryMethod" 
                            value="{{$item->id}}" data-cost="{{$item->cost_delivery}}" />
                            <div>
                                <img src="/arvi/backend-assets/img/delivery/{{$item->image_url}}" /> - {{$item->name}} 
                                <div class="float-end text-muted">{{$item->currency}} {{$item->cost_delivery}}</div>
                            </div>
                        </label>
                    </div>
                @endif
                @endforeach
            </div>
        </div>
        <section class="devider"></section>
    </section>

    @php
        $i = 1;
        function round_up ( $value, $precision ) { 
            $pow = pow ( 10, $precision ); 
            return ( ceil ( $pow * $value ) + ceil 
            ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow; 
        }
        $sumItem = 0;
        $sumAll = 0;
    @endphp
    @foreach ($orders as $item)
    <section>
        <div class="container-fluid container-xs mt-2">
            <div class="mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div><h6>Order {{$i++}}</h6></div>
                    <div class="small text-theme-primary">{{$item['merchantName']}}</div>
                </div>
                <div class="mt-2">
                    <div class="d-flex justify-content-between mb-2">
                        <div>Shopping ({{$item['totalItems']}} items)</div>
                        <div>{{$merchant->currency}} {{$item['totalPrices']}}</div>
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
                                    {{$fee['value_fee']}}
                                    @php
                                        $sumFees += $fee['value_fee']
                                    @endphp
                                @else
                                    {{round_up($item['totalPrices'] * $fee['value_fee']/100 , 2)}}
                                    @php
                                        $sumFees += round_up($item['totalPrices'] * $fee['value_fee']/100 , 2)
                                    @endphp
                                @endif
                            </div>
                        </div>
                    @endforeach
                    @php
                        $sum = $item['totalPrices'] + $sumFees;
                        $sumItem += $item['totalItems'];
                        $sumAll += $sum;
                    @endphp
                    <div class="d-flex justify-content-between mb-2 border-top pt-2">
                        <div><strong>Sub Total</strong></div>
                        <div><strong>{{$merchant->currency}} {{$sum}}</strong></div>
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
                        <div>{{$merchant->currency}} <span id="total-price">{{$sumAll}}</span></div>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <div>Delivery cost</div>
                        <div>{{$merchant->currency}} <span id="delivery-cost">0</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-last">
        <div class="fixed-bottom bg-white border-top">
            <div class="container-fluid container-xs">
                <div class="d-grid my-2">
                    <button class="btn btn-theme-secondary py-2 text-theme-primary-dark text-white"
                    type="submit" id="confirm-orders">
                        <div class="d-flex justify-content-between">
                            <div>Proccess payment</div>
                            <div class="fw-bold">
                                {{$merchant->currency}} <span id="countQtys">0</span>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </section>
</form>
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
                                    <input type="radio" class="saved-address" name="delivery" data-data="{{ $item }}" />
                                    <div>
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="fw-bold">{{ $item->name }}</div>
                                                <div>{{ $item->phone_number }}</div>
                                            </div>
                                            <div class="small icon">
                                                <i class="fas fa-check-circle text-success"></i>
                                            </div>
                                        </div>
                                        <div class="small">address : {{ $item->address }}</div>
                                        <div class="small">notes : {{ $item->address }}</div>
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
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-grid">
                            <button type="button" class="btn btn-sm btn-theme-secondary"
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

    <script type="text/javascript" src="/arvi/backend-assets/js/demo.js"></script>

    <script>

        // autoinput
        $('.saved-address').on('click',function () {
            let data = $(this).data('data');
            // label auto up
            $('.f-label').addClass('f-up');
            $("input[name='nameCust']").val(data['name']);
            $("input[name='phoneCust']").val(data['phone_number']);
            $("input[name='emailCust']").val(data['email']);
            $("textarea[name='addressCust']").val(data['address']);
            $("textarea[name='notesCust']").val(data['notes']);
        })

        // checkout
        $('#confirm-orders-form').on('submit',function () {
            event.preventDefault();
            // set d-none all message error
            $('.error-message').addClass('d-none');
            if ($("input[name='deliveryMethod']:checked.option-delivery").val()) {
                if ($("input[name='nameCust']").val() == ''
                || $("input[name='phoneCust']").val() == ''
                || $("input[name='emailCust']").val() == ''
                || $("textarea[name='addressCust']").val() == '') {
                    if ($("input[name='nameCust']").val() == '') {
                        $('#nameError').removeClass('d-none');
                    }
                    if ($("input[name='phoneCust']").val() == '') {
                        $('#phoneError').removeClass('d-none');
                    }
                    if ($("input[name='emailCust']").val() == '') {
                        $('#emailError').removeClass('d-none');
                    }
                    if ($("textarea[name='addressCust']").val() == '') {
                        $('#addressError').removeClass('d-none');
                    }
                } else {
                    // get data form
                    let locationId   = '{{$merchant->location[0]->id}}';
                    let savedAddress = $("input[name='savedAddress']:checked").val();
                    let nameCust     = $("input[name='nameCust']").val();
                    let phoneCust    = $("input[name='phoneCust']").val();
                    let emailCust    = $("input[name='emailCust']").val();
                    let addressCust  = $("textarea[name='addressCust']").val();
                    let notesCust     = $("textarea[name='notesCust']").val();
                    let deliveryId   = parseFloat($('input[name="deliveryMethod"]:checked').data('id'))
                    // compact data to object
                    let bioCust = {
                        savedAddress:savedAddress,
                        locationId:locationId,
                        nameCust:nameCust,
                        phoneCust:phoneCust,
                        emailCust:emailCust,
                        addressCust:addressCust,
                        notesCust:notesCust,
                        deliveryId:deliveryId,
                    }
                    $.ajax({
                        url: '{{route("payment-checkout")}}',
                        type: "post",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            cart:sessionStorage.getItem('cart-oobe-indonesia-area'),
                            bioCust:bioCust,
                            deliveryId:deliveryId,
                        } ,
                        success: function (data) {
                            $('#main-content').html(data);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });
                }
            }else{
                $('#deliveryError').removeClass('d-none');
            }
        })

        $(document).ready(function(){
            $('.shopping-cart').hide();
        });

        $('input[name="deliveryMethod"]').on('click',function () {
            $('#delivery-cost').text($('input[name="deliveryMethod"]:checked').data('cost'));
            // total all price
            let delivery = parseFloat($('input[name="deliveryMethod"]:checked').data('cost'));
            let price    = parseFloat($('#total-price').text());
            let total    =  price + delivery;
            $('#countQtys').text(total);
        })

    </script>
    </body>
</html>

@endsection
