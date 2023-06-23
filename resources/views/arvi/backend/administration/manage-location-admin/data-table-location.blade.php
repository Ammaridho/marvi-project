@foreach ($locations as $item)
    <!-- loc -->
    <tr class="border-bottom text-nowrap" id="location-list">
        <td><a href="javascript:void(0);" data-bs-toggle="modal" 
            data-bs-target="#modalLocationGenerateQR">QR Code</a></td>
        <th>{{$item->name}}</th>
        <td>{{$item->code}}</td>
        <td>{{$item->address}},{{$item->city}}</td>
        <td>{{$item->postal_code}}</td>
        <td>{{$item->description}}</td>
        <td>{{$item->loc_lat}}, {{$item->loc_lon}}</td>
        <td>{{$item->loc_aware_tolerance}} {{strtolower($item->loc_aware_uom)}}</td>
        @php
            $types = '';
            if ($item->location_type != 'Building' && $item->location_type != null) {
                $typeData = json_decode($item->location_type);
                foreach ($typeData as $key => $value) {
                    $types .= $value.', ';
                }
            } else {
                $types = '-';
            }
            
        @endphp
        <td>{{$types}}</td>
        <td>
            <div class="d-flex justify-content-end align-items-center">
                <div class="form-check form-switch me-3">
                    <script>
                        var locationActive = "{{$item->active}}";
                        if (locationActive == '1') {
                            $("#status-{{$item->id}}").prop('checked', true);
                        }else{
                            $("#status-{{$item->id}}").prop('checked', false);
                        }
                    </script>
                    <input class="form-check-input btn-checkbox active-location" 
                        type="checkbox" id="status-{{$item->id}}" data-data="{{$item}}" value="1">
                    <label class="form-check-label" for="status-{{$item->id}}">
                        {{$item->active == 1 ? 'active' : 'inactive'}}
                    </label>
                </div>
                <div class="mx-2"><a href="javascript:void(0);" class="btn btn-sm btn-primary edit-location" 
                    data-data="{{ $item }}"><i class="fas fa-pen"></i></a></div>
            </div>
        </td>
    </tr>
    <!-- //loc -->
@endforeach

<script>
    // active
    $('.active-location').on('click',function () {
        let data = $(this).data('data');
        $('#save-change-active').data('data',data);
        if (data['active'] == 1) {
            $('#active-status-to-change').html('<span class="fw-bold text-danger">inactive</span>');
        } else {
            $('#active-status-to-change').html('<span class="fw-bold text-success">active</span>');
        }
        // show modal
        $('#modaldActiveInActive').modal('show');
        // check old status active
        // if not checked ============================================================
        if($(this).is(":checked")){
            $(this).prop('checked', false);
        // if checked ============================================================
        }else if($(this).is(":not(:checked)")){
            $(this).prop('checked', true);
        }
    })

    // save switch check active inactive
    $('#save-change-active').on('click',function () {
        let data = $(this).data('data');
        let statusActive = data['active'] == '1' ? '0': '1' ;
        let id = data['id'];
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: 'PUT',
            url: "{{ route('location-update',['companyCode' => $companyCode]) }}",
            data: {statusActive:statusActive,id:id,"_token": token},
            success: function (data) {
                $('#manage-location-admin').trigger("click");
            }
        })
    })

    // button open form edit location
    $('.edit-location').on('click',function () {
        dataLocation = $(this).data('data');
        $.get("{{route('location-edit',['companyCode' => $companyCode])}}",
        {dataLocation:dataLocation},function (data) {
            $('#contentDashboard').html(data);
        })
    })
</script>