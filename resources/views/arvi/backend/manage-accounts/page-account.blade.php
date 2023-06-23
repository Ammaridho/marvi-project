<div class="row justify-content-start">

    <div class="col-lg-12 col-md-12 col-12">
    
        <!-- -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div><h4 class="m-0">Manage Accounts</h4></div>
                    <div><a href="javascript:void(0)" class="btn btn-primary" id="add-account">
                        <i class="tf-icons bx bx-plus"></i> Add account</a>
                    </div>
                </div>
                <hr>

                <div class="mb-3">
                    <form class="search" onsubmit="return false">
                    <input class="form-control form-control-custom me-2" type="search" id="input-search" 
                    placeholder="Name/Email/Company/Brand/Store/Role.." aria-label="Search" autocomplete="off" />
                    <button type="reset">&times;</button>
                    </form>
                </div>

                <div class="table-responsive text-nowrap pb-4 always-show" id="table-scroll">
                    <table class="table table-borderless">
                        <thead>
                            <tr class="table-primary text-nowrap border-0">
                                <th>Full Name</th>
                                <th>Email</th>
                                <th class="">Brand</th>
                                <th class="">Store</th>
                                <th class="">Role</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tbody-account-list">
                            @foreach ($users as $user)
                            <!-- user -->
                            <tr class="border-bottom text-nowrap" id="account-list">
                                <td>{{$user->name}}</td>
                                <td class="fw-bold">{{$user->email}}</td>
                                <td>
                                    @foreach ($user->brands->where('company_id', $company_id) as $brands)
                                        <span class="badge bg-primary">{{$brands->name}}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @if ($user->store_id != null)
                                        @php
                                            $a = '';
                                            $data = json_decode($user->store_id);
                                            $merchants = array_intersect($merchants_id, $data);
                                        @endphp

                                        @foreach ($merchants as $key => $im)
                                            <span class="badge bg-primary">{{$merchant[$im]}}</span>
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
                                <td class="text-nowrap">
                                    <div class="d-flex justify-content-end">
                                        <div class="mx-2"><a href="javascript:void(0)" data-data="{{ $user }}" 
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
                    <div class="text-muted small me-3">Showing 25 from 143</div>
                    <div class="">
                        <select class="dropdown nice">
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

<script src="/arvi/backend-assets/js/dashboards-analytics.js"></script>
<script src="/arvi/backend-assets/js/demo.js"></script>

<script>
    // search order
    $("#input-search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tbody-account-list tr#account-list").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // button openform add account
    $('#add-account').on('click',function () {
        $.get("{{route('account-create',['companyCode' => $companyCode])}}",function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // button open form edit account
    $('.edit-account').on('click',function () {
        dataUser = $(this).data('data');
        $.get("{{route('account-edit',['companyCode' => $companyCode])}}",
            {dataUser:dataUser},function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // delete
    $(".delete-account").on('click',function(){

        conf = confirm('delete?');

        if (conf) {
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
        
            $.ajax({
                type: 'DELETE',
                url: "{{ route('account-destroy',['companyCode' => $companyCode]) }}",
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function (){
                    $('#account-button').trigger("click");
                }
            });
            
        }
    
    });

    
</script>
