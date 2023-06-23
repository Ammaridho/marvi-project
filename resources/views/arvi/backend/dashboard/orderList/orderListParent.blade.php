<!-- filter -->
<div class="row mb-3">
  <div class="col-lg-4 mb-1">
    <div class="card h-100">
      <div class="card-body m-0 p-2">
        <form class="search m-0" onsubmit="return false">
            <input class="form-control form-control-custom me-2" 
            type="search" id="input-search"
            placeholder="Name/Address/Date/Total.." 
            aria-label="Search" autocomplete="off" />
            <button type="reset">&times;</button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-3 mb-1">
    <div class="card h-100">
      <div class="card-body m-0 p-2">
        <div class="me-2 my-1">
            <input type="text" id="dateRange-order-list" 
            name="dateRange-order-list"
            class="form-control form-control-custom"/>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 mb-1">
    <div class="card h-100">
      <div class="card-body m-0 p-2">
        <select class="" name="select-brand-store" 
        style="width: 100%;"
        id="filter-brand-store" multiple>
          @foreach ($merchants as $item)
            <option value="{{$item->id}}">
              {{$item->name}}
            </option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
  <div class="col-lg-2 mb-1">
    <div class="card h-100">
      <div class="card-body m-0 p-2">
          <select class="dropdown nice wide" id="select-fulfilment-or-status">
            <option data-display="Select">Select</option>
            <option disabled>Fulfilment</option>
            <option value="f0">Delivery Ordering</option>
            <option value="f1">Pickup Ordering</option>
            <option disabled>Status</option>
            <option value="s3">Proccess Delivery</option>
            <option value="s2">Already Pickup</option>
            <option value="s1">On Proccess</option>
            <option value="s0">Canceled</option>
          </select>
      </div>
    </div>
  </div>
</div>
<!-- //filter -->
<div class="row">
  <div class="12">
    <!-- Hello -->
    <div class="card h-100">
        <div class="card-body justify-content-center align-items-center">
            <div class="">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div><h5 class="m-0">View Report</h5></div>
                            <div class="btn-group">
                              <button class="btn btn-light border dropdown-toggle" type="button"
                              data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-export" ></i> Export
                              </button>
                              <ul class="dropdown-menu">
                                <li><a href="#" class="dropdown-item"><i class="bx bx-file" ></i> Excel</a><li>
                                <li><a href="#" class="dropdown-item"><i class="bx bxs-file-pdf" ></i> PDF</a><li>
                              </ul>
                            </div>
                        </div>
                        <!-- SPINNER -->
                        <div class="my-4 text-center hidden" id="loader">
                          <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                          </div>
                        </div>
                        <!-- //SPINNER -->
                        <div class="table-responsive text-nowrap pb-4 always-show" id="table-scroll">
                            <table class="table fixed table-borderless">
                                <thead>
                                    <tr class="table-primary text-nowrap border-0">
                                        <th class="text-center">Order No.</th>
                                        <th class="text-center">Time Zone</th>
                                        <th class="text-center">Order Date</th>
                                        <th class="text-center">Order For</th>
                                        <th class="text-center">Fulfilment</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Customer Name</th>
                                        <th class="text-center">Delivery/Pickup Address</th>
                                        <th class="text-center">Notes</th>
                                        <th class="text-center">Item Count</th>
                                        <th class="text-center">Total Product Price</th>
                                        <th class="text-center">delivery method</th>
                                        <th class="text-center">delivery cost</th>
                                        <th class="text-center">Total Fee</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Payment Type</th>
                                        <th class="text-center">Payment Status</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody id="all-data-order-details">
                                    @include('arvi.backend.dashboard.orderList.orderListChild')
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center text-muted mt-2"><i class="fas fa-exchange-alt"></i></div>
                        <!-- empty -->
                        <div class="text-center mt-45 d-none">
                          <img src="/arvi/backend-assets/img/illustrations/ill-nodata.svg" class="img-nodata">
                          <div class="mt-3">You doesn't have any sales yet.</div>
                        </div>
                        <!-- empty -->
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
            </div>
        </div>
    </div>
    <!-- //Hello -->
    </div>
</div>

<script>
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

  // search order
  $("#input-search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#all-data-order-details #data-order-details").filter(function() {
    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

  //multi-select filter brand merchant
  filterBrandMerchant = <?php echo json_encode($filterBrandMerchant); ?>;
  $('#filter-brand-store').multiSelect({
    // Active CSS class
    'activeClass': 'multi-select-container--open',
    'noneText': 'Filter by ',
    'viewportBottomGutter': 20,
    'menuMinHeight': 260,

    noneText: 'Filter by',
    presets: filterBrandMerchant,
  });

  // run all filter
  $('#filter-brand-store, input[name="dateRange-order-list"], #select-fulfilment-or-status').
    on('change click',function () {
    // date filter
    let dateFilter = $('input[name="dateRange-order-list"]').val();
    let startDate = dateFilter.substring(0, 10);
    let endDate = dateFilter.substring(13);
    // brand and merchant filter
    let merchantIds = $('#filter-brand-store').val();
    // select fulfilment or status
    let fulfilmentOrStatus = $('#select-fulfilment-or-status').val();
    $.get("{{route('orderList-dashboard',['companyCode' => $companyCode], true)}}"
        +'?startDate=' + JSON.stringify(startDate)
        +'&endDate=' + JSON.stringify(endDate)
        +'&merchantIds=' + JSON.stringify(merchantIds)
        +'&fulfilmentOrStatus=' + JSON.stringify(fulfilmentOrStatus)
        ,
      function (data) {
        $('#all-data-order-details').html(data);
      }
    )
  })

</script>
