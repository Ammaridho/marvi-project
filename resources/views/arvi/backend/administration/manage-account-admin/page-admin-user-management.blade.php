<div class="row justify-content-start">

    <div class="col-lg-12 col-md-12 col-12">
    
        <!-- -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div><h4 class="m-0"><span class="text-muted">Manage User</span> / Account</h4></div>
                    <div><a href="javascript:void(0)" class="btn btn-primary" id="add-account">
                        <i class="tf-icons bx bx-plus"></i> Add account</a>
                    </div>
                </div>
                <hr>
                <div class="d-flex align-items-center">
                    <div class="mb-3 me-3">
                        <form class="search m-0" onsubmit="return false">
                            <input class="form-control form-control-custom me-2" type="search" id="input-search" 
                            placeholder="Name/Email/Mobile/Company/Brand/Store/Role.." 
                            aria-label="Search" autocomplete="off" />
                            <button type="reset">&times;</button>
                        </form>
                    </div>
                    <div class="mb-3 me-3">
                        <select class="dropdown nice filter-data" id="role-data">
                            <option selected>All</option>
                            <option disabled>Role</option>
                            <option value="superadmin">Super Admin</option>
                            <option value="admin">Admin</option>
                            <option value="viewer">Viewer</option>
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
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Company Name</th>
                                <th>Brand</th>
                                <th>Store</th>
                                <th>Role</th>
                                <th>Last Login</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-account-list">
                            @foreach ($users as $user)
                            <!-- user -->
                            <tr class="border-bottom text-nowrap" id="account-list">
                                <td>{{$user->name}}</td>
                                <td class="fw-bold">{{$user->email}}</td>
                                <td class="fw-bold">{{$user->phone_number}}</td>
                                <td>
                                    @foreach ($user->companies as $companies)
                                        
                                    <span class="badge bg-primary">{{$companies->name}}</span> 
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($user->brands as $brands)
                                        <span class="badge bg-primary">{{$brands->name}}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @if ($user->store_id != null)

                                        @php
                                        $a = '';
                                        @endphp

                                        @foreach (json_decode($user->store_id) as $key => $im)
                                            <span class="badge bg-primary">
                                                {{isset($merchant[$im]) ? $merchant[$im] : '' }}
                                            </span>
                                        @endforeach

                                    @else
                                        please set store!
                                    @endif
                                </td>
                                <td>
                                    @if ($user->role != null)
                                        {{$user->role}}
                                    @else
                                        please set role!
                                    @endif
                                </td>
                                <td>
                                    @if ($user->last_login != null)
                                        {{$user->last_login}}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    <div class="d-flex justify-content-end">
                                        <div class="form-check form-switch me-3">
                                            <script>
                                                var userActive = "{{$user->active}}";

                                                if (userActive == '1') {
                                                    $("#status-{{$user->id}}").prop('checked', true);
                                                }else{
                                                    $("#status-{{$user->id}}").prop('checked', false);
                                                }
                                            </script>
                                            <input class="form-check-input btn-checkbox active-user" 
                                                type="checkbox" id="status-{{$user->id}}" data-id="{{$user->id}}"
                                                data-active="{{$user->active}}" value="1">
                                            <label class="form-check-label" for="status-{{$user->id}}">
                                                {{$user->active == 1 ? 'active' : 'inactive'}}
                                            </label>
                                        </div>
                                        <div class="mx-2"><a href="javascript:void(0)" data-id="{{$user->id}}" 
                                            class="btn btn-sm btn-primary edit-account"><i class="fas fa-pen"></i></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <!-- //user -->
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-center text-muted mt-1"><i class="fas fa-exchange-alt"></i></div>

                <!-- showing data -->
                <div class="d-flex justify-content-end align-items-center mt-4">
                    <div class="text-muted small me-3">
                        Showing {{$users->count()}} from {{DB::table('users')->count()}}
                    </div>
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

{{-- modal --}}
<div class="modal fade" id="modaldActiveInActive" tabindex="-1" aria-labelledby="modaldActiveInActive" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom pb-3">
            <h5 class="modal-title">Confirmation</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body center p-3">
                <div class="">You're about to set to <span class="fw-bold text-primary" 
                    id="active-status-to-change">Active </span> to this item. Are you sure?</div>
            </div>
            <div class="modal-footer border-top pb-2">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-change-active" 
                data-bs-dismiss="modal" data-id="" data-active="">Proceed</button>
            </div>
        </div>
    </div>
</div>

{{-- script plugin --}}
<script type="text/javascript" src="/arvi/backend-assets/js/demo.js"></script>

<script>
    // filter
    $('.filter-data').on('change',function () {
        let role = $('#role-data').val();
        let much = $('#much-data').val();
        $.get("{{route('account-admin-list-table',['companyCode' => $companyCode])}}",
        {role:role,much:much},function (data) {
            $('#tbody-account-list').html(data);
        })
    })

    // active
    $('.active-user').on('click',function () {

        let id = $(this).data('id');
        let active = $(this).data('active');

        $('#save-change-active').data('id',id);
        $('#save-change-active').data('active',active);

        if (active == 1) {
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

        let id = $(this).data('id');
        let active = $(this).data('active');
        let statusActive = active == '1' ? '0': '1' ;

        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: 'PUT',
            url: "{{ route('account-admin-update',['companyCode' => $companyCode]) }}",
            data: {statusActive:statusActive,id:id,"_token": token},
            success: function (data) {
                $('#manage-account-admin').trigger("click");
            }
        })
        
    })

    // search order
    $("#input-search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tbody-account-list tr#account-list").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // button openform add account
    $('#add-account').on('click',function () {
        $.get("{{route('account-admin-create',['companyCode' => $companyCode])}}",function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // button open form edit account
    $('.edit-account').on('click',function () {
        userId = $(this).data('id');
        $.get("{{route('account-admin-edit',['companyCode' => $companyCode])}}",
            {userId:userId},function (data) {
            $('#contentDashboard').html(data);
        })
    })
    
</script>
