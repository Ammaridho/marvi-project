{{-- {{dd($test)}} --}}
<div class="card">
  <div class="d-flex justify-content-between flex-grow align-items-center">
    <div><h5 class="card-header">Delivery Drop Point</h5></div>
    <div>
      <div class="me-2">
          <div class="d-flex justify-content-end flex-sm-row flex-column">
            <div class="me-2 my-1"><input type="text" id="dateRange" name="dateRange" 
                class="form-control form-control-custom" /></div>
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
  
  <div class="mx-3 pb-4 table-responsive" id="paginate-page-report-order">
    @include('arvi.backend.delivery-drop-point-report.page-report-delivery-drop-point-child')
  </div>

</div>

<script>

  $(document).ready(function(){

    // move page
    $(document).on('click', '.page-link', function(event){
      event.preventDefault(); 
      var page = $(this).attr('href').split('page=')[1];
      fetch_data(page);
    });
    function fetch_data(page)
    {
      var _token = $("input[name=_token]").val();
      $.ajax({
        url:"{{ route('deliveryOrderPoint-paginationfetch',['qrCode' => $qrCode, 'action' => 1]) }}",
        method:"POST",
        data:{_token:_token, page:page},
        success:function(data)
        {
        $('#paginate-page-report-order').html(data);
        }
      });
    }

  })

  // export excel
  function exportExcel() {
    let conf = confirm('export excel?');
    if(conf){
      // get all id visible data
      var dataIndex=[];
      $('tr.all-list-delivery-drop-point:visible').each(function() { 
        dataIndex.push($(this).data('index'));
      });

      var urlJavascript = '{{ route('delivery-drop-point-export-excel',['qrCode' => $qrCode]) }}'+
      '?dataIndex=' + JSON.stringify(dataIndex);
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
          url:"{{ route('deliveryOrderPoint-paginationfetch',['qrCode' => $qrCode, 'action' => 2]) }}",
          method:"POST",
          data:{_token:_token},
          success:function(data)
          {
            $('#paginate-page-report-order').html(data);
          },
          error:function(){
            alert('error');
          }
        });
      }
    };
  })();

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

  //show date if on sort data
  function getDatesInRange(startDate, endDate) {
      // hide all order
      $('tr.all-list-delivery-drop-point').hide();
      const date = new Date(startDate.getTime());
      const dates = [];
      while (date <= endDate) {
          // set date in choosed to display
          $(`tr.dd-${dateFormat(date, 'dd-MM-yyyy')}`).show();
          date.setDate(date.getDate() + 1);
      }
    
  }

</script>
