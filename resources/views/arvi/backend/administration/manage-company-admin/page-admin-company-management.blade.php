<!-- Content wrapper -->
<div class="content-wrapper">

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-start">
        <div class="col-lg-12 col-md-12 col-12">

            <!-- -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><h4 class="m-0">Manage Company</h4></div>
                        <div><a href="javascript:void(0);" class="btn btn-primary text-nowrap" id="add-company"><i class="tf-icons bx bx-plus"></i> Add company</a></div>
                    </div>
                    <hr>

                    <div class="d-flex align-items-center">
                        <div class="mb-3 me-3">
                            <form class="search m-0" onsubmit="return false">
                                <input class="form-control form-control-custom me-2" type="search" id="input-search" 
                                placeholder="Name/Email/Mobile/Company/Brand/Store/Role.." aria-label="Search" autocomplete="off" />
                                <button type="reset">&times;</button>
                            </form>
                        </div>
                        <div class="mb-3 me-3">
                            <select class="dropdown nice filter-data" id="status-data">
                                <option value="all">View company status</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                                <option value="inreview">In Review</option>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive text-nowrap pb-4 always-show" id="table-scroll">
                        <table class="table table-borderless">
                            <thead>
                                <tr class="table-primary text-nowrap border-0">
                                    <th>Company Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tbody-company-list">

                                @foreach ($companies as $item)
                                <!-- company -->
                                <tr class="border-bottom text-nowrap" id="company-list">
                                    <th>{{ $item->name }}</th>
                                    <td class="fw-bold">{{ $item->email }}</td>
                                    <td>{{ $item->phone_number }}</td>
                                    <td>{{ $item->street_address}}</td>
                                    <td>
                                        @php
                                            $status = isset($item->status)?$item->status:'kosong';
                                        @endphp
                                        @if ($status == 'rejected')
                                            <span class="badge bg-label-danger w-100">Rejected</span>
                                        @elseif($status == 'approved')
                                            <span class="badge bg-label-success w-100">Approved</span>
                                        @else
                                            <span class="badge bg-label-warning w-100">in review</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end align-items-center">
                                            <div class="form-check form-switch me-3">
                                                <script>
                                                    var companyActive = "{{$item->active}}";
                                                    if (companyActive == '1') {
                                                        $("#status-{{$item->id}}").prop('checked', true);
                                                    }else{
                                                        $("#status-{{$item->id}}").prop('checked', false);
                                                    }
                                                </script>
                                                <input class="form-check-input btn-checkbox active-company" 
                                                    type="checkbox" id="status-{{$item->id}}" data-data="{{$item}}" value="1">
                                                <label class="form-check-label" for="status-{{$item->id}}">
                                                    {{$item->active == 1 ? 'active' : 'inactive'}}
                                                </label>
                                            </div>
                                            <div class="mx-2"><a href="javascript:void(0);" class="btn btn-sm btn-primary edit-company" data-data="{{ $item }}"><i class="fas fa-pen"></i></a></div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- //company -->
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
    
</div>
</div>
<!-- Content wrapper -->

{{-- modal --}}
<div class="modal fade" id="modaldActiveInActive" tabindex="-1" aria-labelledby="modaldActiveInActive" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom pb-3">
            <h5 class="modal-title">Confirmation</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body center p-3">
                <div class="">You're about to set to <span class="fw-bold text-primary" id="active-status-to-change">Active </span> to this item. Are you sure?</div>
            </div>
            <div class="modal-footer border-top pb-2">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-change-active" data-bs-dismiss="modal" data-data="">Proceed</button>
            </div>
        </div>
    </div>
</div>

<script src="/arvi/backend-assets/js/demo.js"></script>

<script>
    // filter
    $('.filter-data').on('change',function () {
        let status = $('#status-data').val();
        let much = $('#much-data').val();
        $.get("{{route('company-list-table',['companyCode' => $companyCode])}}",{status:status,much:much},function (data) {
            $('#tbody-company-list').html(data);
        })
    })

    // active
    $('.active-company').on('click',function () {

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
            url: "{{ route('company-update',['companyCode' => $companyCode]) }}",
            data: {statusActive:statusActive,id:id,"_token": token},
            success: function (data) {
                $('#manage-company').trigger("click");
            }
        })

    })

    // search order
    $("#input-search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tbody-company-list tr#company-list").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // button openform add company
    $('#add-company').on('click',function () {
        $.get("{{route('company-create',['companyCode' => $companyCode])}}",function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // button open form edit company
    $('.edit-company').on('click',function () {
        dataUser = $(this).data('data');
        $.get("{{route('company-edit',['companyCode' => $companyCode])}}",
        {dataUser:dataUser},function (data) {
            $('#contentDashboard').html(data);
        })
    })
</script>


