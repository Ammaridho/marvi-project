
<div class="card">
  
  <div class="d-flex justify-content-between flex-grow align-items-center">
    <div><h5 class="card-header">Orders</h5></div>
    <div>
      <div class="me-2">
          <div class="d-flex justify-content-end flex-sm-row flex-column">
            <div class="me-2 my-1">
              {{-- <button class="btn btn-sm btn-primary"id="filter" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="menu-icon tf-icons bx bx-filter"></i> Filter</button> --}}
              {{-- <div class="dropdown-menu dropdown-menu-end" aria-labelledby="filter">
                <a class="dropdown-item" href="javascript:void(0);">Order Date</a>
                <a class="dropdown-item" href="javascript:void(0);">Delivery Date</a>
              </div> --}}
              <select class="form-select applyClass" id="typeDate" aria-label="Example select with button addon">
                <option value="1" selected>Order Date</option>
                <option value="2">Deliver Date</option>
              </select>
            </div>
            <div class="me-2 my-1"><input type="text" id="dateRange" name="dateRange" class="form-control form-control-custom" /></div>
            <div class="me-2 my-1">
              <form class="d-flex" onsubmit="return false">
                <input class="form-control form-control-custom me-2" onkeyup="searchData()" id="input-search" type="search" placeholder="Order-ID/Order-Date/Delivery-Date/Name/Email/Phone/Delivery-Type/Address" aria-label="Search" autocomplete="off" />
                {{-- <button class="btn btn-sm btn-outline-primary pe-2" id="btnSubmitSearch" type="submit"><i class="menu-icon tf-icons bx bx-search-alt"></i></button> --}}
              </form>
            </div>
            {{-- <button id="btnExport" onclick="fnExcelReport();"> EXPORT </button> --}}
            {{-- <div class=" my-1"><button class="btn btn-sm btn-outline-primary me-2" id="btnSubmitExport" onclick="exportTableToExcel('table_order', 'table_order_{{ $noww->format('d-m-Y') }}')"><i class="menu-icon tf-icons bx bx-download"></i> Export</button></div> --}}
            <div class=" my-1">
                <button class="btn btn-sm btn-outline-primary me-2" id="btnSubmitExport" onclick="exportExcel()">
                  <i class="menu-icon tf-icons bx bx-download"></i> Export
                </button>
            </div>
          </div>
      </div>
    </div>
  </div>
  
  <div class="mx-3 pb-4 table-responsive">
    <table class="table table-bordered table-sm table-striped report" id="table_order">
      <thead>
        <tr class="table-primary">
          <th>Order ID</th>
          <th>Order Date</th>
          <th>Delivery Date</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Delivery Type</th>
          <th>Address</th>
          <th>Orders</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0" id="list-order">

        <!-- row data -->  
        @foreach ($joinForOrderDetails as $key => $item)

        <div class="data-order" id="data-order">
            
          <tr id="order-list" class="od-{{ date("d-m-Y", strtotime($item->create_time)) }} dd-{{ date("d-m-Y", strtotime($item->day_deliver)) }}  all-order" data-id="{{ $item->id }}">
            <td>{{ $item->id }}</td>
            <td>{{ date("d-m-Y h:m:s", strtotime($item->create_time)) }}</td>
            <td>{{ date("d-m-Y", strtotime($item->day_deliver)) }}</td>
            <td class="text-nowrap">{{ $item->name }}</td>
            <td>{{ $item->email }}</td>
            <td class="text-nowrap">+65 {{ $item->mobile_number }}</td>
            <td class="text-center">Pickup</td>
            <td>{{ $item->address }}</td>
            <td class="text-center">
              <button class="btn btn-sm btn-primary show-product" target="{{ $key }}">View</button>
            </td>
          </tr>
          <tr><td colspan="9" class="d-none"></td></tr><!-- this needed to make sure table stripped works-->
          <tr class="more-product" id="blockProduct{{ $key }}" style="display: none;">
            <td colspan="9">
              <div class="m-2">
                <table class="table table-sm table-bordered report">
                  <tr>
                    <th>Black Coffee</th>
                    <th>Strong Black Coffee</th>
                    <th>Oat Milk Coffee</th>
                    <th>Milk & Manuka Honey</th>
                    <th>Coffee Hojicha Green Tea</th>
                    <th>Rooibos Orange Tea</th>
                    <th class="table-warning">Total Item</th>
                  </tr>
                  <tr>
                    {{-- set itteration for print quantity product --}}
                    @for ($i = 1; $i <= $countProduct; $i++) 
                      <td class="text-end qty{{$i}}">{{!empty($productsOrder[$item->id][$i]) ? (int)$productsOrder[$item->id][$i] : (int)0}}</td>
                    @endfor
                    <td class="fw-bold text-end table-warning">{{array_sum($productsOrder[$item->id])}}</td>
                  </tr>
                </table>
              </div>
            </td>
          </tr>
          
        </div>

        @endforeach
        <!-- //row data -->  
        
      </tbody>
    </table>
  </div>

  {{-- page laravel --}}
  {{-- {{ $joinForOrderDetails->links() }} --}}

  <!-- paging -->
  <div class="mx-3 mt-3 text-end">
      <div class="d-flex justify-content-between align-items-center">
        <div class="d-none d-sm-none d-md-block">Showing 25 from 100</div>
        <div class="d-none d-sm-none d-md-block">
          <nav>
              <ul class="pagination justify-content-end">
                  <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">4</a></li>
                  <li class="page-item"><a class="page-link" href="#">5</a></li>
                  <li class="page-item"><a class="page-link p-2" href="#"><i class="bx bx-chevron-left"></i></a></li>
                  <li class="page-item"><a class="page-link p-2" href="#"><i class="bx bx-chevron-right"></i></a></li>
              </ul>
          </nav>
        </div>
        <div class="d-block d-sm-block d-md-none">
          <nav>
              <ul class="pagination justify-content-end">
                  <li class="page-item"><a class="page-link p-2" href="#">Previous</a></li>
                  <li class="page-item"><a class="page-link p-2" href="#">Next</a></li>
              </ul>
          </nav>
        </div>
      </div>
  </div>
  <!-- //paging -->

