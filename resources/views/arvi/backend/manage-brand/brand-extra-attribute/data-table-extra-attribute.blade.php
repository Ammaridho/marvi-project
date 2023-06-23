@foreach ($brandExtraAttributes as $item)

    <!-- extra -->
    <tr class="text-nowrap">
        <td>{{$item->name}}</td>
        <td>{{$item->currency}} {{$item->fee}}</td>
        <td>{{$item->sku}}</td>
        <td>{{$item->uom}}</td>
        <td>{{$item->weight}}</td>
        <td>
            <div class="d-flex justify-content-end align-items-center">
                <script>
                    var brandActive = "{{$item->active}}";
                    if (brandActive == '1') {
                        $("#flexSwitchCheckChecked{{$item->id}}").prop('checked', true);
                    }else{
                        $("#flexSwitchCheckChecked{{$item->id}}").prop('checked', false);
                    }
                    </script>
                <div class="form-check form-switch mt-1 ms-5">
                    <input class="form-check-input flexSwitchCheckChecked"
                    type="checkbox" id="flexSwitchCheckChecked{{$item->id}}"
                    data-data="{{$item}}">
                    <label class="form-check-label" for="flexSwitchCheckChecked{{$item->id}}"></label>
                </div>
                <div class="mx-2">
                    <a href="javascript:void(0);" class="btn btn-sm btn-primary edit-extra-attribute"
                        data-id="{{$item->id}}"><i class="fas fa-pen"></i>
                    </a>
                </div>
            </div>
        </td>
    </tr>
    <!-- //extra -->

@endforeach

<script>
    much_display = {{$brandExtraAttributes->count()}};
    $('#much-display').text(much_display);
</script>
