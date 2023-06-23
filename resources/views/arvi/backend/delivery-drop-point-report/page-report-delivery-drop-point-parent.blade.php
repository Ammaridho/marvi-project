<div class="card">
  <div class="d-flex justify-content-between flex-grow align-items-center">
    <div><h5 class="card-header">Delivery Drop Point</h5></div>
    <div>
      <div class="me-2">
          <div class="d-flex justify-content-end flex-sm-row flex-column">
            <div class="me-2 my-1">
                <input type="text" id="dateRange" name="dateRange"
                class="form-control form-control-custom" />
            </div>
            <div class=" my-1">
              <button class="btn btn-sm btn-outline-primary me-2" id="reset-filter-day-order">
                Reset
              </button>
            </div>
            <div class=" my-1">
              <button class="btn btn-sm btn-outline-primary me-2"
                id="btnSubmitExport" onclick="exportExcel()">
                <i class="menu-icon tf-icons bx bx-download"></i> Export
              </button>
            </div>
          </div>
      </div>
    </div>
  </div>

  <div class="mx-3 pb-4 table-responsive" id="paginate-page-report-order">
    @include('arvi.backend.delivery-drop-point-report.page-report-delivery-drop-point-child')
  </div>

</div>

<script>

  // Reset filter
  $('#reset-filter-day-order').on('click',function () {
    $('#delivery-drop-point-button').trigger("click");
  })

  //Date range
  var start = moment().subtract(29, 'days');
  var end = moment();
  function cb(start, end) {
      $('#dateRange span').html(start.format('MMMM D, YYYY') + ' - ' +
      end.format('MMMM D, YYYY'));
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

  // when date pick on click
  $('input[name="dateRange"]').on('apply.daterangepicker', function(ev, picker) {
    getDatesInRange(picker.startDate,picker.endDate);
  });

  //show date if on sort data
  function getDatesInRange(sd, ed) {

    startDate = dateFormat(new Date(sd), 'yyyy-MM-dd');
    endDate = dateFormat(new Date(ed), 'yyyy-MM-dd');

    $.get("{{route('sortDate-delivery-order-dashboard',['companyCode' => $companyCode], true)}}"
          +'?startDate=' + JSON.stringify(startDate)
          +'&endDate=' + JSON.stringify(endDate),
      function (data) {
        $('#paginate-page-report-order').html(data);
      }
    )
  }

  // set format date
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

  // export excel
  function exportExcel() {
    if (typeof startDate !== 'undefined') {
      let conf = confirm('export excel?');
      if(conf){
        var urlJavascript = '{{ route('delivery-drop-point-export-excel',['companyCode' => $companyCode]) }}'
          +'?startDate=' + JSON.stringify(startDate)
          +'&endDate=' + JSON.stringify(endDate);
        window.location.href = urlJavascript;
      }
    }else{
      console.log('Please set sort date before export!');
    }
  }


</script>
