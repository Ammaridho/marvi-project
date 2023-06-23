<table class="table table-sm small">

    @if (count($shoppingCarts)<1)
        <tr>
            <td class="text-center">           
                <div class="text-theme-primary fw-bold text-center mb-3">
                    Empty, please choose product!
                </div>
            </td>
        </tr>
    @else

        @foreach ($shoppingCarts as $key => $item)

        <tr>
            <td class="text-nowrap w-100">
                <div class="fw-bold">{{$item['product']['name']}}</div>
                <!-- variant -->
                @if ($item['variant'])
                    {{-- <strong>Variant: </strong> --}}
                    <div class="text-grays">{{$item['variant']['name']}}</div>
                @endif
                <!-- attribute -->
                @if ($item['attribute'])
                <div>
                    {{-- <strong>Extra Condiments: </strong><br> --}}
                        @foreach ($item['attribute'] as $item1)
                            <div class="text-grays">{{$item1['name']}} 
                                {{$item1['qty']>1?$item1['qty'].'x':''}}</div>
                            {{-- <br> --}}
                        @endforeach
                    </div>
                @endif
                <!-- extra-attribute -->
                @if ($item['extraAttribute'])
                <div>
                    {{-- <strong>Extra Cutlery: </strong><br> --}}
                        @foreach ($item['extraAttribute'] as $item2)
                            <div class="text-grays">{{$item2['name']}} 
                                {{$item2['qty']>1?$item2['qty'].'x':''}}</div>
                            {{-- <br> --}}
                        @endforeach
                    </div>
                @endif
            </td>
            <td class="text-nowrap">
                <div class="mx-4">x {{$item['qty']}}</div>
            </td>
            <td class="text-nowrap text-end price-product" 
            data-price="{{$item['totalPriceAll']}}">
                @if ($item['discount']>0)
                    <s class="text-danger">{{$item['product']['currency']}} 
                        {{number_format($item['totalPriceAll']-$item['discount']+$item['price'])}}</s>  
                @endif
                {{$item['product']['currency']}} 
                {{number_format($item['totalPriceAll'])}}
            </td>
            <td class="text-nowrap text-center">
                <button class="btn btn-sm btn-link text-danger 
                delete-item-cart" data-id="{{$key}}">
                    <i class="bx bx-trash"></i>
                </button>
           </td>
        </tr>

        @endforeach
        <tr class="d-none">
            <td><span class="fw-bold m-0">Discount</span></td>
            <td class="text-nowrap">
                <div class="mx-4"></div>
            </td>
            <td class="text-nowrap text-end">(Rp 5.000)</td>
        </tr>
        <tr>
            <td><span class="fw-bold m-0">Sub-Total</span></td>
            <td class="text-nowrap">
                <div class="mx-4"></div>
            </td>
            <td class="text-nowrap text-end">
                {{$item['product']['currency']}} <span id="sub-total"></span>
            </td>
            <td></td>
        </tr>
        <tr class="d-none">
            <td><span class="text-grays">Service Charge (15%)</span></td>
            <td class="text-nowrap">
                <div class="mx-4"></div>
            </td>
            <td class="text-nowrap text-end text-grays">Rp 10.000</td>
        </tr>
        @php
        function round_up ( $value, $precision ) { 
            $pow = pow ( 10, $precision ); 
            return ( ceil ( $pow * $value ) + ceil 
            ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow; 
        }
            $sumFees = 0; 
            $sum     = 0;
        @endphp
        @foreach ($fees as $key => $fee)
            <tr>
                <td>
                    <span class="text-grays">{{$fee['name']}}</span>
                </td>
                <td class="text-nowrap">
                    <div class="mx-4"></div>
                </td>
                <td class="text-nowrap text-end text-grays">
                    @if ($fee['type_value'] == 'fixed')
                        {{$fee['currency']}} {{number_format($fee['value_fee'])}}
                        @php
                            $sumFees += $fee['value_fee']
                        @endphp
                    @else
                        @if ($fee['currency'] == 'IDR')
                            ({{$fee['value_fee']}}%) = {{$fee['currency']}} 
                            {{number_format(ceil(round_up($totalPrice * 
                            $fee['value_fee']/100 , 2)))}}
                            @php
                                $sumFees += ceil(round_up($totalPrice * 
                                $fee['value_fee']/100 , 2))
                            @endphp
                        @else
                            ({{$fee['value_fee']}}%) = {{$fee['currency']}} 
                            {{number_format(round_up($totalPrice * 
                            $fee['value_fee']/100 , 2))}}
                            @php
                                $sumFees += round_up($totalPrice * 
                                $fee['value_fee']/100 , 2)
                            @endphp
                        @endif
                    @endif
                </td>
                <td></td>
            </tr>
        @endforeach
        <tr>
            <td class="text-nowrap">
                <h6 class="fw-bold m-0">Total</h6>
            </td>
            <td class="text-nowrap">
                <div class="mx-4"></div>
            </td>
            <td class="text-nowrap text-end">
                <h6 class="fw-bold m-0" id="total-price" data-total="{{$sumFees+$totalPrice}}">
                    {{$currency}} {{number_format($sumFees+$totalPrice)}}
                </h6>
            </td>
            <td></td>
        </tr>
        <script>
            $('#submit-charge').text('Charge {{$currency}} {{number_format($sumFees+$totalPrice)}}');
        </script>
    @endif

</table>

<script>

    var sum = 0;
    $('.price-product').each(function(){
        sum += parseFloat($(this).data('price'));  // Or this.innerHTML, this.innerText
    });
    $('#sub-total').text(thousands_separators(sum));

    function thousands_separators(num)
    {
      var num_parts = num.toString().split(".");
      num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return num_parts.join(".");
    }
    
    // delete specific item in shopping cart
    $('.delete-item-cart').on('click',function () {
        let id = $(this).data('id');
        cart = JSON.parse(sessionStorage.getItem('cart-pos-cashier'));
        // delete item
        delete cart[id];
        // delete empty
        var filtered = cart.filter(elm => elm);
        // store
        sessionStorage.setItem('cart-pos-cashier', JSON.stringify(filtered));
        // refresh cart
        refreshPOSCart();
    })
</script>