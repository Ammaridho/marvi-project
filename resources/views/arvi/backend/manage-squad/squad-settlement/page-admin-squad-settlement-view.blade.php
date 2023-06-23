<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-start">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="m-0">
                                <span class="text-muted">Manage Squad / Settlement</span>
                                 / {{$squad->name}}
                            </h4>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-light border dropdown-toggle" type="button" 
                            data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-export"></i> Export
                            </button>
                            <ul class="dropdown-menu">
                            <li><a href="#" class="dropdown-item"><i class="bx bx-file" ></i> Excel</a><li>
                            <li><a href="#" class="dropdown-item"><i class="bx bxs-file-pdf" ></i> PDF</a><li>
                            </ul>
                        </div>
                    </div>
                    <hr>

                    <div class="d-flex justify-content-between flex-sm-row flex-column mb-2">
                        <div>
                            <div class="d-flex flex-sm-row flex-column">
                                <div class="mb-2 me-3">
                                    <form class="search m-0" onsubmit="return false">
                                        <input class="form-control form-control-custom me-2"
                                        type="search" id="input-search"
                                        placeholder="Name/status/location/store/customer/orders.."
                                        aria-label="Search" autocomplete="off" />
                                        <button type="reset">&times;</button>
                                    </form>
                                </div>
                                <div class="mb-2 me-3">
                                    <input type="text" id="dateRange-order-list" name="dateRange-order-list"
                                    class="form-control form-control-custom"/>
                                </div>
                                <div class="mb-2 me-3">
                                    <select class="dropdown nice" id="filter-location">
                                        <option value="all" data-display="Select Location">
                                            Select Location
                                        </option>
                                        @foreach ($settlements->unique('location') as $item)
                                            <option value="{{$item->location_id}}">{{$item->location}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2 me-3">
                                    <select class="dropdown nice" id="filter-settle">
                                        <option value="all" data-display="Filter">Filter</option>
                                        <option disabled>Settlement Status</option>
                                        <option value="t2">Settled</option>
                                        <option value="t1">-</option>
                                        <option value="t0">Unsettled</option>
                                        <option disabled>Status</option>
                                        <option value="s1">On Progress</option>
                                        <option value="s2">Success</option>
                                        <option value="s0">Failed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="mb-1">
                                <button type="button" class="btn btn-primary" 
                                data-bs-toggle="modal" data-bs-target="#modalSettle" 
                                id="btn-settled" disabled>
                                Settlement
                                </button>
                            </div>
                        </div>
                    </div>    

                    <div class="table-responsive text-nowrap pb-4 always-show" id="table-scroll">
                        <table class="table table-borderless">
                            <thead>
                                <tr class="table-primary text-nowrap border-0">
                                    <th class="fs-6 fw-normal">
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                            type="checkbox" value="" id="selectAll">
                                        </div>
                                    </th>
                                    <th>Transaction ID</th>
                                    <th>Transaction Date</th>
                                    <th>Status</th>
                                    <th>Location</th>
                                    <th>Store</th>
                                    <th>Customer</th>
                                    <th>Orders</th>
                                    <th>Total Price</th>
                                    <th>Fees</th>
                                    <th>Total</th>
                                    <th>Remaining</th>
                                    <th>Settlement</th>
                                    <th>Settlement Date</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-settlement-list">
                                @include('arvi.backend.manage-squad.squad-settlement.page-admin-squad-settlement-view-data')
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

<!--
=============================================
Modals
=============================================
-->

<!-- Modal reset -->
<div class="modal fade" id="modalSettle" tabindex="-1" aria-labelledby="modalSettle" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header border-bottom pb-3">
        <h5 class="modal-title">Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body center p-3">
        
        <h4>You will do settlement for today, are you sure?</h4>

        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>Total order</div>
            <div class="fw-bold" id="count-data"></div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>Total transactions</div>
            <div class="fw-bold" id="total-price"></div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-2 border-top pt-2">
            <div>Remaining balance</div>
            <div class="fw-bold" id="remaining">0</div>
        </div>

        </div>
        <div class="modal-footer border-top pb-2">
        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="submit-settled" data-bs-dismiss="modal">Settle</button>
        </div>
    </div>
    </div>
</div>
<!-- //Modal reset -->

<script src="/arvi/backend-assets/js/demo.js"></script>

<script>

    // button settled
    $('#btn-settled').on('click',function () {
        // get all data from checked
        let opsi = [];
        $("input:checkbox[name=opsi]:checked").each(function(){
            opsi.push(parseFloat($(this).val()));
        });
        // count data
        $('#count-data').text(opsi.length);
        // sum data
        let sum = opsi.reduce(function(a, b){
            return a + b;
        }, 0);
        $('#total-price').text(sum);
    })
    //submit settled
    $('#submit-settled').on('click',function () {
        // process settled
        // wait for squad application
    })

    // Reset filter
    $('#reset-filter-day-order').on('click',function () {
        $('#order-list-button').trigger("click");
    })

    //Date range
    var start = moment().subtract(29, 'days');
    var end = moment();
    function cb(start, end) {
        $('#dateRange-order-list span').html(start.format('MMMM D, YYYY') + ' - ' +
        end.format('MMMM D, YYYY'));
    }
    $('input[name="dateRange-order-list"]').daterangepicker({
        opens: "left",
        startDate: start,
        endDate: end,
        ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'),
        moment().subtract(1, 'month').endOf('month')]
        }
    });
    cb(start, end);

    // search
    $("#input-search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tbody-settlement-list tr#settlement-list").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    
    //Date range
    var start = moment().subtract(29, 'days');
    var end = moment();
    function cb(start, end) {
        $('#dateRange-order-list span').html(start.format('MMMM D, YYYY') + ' - ' +
        end.format('MMMM D, YYYY'));
    }
    $('input[name="dateRange-order-list"]').daterangepicker({
        opens: "left",
        startDate: start,
        endDate: end,
        ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'),
        moment().subtract(1, 'month').endOf('month')]
        }
    });
    cb(start, end);

    // run all filter
    $('#filter-settle, input[name="dateRange-order-list"], #filter-location').
        on('change click',function () {

        // squad id
        let id = "{{$squad->id}}";

        // date filter
        let dateFilter = $('input[name="dateRange-order-list"]').val();
        let startDate = dateFilter.substring(0, 10);
        let endDate = dateFilter.substring(13);

        // brand and merchant filter
        let filter_settle = $('#filter-settle').val();

        // select fulfilment or status
        let filter_location = $('#filter-location').val();

        $.get("{{route('squad-settlement-list-table',['companyCode' => $companyCode], true)}}",
            {id:id,startDate:startDate,endDate:endDate,filter_settle:filter_settle,filter_location:filter_location},
            function (data) {
                $('#tbody-settlement-list').html(data);
            }
        )
    })
</script>