</div>

<script>
  // export excel
  function exportExcel(params) {

    let conf = confirm('export excel?');
    
    if(conf){

        // get all id visible data
        var ek=[];
        $('tr.all-order:visible').each(function() { ek.push($(this).data('id')); });
        var urlJavascript = '{{ route('order-list-export-excel',['qrCode' => $qrCode]) }}'+'?idData=' + JSON.stringify(ek);

        window.location.href = urlJavascript;
      }
  }
  
  // search order
  $("#input-search").on("keyup click change", function() {
    var value = $(this).val().toLowerCase();
    $("#list-order tr#order-list").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  //View product id
  $('.show-product').click(function() {
    $('.more-product').not('#blockProduct' + $(this).attr('target')).hide('');
    $('#blockProduct' + $(this).attr('target')).toggle('');
  });
  //Date range
  var start = moment().subtract(29, 'days');
  var end = moment();
  function cb(start, end) {
      $('#dateRange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  }
  $('input[name="dateRange"]').daterangepicker({
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

  // Reset filter
  $('#reset-filter-day-order').on('click',function () {
      $('tr.all-order').show();
  })
  // when date pick on click
  $('input[name="dateRange"]').on('apply.daterangepicker', function(ev, picker) {
      getDatesInRange(new Date(picker.startDate.format('YYYY-MM-DD')), 
      new Date(picker.endDate.format('YYYY-MM-DD')));
  });
  function dateFormat(inputDate, format) {
      //parse the input date
      const date = new Date(inputDate);
      //extract the parts of the date
      const day = date.getDate();
      const month = date.getMonth() + 1;
      const year = date.getFullYear();    
      //replace the month
      format = format.replace("MM", month.toString().padStart(2,"0"));        
      //replace the year
      if (format.indexOf("yyyy") > -1) {
          format = format.replace("yyyy", year.toString());
      } else if (format.indexOf("yy") > -1) {
          format = format.replace("yy", year.toString().substr(2,2));
      }
      //replace the day
      format = format.replace("dd", day.toString().padStart(2,"0"));
      return format;
  }
  function getDatesInRange(startDate, endDate) {
      // hide all order
      $('tr.all-order').hide();
      const date = new Date(startDate.getTime());
      const dates = [];

      switch ($('#typeDate').find(":selected").text()) {
          case 'Order Date':
              // alert('Order Date');
              var angkerDate = 'od';
              break;
          case 'Deliver Date':
              // alert('Deliver Date');
              var angkerDate = 'dd';
              break;
      }

      while (date <= endDate) {
          // set date in choosed to display
          $(`tr.${angkerDate}-${dateFormat(date, 'dd-MM-yyyy')}`).show();
          date.setDate(date.getDate() + 1);
      }
    
  }
  //DEMO PURPOSE
  // $("#btnSubmitExport").click(function() {
  //     $(this).prop("disabled", true);
  //     $(this).html(
  //         'Exporting ... '
  //     );
  // });
  // $("#btnSubmitSearch").click(function() {
  //     $(this).prop("disabled", true);
  //     $(this).html(
  //         '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
  //     );
  // });
</script>
