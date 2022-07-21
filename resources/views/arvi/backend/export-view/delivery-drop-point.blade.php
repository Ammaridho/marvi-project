<div class="row">
    <div class="scrollable">
        <table class="table table-bordered table-hover">
            <thead>
                <tr class="bg-dark text-white">
                    <th colspan="5"></th>
                    <th colspan="5">Last Update : {{ $noww->format('D, d-M-Y h:m:s') }}</th>
                </tr>
                <tr class="sticky-top bg-dark text-white">
                    <th>No</th>
                    <th>Delivery Date</th>
                    <th>Delivery Address</th>
                    <th>Black Coffee</th>
                    <th>Strong Black Coffee</th>
                    <th>Oat Milk Coffee</th>
                    <th>Milk and Manuka Honey Coffee</th>
                    <th>Hojicha Green Tea</th>
                    <th>Rooibos Orange Tea</th>
                    <th>Total Item</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                    $temp_day_deliver = '';
                    $temp_address = '';
                @endphp
                @foreach ($joinForDeliveryDropPoints as $key => $item)
                    @if (!($temp_day_deliver == $item->day_deliver && $temp_address == $item->address))
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $item->day_deliver }}</td>
                            <td>{{ $item->address }}</td>
                            @foreach ($products as $itemP)
                                {{-- print quantity product --}}
                                <td class="total-{{ $key }}">
                                {{ isset( $deliveryDropPointNew[$item->day_deliver][$item->address][$itemP->id]) ? 
                                $deliveryDropPointNew[$item->day_deliver][$item->address][$itemP->id] : 0 }}
                                </td>
                            @endforeach
                            <td id="result-total-{{ $key }}">
                                {{array_sum($deliveryDropPointNew[$item->day_deliver][$item->address])}}
                            </td>
                        </tr>
                        @php
                            $i++;
                            $temp_day_deliver = $item->day_deliver;
                            $temp_address = $item->address;
                        @endphp
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>