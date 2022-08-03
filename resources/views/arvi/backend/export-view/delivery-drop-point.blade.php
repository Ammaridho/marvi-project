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
                    @foreach ($products as $item)
                        <th>{{$item->name}}</th>
                    @endforeach
                    <th>Total Item</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($displayData as $key => $item)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $item['day_deliver'] }}</td>
                        <td>{{ $item['address'] }}</td>
                        @foreach ($item['dataProduct'] as $itemP)
                            <td>{{$itemP}}</td>
                        @endforeach
                        <td>
                            {{$item['totalItem']}}
                        </td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>
</div>