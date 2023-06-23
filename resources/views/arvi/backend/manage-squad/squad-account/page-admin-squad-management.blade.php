<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-start">
            <div class="col-lg-12 col-md-12 col-12">
                <!-- -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div><h4 class="m-0">Squad Account</h4></div>
                            <div>
                                <a href="javascript:void(0);" class="btn btn-primary text-nowrap"
                                id="add-squad">
                                    <i class="tf-icons bx bx-plus"></i> Add squad
                                </a>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex align-items-center">
                            <div class="mb-3 me-3">
                                <form class="search m-0" onsubmit="return false">
                                    <input class="form-control form-control-custom me-2"
                                    type="search" id="input-search"
                                    placeholder="Name/Phone/location.."
                                    aria-label="Search" autocomplete="off" />
                                    <button type="reset">&times;</button>
                                </form>
                            </div>
                            <div class="mb-3 me-3">
                                <select class="dropdown nice filter-data" id="filter-data">
                                    <option value="all" data-display="Filter">Filter</option>
                                    <option disabled>Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">In Active</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive text-nowrap pb-4 always-show" id="table-scroll">
                            <table class="table table-borderless">
                                <thead>
                                    <tr class="table-primary text-nowrap border-0">
                                        <th>Full Name</th>
                                        <th>Mobile</th>
                                        <th>Assigned Location</th>
                                        <th>Last Login</th>
                                        <th>Last Taking Order</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-squad-list">
                                    @foreach ($squads as $item)
                                    <!-- squad -->
                                    <tr class="border-bottom text-nowrap" id="squad-list">
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->phone_number}}</td>
                                        <td><span class="badge bg-primary">{{$item->location}}</span></td>
                                        <td>{{$item->last_login == null ? '-' :
                                        date("d M Y h:m:s", strtotime($item->last_login)) }}</td>
                                        <td>{{$item->last_taking_order == null ? '-' :
                                        date("d M Y h:m:s", strtotime($item->last_taking_order)) }}</td>
                                        <td>
                                            <div class="d-flex justify-content-end align-items-center">
                                                <div class="form-check form-switch me-3">
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
                                                        <label class="form-check-label" for="flexSwitchCheckChecked{{$item->id}}">
                                                            {{$item->active == 1 ? 'Active' : 'In active'}}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="mx-2">
                                                    <a href="javascript:void(0);" class="btn btn-sm btn-primary edit-squad"
                                                    data-id="{{$item->id}}">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- //squad -->
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

<script src="/arvi/backend-assets/js/demo.js"></script>

<script>
    // filter
    $('.filter-data').on('change',function () {
        let filter = $('#filter-data').val();
        let much = $('#much-data').val();
        $.get("{{route('squad-account-list-table',['companyCode' => $companyCode])}}",
        {filter:filter,much:much},function (data) {
            $('#tbody-squad-list').html(data);
        })
    })

    // search
    $("#input-search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tbody-squad-list tr#squad-list").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // button form edit category
    $('.edit-squad').on('click',function () {
        let id = $(this).data('id');
        $.get("{{route('squad-account-edit',['companyCode' => $companyCode])}}",
        {id:id},function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // button openform add squad
    $('#add-squad').on('click',function () {
        $.get("{{route('squad-account-create',['companyCode' => $companyCode])}}",function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // click check active inactive
    $('.flexSwitchCheckChecked').on('click',function () {
        let data = $(this).data('data');
        $('#confirm-name-brand').text(data['name']);
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
        let active = data['active'] == '1' ? '0': '1' ;
        let id = data['id'];
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: 'PUT',
            url: "{{ route('squad-account-update',['companyCode' => $companyCode]) }}",
            data: {statusActive:active,id:id,"_token": token},
            success: function (data) {
                $('#manage-squad-account-admin').trigger('click');
            },
            error: function (data) {
                console.log(data);
            }
        })
    })
</script>
