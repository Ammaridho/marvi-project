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
            @foreach ($products as $item)
                <th>{{$item->name}}</th>
            @endforeach
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
                @foreach ($products as $itemP)
                    <td>
                        {{!empty($productsOrder[$item->id][$itemP->id]) ? 
                        (int)$productsOrder[$item->id][$itemP->id] : (int)0}}
                    </td>
                @endforeach
                <td class="qtyTotal">{{array_sum($productsOrder[$item->id])}}</td>
            </tr>
        @endforeach       
            {{-- sum --}}
            <tr>
                <td colspan="7"></td>
                <td>Total</td>
                @foreach ($products as $itemP)
                    @php
                        $qtyP = 0;
                    @endphp
                    <td>
                        @foreach ($joinForOrderDetails as $item)
                            @php
                                $qtyP += (!empty($productsOrder[$item->id][$itemP->id]) ? 
                                (int)$productsOrder[$item->id][$itemP->id] : (int)0);
                            @endphp
                        @endforeach
                        {{$qtyP}}
                    </td>
                @endforeach
                <td>
                    @php
                        $qtyP = 0;
                    @endphp
                    @foreach ($products as $itemP)
                        @foreach ($joinForOrderDetails as $item)
                            @php
                                $qtyP += (!empty($productsOrder[$item->id][$itemP->id]) ? 
                                (int)$productsOrder[$item->id][$itemP->id] : (int)0);
                            @endphp
                        @endforeach
                    @endforeach
                    {{$qtyP}}
                </td>
            </tr>
    </tbody>
</table>