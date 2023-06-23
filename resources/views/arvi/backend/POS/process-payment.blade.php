<body class="mobile theme-default">

    <section>
        <div class="container-fluid container-xs" id="asd">
            
            <!-- payment succsess -->
            <div class="d-flex align-items-center 
            justify-content-center vh-100">
                <div class="text-center">
                    <div class="mb-3 text-warning">
                        <span class="material-icons md-48">
                            hourglass_top
                        </span>
                    </div>
                    <h2 class="text-theme-primary">Waiting for Payment</h2>
                    <div>Pleased proceed to pay the transaction.</div>
                    <hr>
                    @if (isset($data->qr_string))
                        <div class="visible-print text-center">
                            {!! \QRCode::text($data->qr_string)->setSize(5)->svg() !!}
                        </div>
                    @endif
                    <div class="small">AMOUNT PAID</div>
                    <div class="fw-bold fs-5">
                        {{$data->payment->currency}} 
                        {{number_format($data->payment->totalPrice)}}
                    </div>


                    <hr>
                    <div class="small mb-2">
                        Refrence #OOBE-{{$data->merchant_order_id}} <br />
                        Name : {{$data->payment->name}}<br />
                        Payment method : {{$data->payment->channel_code}}<br />
                        @if ($data->payment->channel_code == 'OVO')
                            phone account number : <a href="#" 
                            onclick="copyToClipboard('#{{$data->noTelpOvo}}')">
                            <u id="{{$data->noTelpOvo}}">{{$data->noTelpOvo}}</u> 
                            <i class="far fa-copy small"></i></a>
                        @endif
                    </div>
                    <div class="small mb-2">
                        <button type="button" class="btn btn-warning" 
                        id="change-payment">Change Payment</button>
                    </div>
                    <div class="small mb-2">
                        <button type="button" class="btn btn-danger" 
                        id="cancel-order">Cancel</button>
                    </div>
                </div>
            </div>    
            <!-- //payment succsess -->

               

        </div>
    </section>

    <section class="fixed-bottom text-center p-2 mb-3">
        <img src="/frontend-oobe-indonesia/assets/img/logo/oobe-logo-horizontal-dt.png" class="img-80">
    </section>

    <!-- =================================================================
    MODAL
    ================================================================== -->


    <script>

        //copy
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
        }

        // javascript check data transaction already paid
        var ps = 0;
        var setTo;
        var orderId = "{{$data->merchant_order_id}}";
        var channel_code = "{{$data->payment->channel_code}}"
        function checkPayment(){
            $.ajax({
                url: '{{route("pos-check-payment-callback",["companyCode"=>$companyCode])}}',
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    paymentId:"{{$data->payment->id}}",
                } ,
                success: function (ps) {
                    if (ps == 1) {
                        $.get("{{route('pos-payment-success',['companyCode'=>$companyCode])}}",
                            {orderId:orderId,channel_code:channel_code},function (data1) {
                                $('#modalDone').find('.modal-content').html(data1);
                        })
                    }else{
                        setTo = setTimeout(checkPayment, 5000);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
                }
            });
        }
        checkPayment();


        // cancel
        $('#cancel-order').on('click',function () {
            clearTimeout(setTo);
            $.ajax({
                url: '{{route("pos-cancel-payment",["companyCode"=>$companyCode])}}',
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    paymentId:"{{$data->payment->id}}"
                } ,
                success: function (data) {
                    $.get("{{route('pos-payment-failed',['companyCode'=>$companyCode])}}",
                        {orderId:orderId,channel_code:channel_code},function (data1) {
                            $('#modalDone').find('.modal-content').html(data1);
                    })
                },
                error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
                }
            });
        })

        // change payment
        $('#change-payment').on('click',function () {
            clearTimeout(setTo);
            let merchantId = '{{$data->merchantId}}';
            let selesType = '{{$data->selesType}}';
            let totalPrice = '{{$data->totalPrice}}';
            $.ajax({
                url: '{{route("pos-cancel-payment",["companyCode"=>$companyCode])}}',
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    paymentId:"{{$data->payment->id}}"
                } ,
                success: function (data) {
                    $.get("{{route('pos-choose-payment',['companyCode'=>$companyCode])}}",
                    {
                        cart:JSON.parse(sessionStorage.getItem('cart-pos-cashier')),
                        merchantId:merchantId,
                        selesType:selesType,
                        totalPrice:totalPrice,
                    },function (data) {
                        $('#modalCharge').find('.modal-content').html(data);
                        $('#modalDone').modal('hide');
                    });
                    $('#modalCharge').modal('show');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
                }
            });
        });

    </script>
    </body>
