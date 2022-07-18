{{-- {{ dd($test) }} --}}
<div class="row">

    <div class="scrollable">
    
        <table class="table table-bordered table-hover">
            <thead>

                <tr class="sticky-top bg-dark text-white">
                    <th>No</th>
                    <th>Delivery Date</th>
                    <th>Delivery Address</th>
                    <th>Black Coffee</th>
                    <th>Strong Black Coffee</th>
                    <th>Oat Milk Coffee</th>
                    <th>Milk & Manuka Honey Coffee</th>
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
                @foreach ($joinForDeliveryDropPoints as $item)
                    @if (!($temp_day_deliver == $item->day_deliver && $temp_address == $item->address))
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $item->day_deliver }}</td>
                            <td>{{ $item->address }}</td>
                            @foreach ($products as $itemP)
                                <td>on develop</td>
                            {{-- <td class="total-{{ $i }}">{{ isset( $deliveryDropPoint[$item->day_deliver][$item->address][$item->id][$itemP->id]) ?  array_sum($deliveryDropPoint[$item->day_deliver][$item->address][$item->id][$itemP->id]) : 0 }}</td> print quantity product --}}
                            @endforeach
                            <td id="result-total-{{ $i }}"></td>
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

<script>
    $(document).ready(function () {
        for (let i = 1; i <= {{ count($joinForDeliveryDropPoints) }}; i++) {
            var sum = 0;
            $(`td.total-${i}`).each(function () {
                sum += Number($(this).text());
            })
            $(`#result-total-${i}`).text(sum);
        }
    })
</script>