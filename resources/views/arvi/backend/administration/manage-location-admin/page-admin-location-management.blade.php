<!-- Content -->
<div class="row justify-content-start">
    <div class="col-lg-12 col-md-12 col-12">
        <!-- -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div><h4 class="m-0">Manage Location</h4></div>
                    <div>
                        <a href="javascript:void(0);" class="btn btn-primary text-nowrap" id="add-location">
                            <i class="tf-icons bx bx-plus"></i> Add location
                        </a>
                    </div>
                </div>
                <hr>
                <div class="d-flex align-items-center">
                    <div class="mb-3 me-3">
                        <form class="search m-0" onsubmit="return false">
                            <input class="form-control form-control-custom me-2" type="search" id="input-search" 
                            placeholder="Name/Address/Postal/Description.." 
                            aria-label="Search" autocomplete="off" />
                            <button type="reset">&times;</button>
                        </form>
                    </div>
                    <div class="mb-3 me-3">
                        <select class="dropdown nice filter-data" id="filter-data">
                            <option data-display="Filter">Filter</option>
                            <option disabled>Status</option>
                            <option value="1">Active</option>
                            <option value="0">In Active</option>
                            <option disabled>Location type</option>
                            <option>Office Building</option>
                            <option>Hospital</option>
                            <option>Mall</option>
                            <option>Restaurant</option>
                            <option>Cloud Kitchen</option>
                            <option>Pop-ups</option>
                            <option>Food Truck</option>
                            <option>Cafe</option>
                            <option>Fast Food</option>
                            <option>Food Court</option>
                            <option>School/College</option>
                            <option>Public Area</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive text-nowrap pb-4 always-show" id="table-scroll">
                    <table class="table table-borderless">
                        <thead>
                            <tr class="table-primary text-nowrap border-0">
                                <th class="text-center"><i class="fas fa-qrcode"></i></th>
                                <th>Location Name</th>
                                <th>code</th>
                                <th>go to area</th>
                                <th>Address</th>
                                <th>Postal</th>
                                <th>Description</th>
                                <th>Geo Tag</th>
                                <th>Radius Area</th>
                                <th>Location Type</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tbody-location-list">
                            @foreach ($locations as $item)
                                <!-- loc -->
                                <tr class="border-bottom text-nowrap" id="location-list">
                                    <td><a href="javascript:void(0);" data-bs-toggle="modal" 
                                    data-bs-target="#modalLocationGenerateQR">QR Code</a></td>
                                    <th>{{$item->name}}</th>
                                    <td>{{$item->code}}</td>
                                    <td><a href="{{route('index-area',['code'=>$item->code])}}" target="_blank">Go to area..</a></td>
                                    <td>{{$item->address}},{{$item->city}}</td>
                                    <td>{{$item->postal_code}}</td>
                                    <td>{{$item->description}}</td>
                                    <td>{{$item->loc_lat}}, {{$item->loc_lon}}</td>
                                    <td>{{$item->loc_aware_tolerance}} m</td>
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
                                            <div class="mx-2">
                                                <a href="javascript:void(0);" class="btn btn-sm btn-primary edit-location"
                                                data-data="{{ $item }}">
                                                    <i class="fas fa-pen">
                                                    </i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- //loc -->
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center text-muted mt-1"><i class="fas fa-exchange-alt"></i></div>
                <!-- showing data -->
                <div class="d-flex justify-content-end align-items-center mt-4">
                    <div class="text-muted small me-3">Showing 25 from 143</div>
                    <div class="">
                        <select class="dropdown nice filter-data" id="much-data">
                            <option value="25" selected>Showing 25 rows</option>
                            <option value="50">Showing 50 rows</option>
                            <option value="100">Showing 100 rows</option>
                            <option value="150">Showing 150 rows</option>
                            <option value="all">Showing all rows</option>
                        </select>
                    </div>
                </div>
                <!-- //showing data -->
            </div>
        </div>
        <!-- // -->
    </div>
</div>
<!-- Content -->

{{-- modal --}}
<div class="modal fade" id="modaldActiveInActive" tabindex="-1" 
aria-labelledby="modaldActiveInActive" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom pb-3">
            <h5 class="modal-title">Confirmation</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" 
            aria-label="Close"></button>
            </div>
            <div class="modal-body center p-3">
                <div class="">You're about to set to 
                    <span class="fw-bold text-primary" id="active-status-to-change">
                        Active 
                    </span> 
                    to this item. Are you sure?
                </div>
            </div>
            <div class="modal-footer border-top pb-2">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-change-active" 
                data-bs-dismiss="modal" data-data="">Proceed</button>
            </div>
        </div>
    </div>
</div>

{{-- script plugin --}}
<script type="text/javascript" src="/arvi/backend-assets/js/demo.js"></script>

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

    // filter
    $('.filter-data').on('change',function () {
        let filter = $('#filter-data').val();
        let much = $('#much-data').val();
        $.get("{{route('location-list-table',['companyCode' => $companyCode])}}",
        {filter:filter,much:much},function (data) {
            $('#tbody-location-list').html(data);
        })
    })

    // search order
    $("#input-search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tbody-location-list tr#location-list").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // button openform add location
    $('#add-location').on('click',function () {
        $.get("{{route('location-create',['companyCode' => $companyCode])}}",function (data) {
            $('#contentDashboard').html(data);
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
