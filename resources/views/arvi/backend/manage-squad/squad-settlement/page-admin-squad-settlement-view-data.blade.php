@php $a = 0; @endphp
@foreach ($settlements as $item)
    <!-- 1 -->
    <tr class="border-bottom text-nowrap" id="settlement-list">
        <td>
            <div class="form-check">
                <input class="form-check-input opsi" type="checkbox" name="opsi" 
                value="{{$item->id}}" id="opsiaja-{{$a}}">
            </div>
        </td>
        <td>#OD-{{$item->id}}</td>
        <td>{{ date("d M Y h:m:s", strtotime($item->transaction_date)) }}</td>
        <td>
            @if ($item->progress_status==0)
                <span class="badge bg-label-danger w-100">failed</span>
            @elseif($item->progress_status==1)
                <span class="badge bg-label-warning w-100">on progress</span>
            @else
                <span class="badge bg-label-primary w-100">success</span>
            @endif
        </td>
        <td><span class="badge bg-primary">{{$item->location}}</span></td>
        <td>{{$item->store}}</td>
        <td>{{$item->customer}}</td>
        <td>
            @foreach (App\Models\MerchantOrderDetail::
            join('merchant_products','merchant_order_details.product_id','=',
                'merchant_products.id')
            ->select(
                'merchant_products.name as name',
                'merchant_products.retail_price as retail_price',
                'merchant_order_details.qty as qty',
            )
            ->where('merchant_order_details.merchant_order_id',$item->id)
            ->get() as $product)
                {{$product->name}}({{$product->qty}}),
            @endforeach
        </td>
        {{-- product price --}}
        <td class="text-end">
            @php
            $totalPrice = 0;
            foreach (App\Models\MerchantOrderDetail::
                join('merchant_products','merchant_order_details.product_id','=',
                    'merchant_products.id')
                ->where('merchant_order_details.merchant_order_id',$item->id)
                ->get() as $key => $value) {
                    $totalPrice += $value->retail_price * $value->qty;
            }
            @endphp
            {{$totalPrice}}
        </td>
        {{-- fees ========================================= --}}
        <td>
            @php
                $totalFees = 0;
                if (isset($item->fees)) {
                    foreach ($item->fees as $key => $value) {
                    if ($value->type_value == 'fixed') {
                        $totalFees +=  $value->value_fee;
                    } else {
                        $totalFees +=  $value->value_fee/100 * $totalPrice;
                    }
                    }
                }
            @endphp
            {{$totalFees}}
        </td>
        {{-- total --}}
        <td class="text-end">
            {{$totalPrice+$totalFees}}
        </td>
        <script>
            $('#opsiaja-'+'{{$a}}').val('{{$totalPrice+$totalFees}}');
        </script>
        <td class="text-end">{{$item->remaining}}</td>
        <td>
            @if ($item->settlement_status==0)
                <span class="badge bg-label-danger w-100">unsettled</span>
            @elseif($item->settlement_status==1)
                -
            @else
                <span class="badge bg-label-primary w-100">settled</span>
            @endif
        </td>
        <td>{{ date("d M Y h:m:s", strtotime($item->settlement_date)) }}</td>
    </tr>
    <!-- //1 -->
    @php
        $a++;
    @endphp
@endforeach

                                