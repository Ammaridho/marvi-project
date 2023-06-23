<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-start">
            <div class="col-lg-12 col-md-12 col-12">
                <!-- -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div><h4 class="m-0"><span class="text-muted">Manage Squad</span> / Settlement</h4></div>
                        </div>
                        <hr>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center">
                                <div class="mb-3 me-3">
                                    <form class="search m-0" onsubmit="return false">
                                        <input class="form-control form-control-custom me-2"
                                        type="search" id="input-search"
                                        placeholder="Name/status/location.."
                                        aria-label="Search" autocomplete="off" />
                                        <button type="reset">&times;</button>
                                    </form>
                                </div>
                                <div class="mb-3 me-3">
                                    <select class="dropdown nice" id="select-filter">
                                        <option value="all" data-display="Filter">Filter</option>
                                        <option disabled>Status</option>
                                        <option value="a1">Active</option>
                                        <option value="a0">In Active</option>
                                        <option disabled>Settlement</option>
                                        <option value="s0">Not Requested</option>
                                        <option value="s1">Requested</option>
                                        <option value="s2">Done</option>
                                        <option disabled>Location</option>
                                        @foreach ($squads->unique('location') as $item)
                                            <option value="l{{$item->location_id}}">{{$item->location}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        <div>
                            </div>
                        </div>    
                        <div class="table-responsive text-nowrap pb-4 always-show" id="table-scroll">
                            <table class="table table-borderless">
                                <thead>
                                    <tr class="table-primary text-nowrap border-0">
                                        <th>Full Name</th>
                                        <th>Status</th>
                                        <th>Location</th>
                                        <th>Balance</th>
                                        <th>Remaining</th>
                                        <th>Total Order</th>
                                        <th>Settlement</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-settlement-list">
                                    @include('arvi.backend.manage-squad.squad-settlement.page-admin-squad-settlement-data')
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
    </div>
</div>
<!-- Content wrapper -->

<script src="/arvi/backend-assets/js/demo.js"></script>

<script>

    // store balance
    $('#submit-update').on('click',function () {
        id = $(this).data('id');
        balance = $("#balance:input[name='balance']").val();
        $.ajax({
            type: 'POST',
            url: "{{ route('squad-settlement-store',['companyCode' => $companyCode]) }}",
            data: {"_token": "{{ csrf_token() }}",id:id,balance:balance},
            success: function (data) {
                $('#manage-squad-settlement-admin').trigger("click");
            },
            error: function (data) {
                console.log(data);
            }
        })
    })

    // run all filter
    $('#select-filter').on('change click',function () {
        // select fulfilment or status
        let select_filter = $('#select-filter').val();
        $.get("{{route('squad-settlement-list',['companyCode' => $companyCode], true)}}",
            {select_filter,select_filter},
            function (data) {
                $('#tbody-settlement-list').html(data);
            }
        )
    })

    // search
    $("#input-search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tbody-settlement-list tr#settlement-list").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

</script>
