<td colspan="9">
    <div class="m-2">
        <table class="table table-sm table-bordered report">
            <tr>
                @foreach ($products as $itemP)
                    <th>{{$itemP['name']}}</th>
                @endforeach
            </tr>
            <tr>
                @foreach ($products as $itema)
                    <td>
                        @foreach ($rows as $itemb)
                            {{$itema['name'] == $itemb->name ? $itemb->total : ''}}
                        @endforeach
                    </td>
                @endforeach
            </tr>
        </table>
    </div>
</td>
