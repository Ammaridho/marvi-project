<table id="table_order" class="table table-bordered table-hover">
    <thead>
        <tr class="bg-dark text-white">
            <th colspan="10"></th>
            <th colspan="5">Last Update : {{ $noww->format('D, d-M-Y h:m:s') }}</th>
        </tr>
        <tr class="sticky-top bg-dark text-white">
            <th>Order Date</th>
            <th>Delivery Date</th>
            <th>Order Id</th>
            <th>Customer Name</th>
            <th>Customer Email</th>
            <th>Customer Phone</th>
            <th>Delivery Type</th>
            <th>Address</th>
            <th>Black Coffee</th>
            <th>Strong Black Coffee</th>
            <th>Oat Milk Coffee</th>
            <th>Milk and Manuka Honey</th>
            <th>Coffee	Hojicha Green Tea</th>
            <th>Rooibos Orange Tea</th>
            <th>Total Item</th>
        </tr>
    </thead>
    <tbody >
        @foreach ($joinForOrderDetails as $item)
            <tr class="od-{{ date("d-m-Y", strtotime($item->create_time)) }} 
                dd-{{ date("d-m-Y", strtotime($item->day_deliver)) }}  all-order">
                <td>{{ date("d-m-Y h:m:s", strtotime($item->create_time)) }}</td>
                <td>{{ date("d-m-Y", strtotime($item->day_deliver)) }}</td>
                <td>{{ $item->id }}</td>
                <td class="align-left">{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->mobile_number }}</td>
                <td>Pickup</td>
                <td class="align-left">{{ $item->address }}</td>
                @for ($i = 1; $i <= $countProduct; $i++) {{-- set itteration for print quantity product --}}
                <td class="qty{{$i}}">{{!empty($productsOrder[$item->id][$i]) ? 
                (int)$productsOrder[$item->id][$i] : (int)0}}</td>
                @endfor
                <td class="qtyTotal">{{array_sum($productsOrder[$item->id])}}</td>
            </tr>
        @endforeach       
            {{-- sum --}}
            <tr>
                <td colspan="7"></td>
                <td>Total</td>
                <td id="result1">0</td>
                <td id="result2">0</td>
                <td id="result3">0</td>
                <td id="result4">0</td>
                <td id="result5">0</td>
                <td id="result6">0</td>
                <td id="resultTotal">0</td>
            </tr>
    </tbody>
</table>
<script src="/arvi/backend-assets/vendor/libs/jquery/jquery.js"></script>
<script>
    countAll();
        // count all product
        function countAll() {
            for (let i = 1; i <= 6; i++) {
                var sum = 0;
                $(`td.qty${i}`).each(function() {
                    if(!($(this).is(":hidden"))){
                    sum += Number($(this).text());
                    }
                });
                $(`#result${i}`).text(sum);
            }
            // count all product total
            var sum = 0;
            $(`td.qtyTotal`).each(function() {
                if(!($(this).is(":hidden"))){
                    sum += Number($(this).text());
                }
            });
            $(`#resultTotal`).text(sum);
        }
    $(document).ready(function () {
        
    })
</script>