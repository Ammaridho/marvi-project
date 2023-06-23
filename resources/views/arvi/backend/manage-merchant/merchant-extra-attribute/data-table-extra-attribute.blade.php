@foreach ($merchantExtraAttributes as $item)

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
                    var merchantActive = "{{$item->active}}";
                    if (merchantActive == '1') {
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
@foreach ($brandExtraAttribute as $item)

    <!-- extra -->
    <tr class="text-nowrap">
        <td>{{$item->name}}</td>
        <td class="fw-bold">{{$item->currency}} {{$item->fee}}</td>
        <td>
            <div class="d-flex justify-content-end align-items-center">
                <script>
                    var merchantActive = "{{$item->active}}";
                    if (merchantActive == '1') {
                        $("#flexSwitchCheckChecked{{$item->id}}").prop('checked', true);
                    }else{
                        $("#flexSwitchCheckChecked{{$item->id}}").prop('checked', false);
                    }
                    </script>
                <div class="form-check form-switch mt-1 ms-5">
                    <input class="form-check-input flexSwitchCheckChecked"
                    type="checkbox" id="flexSwitchCheckChecked{{$item->id}}"
                    data-data="{{$item}}" disabled>
                    <label class="form-check-label" for="flexSwitchCheckChecked{{$item->id}}"></label>
                </div>
                <div class="mx-2">
                    <a href="javascript:void(0);" class="btn btn-sm btn-primary edit-extra-attribute disabled"
                        data-id="{{$item->id}}"><i class="fas fa-pen"></i>
                    </a>
                </div>
            </div>
        </td>
    </tr>
    <!-- //extra -->

@endforeach

<script>
    much_display = {{$merchantExtraAttributes->count()}};
    $('#much-display').text(much_display);
</script>
