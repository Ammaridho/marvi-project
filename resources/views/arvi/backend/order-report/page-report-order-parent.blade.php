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
                <input class="form-control form-control-custom me-2" id="input-search" type="search" placeholder="Order-ID/Order-Date/Delivery-Date/Name/Email/Phone/Delivery-Type/Address" aria-label="Search" autocomplete="off" />
              </form>
            </div>
            {{-- <button id="btnExport" onclick="fnExcelReport();"> EXPORT </button> --}}
            {{-- <div class=" my-1"><button class="btn btn-sm btn-outline-primary me-2" id="btnSubmitExport" onclick="exportTableToExcel('table_order', 'table_order_{{ $noww->format('d-m-Y') }}')"><i class="menu-icon tf-icons bx bx-download"></i> Export</button></div> --}}
            <div class=" my-1">
                <button class="btn btn-sm btn-outline-primary me-2" id="reset-filter-day-order">
                  Reset
                </button>
            </div>
            <div class=" my-1">
                <button class="btn btn-sm btn-outline-primary me-2" id="btnSubmitExport" onclick="exportExcel()">
                  <i class="menu-icon tf-icons bx bx-download"></i> Export
                </button>
            </div>
          </div>
      </div>
    </div>
  </div>
  
  <div class="mx-3 pb-4 table-responsive" id="paginate-order">
    @include('arvi.backend.order-report.page-report-order-child')
  </div>

</div>

<script>

  $(document).ready(function(){

    $(document).on('click', '.page-link', function(event){
      event.preventDefault(); 
      var page = $(this).attr('href').split('page=')[1];
      fetch_data(page);
    });
    
    function fetch_data(page)
    {
      var _token = $("input[name=_token]").val();
      $.ajax({
        url:"{{ route('order-paginationfetch',['companyCode' => $companyCode, 'action' => 1]) }}",
        method:"POST",
        data:{_token:_token, page:page},
        success:function(data)
        {
        $('#paginate-order').html(data);
        }
      });
    }
    
  });

  // export excel
  function exportExcel(params) {

    let conf = confirm('export excel?');
    
    if(conf){

        // get all id visible data
        var ek=[];
        $('tr.all-order:visible').each(function() { ek.push($(this).data('id')); });
        var urlJavascript = '{{ route('order-list-export-excel',['companyCode' => $companyCode]) }}'+'?idData=' + JSON.stringify(ek);

        window.location.href = urlJavascript;
      }
  }

  // showall data before search and sort
  var showAll = (function() {
    var executed = false;
    return function() {
      if (!executed) {
        executed = true;
        var _token = $("input[name=_token]").val();
        $.ajax({
          url:"{{ route('order-paginationfetch',['companyCode' => $companyCode, 'action' => 2]) }}",
          method:"POST",
          data:{_token:_token},
          success:function(data)
          {
            $('#paginate-order').html(data);
          },
          error:function(){
            console.log(data);
          }
        });
      }
    };
  })();
  
  // search order
  $("#input-search").on("keyup", function() {
    showAll();
    var value = $(this).val().toLowerCase();
    $("#list-order tr#order-list").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

  // Reset filter
  $('#reset-filter-day-order').on('click',function () {
    $('#order-button').trigger("click");
  })

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

  $('input[name="dateRange"]').on('apply.daterangepicker', function(ev, picker) {
    showAll();
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
              var angkerDate = 'od';
              break;
          case 'Deliver Date':
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
